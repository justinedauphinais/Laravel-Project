<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BilletRessource extends JsonResource
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
            'est_actif' => $this->est_actif,
            'est_utilise' => $this->est_utilise,
            'id_transaction_representation' => $this->id_transaction_representation
        ];
    }
}
