<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetRecordsRequest;
use App\Http\Requests\UpdateRecordsRequest;
use App\TaskRecord;
use Illuminate\Http\Request;

class TaskRecordController extends Controller
{
    //
    public function __construct(TaskRecord $taskRecord)
    {
        $this->model = $taskRecord;
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
}
