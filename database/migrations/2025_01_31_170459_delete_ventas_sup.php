<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DeleteVentasSup extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gt_eliminadas', function (Blueprint $table) {
            $table->bigIncrements('id');               
            $table->unsignedInteger('clientes_id')->index()->nullable();
            $table->foreign('clientes_id')->references('id')->on('gt_clientes')->onDelete('cascade'); 
            $table->string('eliminado_por',100);
            $table->string('cometario_sup');
            $table->string('estatus_id');
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
        Schema::dropIfExists('gt_eliminadas');
    }
}
