<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EvenementRessource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'lieu' => $this->lieu,
            'lien' => $this->lien,
            'est_actif' => $this->est_actif,
            'path_photo' => $this->path_photo,
            'code_postal' => $this->code_postal,
            'id_utilisateur' => $this->id_utilisateur,
            'id_statut' => $this->id_statut,
            'id_ville' => $this->id_ville,
            'id_categorie' => $this->id_categorie
        ];
    }
}
