<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQualityPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quality_parts', function (Blueprint $table) {
            $table->id();
            $table->integer('quality_model_id');
            $table->string('name', 100);
            $table->string('description', 320);
            $table->tinyInteger('low');
            $table->tinyInteger('mid');
            $table->tinyInteger('high');
            $table->tinyInteger('left');
            $table->tinyInteger('center');
            $table->tinyInteger('right');
            $table->string('photo',200);

            $table->integer('created_by');
            $table->integer('updated_by');
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
        Schema::dropIfExists('quality_parts');
    }
}
