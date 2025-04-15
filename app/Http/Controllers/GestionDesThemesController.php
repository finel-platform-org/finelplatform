<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GestionDesTheme;
use App\Models\Theme;
use App\Models\Etudiant;
use App\Models\Professeur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class GestionDesThemesController extends Controller
{
    public function index()
{
    $admin = Auth::user();
    $gestiondesthemes = GestionDesTheme::with([
        'theme',
        'specialite',
        'etudiants.group', // Charger les groupes via les étudiants
        'professeurs' => function($query) {
            $query->withPivot('role');
        }
    ])->where('DepartementID', $admin->departement_id)->get();

    return view('gestiondesthemes.index', compact('gestiondesthemes'));
}

    public function create()
    {
        $admin = Auth::user();
        
        // Filtrer les thèmes par département de l'admin
        $themes = Theme::where('DepartementID', $admin->departement_id)->get();
        
        // Filtrer les professeurs par département de l'admin
        $professeurs = Professeur::where('DepartementID', $admin->departement_id)->get();
        
        $etudiants = Etudiant::with(['group', 'specialite'])->get();
    
        return view('gestiondesthemes.create', compact('themes', 'professeurs', 'etudiants'));
    }

    public function getProfessorByTheme($themeId)
    {
        $theme = Theme::with('professeur')->findOrFail($themeId);
        
        if (!$theme->professeur) {
            return response()->json(['error' => 'Aucun professeur associé à ce thème'], 404);
        }
        
        return response()->json([
            'ProfesseurID' => $theme->professeur->ProfesseurID,
            'Nom' => $theme->professeur->Nom
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'ThemeID' => 'required|exists:themes,ThemeID',
            'ProfesseurID_encadrant' => 'required|exists:professeurs,ProfesseurID',
            'ProfesseurID_sous_encadrant' => 'nullable|exists:professeurs,ProfesseurID',
            'EtudiantID' => 'required|array|min:1',
            'EtudiantID.*' => 'exists:etudiants,EtudiantID',
        ]);
    
        DB::beginTransaction();
        try {
            $admin = Auth::user();
            $etudiants = Etudiant::whereIn('EtudiantID', $request->EtudiantID)->get();
    
            $firstStudent = $etudiants->first();
            
            $gestionTheme = GestionDesTheme::create([
                'SpecialiteID' => $firstStudent->SpecialiteID,
                'GroupID' => $firstStudent->GroupID,
                'ThemeID' => $request->ThemeID,
                'DepartementID' => $admin->departement_id,
            ]);
    
            // Attacher les étudiants
            $gestionTheme->etudiants()->attach($request->EtudiantID);
    
            // Préparer les données des professeurs
            $professeursData = [
                $request->ProfesseurID_encadrant => ['role' => 'encadrant']
            ];
    
            // Ajouter le sous-encadrant si spécifié
            if ($request->ProfesseurID_sous_encadrant) {
                $professeursData[$request->ProfesseurID_sous_encadrant] = ['role' => 'sous_encadrant'];
            }
    
            // Attacher tous les professeurs en une seule opération
            $gestionTheme->professeurs()->attach($professeursData);
    
            DB::commit();
            return redirect()->route('gestiondesthemes.index')->with('success', 'Affectation créée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la création: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $gestionTheme = GestionDesTheme::findOrFail($id);
            $gestionTheme->etudiants()->detach();
            $gestionTheme->professeurs()->detach();
            $gestionTheme->delete();
            
            DB::commit();
            return redirect()->route('gestiondesthemes.index')->with('success', 'Affectation supprimée avec succès.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Erreur lors de la suppression: ' . $e->getMessage());
        }
    }

    public function getStudentsInfo(Request $request)
{
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:etudiants,EtudiantID'
    ]);

    $students = Etudiant::with(['group', 'specialite'])
                ->whereIn('EtudiantID', $request->ids)
                ->get();

    return response()->json([
        'students' => $students->map(function($student) {
            return [
                'id' => $student->EtudiantID,
                'name' => $student->Nom,
                'group' => $student->group->Nom ?? 'Non défini',
                'specialite' => $student->specialite->Nom ?? 'Non définie'
            ];
        })
    ]);
}

public function getAllProfessors()
{
    $admin = Auth::user();
    $professeurs = Professeur::where('DepartementID', $admin->departement_id)->get();
    return response()->json($professeurs);
}


}