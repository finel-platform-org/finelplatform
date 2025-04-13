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
        $emplois = EmploiDeSoutenance::with(['professeur', 'theme', 'etudiant', 'specialite', 'group', 'local'])->get();
        
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

    $gestionTheme = GestionDesTheme::where('ThemeID', $themeID)->first();

    if (!$gestionTheme) {
        return response()->json(['error' => 'Aucune correspondance trouvée'], 404);
    }

    return response()->json([
        'professeurs' => $gestionTheme->professeurs->map(fn($prof) => [
            'id' => $prof->ProfesseurID,
            'nom' => $prof->Nom
        ]),
        'etudiants' => $gestionTheme->etudiants->map(fn($etudiant) => [
            'id' => $etudiant->EtudiantID,
            'nom' => $etudiant->Nom
        ]),
        'specialite' => [
            'id' => $gestionTheme->SpecialiteID,
            'nom' => $gestionTheme->specialite->Nom,
        ],
        'groupe' => [
            'id' => $gestionTheme->GroupID,
            'nom' => $gestionTheme->group->Nom,
        ],
    ]);
}


public function store(Request $request)
{
    // Validation des champs
    $request->validate([
        'ThemeID' => 'required',
        'ProfesseurID' => 'required',
        'EtudiantID' => 'required',
        'SpecialiteID' => 'required',
        'GroupID' => 'required',
        'HeureDebut' => 'required',
        'HeureFin' => 'required',
        'LocalID' => 'required',
        'Jour' => 'required|string',
    ]);

    // Vérifier s'il y a déjà un emploi de soutenance dans le même local, jour et créneau
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

    // Vérifier s'il y a un conflit de créneau pour le même professeur
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
    $gestionTheme = DB::table('gestion_theme_professeur')
        ->join('gestiondesthemes', 'gestion_theme_professeur.GestionThemeID', '=', 'gestiondesthemes.GestionThemeID')
        ->where('gestion_theme_professeur.ProfesseurID', $request->ProfesseurID)
        ->where('gestiondesthemes.ThemeID', $request->ThemeID)
        ->first();

    if (!$gestionTheme) {
        return back()->withErrors(['error' => 'Ce professeur n\'est pas associé à ce thème.'])->withInput();
    }

    // Insertion
    DB::table('emploisoutenance')->insert([
        'ThemeID' => $request->ThemeID,
        'ProfesseurID' => $request->ProfesseurID,
        'EtudiantID' => $request->EtudiantID,
        'SpecialiteID' => $request->SpecialiteID,
        'GroupID' => $request->GroupID,
        'HeureDebut' => $request->HeureDebut,
        'HeureFin' => $request->HeureFin,
        'LocalID' => $request->LocalID,
        'Jour' => $request->Jour,
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('soutenance.index')->with('success', 'Emploi de soutenance ajouté avec succès !');
}


}
