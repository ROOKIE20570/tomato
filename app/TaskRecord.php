<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskRecord extends BaseModel
{
    //
    protected $table = 'task_record';

    public static $running = 0;
    public static $toBeConfirmed = 1;
    public static $success = 2;
    public static $failed = 3;
}
