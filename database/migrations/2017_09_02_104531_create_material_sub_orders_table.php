<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialSubOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_sub_orders', function (Blueprint $table) {
            $table->bigInteger('id');

            $table->bigInteger('order_id')->index()->comment('母订单id');
            $table->bigInteger('material_id')->index()->comment('材料id');
            $table->bigInteger('user_id')->index()->comment('下单人');
            $table->bigInteger('restaurant_id')->index()->comment('所属餐厅');
            $table->bigInteger('amount')->comment('采购金额');
            $table->integer('number')->comment('采购数量');
            $table->timestamp('ordered_at')->index()->comment('下单时间');
            $table->tinyInteger('status')->default(0)->comment('状态');
            $table->tinyInteger('type')->default(0)->comment('类型');

            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');

            $table->foreign('restaurant_id')
                ->references('id')->on('restaurants')
                ->onDelete('cascade');

            $table->foreign('order_id')
                ->references('id')->on('orders')
                ->onDelete('cascade');

            $table->foreign('material_id')
                ->references('id')->on('materials')
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
        Schema::dropIfExists('material_sub_orders');
    }
}
