<?php
/* TODO faire ça */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction_Representation extends Model
{
    use HasFactory;

    protected $table = 'transactions_representations';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'id_transaction',
        'id_representation'
    ];
}
