<?php

namespace App\Exports\SegurosMercantil\clientes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Carbon\Carbon;
use App\Models\SegurosMercantil\BancosModel;
class ExportCLienteCARGAPN2 implements  FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithChunkReading, WithCustomCsvSettings {

    /**
    * @return \Illuminate\Support\Collection
    */
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
    $columns = ['TIPO_PERSONA',
        'TP_DOCUMENTO',
        'NU_DOCUMENTO_SECCION1',
        'NU_DOCUMENTO_SECCION2',
        'NU_DOCUMENTO_SECCION3',
        'NU_DOCUMENTO_SECCION4',
        'DI_VERIFICADOR',
        'FE_VENCIMIENTO_DOCUMENTO',
        'FE_NACIMIENTO',	
        'NM_PRIMER_NOMBRE',	
        'NM_SEGUNDO_NOMBRE',
        'NM_PRIMER_APELLIDO',
        'NM_SEGUNDO_APELLIDO',
        'CD_SEXO',	
        'CD_ESTADO_CIVIL',
        'CD_PAIS_NAC',
        'CD_PROVINCIA_NAC',
        'CD_CIUDAD_NAC',	
        'CD_NACIONALIDAD',
        'CD_PAIS_RESIDENCIA',
        'FR_INGRESO',	
        'TP_DIRECCION',	
        'NM_CHEQUE',
        'CD_PAIS',
        'CD_PROVINCIA',
        'CD_CIUDAD',
        'CD_ZONA',
        'TP_VIA',
        'CD_MUNICIPIO',
        'NM_CALLE',
        'TP_VIVIENDA',
        'NU_CASA',
        'NU_PISO',
        'NU_PUERTA',
        'TP_TELEFONO',
        'CD_PAIS_TELEFONO',
        'NU_AREA',
        'NU_TELEFONO',
        'DE_EMAIL'
    ];
    return $columns;
    }
    
   public function prepareRows($data): array {
        return array_map(function ($change) {     
          //  dd($change);
           // $change->fe_vencimiento_documento = Carbon::createFromFormat('Y-m-d',$change->RelationCliente->fe_vencimiento_documento)->format('d-m-Y');
            $change->fecha_de_nacimiento    = Carbon::createFromFormat('Y-m-d',$change->RelationCliente->fecha_de_nacimiento)->format('d-m-Y');
            $change->ingreso                = Carbon::createFromFormat('Y-m-d H:i:s',$change->RelationCliente->created_at)->format('d-m-Y');         
            $change->cheque                 = $change->RelationCliente->nomb1." ".$change->RelationCliente->nomb2." ".$change->RelationCliente->apelld1." ".$change->RelationCliente->apelld2;
            
            $change->concat_cedula = $change->RelationCliente->nacionalidad_cliente."-".$change->RelationCliente->n_cedula;
            
            if ($change->RelationCliente->num_telefono_trab_ofic_tomador == 0000000) {
                $change->cd_area_num_telefono_trab_ofic_tomador = "";
                $change->num_telefono_trab_ofic_tomador = "";
            }
            else {
                $change->cd_area_num_telefono_trab_ofic_tomador = $change->RelationCliente->cd_area_num_telefono_trab_ofic_tomador;
                $change->num_telefono_trab_ofic_tomador         = $change->RelationCliente->num_telefono_trab_ofic_tomador;
            }
            
            $change->cod_celular    = substr($change->RelationCliente->num_celular_pers_tomador, 0,3);
            $change->celular        = substr($change->RelationCliente->num_celular_pers_tomador, 3);
            $change->nacionalidad   = $change->RelationCliente->nacionalidad_cliente;
            $change->n_cedula       = $change->RelationCliente->n_cedula;
            $change->apelld1        = $change->RelationCliente->apelld1;
            $change->apelld2        = $change->RelationCliente->apelld2;
            $change->apellcasada    = $change->RelationCliente->apellcasada;
            $change->nomb1          = $change->RelationCliente->nomb1;
            $change->nomb2          = $change->RelationCliente->nomb2;
            $change->cd_sexo        = $change->RelationCliente->cd_sexo;
            $change->cd_edo_civil   = $change->RelationCliente->cd_edo_civil;
            
            $change->email_persol_tomador           = $change->RelationCliente->email_persol_tomador;
            $change->email_trabajo_u_ofici_tomador  = $change->RelationCliente->email_trabajo_u_ofici_tomador;
            $change->di_av_calle_hab                = $change->RelationCliente->di_av_calle_hab;
            $change->tp_vivienda= 1;
            $change->banco      = $change->banco_domiciliado != null ? BancosModel::find($change->banco_domiciliado)->id : null;
            $change->cuenta     = $change->num_cuenta_asociar_inst_bancario_sinencriptar != null ? $change->num_cuenta_asociar_inst_bancario_sinencriptar : null;
            $change->tipo_tdc_domiciliar = $change->tipo_tdc_domiciliar != null ? $change->tipo_tdc_domiciliar : null;
            $change->fecha_vencimiento_tdc_domiciliar = $change->fecha_vencimiento_tdc_domiciliar != null ? $change->fecha_vencimiento_tdc_domiciliar : null;
            
            
           // dd($change);
            return $change;
        }, $data);              
    }
    
    public function map($data): array{               
        $columns = [
             'TIPO_PERSONA'              => 1,
            'TP_DOCUMENTO'              =>"VEN",
            'NU_DOCUMENTO_SECCION1'     => $data->nacionalidad,
            'NU_DOCUMENTO_SECCION2'     => $data->n_cedula,
            'NU_DOCUMENTO_SECCION3'     => null,
            'NU_DOCUMENTO_SECCION4'     => null,
            'DI_VERIFICADOR'            => null,
            'FE_VENCIMIENTO_DOCUMENTO'  => '31-12-9999',
            'FE_NACIMIENTO'             => $data->fecha_de_nacimiento,
            'NM_PRIMER_NOMBRE'          => $data->nomb1,
            'NM_SEGUNDO_NOMBRE'         => $data->nomb2,
            'NM_PRIMER_APELLIDO'        => $data->apelld1,
            'NM_SEGUNDO_APELLIDO'       => $data->apelld2,
            'CD_SEXO'                   => $data->cd_sexo,
            'CD_ESTADO_CIVIL'           => $data->cd_edo_civil,
            'CD_PAIS_NAC'               => "VEN",
            'CD_PROVINCIA_NAC'          => 10,
            'CD_CIUDAD_NAC'             => 1,
            'CD_NACIONALIDAD'       => "VEN",
            'CD_PAIS_RESIDENCIA'    =>29,
            'FR_INGRESO'            =>$data->ingreso,
            'TP_DIRECCION'          =>1,
            'NM_CHEQUE'             =>$data->cheque,
            'CD_PAIS'           =>29,
            'CD_PROVINCIA'      =>10,
            'CD_CIUDAD'         =>10,
            'CD_ZONA'           =>129,
            'TP_VIA'            =>1,
            'CD_MUNICIPIO'      =>1,
            'NM_CALLE'          =>$data->di_av_calle_hab,
            'TP_VIVIENDA'       =>$data->tp_vivienda,
            'NU_CASA'           =>$data->nu_casa,
            'NU_PISO'           =>$data->nu_piso,
            'NU_PUERTA'         =>$data->nu_puerta,
            'TP_TELEFONO'           =>3,
            'CD_PAIS_TELEFONO'      => 29,
            'NU_AREA'               => $data->cod_celular,
            'NU_TELEFONO'           => $data->celular,
            'DE_EMAIL'              => $data->email_persol_tomador,          
        ];
        return $columns;
    }
}
