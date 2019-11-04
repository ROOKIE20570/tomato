<?php

namespace App\Http\Controllers;

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

}
