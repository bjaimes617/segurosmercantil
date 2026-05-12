<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gt_clientes', function (Blueprint $table) {
            $table->string('rfm')->nullable()->after('tipo_cuenta_domiciliar');
            $table->unique('n_cedula');
            $table->index('n_cedula');
        });

        Schema::table('estados', function (Blueprint $table) {
            $table->string('region')->nullable()->after('estado');
        });

        Schema::table('gt_lotes', function (Blueprint $table) {
            $table->string('identificacion_storage')->nullable()->after('user_id');
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
            $table->dropColumn('rfm');
        });

        Schema::table('estados', function (Blueprint $table) {
            $table->dropColumn('region');
        });

        Schema::table('gt_lotes', function (Blueprint $table) {
            $table->dropColumn('identificacion_storage');
        });
    }
};
