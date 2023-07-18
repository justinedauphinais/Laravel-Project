<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategorieResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {   return[
            'id'=>$this->id,
            'nom' => $this->nom,
            'description'=> $this->description,
            'est_actif' => $this->est_actif
        ];

    }
}
