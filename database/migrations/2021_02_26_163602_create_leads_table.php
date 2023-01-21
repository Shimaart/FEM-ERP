<?php

use App\Models\Lead;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeadsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manager_id')->nullable();
            $table->foreignId('customer_id')->nullable();
            $table->foreignId('order_id')->nullable();
            $table->string('name');
            $table->string('status', 16)->default(Lead::STATUS_NEW);
            $table->string('referrer')->nullable();
            $table->text('measurer_full_name')->nullable();
            $table->text('measurement_address')->nullable();
            $table->date('measurement_date')->nullable();
            $table->string('no_respond_reason', 16)->nullable();
            $table->string('decline_reason', 16)->nullable();
            $table->longText('note')->nullable();
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
        Schema::dropIfExists('leads');
    }
}
