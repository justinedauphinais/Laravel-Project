<?php
/* TODO faire ça */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billet extends Model
{
    use HasFactory;

    protected $table = 'billets';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'est_utilise',
        'est_actif',
        'id_transaction_representation'
    ];
}
