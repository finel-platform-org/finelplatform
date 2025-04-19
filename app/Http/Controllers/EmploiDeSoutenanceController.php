<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmploiDeSoutenance;
use App\Models\GestionDesTheme;
use App\Models\Professeur;
use App\Models\Theme;
use App\Models\Local;
use App\Models\Specialite; // Add this at the top with other imports
use Illuminate\Support\Facades\DB;


class EmploiDeSoutenanceController extends Controller
{
    public function index()
    {
        $emplois = EmploiDeSoutenance::with(['professeur', 'sousEncadrant', 'theme', 'etudiant', 'specialite', 'group', 'local'])
                    ->where('user_id', auth()->id()) // Filtre strict par admin connecté
                    ->orderBy('Jour')
                    ->orderBy('HeureDebut')
                    ->get()
                    ->groupBy(['Jour', 'ThemeID', function ($item) {
                        return $item->HeureDebut . '-' . $item->HeureFin;
                    }]);
        
        return view('soutenance.index', compact('emplois'));
    }
    public function create()
    {
        $professeurs = Professeur::all();
        
        // Récupérer seulement les thèmes du département de l'admin connecté
        $themes = Theme::where('DepartementID', auth()->user()->departement_id)
                    ->get();
                    
        $locals = Local::all();
        
        return view('soutenance.create', compact('professeurs', 'themes', 'locals'));
    }
    public function getGestionThemeByTheme(Request $request)
    {
        try {
            $themeID = $request->query('theme');
            
            if (!$themeID) {
                return response()->json(['error' => 'Theme parameter is required'], 400);
            }
    
            // Find theme with department check
            $theme = Theme::where('ThemeID', $themeID)
                        ->where('DepartementID', auth()->user()->departement_id)
                        ->first();
    
            if (!$theme) {
                return response()->json(['error' => 'Theme not found or unauthorized access'], 404);
            }
    
            // Get all gestion themes for this theme (multiple students)
            $gestionThemes = GestionDesTheme::with([
                    'professeurs' => function($query) {
                        $query->withPivot('role');
                    },
                    'etudiant.group',
                    'specialite',
                    'group'
                ])
                ->where('ThemeID', $themeID)
                ->get();
    
            if ($gestionThemes->isEmpty()) {
                return response()->json(['error' => 'No theme management found'], 404);
            }
    
            // Get unique professors (encadrant/sous-encadrant)
            $professeurs = $gestionThemes->flatMap->professeurs->unique('ProfesseurID');
            
            // Get all students
            $etudiants = $gestionThemes->map(function($gt) {
                return [
                    'id' => $gt->etudiant->EtudiantID,
                    'nom' => $gt->etudiant->Nom,
                    'groupe_id' => optional($gt->etudiant->group)->GroupID,
                    'groupe_nom' => optional($gt->etudiant->group)->Nom ?? '—'
                ];
            });
    
            // Get unique groups
            $groups = $gestionThemes->map(function($gt) {
                return $gt->group ? [
                    'id' => $gt->group->GroupID,
                    'nom' => $gt->group->Nom
                ] : null;
            })->filter()->unique('id')->values();
    
            // Specialties (should be the same for all)
            $specialite = $gestionThemes->first()->specialite ? [
                'id' => $gestionThemes->first()->specialite->SpecialiteID,
                'nom' => $gestionThemes->first()->specialite->Nom
            ] : null;
    
            // Build response data
            $response = [
                'encadrant' => $professeurs->firstWhere('pivot.role', 'encadrant') ? [
                    'id' => $professeurs->firstWhere('pivot.role', 'encadrant')->ProfesseurID,
                    'nom' => $professeurs->firstWhere('pivot.role', 'encadrant')->Nom
                ] : null,
                
                'sous_encadrant' => $professeurs->firstWhere('pivot.role', 'sous_encadrant') ? [
                    'id' => $professeurs->firstWhere('pivot.role', 'sous_encadrant')->ProfesseurID,
                    'nom' => $professeurs->firstWhere('pivot.role', 'sous_encadrant')->Nom
                ] : null,
                
                'etudiants' => $etudiants,
                'specialite' => $specialite,
                'groups' => $groups
            ];
    
            return response()->json($response);
    
        } catch (\Exception $e) {
            \Log::error("Error in getGestionThemeByTheme: " . $e->getMessage());
            return response()->json(['error' => 'Server error: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
{
    $request->validate([
        'ThemeID' => 'required',
        'ProfesseurID' => 'required',
        'SousEncadrantID' => 'nullable',
        'HeureDebut' => 'required',
        'HeureFin' => 'required',
        'LocalID' => 'required',
        'Jour' => 'required|string',
    ]);

    // Vérification supplémentaire
    $theme = Theme::find($request->ThemeID);
    if (!$theme || $theme->DepartementID != auth()->user()->departement_id) {
        return back()->withErrors(['error' => 'Thème non autorisé'])->withInput();
    }
    
    // Récupérer TOUTES les gestions de thème pour ce thème (pour avoir tous les étudiants)
    $gestionThemes = GestionDesTheme::with(['etudiant.group', 'specialite'])
        ->where('ThemeID', $request->ThemeID)
        ->get();
    
    if ($gestionThemes->isEmpty()) {
        return back()->withErrors(['error' => 'Aucun étudiant trouvé pour ce thème'])->withInput();
    }
    
    // Vérifier les conflits (local et professeur)
    $localConflict = EmploiDeSoutenance::where('Jour', $request->Jour)
        ->where('LocalID', $request->LocalID)
        ->where(function($query) use ($request) {
            $query->whereBetween('HeureDebut', [$request->HeureDebut, $request->HeureFin])
                ->orWhereBetween('HeureFin', [$request->HeureDebut, $request->HeureFin])
                ->orWhere(function($q) use ($request) {
                    $q->where('HeureDebut', '<=', $request->HeureDebut)
                      ->where('HeureFin', '>=', $request->HeureFin);
                });
        })
        ->exists();
    
    if ($localConflict) {
        return back()->withErrors(['error' => 'Ce créneau est déjà réservé dans cette salle.'])->withInput();
    }
    
    $profConflict = EmploiDeSoutenance::where('Jour', $request->Jour)
        ->where('ProfesseurID', $request->ProfesseurID)
        ->where(function($query) use ($request) {
            $query->whereBetween('HeureDebut', [$request->HeureDebut, $request->HeureFin])
                ->orWhereBetween('HeureFin', [$request->HeureDebut, $request->HeureFin])
                ->orWhere(function($q) use ($request) {
                    $q->where('HeureDebut', '<=', $request->HeureDebut)
                      ->where('HeureFin', '>=', $request->HeureFin);
                });
        })
        ->exists();
    
    if ($profConflict) {
        return back()->withErrors(['error' => 'Ce professeur a déjà une soutenance prévue à ce créneau.'])->withInput();
    }
    
    // Vérifier la correspondance professeur <-> thème
    $profThemeExists = DB::table('gestion_theme_professeur')
        ->join('gestiondesthemes', 'gestion_theme_professeur.GestionThemeID', '=', 'gestiondesthemes.GestionThemeID')
        ->where('gestion_theme_professeur.ProfesseurID', $request->ProfesseurID)
        ->where('gestiondesthemes.ThemeID', $request->ThemeID)
        ->exists();
    
    if (!$profThemeExists) {
        return back()->withErrors(['error' => 'Ce professeur n\'est pas associé à ce thème.'])->withInput();
    }
    
    // Préparer les données pour l'insertion multiple
    $insertData = [];
    $now = now();
    
    foreach ($gestionThemes as $gestionTheme) {
        // Vérifier que l'étudiant existe
        if ($gestionTheme->etudiant) {
            $insertData[] = [
                'ThemeID' => $request->ThemeID,
                'ProfesseurID' => $request->ProfesseurID,
                'SousEncadrantID' => $request->SousEncadrantID,
                'EtudiantID' => $gestionTheme->etudiant->EtudiantID,
                'SpecialiteID' => $gestionTheme->SpecialiteID,
                'GroupID' => optional($gestionTheme->etudiant->group)->GroupID,
                'HeureDebut' => $request->HeureDebut,
                'HeureFin' => $request->HeureFin,
                'LocalID' => $request->LocalID,
                'Jour' => $request->Jour,
                'created_at' => $now,
                'updated_at' => $now,
                'user_id' => auth()->id(), 
            ];
        }
    }
    
    if (empty($insertData)) {
        return back()->withErrors(['error' => 'Aucun étudiant valide trouvé pour ce thème'])->withInput();
    }
    
    // Insertion multiple
    DB::table('emploisoutenance')->insert($insertData);
    
    return redirect()->route('soutenance.index')
        ->with('success', count($insertData) . ' emplois de soutenance créés avec succès!');
}
// Add these methods to your EmploiDeSoutenanceController

public function edit($id)
{
    $emploi = EmploiDeSoutenance::with(['theme', 'professeur', 'sousEncadrant', 'etudiant', 'specialite', 'group', 'local'])
                ->where('user_id', auth()->id())
                ->findOrFail($id);

    $professeurs = Professeur::all();
    $themes = Theme::where('DepartementID', auth()->user()->departement_id)->get();
    $locals = Local::all();

    return view('soutenance.edit', compact('emploi', 'professeurs', 'themes', 'locals'));
}

public function update(Request $request, $id)
{
    $emploi = EmploiDeSoutenance::where('user_id', auth()->id())
                ->findOrFail($id);

    $request->validate([
        'ThemeID' => 'required',
        'ProfesseurID' => 'required',
        'SousEncadrantID' => 'nullable',
        'HeureDebut' => 'required',
        'HeureFin' => 'required',
        'LocalID' => 'required',
        'Jour' => 'required|string',
    ]);

    $emploi->update($request->all());

    return redirect()->route('soutenance.index')
        ->with('success', 'Emploi de soutenance modifié avec succès!');
}

public function destroy($id)
{
    $emploi = EmploiDeSoutenance::findOrFail($id);

    // Vérification que l'emploi appartient au bon département
    if ($emploi->user_id !== auth()->id()) {
        return redirect()->route('soutenance.index')->withErrors(['error' => 'Action non autorisée.']);
    }

    $emploi->delete();

    return redirect()->route('soutenance.index')->with('success', 'Emploi supprimé avec succès.');
}






}