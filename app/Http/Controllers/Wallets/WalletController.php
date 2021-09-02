<?php

namespace App\Http\Controllers\Wallets;

use App\Models\User;
use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\WalletResource;
use App\Models\Traits\Wallet\HasWallets;

class WalletController extends Controller
{
    // use HasWallets;
    public $user;

    public function __construct()
    {
        //
    }
   
    public function index()
    {
        $wallets = Wallet::with('user')->paginate();

        $data = [
            'status' => 'success',
            'data' => WalletResource::collection($wallets),
        ];
        
        return response()->json($data, 200);
    }

    public function show(Wallet $wallet)
    {
        $wallet = Wallet::with('user')->find($wallet->id);

        $data = [
            'status' => 'success',
            'data' => new WalletResource($wallet),
        ];
        
        return response()->json($data, 200);
    }

}
