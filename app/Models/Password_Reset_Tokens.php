<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Password_Reset_Tokens extends Model
{
    use HasFactory;

    protected $table = 'password_reset_tokens';

    const UPDATED_AT = null;
    protected $primaryKey = 'created_at';

    protected $fillable = [
        'email',
        'token'
    ];
}
