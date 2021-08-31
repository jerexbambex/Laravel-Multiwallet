<?php

namespace App\Http\Controllers\Wallets;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Resources\WalletResource;
use App\Models\Traits\Wallet\HasWallets;

class WalletController extends Controller
{
    // use HasWallets;
   
    public function index()
    {
        $wallet = request()->user()->getWallets();

        $data = [
            'status' => 'success',
            'data' => WalletResource::collection($wallet),
        ];
        
        return response()->json($data, 200);
    }

    public function store(Request $request)
    {
        $request->validate(['wallet_type_id' => 'required|exists:wallet_types,id']);

        $walletType = $request->wallet_type_id;

        $wallet = $request->user()->createWallet($walletType);

        $data = [
            'status' => 'success',
            'data' => new WalletResource($wallet),
        ];
        
        return response()->json($data, 200);
    }

    public function add()
    {
        //
    }
}
