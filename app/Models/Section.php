<?php

// app/Models/Section.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $primaryKey = 'SectionID';
    public $timestamps = true;

    // A section has many parcours
    public function parcours()
    {
        return $this->hasMany(Parcours::class, 'SectionID');
    }

    // A section has many niveaux
    public function niveaux()
    {
        return $this->hasMany(Niveau::class, 'SectionID');
    }

    // A section has many specialites
    public function specialites()
    {
        return $this->hasMany(Specialite::class, 'SectionID');
    }
    // Dans Section.php
public function modules()
{
    return $this->hasMany(Module::class, 'SectionID'); // ou la bonne clé étrangère
}

}