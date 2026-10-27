<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $exists = !empty(DB::select("SHOW INDEX FROM gt_procesados WHERE Key_name = 'idx_proc_created_cliente_estatus'"));
        if (!$exists) {
            Schema::table('gt_procesados', function (Blueprint $table) {
                $table->index(['created_at', 'clientes_id', 'estatus_id'], 'idx_proc_created_cliente_estatus');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gt_procesados', function (Blueprint $table) {
            $table->dropIndex('idx_proc_created_cliente_estatus');
        });
    }
};
