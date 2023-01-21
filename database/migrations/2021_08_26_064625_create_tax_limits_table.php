<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaxLimitsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tax_limits', function (Blueprint $table) {
            $table->id();
            $table->date('month')->unique();
            $table->decimal('value', 14, 2)->default(0);
            $table->string('status')->default(\App\Models\TaxLimit::STATUS_CREATED);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tax_limits');
    }
}
