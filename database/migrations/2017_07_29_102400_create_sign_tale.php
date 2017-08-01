<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignTale extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('signs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id')->comment('排班的id');
            $table->integer('employee_id')->comment('员工id');
            $table->integer('restaurant_id')->comment('餐厅id');
            $table->integer('company_id')->comment('公司id');
            $table->decimal('hour',10,2)->comment('工时');
            $table->decimal('salary',10,2)->comment('工资');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['schedule_id','employee_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('signs');
    }
}
