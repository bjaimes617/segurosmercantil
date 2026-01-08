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
    ///recursos de tipificaciones generales
    public function ReporteGeneral(Request $request)
    {
        
        try {
       
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
            gt_procesados.monto_a_pagar as MONTO_A_PAGAR,
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

    ///recursos de acceso a data clientes
    public function ReporteClientes(Request $request)
    {
     
     //   try {
            $data = array();        
            $init   = Carbon::createFromFormat('Y-m', $request->inicio)->startOfMonth();
            $finish = Carbon::createFromFormat('Y-m', $request->final)->endOfMonth();
      
            $data = DB::table('gt_clientes')
             ->leftJoin('estatus', 'gt_clientes.estatus_id', '=', 'estatus.id')
             ->leftJoin('gt_lotes', 'gt_clientes.lote_id', '=', 'gt_lotes.id')
             ->leftJoin('estados', 'gt_clientes.cd_estado_hab', '=', 'estados.id')             
             ->leftJoin('users', 'gt_clientes.user_id', '=', 'users.id')        
             ->whereDate('gt_lotes.created_at', '>=', $init->format('Y-m-d'))  
             ->whereDate('gt_lotes.created_at', '<=', $finish->format('Y-m-d')) 
             ->selectRaw(" DATE_FORMAT(gt_clientes.created_at, '%d/%m/%Y %H:%i:%s') as CLIENTE_REGISTRADO,
             DATE_FORMAT(gt_clientes.updated_at, '%d/%m/%Y %H:%i:%s') as CLIENTE_MODIFICADO,
             DATE_FORMAT(gt_lotes.created_at, '%d/%m/%Y %H:%i:%s') as REGISTRO_DE_LOTE,
             gt_lotes.archivo as NOMBRE_LOTE,
             gt_clientes.nacionalidad_cliente as NACIONALIDAD_TOMADOR,
             gt_clientes.n_cedula as CEDULA_DEL_TOMADOR,
             gt_clientes.cd_sexo as SEXO_TOMADOR,
             gt_clientes.cd_edo_civil as EDO_CIVIL_TOMADOR,
             gt_clientes.fecha_de_nacimiento as FECHA_NAC_TOMADOR,
             estados.estado as ESTADO,
             gt_clientes.cd_zona as ZONA,
             gt_clientes.di_av_calle_hab as DIRECCION,
             gt_clientes.di_casa_hab as NUMERO,
             gt_clientes.email_persol_tomador as EMAIL,
             gt_clientes.email_trabajo_u_ofici_tomador as EMAIL_TRABAJO,
             gt_clientes.cd_area_num_telefono_habitacion_tomador as CODIGO_AREA,
             gt_clientes.num_telefono_hab_tomador as TELEFONO,
             gt_clientes.cd_area_num_telefono_trab_ofic_tomador as CODIGO_AREA_TRABAJO,
             gt_clientes.num_telefono_trab_ofic_tomador as TELEFONO_TRABAJO,
             gt_clientes.num_celular_pers_tomador as CELULAR,
             gt_clientes.num_celular_trab_tomador as CELULAR_TRABAJO,
             gt_clientes.num_cuenta_asociar_inst_bancario_sinencriptar as NRO_CUENTA,
             gt_clientes.tipo_cuenta_domiciliar as TIPO_CUENTA,
             estatus.descripcion as ESTATUS,
             users.username as USUARIO")->get();

            return response()->json($data,200);

      //  } catch (\Exception $e) {
           // return response()->json($e->getMessage(),500);
    //    }
    }
}
