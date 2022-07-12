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
            $table->string('vendor')->nullable();
            $table->time('time_pickup');
            $table->timestamps();
        });

        Schema::create('delivery_preparation', function (Blueprint $table) {
            $table->id();
            $table->string('customer_pickup_id');
            $table->integer('cycle');
            $table->integer('cycle_time_preparation');
            $table->string('help_column');
            $table->time('plan_time_preparation');
            $table->string('shift');
            $table->string('pic');
            $table->float('time_hour');
            $table->date('plan_date_preparation');
            $table->dateTime('date_preparation')->nullable();
            $table->dateTime('start_preparation')->nullable();
            $table->dateTime('end_preparation')->nullable();
            $table->integer('status')->nullable();
            $table->string('start_by')->nullable();
            $table->string('end_by')->nullable();
            $table->string('time_preparation')->nullable();
            $table->string('problem')->nullable();
            $table->mediumText('remark')->nullable();

            $table->dateTime('arrival_plan');
            $table->dateTime('arrival_actual')->nullable();
            $table->string('arrival_gap')->nullable();
            $table->string('arrival_status')->nullable();
            $table->dateTime('departure_plan');
            $table->dateTime('departure_actual')->nullable();
            $table->string('departure_gap')->nullable();
            $table->string('departure_status')->nullable();
            $table->string('vendor');
            $table->string('security_name_arrival')->nullable();
            $table->string('security_name_departure')->nullable();
            $table->string('driver_name')->nullable();

            $table->timestamps();
        });

        Schema::create('delivery_claim', function (Blueprint $table) {
            $table->id();
            $table->string('customer_pickup_id');
            $table->date('claim_date');
            $table->string('problem');
            $table->string('part_number');
            $table->string('part_name');
            $table->string('category');
            $table->string('part_number_actual');
            $table->string('part_name_actual');
            $table->integer('qty');
            $table->string('evidence');
            $table->mediumText('corrective_action');
            $table->timestamps();
        });

        Schema::create('delivery_notes', function (Blueprint $table) {
            $table->id();
            $table->string('customer');
            $table->string('delivery_note');
            $table->dateTime('out')->nullable();
            $table->dateTime('in')->nullable();
            $table->string('days');
            $table->integer('status')->nullable();
            $table->timestamps();
        });

        Schema::create('delivery_henkaten', function (Blueprint $table) {
            $table->id();
            $table->string('position');
            $table->string('user_id');
            $table->integer('henkaten_status')->nullable();
            $table->dateTime('date_henkaten')->nullable();
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

        Schema::table('delivery_henkaten', function ( $table) {
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
        Schema::dropIfExists('delivery_skills');
        Schema::dropIfExists('delivery_pickup_customer');
        Schema::dropIfExists('delivery_preparation');
        Schema::dropIfExists('delivery_claim');
        Schema::dropIfExists('delivery_notes');
        Schema::dropIfExists('delivery_mos');
        Schema::dropIfExists('delivery_henkaten');
    }
}
