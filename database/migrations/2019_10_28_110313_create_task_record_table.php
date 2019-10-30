<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskRecordTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('task_id');
            $table->tinyInteger('task_type')->comment('冗余 task_type');
            $table->tinyInteger('task_name')->comment('冗余 task_type');
            $table->tinyInteger('status')->comment('0-进行中 1-待用户确认 2-成功已结算 3-失败已结算');
            $table->timestamp('deadline')->comment('结束时间')->nullable(true);
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
        Schema::dropIfExists('task_record');
    }
}
