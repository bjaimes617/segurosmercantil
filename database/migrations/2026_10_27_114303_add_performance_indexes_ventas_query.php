<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPerformanceIndexesVentasQuery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Índice para filtrar clientes por cédula + estatus (consulta DataTatableVentas)
        Schema::table('gt_clientes', function (Blueprint $table) {
            $table->index(['n_cedula', 'estatus_id'], 'idx_clientes_cedula_estatus');
        });

        // Índice compuesto para la subquery de procesados: filtra por fecha y agrupa por cliente
        Schema::table('gt_procesados', function (Blueprint $table) {
            $table->index(['clientes_id', 'created_at', 'estatus_id'], 'idx_procesados_cliente_fecha_estatus');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gt_clientes', function (Blueprint $table) {
            $table->dropIndex('idx_clientes_cedula_estatus');
        });

        Schema::table('gt_procesados', function (Blueprint $table) {
            $table->dropIndex('idx_procesados_cliente_fecha_estatus');
        });
    }
}
