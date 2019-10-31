<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetRecordsRequest;
use App\Http\Requests\UpdateRecordsRequest;
use App\Task;
use App\TaskRecord;
use App\Wallet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TaskRecordController extends Controller
{
    //
    public function __construct(TaskRecord $taskRecordModel)
    {
        $this->model = $taskRecordModel;
    }

    public function getRecords(GetRecordsRequest $request)
    {
        $cond = $request->validated();
        $records = $this->model->where($cond)->orderBy('id','desc')->paginate(10);
        if (($records)) {
            $records = $records->toArray();
        }
        return $this->success($records['data'], ['count' => $records['total'], 'limit' => $records['per_page']]);
    }

    public function update($id, UpdateRecordsRequest $request)
    {
        $this->model->find($id)->update($request->validated());
        return $this->success();
    }

    public function confirm($id, Request $request, Task $taskModel)
    {
        $status = $request->input('status');
        try{
            DB::beginTransaction();
            $taskRecord = $this->model->find($id);
            if (!$taskRecord){
                return $this->fail(40004,404);
            }
            $taskRecord->status = $status;
            if ($status == TaskRecord::$success){
                $task = $taskModel->find($taskRecord->task_id);
                if(!$task){
                    return $this->fail(40004,404);
                }

                $wallet = new Wallet();
                $wallet->income = $task['income'];
                $wallet->type = Wallet::$income;
                $wallet->bind_id = $task['id'];
                $wallet->save();
            }

            $taskRecord->save();
            DB::commit();
        }catch (\Exception $e){
            DB::rollBack();
            throw $e;
        }

        return $this->success();
    }
}
