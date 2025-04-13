<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $primaryKey = 'DepartementID';
    public $timestamps = true;

    // A department has one chef pedagogique (professor)
    public function chefPedagogique()
    {
        return $this->belongsTo(Professeur::class, 'ChefPedagogiqueID');
    }

    // A department has many professors
    public function professeurs()
    {
        return $this->hasMany(Professeur::class, 'DepartementID');
    }
}