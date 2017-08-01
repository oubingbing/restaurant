<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMaterialGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('material_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name',128)->comment('材料分组名称');
            $table->integer('restaurant_id')->comment('餐厅id');
            $table->tinyInteger('type')->comment('分组类型，1=一级分组，2=二级分组');
            $table->tinyInteger('status')->default(1)->comment('分组状态');
            $table->integer('belong_to')->default(0)->comment('所属分组,0=不属于任何分组，该分组为一级分组');

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
        Schema::dropIfExists('material_groups');
    }
}
