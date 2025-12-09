<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddGtTipificacion3IdToGtProcesadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gt_procesados', function (Blueprint $table) {
            $table->bigInteger('gt_tipificacion3_id')->unsigned()->index()->nullable()->after('gt_tipificacion2_id');
            $table->foreign('gt_tipificacion3_id')->references('id')->on('gt_tipificacion3');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gt_procesados', function (Blueprint $table) {
            $table->dropForeign(['gt_procesados_gt_tipificacion3_id_foreign']);
            $table->dropIndex(['gt_procesados_gt_tipificacion3_id_index']);
            $table->dropColumn('gt_tipificacion3_id');
        });
    }
}
