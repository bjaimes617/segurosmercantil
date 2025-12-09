<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class TableProcesadosAndTableTipificacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('gt_tipificacion1', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion');                                   
            $table->boolean('active')->default(1);            
            $table->timestamps();
        });
        
        Schema::create('gt_tipificacion2', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion');        
            $table->unsignedBigInteger('gt_tipificacion1_id')->index()->nullable();
            $table->foreign('gt_tipificacion1_id')->references('id')->on('gt_tipificacion1')->onDelete(NULL);
            $table->string('estatus_asignado'); 
            $table->boolean('active')->default(1);
            $table->timestamps();
        });
        
        Schema::create('gt_procesados', function (Blueprint $table) {
            $table->integerincrements('id');
            
            $table->unsignedInteger('clientes_id')->index()->nullable();
            $table->foreign('clientes_id')->references('id')->on('gt_clientes')->onDelete('cascade');           
            
            $table->string('banco_domiciliado')->nullable();	
            
            $table->string('num_cuenta_asociar_inst_bancario_sinencriptar')->nullable();	
            $table->string('tipo_cuenta_domiciliar')->nullable();
            
            $table->string('tipo_tdc_domiciliar')->nullable();              
            $table->string('fecha_vencimiento_tdc_domiciliar')->nullable();

            $table->date('fecha_agendado')->nullable();
            
            $table->string('plan_id')->nullable();
            $table->string('suma_asegurada_id')->nullable();
            
            $table->string('tipo_pago',2)->nullable();
            $table->decimal('monto_a_pagar',8,2)->nullable();
            
            $table->string('estatus_id',2)->nullable();            
                        
            $table->string('user_id',50)->nullable();
                        
            $table->unsignedBigInteger('gt_tipificacion1_id')->index()->nullable();
            $table->foreign('gt_tipificacion1_id')->references('id')->on('gt_tipificacion1')->onDelete(NULL);
            
            $table->unsignedBigInteger('gt_tipificacion2_id')->index()->nullable();
            $table->foreign('gt_tipificacion2_id')->references('id')->on('gt_tipificacion2')->onDelete(NULL);
            
            $table->text('comentario')->nullable();
            $table->timestamps();
           
        });
        
        Schema::create('gt_vicialRecords', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('descripcion');                                   
            $table->unsignedInteger('gt_procesados_id')->index()->nullable();
            $table->foreign('gt_procesados_id')->references('id')->on('gt_procesados')->onDelete('cascade');
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
        Schema::dropIfExists('gt_vicialRecords');
        Schema::dropIfExists('gt_procesados');
        Schema::dropIfExists('gt_tipificacion2');
        Schema::dropIfExists('gt_tipificacion1');
         
    }
}

