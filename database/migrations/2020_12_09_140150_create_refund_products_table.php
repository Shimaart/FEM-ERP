<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRefundProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('refund_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('refund_id');
            $table->unsignedBigInteger('item_id');
            $table->decimal('quantity');
            $table->decimal('price')->nullable();
            $table->decimal('discount')->nullable();

            $table->timestamps();

            $table->foreign('refund_id')->references('id')->on('refunds')->onDelete('CASCADE');
            $table->foreign('item_id')->references('id')->on('order_items')->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('refund_products');
    }
}
