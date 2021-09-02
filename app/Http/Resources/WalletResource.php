<?php

namespace App\Http\Resources;

use App\Models\Wallet;
use Illuminate\Http\Resources\Json\JsonResource;

class WalletResource extends JsonResource
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
            'balance' => $this->balance,
            'relationship' => [
                'wallet_type' => new WalletTypeResource($this->walletType),
                'owner' => new UserResource(($this->whenLoaded('user'))),
                'transactions' => TransactionResource::collection($this->whenLoaded('transactions')),
            ],
        ];
    }
}
