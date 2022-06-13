<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityMonitorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_monitors', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->string('doc_number', 50);
            $table->integer('judgement', 1);

            $table->bigInteger('quality_area_id', 20);
            $table->bigInteger('quality_process_id', 20);
            $table->bigInteger('quality_model_id', 20);
            $table->bigInteger('quality_part_id', 20);
            $table->tinyInteger('quality_cs_qtime');
            $table->tinyInteger('quality_cs_accuracy');

            $table->integer('created_by');
            $table->integer('updated_by');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('quality_area_id')
                ->references('id')
                ->on('quality_areas')
                ->onDelete('cascade');

            $table->foreign('quality_process_id')
                ->references('id')
                ->on('quality_processes')
                ->onDelete('cascade');

            $table->foreign('quality_model_id')
                ->references('id')
                ->on('quality_models')
                ->onDelete('cascade');

            $table->foreign('quality_part_id')
                ->references('id')
                ->on('quality_parts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('quality_monitors');
    }
}
