<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TablesGestionVentas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estados', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('estado');           
        });
        
         Schema::create('ciudades', function (Blueprint $table) {
            $table->integerIncrements('id');            
            $table->unsignedInteger('estado_id');              
            $table->string('nombre_ciudad');                          
            $table->boolean('active')->default(1);
        });
        
         Schema::create('municipio', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nombre_municipio');   
            $table->unsignedInteger('estado_id');
            $table->unsignedInteger('ciudad_id');  
            
            $table->boolean('active')->default(1);
        });
        
        Schema::create('parroquias', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->string('nombre_parroquia');  
            $table->unsignedInteger('municipio_id')->unsigned()->index(); 
            $table->unsignedInteger('ciudad_id')->unsigned()->index();   
            $table->boolean('active')->default(1);
        });
        
         Schema::create('urbanizacion', function (Blueprint $table) {
            $table->integerIncrements('id');    
            $table->unsignedInteger('estado_id');  
            $table->unsignedInteger('ciudad_id');       
            $table->unsignedInteger('municipio_id');       
            $table->unsignedInteger('parroquia_id'); 
            $table->string('codigo_postal',8);   
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
        Schema::dropIfExists('urbanizacion');
        Schema::dropIfExists('parroquias');
        Schema::dropIfExists('municipio');
        Schema::dropIfExists('ciudades');
        Schema::dropIfExists('estados');
        
        
    }
}
