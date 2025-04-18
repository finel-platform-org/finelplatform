<?php

// app/Models/Etudiant.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    protected $primaryKey = 'EtudiantID';
    public $timestamps = true;

    // A student belongs to a group
    public function group()
    {
        return $this->belongsTo(Group::class, 'GroupID');
    }

    // A student belongs to a speciality
    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'SpecialiteID');
    }

    // A student belongs to a niveau
    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'NiveauID');
    }
    
    
    public function professeurs()
{
    return $this->belongsToMany(Professeur::class, 'gestion_theme_professeur', 'EtudiantID', 'ProfesseurID')->withTimestamps();
}
// app/Models/Etudiant.php

public function gestionTheme()
{
    return $this->hasOne(GestionDesTheme::class, 'EtudiantID');
}


}
