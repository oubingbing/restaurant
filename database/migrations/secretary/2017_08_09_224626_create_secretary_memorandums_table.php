<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSecretaryMemorandumsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('secretary_memorandums', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->index()->comment('用户id');
            $table->tinyInteger('level')->comment('备忘录等级');
            $table->text('content')->comment('备忘录内容');
            $table->tinyInteger('status')->comment('备忘录状态，1=持续中，2=废弃，3=延期，4=完成，未完成');
            $table->tinyInteger('type')->comment('备忘录的类型，1=工作，2=生活，3=其他');
            $table->tinyInteger('remind_me')->comment('到期后是否提醒我');

            $table->timestamp('latest_at')->nullable()->comment('最迟完成时间');
            $table->timestamp('remind_at')->nullable()->comment('闹钟，提醒我');
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
        Schema::dropIfExists('secretary_memorandums');
    }
}
