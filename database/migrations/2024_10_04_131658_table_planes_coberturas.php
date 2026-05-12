<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablePlanesCoberturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gt_planes', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nombre');  
            $table->string('codigo');           
            $table->string('nombre_archivo')->nullable();            
            $table->boolean('required_planes_rango_edad')->default(0);
            $table->boolean('required_planes_desgloce_edad')->default(0);            
            $table->boolean('active')->default(1);
           
        });
        
        Schema::create('gt_suma_asegurada', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nombre');  
            $table->unsignedInteger('gt_planes_id')->index()->nullable();
            $table->foreign('gt_planes_id')->references('id')->on('gt_planes')->onDelete('cascade');
            $table->boolean('active')->default(1);           
        });
        
        Schema::create('gt_planes_desgloce_edad', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('gt_suma_asegurada_id')->index()->nullable();
            $table->foreign('gt_suma_asegurada_id')->references('id')->on('gt_suma_asegurada')->onDelete('cascade');
            $table->string('edad');             
            $table->decimal('prima_anual',8,2);  
            $table->decimal('prima_semestral',8,2); 
            $table->decimal('prima_trimestral',8,2); 
            $table->decimal('prima_mensual',8,2);                        
            $table->boolean('active')->default(1);
        });
        
        Schema::create('gt_planes_rango_edad', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedInteger('gt_suma_asegurada_id')->index()->nullable();
            $table->foreign('gt_suma_asegurada_id')->references('id')->on('gt_suma_asegurada')->onDelete('cascade');   
            $table->string('minEdad'); 
            $table->string('maxEdad');  
            $table->decimal('prima_anual',8,2);  
            $table->decimal('prima_semestral',8,2); 
            $table->decimal('prima_trimestral',8,2); 
            $table->decimal('prima_mensual',8,2); 
            $table->boolean('active')->default(1);
        });
    }

    /**

     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {        
        Schema::dropIfExists('gt_planes');
        Schema::dropIfExists('gt_suma_asegurada');
        Schema::dropIfExists('gt_planes_desgloce_edad');
        Schema::dropIfExists('gt_planes_rango_edad');
    }
}