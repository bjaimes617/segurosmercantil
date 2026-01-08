<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\SegurosMercantil\ProcesadosModel;
use App\Models\SegurosMercantil\SumaAseguradaModel;
use App\Models\SegurosMercantil\PlanesModel;
use App\Models\SegurosMercantil\BancosModel;

use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ReporteGeneral(Request $request)
    {
        
       try{
       
        $data = array();        
        $init   = Carbon::create($request->inicio);
        $finish = Carbon::create($request->final);     
        
       $data = DB::table('gt_procesados')
    ->leftJoin('gt_vicialRecords', 'gt_vicialRecords.gt_procesados_id', '=', 'gt_procesados.id')
    ->leftJoin('gt_clientes', 'gt_procesados.clientes_id', '=', 'gt_clientes.id')
    ->leftJoin('gt_tipificacion1', 'gt_procesados.gt_tipificacion1_id', '=', 'gt_tipificacion1.id')
    ->leftJoin('gt_tipificacion2', 'gt_procesados.gt_tipificacion2_id', '=', 'gt_tipificacion2.id')
    ->leftJoin('gt_tipificacion3', 'gt_procesados.gt_tipificacion3_id', '=', 'gt_tipificacion3.id')
    ->leftJoin('estatus', 'gt_procesados.estatus_id', '=', 'estatus.id')
    ->leftJoin('gt_planes', 'gt_procesados.plan_id', '=', 'gt_planes.id')
    ->leftJoin('gt_suma_asegurada', 'gt_procesados.suma_asegurada_id', '=', 'gt_suma_asegurada.id')
    ->leftJoin('gt_bancos', 'gt_procesados.banco_domiciliado', '=', 'gt_bancos.id')
    ->whereDate('gt_procesados.created_at', '>=', $init->format('Y-m-d'))
    ->whereDate('gt_procesados.created_at', '<=', $finish->format('Y-m-d'))
    ->orderBy('gt_procesados.created_at', 'desc')
    ->selectRaw("
        DATE_FORMAT(gt_procesados.created_at, '%d/%m/%Y') as FECHA,
        DATE_FORMAT(gt_procesados.created_at, '%H:%i:%s') as HORA,
        gt_vicialRecords.descripcion as LLAMADA,
        gt_clientes.n_cedula as CEDULA_DEL_TOMADOR,
        gt_clientes.cd_sexo as SEXO_TOMADOR,
        gt_clientes.cd_edo_civil as EDO_CIVIL_TOMADOR,
        gt_clientes.fecha_de_nacimiento as FECHA_NAC_TOMADOR,
        gt_planes.codigo as PRODUCTO,
        gt_suma_asegurada.nombre as SUMA_ASEGURADA,
        gt_procesados.tipo_pago as DOMICILIADO,
        gt_bancos.id as BANCO,
        gt_procesados.num_cuenta_asociar_inst_bancario_sinencriptar as NRO_CUENTA,
        gt_tipificacion1.descripcion as `TIPIFICACION 1`,
        gt_tipificacion2.descripcion as `TIPIFICACION 2`,
        gt_tipificacion3.descripcion as `TIPIFICACION 3`,
        gt_procesados.user_id as USUARIO,
        estatus.descripcion as ESTATUS")->get();

        return response()->json($data,200);

       } catch (\Exception $e){
            return response()->json([$e->getMessage()],500);
       }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
