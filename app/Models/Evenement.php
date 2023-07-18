<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class Evenement extends Model
{
    use HasFactory;

    protected $table = 'evenements';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nom',
        'lieu',
        'lien',
        'est_actif',
        'path_photo',
        'code_postal',
        'id_utilisateur',
        'id_statut',
        'id_ville',
        'id_categorie'
    ];

    public function statut(): BelongsTo
    {
        return $this->belongsTo(Statut::class, 'id_statut');
    }

    public function ville(): BelongsTo
    {
        return $this->belongsTo(Ville::class, 'id_ville');
    }

    public function pays($id_ville)
    {
        $id_pays = DB::table('pays')
            ->join('etats', 'pays.id', '=', 'etats.id_pays')
            ->join('villes', 'etats.id', '=', 'villes.id_etat')
            ->select('pays.*')
            ->where('villes.id', '=', $id_ville)
            ->get();

        return $id_pays;
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class, 'id_categorie');
    }
}
