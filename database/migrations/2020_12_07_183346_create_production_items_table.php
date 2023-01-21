<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('production_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('production_id');
            $table->unsignedBigInteger('item_id');
            $table->integer('need_quantity');
            $table->integer('processed_quantity')->nullable();
            $table->integer('defects_count')->nullable();
            $table->integer('received_quantity')->nullable();
            $table->timestamps();

            $table->foreign('production_id')->references('id')->on('productions')->onDelete('CASCADE');
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
        Schema::dropIfExists('production_items');
    }
}
