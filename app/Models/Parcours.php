<?php

// app/Models/Parcours.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parcours extends Model
{
    protected $primaryKey = 'ParcoursID';
    public $timestamps = true;

    // A parcours belongs to a section
    public function section()
    {
        return $this->belongsTo(Section::class, 'SectionID');
    }

    // A parcours has many niveaux
    public function niveaux()
    {
        return $this->hasMany(Niveau::class, 'ParcoursID');
    }

    // A parcours has many specialites
    public function specialites()
    {
        return $this->hasMany(Specialite::class, 'ParcoursID');
    }
}