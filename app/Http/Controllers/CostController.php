<?php

namespace App\Http\Controllers;

use App\Cost;
use App\Http\Requests\AddCostRequest;
use App\Http\Requests\UpdateCostRequest;
use App\Wallet;
use Illuminate\Http\Request;

class CostController extends Controller
{
    //
    public function __construct(Cost $cost)
    {
        $this->model = $cost;
    }

    public function addCost(AddCostRequest $request)
    {
        $request->validated();
        $cost = $this->model->create($request->validated());
        return $this->success($cost);
    }

    public function cost($id)
    {
        $cost = $this->model->find($id);
        if (!$cost){
            return $this->fail(40004,404);
        }


        $wallet = new Wallet();
        $wallet->income = -$cost->price;
        $wallet->type = Wallet::$spend;
        $wallet->bind_id = $id;
        $wallet->save();
        return $this->success();
    }

    public function updateCost($id, UpdateCostRequest $request)
    {

        $this->model->find($id)->update($request->validated());
        return $this->success();
    }

    public function getCosts()
    {
        $costs = $this->model->orderBy('id','desc')->paginate(10);
        if ($costs){
            $costs = $costs->toArray();
        }
        return $this->success($costs['data'],['count'=>$costs['total'],'limit'=>$costs['per_page']]);
    }
}
