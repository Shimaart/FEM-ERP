<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedBigInteger('unit_id')->nullable();
            $table->unsignedBigInteger('item_type_id')->nullable();
            $table->string('name');
            $table->decimal('price');
            $table->boolean('is_preferential')->default(false);
            $table->decimal('weight')->nullable();
            $table->decimal('quantity');
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('item_categories');
            $table->foreign('unit_id')->references('id')->on('units');
            $table->foreign('item_type_id')->references('id')->on('item_types');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('items');
    }
}
