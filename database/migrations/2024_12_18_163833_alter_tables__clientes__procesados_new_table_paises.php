<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTablesClientesProcesadosNewTablePaises extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        
        Schema::table('gt_clientes', function (Blueprint $table) {
                $table->date('fe_vencimiento_documento')->after('n_cedula')->nullable();
                $table->string('tp_direccion')->after('codigo_postal_hab')->nullable();              
                $table->string('tp_vivienda')->after('tp_direccion')->nullable();                            
                $table->string('nu_casa')->after('tp_vivienda')->nullable();    
                $table->string('nu_piso')->after('nu_casa')->nullable();    
                $table->string('nu_puerta')->after('nu_piso')->nullable();    
                $table->string('tp_telefono')->after('nu_puerta')->nullable();    
                $table->string('cd_pais')->after('tp_telefono')->nullable(); 
                $table->string('cd_provincia')->after('cd_pais')->nullable(); 
                $table->string('cd_ciudad')->after('cd_provincia')->nullable(); 
                $table->string('cd_zona')->after('cd_ciudad')->nullable(); 
        });
        
        Schema::create('gt_pais', function (Blueprint $table) {
            $table->bigIncrements('id');                      
            $table->string('nacionalidad')->nullable();           
            $table->string('nombre');   
            $table->boolean('active')->default(1);                       
        });
        
        Schema::create('gt_provincia', function (Blueprint $table) {
            $table->bigIncrements('id');                      
            $table->string('gt_pais_id');           
            $table->string('cod_provincia');    
            $table->string('nombre');   
            $table->boolean('active')->default(1);                       
        });
        
        Schema::create('gt_ciudad', function (Blueprint $table) {
            $table->bigIncrements('id');                      
            $table->string('gt_pais_id');           
            $table->string('cod_provincia');
             $table->string('cod_ciudad');
            $table->string('nombre');   
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
        Schema::dropIfExists('gt_ciudad');
        Schema::dropIfExists('gt_provincia');
        Schema::dropIfExists('gt_pais');
    }
}
