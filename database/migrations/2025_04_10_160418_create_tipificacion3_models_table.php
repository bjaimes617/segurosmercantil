<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipificacion3ModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gt_tipificacion3', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('descripcion');
            $table->bigInteger('gt_tipificacion2_id')->unsigned()->index()->nullable();
            $table->foreign('gt_tipificacion2_id')->references('id')->on('gt_tipificacion2');
            $table->integer('active');
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
        Schema::dropIfExists('gt_tipificacion3');
    }
}
