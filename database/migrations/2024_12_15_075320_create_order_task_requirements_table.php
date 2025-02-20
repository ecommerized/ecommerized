<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_task_requirements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_order_id');
            $table->unsignedBigInteger('client_order_item_id');
            $table->unsignedBigInteger('order_task_id');
            $table->longText('description');
            $table->text('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('order_task_requirements');
    }
};
