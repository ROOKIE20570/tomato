<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $model;

    public function delete($id)
    {
        $item = $this->model->find($id);
        if ($item){
            $item->delete();
        }

        return $this->success();
    }


    public function success($data = [], $attachData = [],$httpCode = 200)
    {
        $result = [
            'code' => 0,
            'msg' => 'success',
            'data' => $data
        ];

        foreach ($attachData as $key=>$datum){
            $result[$key] = $datum;
        }

        return response()->json($result, $httpCode);
    }

    public function fail($code, $httpCode, $message = null)
    {
        return response()->json([
            'code' => $code,
            'msg' => $message,
            'data' => null
        ], $httpCode);
    }

    public function getOne($id)
    {
        $item = $this->model->find($id);
        return $this->success($item);
    }
}
