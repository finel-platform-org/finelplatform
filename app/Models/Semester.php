<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Semester extends Model
{
    use HasFactory;
    protected $primaryKey = 'SemestreID';
    protected $fillable = ['Nom']; // Ajoute le champ Nom
   
    // app/Models/Semester.php

    public function modules()
    {
        return $this->hasMany(Module::class, 'SemestreID');
    }
public function niveau()
{
    return $this->belongsTo(Niveau::class, 'NiveauID'); // Spécifiez explicitement la clé étrangère
}

}
