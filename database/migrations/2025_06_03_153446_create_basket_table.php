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
        Schema::create('basket', function (Blueprint $table) {
            $table->id();
			$table->unsignedBigInteger('order_id')->nullable(false);
			$table->unsignedBigInteger('product_id')->nullable(false);
			$table->integer('count')->nullable(false)->default(1);
			$table->foreign('order_id')->references('id')->on('orders');
			$table->foreign('product_id')->references('id')->on('products');
			$table->unsignedBigInteger('item_price')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('basket');
    }
};
