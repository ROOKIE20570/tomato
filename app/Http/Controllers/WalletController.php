<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetRecentWalletRequest;
use App\Wallet;
use Illuminate\Http\Request;

class WalletController extends Controller
{
    //
    public function __construct(Wallet $wallet)
    {
        $this->model = $wallet;
    }

    public function getWallet()
    {
        $wallet = $this->model->getWallet();
        return $this->success($wallet);
    }

    public function getRecentWalletStatus(GetRecentWalletRequest $request)
    {
        $cond = $request->validated();
        $amount = $this->model->getWallet();
        $recent = $this->model->orderBy('id', 'desc')->limit($cond['length'])->get();
        $amouts = [];
        $triggerNames = [];
        foreach ($recent as $item) {
            $triggerNames[] = $item['trigger_name'];

            $amouts[] = $amount;
            $amount -= $item['income'];
        }

        return $this->success(['trigger' => $triggerNames, 'amount' => $amouts]);
    }

}
