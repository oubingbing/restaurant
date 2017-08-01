<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',128)->comment('材料名称');
            $table->decimal('price',10,2)->comment('单价');
            $table->string('unit',32)->comment('单位计量');
            $table->decimal('value',10,2)->comment('单位含量');
            $table->integer('restaurant_id')->comment('餐厅id');
            $table->integer('one_level_group')->comment('所属一级分组');
            $table->integer('two_level_group')->comment('所属二级分组');

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
        Schema::dropIfExists('materials');
    }
}
