<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //得分方式表
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger("price")->comment('得分奖励');
            $table->string('name',40)->comment('得分方式名称');
            $table->integer('type')->comment('0-普通任务  1-时间段任务 2-定时提醒任务');
            $table->integer('duration')->comment('type = 1时 秒');
            $table->string('remind_time')->comment('type = 2时的提醒时间  每天的几点  12:00这种格式');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
