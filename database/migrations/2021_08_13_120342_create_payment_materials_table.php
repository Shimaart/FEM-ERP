<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_materials', function (Blueprint $table) {
            $table->unsignedBigInteger('payment_id');
            $table->unsignedBigInteger('item_id');
            $table->decimal('purchase_price', 14, 2)->nullable();
            $table->decimal('quantity', 14, 2)->nullable();
            $table->timestamps();

            $table->primary('payment_id');
            $table->foreign('payment_id')->references('id')->on('payments');
            $table->foreign('item_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('payment_materials', function (Blueprint $table) {
            $table->dropForeign(['payment_id']);
            $table->dropForeign(['item_id']);
        });

        Schema::dropIfExists('payment_materials');
    }
}
