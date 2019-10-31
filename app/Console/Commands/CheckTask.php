<?php

namespace App\Console\Commands;

use App\Task;
use App\TaskRecord;
use Illuminate\Console\Command;

class CheckTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:task';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'check daliy task';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Task $task)
    {
        //
        $now = date("H:i:s");
        $tasks = $task->where('type', Task::$remind)->where('remind_time',$now)->get();
        foreach ($tasks as $item){
            $taskRecord = new TaskRecord();
            $taskRecord->task_id = $item->id;
            $taskRecord->task_type = Task::$remind;
            $taskRecord->task_name = $item->name;
            $taskRecord->status = TaskRecord::$toBeConfirmed;
            $taskRecord->save();
        }
    }
}
