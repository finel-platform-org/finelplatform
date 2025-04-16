<?php

// app/Models/Niveau.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Niveau extends Model
{
    protected $primaryKey = 'NiveauID';
    public $timestamps = true;

    // A niveau belongs to a section
    public function section()
    {
        return $this->belongsTo(Section::class, 'SectionID');
    }

    // A niveau belongs to a parcours
    public function parcours()
    {
        return $this->belongsTo(Parcours::class, 'ParcoursID');
    }
    public function semesters()
    {
        return $this->belongsToMany(Semester::class, 'niveau_semester', 'NiveauID', 'SemestreID');
    }
    public function departement()
{
    return $this->belongsTo(Departement::class, 'departement_id', 'DepartementID');
}
}
