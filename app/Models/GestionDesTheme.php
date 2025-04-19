<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Etudiant;


class GestionDesTheme extends Model
{
    protected $table = 'gestiondesthemes';
    protected $primaryKey = 'GestionThemeID';
    public $timestamps = true;

    protected $fillable = [
        'SpecialiteID',
        'GroupID',
        'ThemeID',
        'DepartementID',
         'EtudiantID'
    ];

    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'SpecialiteID');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'GroupID');
    }

   
    public function professeurs()
    {
        return $this->belongsToMany(Professeur::class, 'gestion_theme_professeur', 'GestionThemeID', 'ProfesseurID')
                    ->withPivot('role');
    }
    

    public function theme()
    {
        return $this->belongsTo(Theme::class, 'ThemeID');
    }

    public function departement()
    {
        return $this->belongsTo(Departement::class, 'DepartementID');
    }
    public function getGroupsAttribute()
{
    return $this->etudiants->pluck('group.Nom')->unique()->implode(', ');
}
// app/Models/GestionDesTheme.php

// Retirez la relation many-to-many
public function etudiant()
{
    return $this->belongsTo(Etudiant::class, 'EtudiantID');
}

}