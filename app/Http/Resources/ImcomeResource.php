<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ImcomeResource extends JsonResource
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
            'user_id' => $this->user_id,
            'customer_phone' => $this->customer_phone,
            'customer_name' => $this->customer_name,
            'sale_price' => $this->sale_price,
            'percent' => $this->percent,
            'income' => $this->income,
            'code' => $this->code,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'user' => new UserResource($this->whenLoaded('user'))
        ];
    }
}
