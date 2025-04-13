<?php

namespace App\Http\Controllers;

use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesseurController extends Controller
{
    public function index()
{
    $header = 'Gestion des Professeurs';
    
    // Filtrer les professeurs selon le département de l’admin connecté
    $departementID = Auth::user()->departement_id;
    $professeurs = Professeur::where('DepartementID', $departementID)->get();

    return view('professeurs.index', compact('professeurs', 'header'));
}


    public function create()
    {
        return view('professeurs.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'Nom' => 'required',
            'grade' => 'required',
            'email' => 'required|email|unique:professeurs',
            'bureau' => 'required',
        ]);

        // Récupérer l'ID du département de l'utilisateur connecté
        $departementID = Auth::user()->departement_id;


        $existingIDs = Professeur::pluck('ProfesseurID')->toArray();

        // Trouver le premier ID manquant
        $firstMissingID = 0;
        while (in_array($firstMissingID, $existingIDs)) {
            $firstMissingID++;
    }

        // Création du professeur avec l'ajout automatique du DepartementID
        Professeur::create([
            'ProfesseurID' => $firstMissingID,
            'Nom' => $request->Nom,
            'grade' => $request->grade,
            'email' => $request->email,
            'bureau' => $request->bureau,
            'DepartementID' => $departementID,
        ]);
        

        return redirect()->route('professeurs.index')->with('success', 'Professeur créé avec succès.');
    }

    public function edit(Professeur $professeur)
    {
        return view('professeurs.edit', compact('professeur'));
    }

    public function update(Request $request, Professeur $professeur)
    {
        $request->validate([
            'Nom' => 'required',
            'grade' => 'required',
            'email' => 'required|email|unique:professeurs,email,' . $professeur->ProfesseurID,
            'bureau' => 'required',
        ]);

        // On ne met pas à jour le `DepartementID`, car il doit rester celui du créateur initial
        $professeur->update([
            'Nom' => $request->Nom,
            'grade' => $request->grade,
            'email' => $request->email,
            'bureau' => $request->bureau,
        ]);

        return redirect()->route('professeurs.index')->with('success', 'Professeur mis à jour avec succès.');
    }

    public function destroy(Professeur $professeur)
    {
        $professeur->delete();
        return redirect()->route('professeurs.index')->with('success', 'Professeur supprimé avec succès.');
    }
}
