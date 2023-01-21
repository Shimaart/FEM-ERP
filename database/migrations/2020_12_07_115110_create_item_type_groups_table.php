<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemTypeGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_type_groups', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('item_type_id');
            $table->unsignedBigInteger('group_id');
            $table->integer('sort')->nullable();
            $table->timestamps();

            $table->foreign('item_type_id')->references('id')->on('item_types')->onDelete('CASCADE');
            $table->foreign('group_id')->references('id')->on('attribute_groups');


            $table->unique(['item_type_id', 'group_id']);

//            $table->primary(['item_type_id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('item_type_groups');
    }
}
