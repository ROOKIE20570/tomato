<?php

namespace App\Http\Controllers;

use App\Diary;
use App\Http\Requests\AddDiaryRequest;
use Illuminate\Http\Request;

class DiaryController extends Controller
{
    //

    public function __construct(Diary $diaryModel)
    {
        $this->model = $diaryModel;
    }

    public function getDiarys()
    {
        $diarys = $this->model->orderBy('id','desc')->paginate(10);
        if (($diarys)) {
            $diarys = $diarys->toArray();
        }
        return $this->success($diarys['data'], ['count' => $diarys['total'], 'limit' => $diarys['per_page']]);
    }

    public function addDiary(AddDiaryRequest $request)
    {
        $diary = $this->model->create($request->validated());
        return $this->success($diary);
    }
}
