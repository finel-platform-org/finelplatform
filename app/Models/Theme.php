<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    protected $table = 'themes'; 
    protected $primaryKey = 'ThemeID';
    public $timestamps = false;
    protected $fillable = ['Nom', 'ProfesseurID'];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class, 'ProfesseurID');
    }
    public function professeurs()
{
    return $this->belongsToMany(
        Professeur::class,
        'gestion_theme_professeur',
        'GestionThemeID',
        'ProfesseurID'
    )->withTimestamps();
}

    

}
