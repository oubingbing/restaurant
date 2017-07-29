<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScheduleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',128)->comment('排班的名称');
            $table->timestamp('start_date')->nullable()->comment('该排班的有效起始日期');
            $table->timestamp('end_date')->nullable()->comment('排班的有效截止日期');
            $table->timestamp('start_time')->nullable()->comment('该排班上班时间');
            $table->timestamp('end_time')->nullable()->comment('该排班的下班时间');
            $table->bigInteger('user_id')->comment('谁排的班');
            $table->bigInteger('restaurant_id')->comment('餐厅id');
            $table->tinyInteger('status')->default(1)->comment('排班的状态，1=启用，2=暂停....');
            $table->tinyInteger('type')->default(1)->comment('排班类型，1=固定班，2=临时班');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('schedules');
    }
}
