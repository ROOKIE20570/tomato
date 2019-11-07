<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\GetTasksRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Serivces\DelayService;
use App\Task;
use App\TaskRecord;
use App\Wallet;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use function Psy\sh;

class TaskController extends Controller
{
     /**
     */
    //
    public function __construct(Task $taskModel)
    {
        $this->model = $taskModel;
    }

    public function addTask(AddTaskRequest $request)
    {
        $cost = $this->model->create($request->validated());
        return $this->success($cost);
    }

    /**
     * @param $id
     * @param UpdateTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     *
     *
    **/
    public function updateTask($id, UpdateTaskRequest $request)
    {
        $this->model->find($id)->update($request->validated());
        return $this->success();
    }

    public function getTasks(GetTasksRequest $request)
    {
        $cond = $request->validated();
        $tasks = $this->model->where($cond)->orderBy('name','desc')->paginate(10);
        if (($tasks)) {
            $tasks = $tasks->toArray();
        }

        return $this->success($tasks['data'], ['count' => $tasks['total'], 'limit' => $tasks['per_page']]);

    }
    //定时的要扫 扫到了⏰ 发邮件通知检查
    //时间段的搞一个延迟队列  延迟队列结束后发邮件询问是否完成 完成后再加
    //普通的直接加分

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function trigger($id, DelayService $delayService)
    {
        $task = $this->model->find($id);
        if(!$task){
            return $this->fail(40000,404);
        }

        $taskRecord = new TaskRecord();
        $taskRecord->task_id = $id;
        $taskRecord->task_type = $task['type'];
        $taskRecord->task_name = $task['name'];

        switch ($task['type']){
            case 0:

                $taskRecord->status = TaskRecord::$success;

                $taskRecord->save();

                $wallet = new Wallet();
                $wallet->income = $task['price'];
                $wallet->type = Wallet::$income;
                $wallet->bind_id = $id;
                $wallet->trigger_name = $task['name'];
                $wallet->save();
                break;
            case 1:
                $taskRecord->status = TaskRecord::$running;
                $endTime = Carbon::now()->addSeconds($task['duration']);
                Log::info($endTime);
                $taskRecord->deadline = $endTime;
                $taskRecord->save();
                $res = $delayService->createDelayJob('task',$taskRecord->id,$task['duration'],'http://localhost:8000/api/task/deal',null);
                Log::info(var_export($res,true));
                break;
            default:
                return $this->fail(40000,400,'该种任务无需触发');
        }


        return $this->success();

    }

    public function dealTask(Request $request, TaskRecord $taskRecordModel)
    {
        $taskRecordId = $request->input('id');
        $record = $taskRecordModel->find($taskRecordId);
        if ($record){
            $record->status = TaskRecord::$toBeConfirmed;
            $record->save();
        }


        echo 'success';
    }
}
