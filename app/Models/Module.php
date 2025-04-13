<?php

// app/Models/Module.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $primaryKey = 'ModuleID';
    public $timestamps = true;

    // A module can be taught by many professors (many-to-many)
    public function professeurs()
    {
        return $this->belongsToMany(Professeur::class, 'professeur_module', 'ModuleID', 'ProfesseurID');
    }
    // app/Models/Module.php

public function semesters()
{
    return $this->belongsToMany(Semester::class, 'semester_module', 'ModuleID', 'SemestreID');
}


}
