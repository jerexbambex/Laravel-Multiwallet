<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WalletType extends Model
{
    use HasFactory;

    public static function boot()
	{
        parent::boot();

        static::creating(function ($model) {
            $model->slug = (string) Str::of($model->name)->slug('-');
        });
	}

    protected $guarded = [];
}
