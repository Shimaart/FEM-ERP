<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_attributes', function (Blueprint $table) {
            $table->unsignedBigInteger('item_id');
            $table->unsignedBigInteger('group_id');
            $table->unsignedBigInteger('attribute_id');

            $table->foreign('item_id')->references('id')->on('items')->onDelete('CASCADE');
            $table->foreign('group_id')->references('id')->on('attribute_groups');
            $table->foreign('attribute_id')->references('id')->on('attributes');

            $table->primary(['item_id', 'group_id']);

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
        Schema::dropIfExists('item_attributes');
    }
}
