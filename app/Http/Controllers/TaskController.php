<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\GetTasksRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
     /**
     */
    //
    public function __construct(Task $task)
    {
        $this->model = $task;
    }

    public function addTask(AddTaskRequest $request)
    {
        $request->validated();
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
        $tasks = $this->model->where($cond)->orderBy('id','desc')->paginate(10);
        if (($tasks)) {
            $tasks = $tasks->toArray();
        }
        return $this->success($tasks['data'], ['count' => $tasks['total'], 'limit' => $tasks['per_page']]);

    }
    //定时的要扫 扫到了⏰ 发邮件通知检查
    //时间段的搞一个延迟队列  延迟队列结束后发邮件询问是否完成 完成后再加
    //普通的直接加分
    public function trigger($id)
    {
        $task = $this->model->find($id);
        if(!$task){
            return $this->fail(40000,404);
        }

        switch ($task['type']){
            case 0:

        }
    }
}
