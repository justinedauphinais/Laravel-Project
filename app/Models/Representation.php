<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Representation extends Model
{
    use HasFactory;

    protected $table = 'representations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'date',
        'heure',
        'nbr_places',
        'est_actif',
        'prix',
        'id_evenement',
    ];
}
