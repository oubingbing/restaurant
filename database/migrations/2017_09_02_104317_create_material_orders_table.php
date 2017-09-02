<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_orders', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('order_number')->index()->comment('订单编号');

            $table->bigInteger('user_id')->index()->commnet('下单人');

            $table->bigInteger('restaurant_id')->index()->commnet('餐厅');

            $table->bigInteger('total_amount')->comment('订单金额');

            $table->integer('total_number')->comment('订单数量');

            $table->tinyInteger('status')->default(0)->comment('订单状态，0=准备中，1=已完成，2=已取消');

            $table->tinyInteger('type')->default(0)->comment('订单类型');


            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('restaurant_id')
                ->references('id')->on('restaurants')
                ->onDelete('cascade');

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
        Schema::dropIfExists('material_orders');
    }
}
