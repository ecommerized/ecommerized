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
        Schema::create('client_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('package_id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->string('order_id')->nullable();
            $table->decimal('amount', 12, 2)->default(0);
            $table->tinyInteger('payment_status')->default(0);
            $table->tinyInteger('working_status')->default(0);
            $table->tinyInteger('package_type')->default(DURATION_MONTH);
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();
            $table->unsignedBigInteger('order_create_type')->default(CREATE_BY_USER);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->softDeletes();
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
        Schema::dropIfExists('client_orders');
    }
};
