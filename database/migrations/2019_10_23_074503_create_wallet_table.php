<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallet', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('income')->comment('收入和支出');
            $table->integer('type')->comment('0-收入 绑定task表 1-支出 绑定costs表');
            $table->integer('bind_id')->comment('绑定的ID');
            $table->timestamps();
        });
    }
    /**
     */

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wallet');
    }
}
