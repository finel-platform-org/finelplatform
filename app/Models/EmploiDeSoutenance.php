<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploiDeSoutenance extends Model
{
    use HasFactory;
    
    protected $table = 'emploisoutenance';
    protected $primaryKey = 'EmploiSoutenanceID';
    public $timestamps = true;
    protected $fillable = [
        'ProfesseurID', 
        'SousEncadrantID',
        'ThemeID', 
        'EtudiantID', 
        'SpecialiteID', 
        'GroupID', 
        'HeureDebut', 
        'HeureFin', 
        'LocalID',
        'Jour'
    ];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class, 'ProfesseurID');
    }
    public function sousEncadrant()
    {
        return $this->belongsTo(Professeur::class, 'SousEncadrantID');
    }


    public function theme()
    {
        return $this->belongsTo(Theme::class, 'ThemeID');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'EtudiantID');
    }

    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'SpecialiteID');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'GroupID');
    }

    public function local()
    {
        return $this->belongsTo(Local::class, 'LocalID');
    }
}
