<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parts', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->unique();
            $table->string('part_no_customer');
            $table->string('part_no_aji');
            $table->string('part_name');
            $table->string('model');
            $table->string('category')->nullable();
            $table->string('cycle_time')->nullable();
            $table->string('addresing')->nullable();
            $table->string('customer_code');
            $table->string('color_code')->nullable();
            $table->string('line_code')->nullable();
            $table->string('packaging_code')->nullable();
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
        Schema::dropIfExists('parts');
    }
}
