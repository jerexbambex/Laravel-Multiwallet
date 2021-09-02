<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $guarded = [];
    
    public function getBalanceAttribute($value)
    {
        return $value / 100;
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }


    public function walletType()
    {
        return $this->belongsTo(WalletType::class);
    }
}
