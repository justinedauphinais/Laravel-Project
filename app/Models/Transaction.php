<?php
/* TODO faire ça */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'date_demande',
        'date_complete',
        'paye',
        'token',
        'id_utilisateur'
    ];
}
