<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityCsQtimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_cs_qtimes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('quality_monitor_id');
            $table->integer('shift');
            $table->integer('cycle');

            $table->tinyInteger('destructive_test');
            $table->mediumText('destructive_test_remark');
            $table->tinyInteger('appearance_produk');
            $table->mediumText('appearance_produk_remark');
            $table->tinyInteger('parting_line');
            $table->mediumText('parting_line_remark');

            $table->tinyInteger('marking_cek_final');
            $table->mediumText('marking_cek_final_remark');
            $table->tinyInteger('marking_garansi_function');
            $table->mediumText('marking_garansi_function_remark');
            $table->tinyInteger('marking_identification');
            $table->mediumText('marking_identification_remark');

            $table->tinyInteger('kelengkapan_komponen');
            $table->mediumText('kelengkapan_komponen_remark');

            $table->tinyInteger('housing');
            $table->tinyInteger('lens');
            $table->tinyInteger('extension');
            $table->tinyInteger('extension_rs_1'); 
            $table->tinyInteger('reflector_1');
            $table->tinyInteger('reflector_2');
            $table->tinyInteger('light_guide'); 
            $table->tinyInteger('base'); 
            $table->tinyInteger('ldm');
            $table->tinyInteger('wire_harness_1'); 
            $table->tinyInteger('wire_harness_2');
            $table->tinyInteger('wire_harness_3');
            $table->tinyInteger('wire_harness_4');
            $table->tinyInteger('wire_harness_5');
            $table->tinyInteger('pcb_assy_2');
            $table->tinyInteger('pcb_assy_3');
            $table->tinyInteger('gore_tag');
            $table->tinyInteger('tapping_screw');
            $table->tinyInteger('tapping_screw_assy');
            $table->tinyInteger('screw_pin');
            $table->tinyInteger('non_woven_tape');
            $table->tinyInteger('vant_cap_assy');

            $table->tinyInteger('kondisi_jig');
            $table->tinyInteger('kondisi_pokayoke');
            $table->tinyInteger('operator_wi_qpoint');
            $table->tinyInteger('childpart_identitas');
            $table->tinyInteger('kondisi_parameter');

            $table->tinyInteger('judge');

            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('quality_cs_qtimes');
    }
}
