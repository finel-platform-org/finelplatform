<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Section;
use App\Models\Parcours;
use App\Models\Niveau;
use App\Models\Specialite;
use App\Models\Group;
use App\Models\Module;
use App\Models\Activite;
use App\Models\Professeur;
use App\Models\Local;
use App\Models\Semester;

use App\Models\EmploiDuTemps;

class EmploiDuTempsController extends Controller
{
    /**
     * Affiche la page d'accueil avec le tableau des emplois du temps.
     */
    public function index()
    {
        // Récupérer les données depuis la base
        $sections = Section::all();
        $parcours = Parcours::all();
        $niveaux = Niveau::all();
        $specialites = Specialite::all();
        $groups = Group::all();
        $modules = Module::all();
        $activites = Activite::all();
        $professeurs = Professeur::all();
        $locaux = Local::all();
        $emplois = EmploiDuTemps::all();
        $semesters = Semester::all();
        

        // Passer les données à la vue
        $emplois = EmploiDuTemps::with(['niveau', 'group', 'activite', 'module', 'locals', 'professeur', 'specialite', 'semester'  ,'departement']) ->where('departement_id', auth()->user()->departement_id)
        ->get();


    return view ('emploi_du_temps.index', compact('emplois'));
    }

    /**
     * Affiche le formulaire pour créer un emploi du temps.
     */
    public function create(Request $request)
{
    $day = $request->query('day');
    $timeSlot = $request->query('time'); // Rename to avoid confusion

    // Validate day and timeSlot
    if (!$day || !is_numeric($timeSlot) || $timeSlot < 0 || $timeSlot > 5) {
        return back()->withErrors("Paramètres invalides.");
    }

    $timeRanges = [
        0 => '08:00 - 09:30',
        1 => '09:30 - 11:00',
        2 => '11:00 - 12:30',
        3 => '12:30 - 14:00',
        4 => '14:00 - 15:30',
        5 => '15:30 - 17:00',
    ];


    $sections = Section::with('modules')->get();
    $parcours = Parcours::all();
    $niveaux = Niveau::with('semesters')->get();
    $specialites = Specialite::all();
    $groups = Group::all();
   // $modules = Module::all();
    $activites = Activite::all();
    $professeurs = Professeur::where('DepartementID', auth()->user()->departement_id)->get();
    $locaux = Local::all();
   

    return view('emploi_du_temps.create', compact(
        'day', 'timeSlot', 'timeRanges', 'sections', 'parcours',
        'niveaux', 'specialites', 'groups', 
        'activites', 'professeurs', 'locaux'
    ));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'SectionID' => 'required|exists:sections,SectionID',
        'ParcoursID' => 'required|exists:parcours,ParcoursID',
        'NiveauID' => 'required|exists:niveaux,NiveauID',
        'SpecialiteID' => 'required|exists:specialites,SpecialiteID',
        'SemestreID' => 'required|exists:semesters,SemestreID', 
        
        'GroupID' => 'required|exists:groups,GroupID',
        'ModuleID' => 'required|exists:modules,ModuleID',
        'ActiviteID' => 'required|exists:activites,ActiviteID',
        'ProfesseurID' => 'required|exists:professeurs,ProfesseurID',
        'LocalID' => 'required|exists:locals,LocalID',
        'Jour' => 'required|string|in:Lundi,Mardi,Mercredi,Jeudi,Vendredi,Samedi,Dimanche',
        'TimeSlot' => 'required|integer|min:0|max:5',
    ]);

    // Get the authenticated user's departement_id
    $userDepartementId = auth()->user()->departement_id;
    
    if (!$userDepartementId) {
        return back()->withErrors("L'utilisateur n'est pas associé à un département.")->withInput();
    }

    // Add the department ID to the validated data
    $validatedData['departement_id'] = $userDepartementId;



    // Vérification #1 : local déjà pris
    $localConflit = EmploiDuTemps::where('Jour', $validatedData['Jour'])
        ->where('TimeSlot', $validatedData['TimeSlot'])
        ->where('LocalID', $validatedData['LocalID'])
        ->exists();

    if ($localConflit) {
        return back()->withErrors("Ce local est déjà réservé à ce créneau.")->withInput();
    }

    // Vérification #2 : professeur déjà pris
    $profConflit = EmploiDuTemps::where('Jour', $validatedData['Jour'])
        ->where('TimeSlot', $validatedData['TimeSlot'])
        ->where('ProfesseurID', $validatedData['ProfesseurID'])
        ->exists();

    if ($profConflit) {
        return back()->withErrors("Ce professeur est déjà occupé à ce créneau.")->withInput();
    }

    // Vérification #3 : groupe déjà pris
    $groupeConflit = EmploiDuTemps::where('Jour', $validatedData['Jour'])
        ->where('TimeSlot', $validatedData['TimeSlot'])
        ->where('GroupID', $validatedData['GroupID'])
        ->exists();

    if ($groupeConflit) {
        return back()->withErrors("Ce groupe a déjà une activité à ce créneau.")->withInput();
    }

    // Si tout est OK, on insère
    EmploiDuTemps::create($validatedData);

    return redirect()->route('emploi_du_temps.index')->with('success', 'Emploi du temps ajouté avec succès.');
}

public function getNiveauxByParcours($id)
    {
        $niveaux = Niveau::where('ParcoursID', $id)->get();
        return response()->json($niveaux);
    }

    public function getSemestresByNiveau($id)
    {
        // Modifiez la jointure pour utiliser la bonne colonne de clé primaire
        $semesters = Semester::where('NiveauID', $id)
                             ->join('niveau_semester', 'semesters.SemestreID', '=', 'niveau_semester.SemestreID')
                             ->get();
        return response()->json($semesters);
    }
    


    public function getSpecialitesByNiveau($id)
    {
        $specialites = Specialite::where('NiveauID', $id)->get();
        return response()->json($specialites);
    }

    public function getSectionsBySpecialite($id)
    {
        $sections = Section::where('SpecialiteID', $id)->get();
        return response()->json($sections);
    }

    public function getGroupesBySection($id)
    {
        $groupes = Group::where('SectionID', $id)->get();
        return response()->json($groupes);
    }

    public function getModulesBySemestre($id)
{
    // Récupérer le semestre avec ses modules associés
    $modules = Semester::findOrFail($id)->modules;

    // Retourner les modules sous forme de réponse JSON
    return response()->json($modules);
}

    public function getSemestresByModule($id)
    {
        $semesters = Module::findOrFail($id)->semesters;
        return response()->json($semesters);
    }

    public function getProfsByModule($id)
{
    $profs = Module::findOrFail($id)
        ->professeurs()
        ->where('DepartementID', auth()->user()->departement_id)
        ->get();
        
    return response()->json($profs);
}

    public function getLocauxByActivite($id)
    {
        $locaux = Activite::findOrFail($id)->locals;
        return response()->json($locaux);
    }
    public function getModulesBySection($id)
{
    // Récupérer les modules associés à la section donnée
    $modules = Section::findOrFail($id)->modules;  // Assure-toi que la relation est correctement définie dans le modèle Section

    // Retourner les modules sous forme de réponse JSON
    return response()->json($modules);
}





   
}