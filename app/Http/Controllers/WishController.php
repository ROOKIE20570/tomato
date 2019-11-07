<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddWishRequest;
use App\Http\Requests\CompleteWishRequest;
use App\Http\Requests\GetWishesRequest;
use App\Wish;
use Illuminate\Http\Request;

class WishController extends Controller
{

    public function __construct(Wish $wish)
    {
        $this->model = $wish;
    }

    public function getWishes(GetWishesRequest $request)
    {
        $wishes = $this->model->where($request->validated())->paginate(10);
        if (($wishes)) {
            $wishes = $wishes->toArray();
        }
        return $this->success($wishes['data'], ['count' => $wishes['total'], 'limit' => $wishes['per_page']]);
    }

    /**
     * @param AddWishRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function addWish(AddWishRequest $request)
    {
        $wish = $this->model->create($request->validated());
        return $this->success($wish);
    }

    public function complete(CompleteWishRequest $request, $id)
    {
        $this->model->find($id)->update($request->validated());
        return $this->success();
    }
}
