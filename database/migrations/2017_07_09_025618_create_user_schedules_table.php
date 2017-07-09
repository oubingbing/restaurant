<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('user_id')->comment('员工id');
            $table->bigInteger('schedule_id')->comment('排班id');
            $table->timestamps();
            $table->softDeletes();
            $table->index(['user_id','schedule_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_schedules');
    }
}
