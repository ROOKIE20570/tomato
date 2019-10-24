<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Work extends BaseModel
{
    //
    protected $table = 'works';

    public static $running = 0;
    public static $toBeConfirmed = 1;
    public static $success = 2;
    public static $failed = 3;
}
