<?php

namespace App\Http\Controllers\Users;

use App\Models\Wallet;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\WalletResource;

class UserWalletController extends Controller
{
    public function index()
    {
        $wallet = request()->user()->getWallets();

        $data = [
            'status' => 'success',
            'data' => WalletResource::collection($wallet),
        ];
        
        return response()->json($data, 200);
    }

    public function show(Wallet $wallet)
    {
        // $wallet = Wallet::with('user', 'transactions')->find($wallet->id);

        $data = [
            'status' => 'success',
            'data' => new WalletResource($wallet),
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

    public function sendMoney(Request $request, Wallet $wallet)
    {
        $request->validate([
            'amount' => ['required', 'numeric'],
            'wallet_id' => ['required', 'numeric', 'exists:wallets,id'],
        ]);

        $receiverWallet = Wallet::with('user')->where('id', $request->wallet_id)->first();

       $request->user()->transfer($wallet->id, $receiverWallet->id, $request->amount);

        $transaction = Transaction::make([
            'wallet_id' => $request->wallet_id,
            'description' => "You sent {$request->amount} to {$receiverWallet->user->name}'s {$receiverWallet->walletType->name} wallet"
        ]);

        $request->user()->transactions()->save($transaction);

        $myWallet = $request->user()->getWallet($wallet->id);

        $data = [
            'status' => 'success',
            'data' => new WalletResource($myWallet),
        ];
        
        return response()->json($data, 200);
    }

    public function addMoney(Request $request, Wallet $wallet)
    {
        $request->validate([
            'amount' => ['required', 'numeric'],
            // 'wallet_id' => ['required'],
        ]);

        $request->user()->deposit($wallet->id, $request->amount);
        
        $transaction = Transaction::make([
            'wallet_id' => $wallet->id,
            'description' => "You added {$request->amount} to your wallet"
        ]);

        $wallet = $request->user()->getWallet($wallet->id);

        $data = [
            'status' => 'success',
            'data' => new WalletResource($wallet),
        ];
        
        return response()->json($data, 200);
    }
}
