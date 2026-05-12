<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('estatus', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion');
            $table->timestamps();
        });
        
        Schema::create('gt_lotes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('archivo');
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete(NULL);
            $table->timestamps();
        });
        
        Schema::create('gt_clientes', function (Blueprint $table) {
            $table->integerincrements('id');
            $table->string('nacionalidad_cliente',2);
            $table->string('n_cedula',8);	
            $table->string('apelld1',50)->nullable();
            $table->string('apelld2',50)->nullable();	
            $table->string('apellcasada',50)->nullable();
            $table->string('nomb1',50)->nullable();
            $table->string('nomb2',50)->nullable();
            $table->string('cd_sexo',1)->nullable();
            $table->string('cd_edo_civil',1)->nullable();
            $table->date('fecha_de_nacimiento')->nullable();
            $table->string('cd_estado_hab',50)->nullable();
            $table->string('cd_ciudad_hab',50)->nullable();
            $table->string('municipio_hab',50)->nullable();
            $table->string('parroquia_hab',50)->nullable();
            $table->string('cd_urbanizsector_hab',50)->nullable();
            $table->string('codigo_postal_hab',50)->nullable();
            $table->string('di_av_calle_hab')->nullable();
            $table->string('di_casa_hab')->nullable();
            $table->string('email_persol_tomador')->nullable();
            $table->string('email_trabajo_u_ofici_tomador')->nullable();
            $table->string('cd_area_num_telefono_habitacion_tomador')->nullable();
            $table->string('num_telefono_hab_tomador')->nullable();
            $table->string('cd_area_num_telefono_trab_ofic_tomador')->nullable();
            $table->string('num_telefono_trab_ofic_tomador')->nullable();	
            $table->string('num_celular_pers_tomador')->nullable();
            $table->string('num_celular_trab_tomador')->nullable();
            $table->string('cd_profesion_ocupacion_cliente')->nullable();
            $table->string('num_cuenta_asociar_inst_bancario_sinencriptar')->nullable();	
            $table->string('tipo_cuenta_domiciliar')->nullable();
                        
            $table->date('fecha_agendado')->nullable();
            
            $table->unsignedBigInteger('estatus_id')->index()->nullable();
            $table->foreign('estatus_id')->references('id')->on('estatus')->onDelete(null);
            
            $table->unsignedBigInteger('lote_id')->index()->nullable();
            $table->foreign('lote_id')->references('id')->on('gt_lotes')->onDelete('cascade');
            
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete(null);
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
        Schema::dropIfExists('gt_clientes');
        Schema::dropIfExists('gt_lotes');
        Schema::dropIfExists('estatus');        
    }
}
