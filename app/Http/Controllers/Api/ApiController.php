<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\SegurosMercantil\ProcesadosModel;
use App\Models\SegurosMercantil\SumaAseguradaModel;
use App\Models\SegurosMercantil\PlanesModel;

use Carbon\Carbon;

class ApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ReporteGeneral()
    {
        $row = array();
        $data = array();
        
        $init   = Carbon::now()->subMonth(3)->StartOfDay();
        $finish = Carbon::now()->EndOfDay();
        
        $sql = ProcesadosModel::whereBetween('created_at',array($init->copy()->format('Y-m-d H:i:s'), $finish->copy()->format('Y-m-d H:i:s')))->get();
        
        foreach ($sql as $change) {
            $row['FECHA']                   = date('d/m/Y', strtotime($change->created_at));
            $row['HORA']                    = date('H:i:s', strtotime($change->created_at));         
            $row['LLAMADA']                 = $change->RelationVicidial != null ? $change->RelationVicidial->descripcion : null;
            $row['FECHA_AGENDADO']          = $change->fecha_agendado != null ? date('d/m/Y', strtotime($change->fecha_agendado)) : null;
            $row['NACIONALIDAD_TOMADOR']    = $change->RelationCliente->nacionalidad_cliente;
            $row['CEDULA_DEL_TOMADOR']      = $change->RelationCliente->n_cedula;
            $row['APELLIDO_1_TOMADOR']      = $change->RelationCliente->apelld1; 
            $row['APELLIDO_2_TOMADOR']      = $change->RelationCliente->apelld2;
            $row['APELL CASADA TOMADOR']    = $change->RelationCliente->apellcasada;
            $row['NOMBRE_1_TOMADOR']        = $change->RelationCliente->nomb1;
            $row['NOMBRE_2_TOMADOR']        = $change->RelationCliente->nomb2;
            $row['SEXO_TOMADOR']            = $change->RelationCliente->cd_sexo;
            $row['EDO_CIVIL_TOMADOR']       = $change->RelationCliente->cd_edo_civil;
            $row['FECHA_NAC_TOMADOR']       = $change->RelationCliente->fecha_de_nacimiento;
            $row['ESTADO_HAB_TOMADOR']      = $change->RelationCliente->cd_estado_hab;
            $row['CIUDAD_HAB_TOMADOR']      = $change->RelationCliente->cd_ciudad_hab;
            $row['MUNICIPIO_HAB_TOMADO']    = $change->RelationCliente->municipio_hab;
            $row['PARROQUIA_HAB_TOMADO']    = $change->RelationCliente->parroquia_hab;
            $row['URB_HAB_TOMADOR']         = $change->RelationCliente->cd_urbanizsector_hab;
            $row['ZN_POSTAL_HAB_TOMADO']    = $change->RelationCliente->codigo_postal_hab;
            $row['AVENIDA_HAB_TOMADOR']     = $change->RelationCliente->di_av_calle_hab;          
            $row['CASA_HAB_TOMADOR']        = $change->RelationCliente->di_casa_hab;
            $row['EMAIL_OFIC_TOMADOR']      = $change->RelationCliente->email_trabajo_u_ofici_tomador;
            $row['EMAIL_HAB_TOMADOR']       = $change->RelationCliente->email_persol_tomador;
            $row['AREA_TLF_HAB_TOMADOR']    = $change->RelationCliente->cd_area_num_telefono_habitacion_tomador;
            $row['TELEFONO_HAB_TOMADOR']    = $change->RelationCliente->num_telefono_hab_tomador;
            $row['AREA_TLF_OFI_TOMADOR']    = $change->RelationCliente->cd_area_num_telefono_trab_ofic_tomador;
            $row['TELEFONO_OFI_TOMADOR']    = $change->RelationCliente->num_telefono_trab_ofic_tomador;
            $row['CELULAR_HAB_TOMADOR']     = $change->RelationCliente->num_celular_pers_tomador;
            $row['CELULAR_OFI_TOMADOR']     = $change->RelationCliente->num_celular_trab_tomador;
            $row['NACIONALIDAD_CLIENTE']    = $change->RelationCliente->nacionalidad_cliente;
            $row['CEDULA_DEL_CLIENTE']      = $change->RelationCliente->n_cedula;
            $row['APELLIDO_1_CLIENTE']      = $change->RelationCliente->apelld1;
            $row['APELLIDO_2_CLIENTE']      = $change->RelationCliente->apelld2;
            $row['APELL_CASADA_CLIENTE']    = $change->RelationCliente->apellcasada;
            $row['NOMBRE_1_CLIENTE']        = $change->RelationCliente->nomb1;
            $row['NOMBRE_2_CLIENTE']        = $change->RelationCliente->nomb2;
            $row['SEXO_CLIENTE']            = $change->RelationCliente->cd_sexo;
            $row['EDO_CIVIL_CLIENTE']       = $change->RelationCliente->cd_edo_civil;
            $row['FECHA_NAC_CLIENTE']       = $change->RelationCliente->fecha_de_nacimiento;
            $row['ESTADO_HAB_CLIENTE']      = $change->RelationCliente->cd_estado_hab;
            $row['CIUDAD_HAB_CLIENTE']      = $change->RelationCliente->cd_ciudad_hab;
            $row['MUNICIPIO_HAB_CLIENT']    = $change->RelationCliente->municipio_hab;
            $row['PARROQUIA_HAB_CLIENT']    = $change->RelationCliente->parroquia_hab;
            $row['URB_HAB_CLIENTE']         = $change->RelationCliente->cd_urbanizsector_hab;
            $row['ZN_POSTAL_HAB_CLIENT']    = $change->RelationCliente->codigo_postal_hab;
            $row['AVENIDA_HAB_CLIENTE']     = $change->RelationCliente->di_av_calle_hab;
            $row['CASA_HAB_CLIENTE']        = $change->RelationCliente->di_casa_hab;
            $row['AREA_TLF_HAB_CLIENTE']    = $change->RelationCliente->cd_area_num_telefono_habitacion_tomador;
            $row['TELEFONO_HAB_CLIENTE']    = $change->RelationCliente->num_telefono_hab_tomador;
            $row['CELULAR_HAB_CLIENTE']     = $change->RelationCliente->num_celular_pers_tomador;
            $row['EMAIL_HAB_CLIENTE']       = $change->RelationCliente->email_persol_tomador;
            $row['EMAIL_OFIC_CLIENTE']      = $change->RelationCliente->email_trabajo_u_ofici_tomador;
            $row['AREA_TLF_OFI_CLIENTE']    = $change->RelationCliente->cd_area_num_telefono_trab_ofic_tomador;
            $row['TELEFONO_OFI_CLIENTE']    = $change->RelationCliente->num_telefono_trab_ofic_tomador;
            $row['CELULAR_OFI_CLIENTE']     = $change->RelationCliente->num_celular_trab_tomador;
            $row['SUCURSAL']                = 1;
            $row['PRODUCTO']                = $change->plan_id != null ? PlanesModel::find($change->plan_id)->codigo : null;
            $row['FECHA_SOLICITUD']         = $change->estatus_id  == 5 ? $change->fecha_solicitud = date('d/m/Y', strtotime($change->created_at)) :  $change->fecha_solicitud = null;
            $row['FR_PAGO']                 = $change->tipo_pago;
            $row['CANAL_VENTA']             = 12;
            $row['PRODUCTOR']               = 35000;
            $row['PROFESION']               = $change->RelationCliente->cd_profesion_ocupacion_cliente;
            $row['SUMA_ASEGURADA']          = $change->suma_asegurada_id != null ? SumaAseguradaModel::find($change->suma_asegurada_id)->nombre : null;
            $row['DOMICILIADO']             = $change->tipo_pago;
            $row['BANCO']                   = $change->banco_domiciliado != null ? BancosModel::find($change->banco_domiciliado)->id : null;
            $row['NRO_CUENTA']              = $change->num_cuenta_asociar_inst_bancario_sinencriptar != null ? strval($change->num_cuenta_asociar_inst_bancario_sinencriptar) : null;
            $row['TIPO_CUENTA']             = $change->tipo_cuenta_domiciliar;
            $row['TIPO_TARJETA']            = $change->tipo_tdc_domiciliar;
            $row['FE_VCMTO_TARJETA']        = $change->fecha_vencimiento_tdc_domiciliar;  
            $row['MONTO_PLAN']              = $change->monto_a_pagar != null ? $change->monto_a_pagar : null;
            $row['TIPIFICACION 1']          = $change->RelationTipiifcacion1->descripcion;
            $row['TIPIFICACION 2']          = $change->RelationTipiifcacion2->descripcion;
            $row['TIPIFICACION 3']          = $change->RelationTipiifcacion3 != null ? $change->RelationTipiifcacion3->descripcion : null;
            $row['USUARIO']                 = $data->user_id;
            $row['ESTATUS']                 = $change->RelationEstatus->descripcion;
            $row['COMENTARIOS']             = $data->comentario;

            $data[] = $row;
        }
        return json_encode($data,200);
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
