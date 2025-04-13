<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $primaryKey = 'SemestreID';
    protected $fillable = ['Nom']; // Ajoute le champ Nom
    public function niveaux()
    {
        return $this->belongsToMany(Niveau::class, 'niveau_semester', 'SemestreID', 'NiveauID');
    }
    // app/Models/Semester.php

public function modules()
{
    return $this->belongsToMany(Module::class, 'semester_module', 'SemestreID', 'ModuleID');
}

}
