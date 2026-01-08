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
        $sql = ProcesadosModel::with([
            'RelationVicidial',
            'RelationCliente',
            'RelationTipiifcacion1',
            'RelationTipiifcacion2',
            'RelationTipificacion3',
            'RelationEstatus'
        ])->whereDate('created_at', '>=', $init->format('Y-m-d'))
        ->whereDate('created_at', '<=', $finish->format('Y-m-d'))
        ->orderby('created_at','desc');
        $sql->chunk(50, function ($chunk) use (&$data) {    
            $row = array();
            foreach ($chunk as $change) {
                $row['FECHA']                   = date('d/m/Y', strtotime($change->created_at));
                $row['HORA']                    = date('H:i:s', strtotime($change->created_at));         
                $row['LLAMADA']                 = $change->RelationVicidial != null ? $change->RelationVicidial->descripcion : null;
                $row['CEDULA_DEL_TOMADOR']      = $change->RelationCliente->n_cedula;
                $row['SEXO_TOMADOR']            = $change->RelationCliente->cd_sexo;
                $row['EDO_CIVIL_TOMADOR']       = $change->RelationCliente->cd_edo_civil;
                $row['FECHA_NAC_TOMADOR']       = $change->RelationCliente->fecha_de_nacimiento;                                
                $row['PRODUCTO']                = $change->plan_id != null ? PlanesModel::find($change->plan_id)->codigo : null;                                
                $row['SUMA_ASEGURADA']          = $change->suma_asegurada_id != null ? SumaAseguradaModel::find($change->suma_asegurada_id)->nombre : null;
                $row['DOMICILIADO']             = $change->tipo_pago;
                $row['BANCO']                   = $change->banco_domiciliado != null ? BancosModel::find($change->banco_domiciliado)->id : null;
                $row['NRO_CUENTA']              = $change->num_cuenta_asociar_inst_bancario_sinencriptar != null ? strval($change->num_cuenta_asociar_inst_bancario_sinencriptar) : null;
                $row['TIPIFICACION 1']          = $change->RelationTipiifcacion1->descripcion;
                $row['TIPIFICACION 2']          = $change->RelationTipiifcacion2->descripcion;
                $row['TIPIFICACION 3']          = $change->RelationTipiifcacion3 != null ? $change->RelationTipiifcacion3->descripcion : null;
                $row['USUARIO']                 = $change->user_id;
                $row['ESTATUS']                 = $change->RelationEstatus->descripcion;
                $data[] = $row;
            
            }
        });
        return response()->json($data,200);

       } catch (\Exception $e){
            return response()->json($e->getMessage(),500);
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
