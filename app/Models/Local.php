<?php

// app/Models/Local.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Local extends Model
{
    protected $table = 'locals';
    protected $primaryKey = 'LocalID';
    public $timestamps = true;
    protected $fillable = ['LocalID', 'Nom' ,'Capacite'];

    // A local belongs to a group
    public function group()
    {
        return $this->belongsTo(Group::class, 'GroupID');
    }
}
