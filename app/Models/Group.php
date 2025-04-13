<?php

// app/Models/Group.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $primaryKey = 'GroupID';
    public $timestamps = true;

    // A group belongs to a speciality
    public function specialite()
    {
        return $this->belongsTo(Specialite::class, 'SpecialiteID');
    }

    // A group has many students
    public function etudiants()
    {
        return $this->hasMany(Etudiant::class, 'GroupID');
    }
}
