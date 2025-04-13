<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmploiDuTemps extends Model
{
    use HasFactory;
    protected $table = 'emploi_du_temps';
    protected $fillable = [
        'Jour', 'TimeSlot', 'SectionID', 'ParcoursID', 'NiveauID', 
        'SpecialiteID', 'GroupID', 'ModuleID', 'ActiviteID', 'ProfesseurID', 'LocalID',
    ];

    // Define relationships if needed
    public function section()
    {
        return $this->belongsTo(Section::class, 'SectionID');
    }

    public function niveau()
    {
        return $this->belongsTo(Niveau::class, 'NiveauID');
    }

    public function group()
    {
        return $this->belongsTo(Group::class, 'GroupID');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'ModuleID');
    }

    public function professeur()
    {
        return $this->belongsTo(Professeur::class, 'ProfesseurID');
    }
    public function parcour()
    {
        return $this->belongsTo(Parcours::class, 'ParcourID');
    }
    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'SpecialiteID');
    }
    public function activite()
    {
        return $this->belongsTo(Activite::class, 'ActiviteID');
    }
    public function locals()
    {
        return $this->belongsTo(Local::class, 'LocalID');
    }
    public function semester()
{
    return $this->belongsTo(Semester::class, 'SemestreID');
}

    public function getNiveauxByParcours($id)
{
    return response()->json(Niveau::where('ParcoursID', $id)->get());
}

public function getSemestresByNiveau($id)
{
    return response()->json(Semester::where('NiveauID', $id)->get());
}

public function getSpecialitesByNiveau($id)
{
    return response()->json(Specialite::where('NiveauID', $id)->get());
}

public function getSectionsBySpecialite($id)
{
    return response()->json(Section::where('SpecialiteID', $id)->get());
}

public function getGroupesBySection($id)
{
    return response()->json(Groupe::where('SectionID', $id)->get());
}

public function getModulesBySection($id)
{
    return response()->json(Module::where('SectionID', $id)->get());
}

    


}