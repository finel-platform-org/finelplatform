<?php

// app/Models/Activite.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Activite extends Model
{

    
    
    
    protected $primaryKey = 'ActiviteID';
    public $timestamps = true;
    

    // An activity belongs to a module
    public function module()
    {
        return $this->belongsTo(Module::class, 'ModuleID');
    }

    // An activity belongs to a professor
    public function professeur()
    {
        return $this->belongsTo(Professeur::class, 'ProfesseurID');
    }
}
