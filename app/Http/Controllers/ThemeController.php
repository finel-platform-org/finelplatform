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
        // Charger tous les thèmes avec le professeur (relation one-to-one)
        $themes = Theme::with('professeur')->get();

        return view('themes.index', compact('themes'));
    }

    public function create()
{
    // Suppression de la vérification Auth
    // Remplace Auth::user() par un utilisateur générique ou une valeur par défaut

    // Exemple sans Auth
    $adminDepartmentID = 1; // Si tu veux forcer un département particulier pour l'exemple

    if (!$adminDepartmentID) {
        return redirect()->back()->with('error', 'Département introuvable pour cet administrateur.');
    }

    // Récupérer les professeurs du même département
    $professeurs = Professeur::where('DepartementID', $adminDepartmentID)->get();

    return view('themes.create', compact('professeurs'));
}


    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'Nom' => 'required|string|max:255',
            'ProfesseurID' => 'required|exists:professeurs,ProfesseurID',
        ]);

        // Création du thème avec le professeur sélectionné (clé étrangère directe)
        $theme = Theme::create([
            'Nom' => $request->Nom,
            'ProfesseurID' => $request->ProfesseurID,
        ]);

        // Si tu utilises vraiment une table pivot many-to-many (facultatif)
        // $theme->professeurs()->attach($request->ProfesseurID);

        return redirect()->route('themes.index')->with('success', 'Thème ajouté avec succès');
    }
}
