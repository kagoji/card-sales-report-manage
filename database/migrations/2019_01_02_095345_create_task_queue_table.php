<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::defaultStringLength(191);
        Schema::create('task_queue', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task_name');
            $table->integer('task_user_id');
            $table->string('task_user_name')->nullable();
            $table->timestamp('task_start_at')->nullable();
            $table->timestamp('task_stop_at')->nullable();
            $table->integer('task_status')->default(1);
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_queue');
    }
}
