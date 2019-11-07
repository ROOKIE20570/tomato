<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('tasks');
});
Route::get('/task/{id?}', function (\App\Task $task) {

    $id = Route::current()->parameter('id');
    $currentTask = null;
    if ($id){
        $currentTask = $task->find($id);
    }
    return view('task',compact('id', 'currentTask'));
});
Route::get('/tasks', function () {
    return view('tasks');
});
Route::get('/cost/{id?}', function (\App\Cost $cost) {

    $id = Route::current()->parameter('id');
    $currentCost = null;
    if ($id){
        $currentCost = $cost->find($id);
    }
    return view('cost',compact('id', 'currentCost'));
});
Route::get('/costs', function () {
    return view('costs');
});
Route::get('/records', function () {
    return view('task_record');
});

Route::get('/diarys', function () {
    return view('diarys');
});

Route::get('/diary/{id?}', function (\App\Diary $diaryModel) {
    $id = Route::current()->parameter('id');
    $diary = null;
    if ($id){
        $diary = $diaryModel->find($id);
    }
    return view('diary',compact('id', 'diary'));
});
Route::get('/wishes', function () {
    return view('wishes');
});

Route::get('/wish', function () {
    return view('wish');
});
Route::get('/count', function () {
    return view('count');
});
