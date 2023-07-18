<?php
/* TODO faire ça */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commentaire extends Model
{
    use HasFactory;

    protected $table = 'commentaires';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'commentaire',
        'est_actif',
        'id_transaction_representation'
    ];
}
