<?php

namespace App\Models\Traits\Wallet;

use App\Models\User;
use App\Models\Wallet;

trait HasWallets
{
    public function getWallets()
    {
        return $this->wallets;
    }

    public function getWallet($id)
    {
        return Wallet::where('id', $id)->first();
    }

    public function getWalletBalance($id)
    {
        return $this->getWallet($id)->balance;
    }

    public function createWallet($type)
    {
        $wallet = Wallet::make([
            'wallet_type_id' => $type,
            'balance' => 230000,
        ]);

        return $this->wallets()->save($wallet);
    }

    public function deposit($wallet, $value)
    {
        $balance = $this->getWalletBalance($wallet);
        
        $attributes['balance'] = ($balance * 100) + ($value * 100);

        return $this->getWallet($wallet)->update($attributes);
    }

    public function withdraw($wallet, $value)
    {
        $balance = $this->getWalletBalance($wallet);
        
        $attributes['balance'] = ($balance * 100) - ($value * 100);

        return $this->getWallet($wallet)->update($attributes);
    }
}