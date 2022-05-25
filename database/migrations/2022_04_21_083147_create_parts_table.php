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
        Schema::create('delivery_parts', function (Blueprint $table) {
            $table->id();
            $table->string('sku')->index();
            $table->string('part_no_customer');
            $table->string('part_no_aji');
            $table->string('part_name');
            $table->string('model');
            $table->string('customer_id', 255);
            $table->string('category')->nullable();
            $table->string('cycle_time')->nullable();
            $table->string('addresing')->nullable();
            $table->string('color_id', 40)->nullable();
            $table->string('line_id', 40)->nullable();
            $table->string('packaging_id', 40)->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();

            
        });
        

        Schema::create('delivery_customers', function (Blueprint $table) {
            $table->id();
            $table->string('customer_code', 255)->index();
            $table->string('customer_name', 189);
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('delivery_lines', function (Blueprint $table) {
            $table->id();
            $table->string('line_code', 40)->index();
            $table->string('line_name', 100);
            $table->string('line_category', 40);
            $table->string('tonase', 15)->nullable();
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('delivery_part_cards', function (Blueprint $table) {
            $table->id();
            $table->string('color_code')->index();
            $table->string('description');
            $table->string('remark_1');
            $table->string('remark_2');
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('delivery_packagings', function (Blueprint $table) {
            $table->id();
            $table->string('packaging_code')->index();
            $table->string('qty_per_pallet');
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('delivery_mos', function (Blueprint $table) {
            $table->id();
            $table->string('sku');
            $table->date('prod_date');
            $table->integer('qty_mo');
            $table->integer('qty_act_prod');
            $table->enum('status_mo', ['selesai', 'belum selesai']);
            $table->string('updated_by')->nullable();
            $table->timestamps();
        });

        Schema::create('delivery_man_powers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('npk')->index();
            $table->string('position');
            $table->string('title');
            $table->string('shift');
            $table->string('photo')->nullable();
            $table->timestamps();
        });

        Schema::create('delivery_skills', function (Blueprint $table) {
            $table->id();
            $table->string('skill_code')->index();
            $table->string('skill');
            $table->string('category');
            $table->timestamps();
        });

        Schema::create('delivery_matrix_skills', function (Blueprint $table) {
            $table->id();
            $table->string('skill_id');
            $table->string('user_id');
            $table->integer('value')->default(0);
            $table->string('category');
            $table->timestamps();
        });

        Schema::create('delivery_pickup_customer', function (Blueprint $table) {
            $table->id();
            $table->string('customer_pickup_code')->index();
            $table->integer('cycle');
            $table->integer('cycle_time_preparation');
            $table->string('help_column');
            $table->time('time_pickup');
            $table->timestamps();
        });

        Schema::create('delivery_preparation', function (Blueprint $table) {
            $table->id();
            $table->string('customer_pickup_id');
            $table->integer('cycle');
            $table->integer('cycle_time_preparation');
            $table->string('help_column');
            $table->time('time_pickup');
            $table->string('shift');
            $table->string('pic');
            $table->integer('time_hour');
            $table->dateTime('date_preparation')->nullable();
            $table->dateTime('date_delivery');
            $table->dateTime('start_preparation')->nullable();
            $table->dateTime('end_preparation')->nullable();
            $table->timestamps();
        });

        //relasi table 
        Schema::table('delivery_parts', function($table) {
            $table->foreign('customer_id')->references('customer_code')->on('delivery_customers')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('color_id')->references('color_code')->on('delivery_part_cards')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('packaging_id')->references('packaging_code')->on('delivery_packagings')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('line_id')->references('line_code')->on('delivery_lines')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('delivery_mos', function ( $table) {
            $table->foreign('sku')->references('sku')->on('delivery_parts')->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::table('delivery_matrix_skills', function ( $table) {
            $table->foreign('skill_id')->references('skill_code')->on('delivery_skills')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('npk')->on('delivery_man_powers')->onUpdate('cascade')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('delivery_customers');
        Schema::dropIfExists('parts');
        Schema::dropIfExists('delivery_lines');
        Schema::dropIfExists('delivery_packagings');
        Schema::dropIfExists('delivery_part_cards');
        Schema::dropIfExists('delivery_man_power');
        Schema::dropIfExists('delivery_matrix_skills');
        Schema::dropIfExists('delivery_pickup_customer');
        Schema::dropIfExists('delivery_preparation');
    }
}
