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
            $table->string('sku')->unique()->index();
            $table->string('part_no_customer');
            $table->string('part_no_aji');
            $table->string('part_name');
            $table->string('model');
            $table->string('customer_id', 32);
            $table->string('category')->nullable();
            $table->string('cycle_time')->nullable();
            $table->string('addresing')->nullable();
            $table->string('color_id', 32);
            $table->string('line_id', 32);
            $table->string('packaging_id', 32);
            $table->timestamps();

            
        });
        

        Schema::create('delivery_customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code', 32)->index();
            $table->string('customer_name', 32);
            $table->timestamps();
        });

        Schema::create('delivery_lines', function (Blueprint $table) {
            $table->id();
            $table->string('line_code', 32)->index();
            $table->string('line_name', 32);
            $table->timestamps();
        });

        Schema::create('delivery_part_cards', function (Blueprint $table) {
            $table->id();
            $table->string('color_code')->index();
            $table->string('description');
            $table->timestamps();
        });

        Schema::create('delivery_packagings', function (Blueprint $table) {
            $table->id();
            $table->string('packaging_code')->index();
            $table->string('qty_per_pallet');
            $table->timestamps();
        });

        Schema::create('delivery_mos', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->date('prod_date');
            $table->integer('qty_mo');
            $table->integer('qty_act_prod');
            $table->enum('status_mo', ['selesai', 'belum selesai']);
            $table->timestamps();
        });

        //relasi table 
        Schema::table('parts', function($table) {
            $table->foreign('customer_id')->references('customer_code')->on('delivery_customers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('color_id')->references('color_code')->on('delivery_part_cards')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('packaging_id')->references('packaging_code')->on('delivery_packagings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('line_id')->references('line_code')->on('delivery_lines')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('delivery_mos', function ( $table) {
            $table->foreign('sku')->references('sku')->on('parts')->onUpdate('cascade')->onDelete('cascade');
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
        Schema::dropIfExists('delivery_customers');
        Schema::dropIfExists('delivery_lines');
        Schema::dropIfExists('delivery_packagings');
        Schema::dropIfExists('delivery_part_cards');
    }
}
