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
        $themes = Theme::all();
        $locals = Local::all();
        return view('soutenance.create', compact('professeurs', 'themes', 'locals'));
    }
    public function getGestionThemeByTheme(Request $request)
    {
        $themeID = $request->query('theme');
        $gestionTheme = GestionDesTheme::with(['professeurs', 'etudiants.group', 'specialite'])
            ->where('ThemeID', $themeID)
            ->first();
    
        if (!$gestionTheme) {
            return response()->json(['error' => 'Aucune correspondance trouvée'], 404);
        }
    
        // Récupérer tous les étudiants avec leurs groupes
        $etudiants = $gestionTheme->etudiants->map(function($etudiant) {
            return [
                'id' => $etudiant->EtudiantID,
                'nom' => $etudiant->Nom,
                'groupe_id' => $etudiant->group->GroupID ?? null,
                'groupe_nom' => $etudiant->group->Nom ?? '—'
            ];
        });
    
        return response()->json([
            'encadrant' => $gestionTheme->professeurs
                ->where('pivot.role', 'encadrant')
                ->map(fn($prof) => ['id' => $prof->ProfesseurID, 'nom' => $prof->Nom])
                ->first(),
            'sous_encadrant' => $gestionTheme->professeurs
                ->where('pivot.role', 'sous_encadrant')
                ->map(fn($prof) => ['id' => $prof->ProfesseurID, 'nom' => $prof->Nom])
                ->first(),
            'etudiants' => $etudiants,
            'specialite' => [
                'id' => $gestionTheme->SpecialiteID,
                'nom' => $gestionTheme->specialite->Nom,
            ],
        ]);
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
    
        // Récupérer la gestion du thème avec les étudiants
        $gestionTheme = GestionDesTheme::with(['etudiants.group', 'specialite'])
            ->where('ThemeID', $request->ThemeID)
            ->first();
    
        if (!$gestionTheme || $gestionTheme->etudiants->isEmpty()) {
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
    
        foreach ($gestionTheme->etudiants as $etudiant) {
            $insertData[] = [
                'ThemeID' => $request->ThemeID,
                'ProfesseurID' => $request->ProfesseurID,
                'SousEncadrantID' => $request->SousEncadrantID,
                'EtudiantID' => $etudiant->EtudiantID,
                'SpecialiteID' => $gestionTheme->SpecialiteID,
                'GroupID' => $etudiant->group->GroupID ?? null,
                'HeureDebut' => $request->HeureDebut,
                'HeureFin' => $request->HeureFin,
                'LocalID' => $request->LocalID,
                'Jour' => $request->Jour,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }
    
        // Insertion multiple
        DB::table('emploisoutenance')->insert($insertData);
    
        return redirect()->route('soutenance.index')
            ->with('success', count($insertData) . ' emplois de soutenance créés avec succès!');
    }


}