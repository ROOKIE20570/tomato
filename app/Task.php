<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends BaseModel
{
    //
    protected $table = 'tasks';
    public static $ordinary = 0;
    public static $duration = 1;
    public static $remind = 2;
}
