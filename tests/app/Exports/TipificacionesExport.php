<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\SegurosMercantil\PlanesModel;
use App\Models\SegurosMercantil\SumaAseguradaModel;
use App\Models\SegurosMercantil\BancosModel;

class TipificacionesExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithChunkReading, WithCustomCsvSettings {

    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function chunkSize(): int {
        return 500;
    }

    public function getCsvSettings(): array {
        return [
            'input_encoding' => 'utf_8',
            'delimiter' => ';',
            "Content-type" => "text/csv; charset=utf_8",
            'use_bom' => true,
        ];
    }

    public function startRow(): int {
        return 2;
    }

    public function collection() {
        $this->data->each(function ($data) {
            $this->map($data);
        });
        return $this->data;
    }

    public function headings(): array {
      $columns = [
            'FECHA',
            'HORA',
            'LLAMADA',
            'FECHA_AGENDADO',           
            'NACIONALIDAD_TOMADOR',
            'CEDULA_DEL_TOMADOR',
            'APELLIDO_1_TOMADOR',
            'APELLIDO_2_TOMADOR',
            'APELL CASADA TOMADOR',
            'NOMBRE_1_TOMADOR',
            'NOMBRE_2_TOMADOR',
            'SEXO_TOMADOR',
            'EDO_CIVIL_TOMADOR',
            'FECHA_NAC_TOMADOR',
            'ESTADO_HAB_TOMADOR',
            'CIUDAD_HAB_TOMADOR',
            'MUNICIPIO_HAB_TOMADO',
            'PARROQUIA_HAB_TOMADO',
            'URB_HAB_TOMADOR',
            'ZN_POSTAL_HAB_TOMADO',
            'AVENIDA_HAB_TOMADOR',
            'CASA_HAB_TOMADOR',
            'EMAIL_OFIC_TOMADOR',
            'EMAIL_HAB_TOMADOR',
            'AREA_TLF_HAB_TOMADOR',
            'TELEFONO_HAB_TOMADOR',
            'AREA_TLF_OFI_TOMADOR',
            'TELEFONO_OFI_TOMADOR',
            'CELULAR_HAB_TOMADOR',
            'CELULAR_OFI_TOMADOR',
            'NACIONALIDAD_CLIENTE',
            'CEDULA_DEL_CLIENTE',
            'APELLIDO_1_CLIENTE',
            'APELLIDO_2_CLIENTE',
            'APELL_CASADA_CLIENTE',
            'NOMBRE_1_CLIENTE',
            'NOMBRE_2_CLIENTE',
            'SEXO_CLIENTE',
            'EDO_CIVIL_CLIENTE',
            'FECHA_NAC_CLIENTE',
            'ESTADO_HAB_CLIENTE',
            'CIUDAD_HAB_CLIENTE',
            'MUNICIPIO_HAB_CLIENT',
            'PARROQUIA_HAB_CLIENT',
            'URB_HAB_CLIENTE',
            'ZN_POSTAL_HAB_CLIENT',
            'AVENIDA_HAB_CLIENTE',
            'CASA_HAB_CLIENTE',
            'AREA_TLF_HAB_CLIENTE',
            'TELEFONO_HAB_CLIENTE',
            'CELULAR_HAB_CLIENTE',
            'EMAIL_HAB_CLIENTE',
            'EMAIL_OFIC_CLIENTE',
            'AREA_TLF_OFI_CLIENTE',
            'TELEFONO_OFI_CLIENTE',
            'CELULAR_OFI_CLIENTE',
            'SUCURSAL',
            'PRODUCTO',
            'FECHA_SOLICITUD',
            'FR_PAGO',
            'CANAL_VENTA',
            'PRODUCTOR',
            'PROFESION',
            'SUMA_ASEGURADA',
            'DOMICILIADO',
            'BANCO',
            'NRO_CUENTA',
            'TIPO_CUENTA',
            'TIPO_TARJETA',
            'FE_VCMTO_TARJETA',  
            'MONTO_PLAN',          
            'TIPIFICACION 1',
            'TIPIFICACION 2',
            'TIPIFICACION 3',
            'USUARIO',
            'ESTATUS',
            'COMENTARIOS'            
            ];
        return $columns;
    }

    public function prepareRows($data): array {
         return array_map(function ($change) {            
          $change->fecha        = date('d/m/Y', strtotime($change->created_at));
          $change->hora         = date('H:i:s', strtotime($change->created_at));         
          $change->llamada          = $change->RelationVicidial != null ? $change->RelationVicidial->descripcion : null;
          $change->fechaAgendado    = $change->fecha_agendado != null ? date('d/m/Y', strtotime($change->fecha_agendado)) : null;
          $change->nacionalidad     = $change->RelationCliente->nacionalidad_cliente;
          $change->n_cedula         = $change->RelationCliente->n_cedula;
          $change->apelld1          = $change->RelationCliente->apelld1;
          $change->apelld2          = $change->RelationCliente->apelld2;
          $change->apellcasada      = $change->RelationCliente->apellcasada;
          $change->nomb1        = $change->RelationCliente->nomb1;
          $change->nomb2        = $change->RelationCliente->nomb2;
          $change->cd_sexo      = $change->RelationCliente->cd_sexo;
          $change->cd_edo_civil             = $change->RelationCliente->cd_edo_civil;
          $change->fecha_de_nacimiento      = $change->RelationCliente->fecha_de_nacimiento;
          $change->cd_estado_hab     = $change->RelationCliente->cd_estado_hab;
          $change->cd_ciudad_hab     = $change->RelationCliente->cd_ciudad_hab;
          $change->municipio_hab     = $change->RelationCliente->municipio_hab;
          $change->parroquia_hab     = $change->RelationCliente->parroquia_hab;
          $change->cd_urbanizsector_hab     = $change->RelationCliente->cd_urbanizsector_hab;
          $change->codigo_postal_hab        = $change->RelationCliente->codigo_postal_hab;
          $change->di_av_calle_hab          = $change->RelationCliente->di_av_calle_hab;          
          $change->di_casa_hab              = $change->RelationCliente->di_casa_hab;
          $change->email_persol_tomador                     = $change->RelationCliente->email_persol_tomador;
          $change->email_trabajo_u_ofici_tomador            = $change->RelationCliente->email_trabajo_u_ofici_tomador;
          $change->cd_area_num_telefono_habitacion_tomador            = $change->RelationCliente->cd_area_num_telefono_habitacion_tomador;
          $change->num_telefono_hab_tomador            = $change->RelationCliente->num_telefono_hab_tomador;
          $change->cd_area_num_telefono_trab_ofic_tomador            = $change->RelationCliente->cd_area_num_telefono_trab_ofic_tomador;
          $change->num_telefono_trab_ofic_tomador            = $change->RelationCliente->num_telefono_trab_ofic_tomador;
          $change->num_celular_pers_tomador            = $change->RelationCliente->num_celular_pers_tomador;
          $change->num_celular_trab_tomador            = $change->RelationCliente->num_celular_trab_tomador;
          $change->cd_profesion_ocupacion_cliente = $change->RelationCliente->cd_profesion_ocupacion_cliente;
              
         
          if($change->banco_domiciliado !== 4 && $change->estatus_id != 5){
            $change->cuenta                 = "'".$change->RelationCliente->num_cuenta_asociar_inst_bancario_sinencriptar;
            
            $cod = substr($change->RelationCliente->num_cuenta_asociar_inst_bancario_sinencriptar, 0,4);
            $change->banco                  = BancosModel::where('codigo',$cod)->first()->id;
            
            $change->tipo_cuenta_domiciliar = $change->RelationCliente->tipo_cuenta_domiciliar;
          } else {
            $change->cuenta   = $change->num_cuenta_asociar_inst_bancario_sinencriptar != null ? "'".$change->num_cuenta_asociar_inst_bancario_sinencriptar : null;
            $change->banco    = $change->banco_domiciliado != null ? BancosModel::find($change->banco_domiciliado)->id : null;
            
          }
          
          $change->plan         = $change->plan_id != null ? PlanesModel::find($change->plan_id)->codigo : null;
          $change->estatus_id   == 5 ? $change->fecha_solicitud = date('d/m/Y', strtotime($change->created_at)) :  $change->fecha_solicitud = null;
          $change->suma_asegurada_id != null ?  SumaAseguradaModel::find($change->suma_asegurada_id)->nombre : null;
          
          $change->monto    = $change->monto_a_pagar != null ? $change->monto_a_pagar : null;
          $change->tipif1   = $change->RelationTipiifcacion1->descripcion;
          $change->tipif2   = $change->RelationTipiifcacion2->descripcion;
          if($change->RelationTipificacion3 == null){
          $change->tipif3    = null;  
          }else{
          $change->tipif3    = $change->RelationTipificacion3->descripcion;
          }
          $change->estatus  = $change->RelationEstatus->descripcion;
          return $change;
        }, $data);
    }
    
    
    public function map($data): array{               
        $columns = [
            'FECHA'                 =>$data->fecha,
            'HORA'                  =>$data->hora,
            'LLAMADA'               =>$data->llamada,
            'FECHA_AGENDADO'        =>$data->fechaAgendado,           
            'NACIONALIDAD_TOMADOR'  =>$data->nacionalidad,
            'CEDULA_DEL_TOMADOR'    =>$data->n_cedula,
            'APELLIDO_1_TOMADOR'    =>$data->apelld1,
            'APELLIDO_2_TOMADOR'    =>$data->apelld2,
            'APELL CASADA TOMADOR'  =>$data->apellcasada,
            'NOMBRE_1_TOMADOR'      =>$data->nomb1,
            'NOMBRE_2_TOMADOR'      =>$data->nomb2,
            'SEXO_TOMADOR'          =>$data->cd_sexo,
            'EDO_CIVIL_TOMADOR'     =>$data->cd_edo_civil,
            'FECHA_NAC_TOMADOR'     =>$data->fecha_de_nacimiento,
            'ESTADO_HAB_TOMADOR'    =>$data->cd_estado_hab,
            'CIUDAD_HAB_TOMADOR'    =>$data->cd_ciudad_hab,
            'MUNICIPIO_HAB_TOMADO'  =>$data->municipio_hab,
            'PARROQUIA_HAB_TOMADO'  =>$data->parroquia_hab,
            'URB_HAB_TOMADOR'       =>$data->cd_urbanizsector_hab,
            'ZN_POSTAL_HAB_TOMADO'  =>$data->codigo_postal_hab,
            'AVENIDA_HAB_TOMADOR'   =>$data->di_av_calle_hab,
            'CASA_HAB_TOMADOR'      =>$data->di_casa_hab,
            'EMAIL_OFIC_TOMADOR'    =>$data->email_persol_tomador,
            'EMAIL_HAB_TOMADOR'     =>$data->email_trabajo_u_ofici_tomador,
            'AREA_TLF_HAB_TOMADOR'  =>$data->cd_area_num_telefono_habitacion_tomador,
            'TELEFONO_HAB_TOMADOR'  =>$data->num_telefono_hab_tomador,
            'AREA_TLF_OFI_TOMADOR'  =>$data->cd_area_num_telefono_trab_ofic_tomador,
            'TELEFONO_OFI_TOMADOR'  =>$data->num_telefono_trab_ofic_tomador,
            'CELULAR_HAB_TOMADOR'   =>$data->num_celular_pers_tomador,
            'CELULAR_OFI_TOMADOR'   =>$data->num_celular_trab_tomador,
            'NACIONALIDAD_CLIENTE'  =>$data->nacionalidad,
            'CEDULA_DEL_CLIENTE'    =>$data->n_cedula,
            'APELLIDO_1_CLIENTE'    =>$data->apelld1,
            'APELLIDO_2_CLIENTE'    =>$data->apelld2,
            'APELL_CASADA_CLIENTE'  =>$data->apellcasada,
            'NOMBRE_1_CLIENTE'      =>$data->nomb1,
            'NOMBRE_2_CLIENTE'      =>$data->nomb2,
            'SEXO_CLIENTE'          =>$data->cd_sexo,
            'EDO_CIVIL_CLIENTE'     =>$data->cd_edo_civil,
            'FECHA_NAC_CLIENTE'     =>$data->fecha_de_nacimiento,
            'ESTADO_HAB_CLIENTE'    =>$data->cd_estado_hab,
            'CIUDAD_HAB_CLIENTE'    =>$data->cd_ciudad_hab,
            'MUNICIPIO_HAB_CLIENT'  =>$data->municipio_hab,
            'PARROQUIA_HAB_CLIENT'  =>$data->parroquia_hab,
            'URB_HAB_CLIENTE'       =>$data->cd_urbanizsector_hab,
            'ZN_POSTAL_HAB_CLIENT'  =>$data->codigo_postal_hab,
            'AVENIDA_HAB_CLIENTE'   =>$data->di_av_calle_hab,
            'CASA_HAB_CLIENTE'      =>$data->di_casa_hab,
            'AREA_TLF_HAB_CLIENTE'  =>$data->cd_area_num_telefono_habitacion_tomador,
            'TELEFONO_HAB_CLIENTE'  =>$data->num_telefono_hab_tomador,
            'CELULAR_HAB_CLIENTE'   =>$data->num_celular_pers_tomador,
            'EMAIL_HAB_CLIENTE'     =>$data->email_persol_tomador,
            'EMAIL_OFIC_CLIENTE'    =>$data->email_trabajo_u_ofici_tomador,
            'AREA_TLF_OFI_CLIENTE'  =>$data->cd_area_num_telefono_trab_ofic_tomador,
            'TELEFONO_OFI_CLIENTE'  =>$data->num_telefono_trab_ofic_tomador,
            'CELULAR_OFI_CLIENTE'   =>$data->num_celular_trab_tomador,
            'SUCURSAL'              =>1,
            'PRODUCTO'              =>$data->plan,
            'FECHA_SOLICITUD'       =>$data->fecha_solicitud,
            'FR_PAGO'               =>$data->tipo_pago,
            'CANAL_VENTA'           =>"12",
            'PRODUCTOR'             =>"35000",
            'PROFESION'             =>$data->cd_profesion_ocupacion_cliente,
            'SUMA_ASEGURADA'        =>$data->suma_asegurada_id,
            'DOMICILIADO'           =>$data->tipo_pago,
            'BANCO'                 =>$data->banco,
            'NRO_CUENTA'            =>$data->cuenta,
            'TIPO_CUENTA'           =>$data->tipo_cuenta_domiciliar,
            'TIPO_TARJETA'          =>$data->tipo_tdc_domiciliar,
            'FE_VCMTO_TARJETA'      =>$data->fecha_vencimiento_tdc_domiciliar,  
            'MONTO_PLAN'            =>$data->monto,
            'TIPIFICACION 1'        =>$data->tipif1,
            'TIPIFICACION 2'        =>$data->tipif2,
            'TIPIFICACION 3'       => strtoupper($data->tipif3),
            'USUARIO'               =>$data->user_id,       
            'ESTATUS'               =>$data->estatus,
            'COMENTARIOS'           =>$data->comentario            
            ];
        return $columns;
    }
}