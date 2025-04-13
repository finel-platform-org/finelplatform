<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GestionDesTheme;
use App\Models\Theme;
use App\Models\Specialite;
use App\Models\Section;
use App\Models\Group;
use App\Models\Etudiant;
use App\Models\Professeur;
use Illuminate\Support\Facades\Auth;

class GestionDesThemesController extends Controller
{
   public function index()
{
    $admin = Auth::user();
    $departmentID = $admin->departement_id;

    $gestiondesthemes = GestionDesTheme::with([
        'theme', 
        'specialite', 
        'group', 
        'etudiants',
        'professeurs' => function ($query) {
            $query->withPivot('role');
        }
    ])
    ->where('DepartementID', $departmentID)
    ->get();

    return view('gestiondesthemes.index', compact('gestiondesthemes'));
}


    public function create()
    {
        $themes = Theme::all();
        $specialites = Specialite::all();
        $groups = Group::all();
        $etudiants = Etudiant::all();
        $professeurs = Professeur::all();
        $sections = Section::all();

        return view('gestiondesthemes.create', compact('themes', 'specialites', 'groups', 'etudiants', 'professeurs','sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'SpecialiteID' => 'required|exists:specialites,SpecialiteID',
            'SectionID' => 'required|exists:sections,SectionID',
            'GroupID' => 'required|exists:groups,GroupID',
            'ThemeID' => 'required|exists:themes,ThemeID',
            'EtudiantID' => 'required|array|min:1',
            'ProfesseurID.encadrant' => 'required|array|min:1',
            'ProfesseurID.sous_encadrant' => 'nullable|array',
        ]);

        $admin = Auth::user();

        $gestionTheme = GestionDesTheme::create([
            'SpecialiteID' => $request->SpecialiteID,
            'SectionID' => $request->SectionID,
            'GroupID' => $request->GroupID,
            'ThemeID' => $request->ThemeID,
            'DepartementID' => $admin->departement_id,
        ]);

        if (!$gestionTheme) {
            return back()->with('error', 'Erreur lors de la création de la gestion de thème.');
        }

        // Attacher les étudiants
        $gestionTheme->etudiants()->attach($request->EtudiantID);

        // Attacher les professeurs avec leurs rôles
        foreach ($request->ProfesseurID['encadrant'] as $profID) {
            $gestionTheme->professeurs()->attach($profID, [
                'role' => 'encadrant',
                
            ]);
        }

        if (!empty($request->ProfesseurID['sous_encadrant'])) {
            foreach ($request->ProfesseurID['sous_encadrant'] as $profID) {
                $gestionTheme->professeurs()->attach($profID, [
                    'role' => 'sous_encadrant',
                    
            
                ]);
            }
        }

        return redirect()->route('gestiondesthemes.index')->with('success', 'Gestion des thèmes ajoutée avec succès.');
    }

    public function destroy($id)
    {
        $gestionTheme = GestionDesTheme::find($id);

        if (!$gestionTheme) {
            return redirect()->route('gestiondesthemes.index')->with('error', 'Gestion de thème introuvable.');
        }

        $gestionTheme->etudiants()->detach();
        $gestionTheme->professeurs()->detach();
        $gestionTheme->delete();

        return redirect()->route('gestiondesthemes.index')->with('success', 'Gestion de thème supprimée avec succès.');
    }

    // 🔹 Appelé via AJAX pour récupérer les sections d’une spécialité
    public function getSections($specialiteID)
    {
        $sections = Section::where('SpecialiteID', $specialiteID)->get(['SectionID', 'Nom']);
        return response()->json($sections);
    }
    public function getGroupesBySection($sectionId)
    {
        $groups = Group::where('SectionID', $sectionId)->get(['GroupID', 'Nom']);
        return response()->json($groups);
    }

    public function getByGroup($groupID)
    {
        // Vérification des étudiants récupérés
        $etudiants = Etudiant::where('GroupID', $groupID)->get(['EtudiantID', 'Nom']);
    
        // Log pour débogage
        \Log::info('Étudiants récupérés pour le groupe ' . $groupID, $etudiants->toArray());
    
        // Retourner les données en format JSON
        return response()->json($etudiants);
    }
    


    



}
