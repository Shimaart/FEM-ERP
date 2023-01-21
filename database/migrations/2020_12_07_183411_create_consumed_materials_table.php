<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConsumedMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('consumed_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('production_item_id');
            $table->unsignedBigInteger('material_id');
            $table->decimal('value')->nullable();
            $table->timestamps();

            $table->foreign('production_item_id')->references('id')->on('production_items')->onDelete('CASCADE');
            $table->foreign('material_id')->references('id')->on('items');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('consumed_materials');
    }
}
