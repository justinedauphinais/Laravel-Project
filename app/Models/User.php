<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Evenement;
use App\Models\Ville;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'users';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'nom',
        'prenom',
        'email',
        'numero_telephone',
        'date_naissance',
        'password',
        'est_actif',
        'id_role',
        'id_ville'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     *
     * Get les événements d'un organisateur
     *
     */
    public function evenements(): HasMany
    {
        return $this->hasMany(Evenement::class, 'id_utilisateur', 'id');
    }

    /**
     * Get la ville associée avec l'utilisateur
     */
    public function ville(): HasOne
    {
        return $this->hasOne(Ville::class, 'id', 'id_ville');
    }
}
