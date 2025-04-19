<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\EmploiDuTempsController;
use App\Http\Controllers\ProfesseurController;
use App\Http\Controllers\GestionDesThemesController;
use App\Http\Controllers\EmploiDeSoutenanceController;

use App\Http\Controllers\LocalController;
use App\Http\Controllers\ThemeController;



Route::get('/', function () {
    return view('welcome'); // Show welcome page
});

// Include Auth routes (login, register, etc.)
require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
Route::prefix('emploi_du_temps')->group(function () {
    Route::get('/', [EmploiDuTempsController::class, 'index'])->name('emploi_du_temps.index');
    Route::post('/', [EmploiDuTempsController::class, 'store'])->name('emploi_du_temps.store');
});

Route::get('/emploi_du_temps/create', [EmploiDuTempsController::class, 'create'])->name('emploi_du_temps.create');


Route::resource('professeurs', ProfesseurController::class);

Route::resource('gestiondesthemes', GestionDesThemesController::class);
// Route pour afficher la liste des emplois de soutenance
Route::get('/soutenance', [EmploiDeSoutenanceController::class, 'index'])->name('soutenance.index');

// Route pour afficher le formulaire de création d'un emploi de soutenance (avec un paramètre optionnel pour le jour)
Route::get('/soutenance/create', [EmploiDeSoutenanceController::class, 'create'])->name('soutenance.create');

// Route pour enregistrer un emploi de soutenance
Route::post('/soutenance', [EmploiDeSoutenanceController::class, 'store'])->name('soutenance.store');

Route::get('/soutenances/create', [EmploiDeSoutenanceController::class, 'create'])->name('soutenances.create');
Route::post('/soutenances/store', [EmploiDeSoutenanceController::class, 'store'])->name('soutenances.store');
Route::get('/get-gestion-theme-by-theme', [EmploiDeSoutenanceController::class, 'getGestionThemeByTheme'])->name('getGestionThemeByTheme');



Route::resource('locals', LocalController::class);
Route::get('/locals', [LocalController::class, 'index'])->name('locals.index');

    // Afficher tous les thèmes
    Route::get('/themes', [ThemeController::class, 'index'])->name('themes.index');

    // Afficher le formulaire de création
   

    // Enregistrer un nouveau thème
    Route::post('/themes', [ThemeController::class, 'store'])->name('themes.store');
// Retirer du groupe 'auth' pour tester
Route::get('/themes/create', [ThemeController::class, 'create'])->name('themes.create');

Route::get('/get-niveaux-by-parcours/{id}', [EmploiDuTempsController::class, 'getNiveauxByParcours']);
Route::get('/get-semestres-by-niveau/{id}', [EmploiDuTempsController::class, 'getSemestresByNiveau']);
Route::get('/get-specialites-by-niveau/{id}', [EmploiDuTempsController::class, 'getSpecialitesByNiveau']);
Route::get('/get-sections-by-specialite/{id}', [EmploiDuTempsController::class, 'getSectionsBySpecialite']);
Route::get('/get-groupes-by-section/{id}', [EmploiDuTempsController::class, 'getGroupesBySection']);
Route::get('/get-modules-by-section/{id}', [EmploiDuTempsController::class, 'getModulesBySection']);

Route::get('/get-semestres-by-module/{id}', [EmploiDuTempsController::class, 'getSemestresByModule']);
Route::get('/get-profs-by-module/{id}', [EmploiDuTempsController::class, 'getProfsByModule']);
Route::get('/get-locaux-by-activite/{id}', [EmploiDuTempsController::class, 'getLocauxByActivite']);

Route::get('/specialites/{id}/sections', [GestionDesThemesController::class, 'getSections']);

Route::get('/get-groups-by-section/{id}', [App\Http\Controllers\GroupeController::class, 'getGroupesBySection']);
Route::get('/get-etudiants-by-group/{groupID}', [App\Http\Controllers\EtudiantController::class, 'getByGroup']);
// Gestion des thèmes
Route::resource('gestiondesthemes', GestionDesThemesController::class);
Route::get('/get-students-info', [GestionDesThemesController::class, 'getStudentsInfo']);
Route::get('/professeurs/{id}', [ProfesseurController::class, 'show']);
Route::get('/get-professor-by-theme/{themeId}', [GestionDesThemesController::class, 'getProfessorByTheme']);
Route::get('/get-all-professors', [GestionDesThemesController::class, 'getAllProfessors']);
Route::get('/get-parcours-by-departement', [EmploiDuTempsController::class, 'getParcoursByDepartement']);
//Route::resource('soutenance', EmploiDeSoutenanceController::class)->except(['show']);
Route::get('/soutenance/{id}/edit', [EmploiDeSoutenanceController::class, 'edit'])->name('soutenance.edit');
Route::put('/soutenance/{id}', [EmploiDeSoutenanceController::class, 'update'])->name('soutenance.update');
Route::delete('/soutenance/{id}', [EmploiDeSoutenanceController::class, 'destroy'])->name('soutenance.destroy');



