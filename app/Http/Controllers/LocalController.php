<?php
namespace App\Http\Controllers;

use App\Models\Local;
use Illuminate\Http\Request;

class LocalController extends Controller
{
    public function index()
    {
        $locals = Local::all(); // Récupérer toutes les salles
    
        return view('locals.index', compact('locals'));
    }
    

    public function create()
    {
        return view('locals.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:100',
        'capacite' => 'nullable|integer|min:1',
    ]);

    Local::create([
        'Nom' => $request->nom,
        'Capacite' => $request->capacite,
    ]);

    return redirect()->route('locals.index')->with('success', 'Salle créée avec succès.');
}

    public function edit(Local $local)
    {
        return view('locals.edit', compact('local'));
    }

    public function update(Request $request, Local $local)
    {
        $request->validate([
            'nom' => 'required|unique:locals,nom,' . $local->id,
            'capacite' => 'required|integer|min:1',
        ]);

        $local->update($request->all());

        return redirect()->route('locals.index')->with('success', 'Salle mise à jour.');
    }

    public function destroy(Local $local)
    {
        $local->delete();
        return redirect()->route('locals.index')->with('success', 'Salle supprimée.');
    }
}
