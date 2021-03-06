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

    public function getMyWallet()
    {
        // return
    }

    public function createWallet($type)
    {
        $wallet = Wallet::make([
            'wallet_type_id' => $type,
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

        if ($balance < $value) {
            return false;
        }
       
        $attributes['balance'] = ($balance - $value) * 100;

        return $this->getWallet($wallet)->update($attributes);
        // return true;
    }

    public function transfer($wallet, $receiver, $amount)
    {
        $this->withdraw($wallet, $amount);
        $this->deposit($receiver, $amount);

        return true;
    }
}