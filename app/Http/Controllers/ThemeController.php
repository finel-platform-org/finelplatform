<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Theme;
use App\Models\Professeur;
use Illuminate\Support\Facades\Auth;

class ThemeController extends Controller
{
    public function index()
    {
        // Get the department ID of the logged-in admin
        $departementId = Auth::user()->departement_id;
        
        // Load only themes from the same department
        $themes = Theme::with('professeur')
                      ->where('DepartementID', $departementId)
                      ->get();

        return view('themes.index', compact('themes'));
    }

    public function create()
    {
        // Get the department ID of the logged-in admin
        $departementId = Auth::user()->departement_id;
        
        if (!$departementId) {
            return redirect()->back()->with('error', 'Département introuvable pour cet administrateur.');
        }

        // Get professors from the same department
        $professeurs = Professeur::where('DepartementID', $departementId)->get();

        return view('themes.create', compact('professeurs'));
    }



    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'Nom' => 'required|string|max:255',
            'ProfesseurID' => 'required|exists:professeurs,ProfesseurID',
        ]);



       // Get the department ID of the logged-in admin
        $departementId = Auth::user()->departement_id;

        // Create the theme with the professor and department
        $theme = Theme::create([
            'Nom' => $request->Nom,
            'ProfesseurID' => $request->ProfesseurID,
            'DepartementID' => $departementId,
        ]);
        // Si tu utilises vraiment une table pivot many-to-many (facultatif)
        // $theme->professeurs()->attach($request->ProfesseurID);

        return redirect()->route('themes.index')->with('success', 'Thème ajouté avec succès');
    }
}
