<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends BaseModel
{
    //
    protected $table = 'wallet';

    public static $income = 0;
    public static $spend = 1;

    public function getWallet()
    {
        return $this->sum('income');

    }
}
        