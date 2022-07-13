<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'sku' => $this->sku,
            'price' => $this->price,
            'quantity' => $this->whenPivotLoaded('note_items', fn () => $this->pivot->quantity),
            'total' => $this->whenPivotLoaded('note_items', fn () =>  $this->pivot->total),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
