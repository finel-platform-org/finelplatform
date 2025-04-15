<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionDesTheme extends Model
{
    protected $table = 'gestiondesthemes';
    protected $primaryKey = 'GestionThemeID';
    public $timestamps = true;

    protected $fillable = [
        'SpecialiteID',
        'GroupID',
        'ThemeID',
        'DepartementID'
    ];

    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'SpecialiteID');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'GroupID');
    }

    public function etudiants()
    {
        return $this->belongsToMany(Etudiant::class, 'gestion_theme_etudiant', 'GestionThemeID', 'EtudiantID')
                    ->withPivot('id');
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
}