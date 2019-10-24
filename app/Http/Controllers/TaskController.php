<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
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

    public function updateTask($id, UpdateTaskRequest $request)
    {
        $this->model->find($id)->update($request->validated());
        return $this->success();
    }
}
