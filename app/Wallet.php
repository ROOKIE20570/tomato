<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wallet extends BaseModel
{
    //
    protected $table = 'wallet';

    public static $income = 0;
    public static $spend = 1;

}
        