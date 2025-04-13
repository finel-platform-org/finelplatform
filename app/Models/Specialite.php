<?php

// app/Models/Specialite.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Specialite extends Model
{
    
    protected $primaryKey = 'SpecialiteID';
    public $timestamps = true;

    // A specialite belongs to a section
    public function section()
    {
        return $this->belongsTo(Section::class, 'SectionID');
    }

    // A specialite belongs to a parcours
    public function parcours()
    {
        return $this->belongsTo(Parcours::class, 'ParcoursID');
    }

    // A specialite has many groups
    public function groups()
    {
        return $this->hasMany(Group::class, 'SpecialiteID');
    }
}
