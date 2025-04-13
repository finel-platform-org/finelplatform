<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Professeur extends Model
{
    protected $primaryKey = 'ProfesseurID';
    public $timestamps = true;

    // Définir les champs autorisés pour le mass assignment
    protected $fillable = ['Nom', 'DepartementID', 'grade', 'email', 'bureau'];

    // Relations
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'DepartementID');
    }

    public function modules()
    {
        return $this->belongsToMany(Module::class, 'professeur_module', 'ProfesseurID', 'ModuleID');
    }

    public function specialites()
    {
        return $this->belongsToMany(Specialite::class, 'professeur_specialite', 'ProfesseurID', 'SpecialiteID');
    }

    public function parcours()
    {
        return $this->belongsToMany(Parcours::class, 'professeur_parcours', 'ProfesseurID', 'ParcoursID');
    }

    public function niveaux()
    {
        return $this->belongsToMany(Niveau::class, 'professeur_niveau', 'ProfesseurID', 'NiveauID');
    }
    public function themes()
{
    return $this->belongsToMany(Theme::class, 'gestion_theme_professeur', 'ProfesseurID', 'ThemeID')->withTimestamps();
}

public function etudiants()
{
    return $this->belongsToMany(Etudiant::class, 'gestion_theme_professeur', 'ProfesseurID', 'EtudiantID')->withTimestamps();
}
public function gestionThemes()
    {
        return $this->belongsToMany(GestionDesTheme::class, 'gestion_theme_professeur', 'ProfesseurID', 'GestionThemeID');
    }

}
