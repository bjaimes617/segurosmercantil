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

class EstatusClientesExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithChunkReading, WithCustomCsvSettings {

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
            'CARGADO_EL',            
            'NACIONALIDAD_TOMADOR',
            'CEDULA_DEL_TOMADOR',
            'APELLIDO_1_TOMADOR',
            'APELLIDO_2_TOMADOR',
            'FECHA_NAC_TOMADOR',
            'APELL CASADA TOMADOR',
            'NOMBRE_1_TOMADOR',
            'NOMBRE_2_TOMADOR',
            'FECHA_AGENDADO',          
            'ESTATUS',
            'ASIGNADO A',
            'NRO_CUENTA',  
            'AREA_TLF_HAB_TOMADOR',
            'TELEFONO_HAB_TOMADOR',
            'AREA_TLF_OFI_TOMADOR',
            'TELEFONO_OFI_TOMADOR',
            'CELULAR_HAB_TOMADOR',
            'CELULAR_OFI_TOMADOR',
                     
            ];
        return $columns;
    }

    public function prepareRows($data): array {
         return array_map(function ($change) {            
          $change->fecha        = date('d/m/Y', strtotime($change->created_at));  
          
          if( $change->estatus == 6){
            $change->fechaAgendado    = $change->fecha_agendado != null ? date('d/m/Y', strtotime($change->fecha_agendado)) : null;
          } else {
              $change->fechaAgendado = null;
          }
          $change->nacionalidad     = $change->nacionalidad_cliente;
          $change->n_cedula         = $change->n_cedula;
          $change->apelld1          = $change->apelld1;
          $change->apelld2          = $change->apelld2;
          $change->apellcasada      = $change->apellcasada;
          $change->nomb1            = $change->nomb1;
          $change->nomb2            = $change->nomb2;
          $change->estatus          = $change->RelationEstatus->descripcion;          
          $change->usuario          = $change->RelationUsuario != null ? $change->RelationUsuario->username : null;
          $change->cd_area_num_telefono_habitacion_tomador      = $change->cd_area_num_telefono_habitacion_tomador;
          $change->num_telefono_hab_tomador                     = $change->num_telefono_hab_tomador;
          $change->cd_area_num_telefono_trab_ofic_tomador       = $change->cd_area_num_telefono_trab_ofic_tomador;
          $change->num_telefono_trab_ofic_tomador               = $change->num_telefono_trab_ofic_tomador;
          $change->num_celular_pers_tomador                     = $change->num_celular_pers_tomador;
          $change->num_celular_trab_tomador                     = $change->num_celular_trab_tomador;
          $change->num_cuenta_asociar_inst_bancario_sinencriptar                     = "'".$change->num_cuenta_asociar_inst_bancario_sinencriptar;
          $change->fecha_de_nacimiento                    = $change->fecha_de_nacimiento;
          return $change;
        }, $data);
    }
    
    
    public function map($data): array{               
        $columns = [
            'CARGADO_EL'            =>$data->fecha,     
            'NACIONALIDAD_TOMADOR'  =>$data->nacionalidad,
            'CEDULA_DEL_TOMADOR'    =>$data->n_cedula,
            'APELLIDO_1_TOMADOR'    =>$data->apelld1,
            'APELLIDO_2_TOMADOR'    =>$data->apelld2,
            'FECHA_NAC_TOMADOR' => date("d-m-Y", strtotime($data->fecha_de_nacimiento)),
            'APELL CASADA TOMADOR'  =>$data->apellcasada,
            'NOMBRE_1_TOMADOR'      =>$data->nomb1,
            'NOMBRE_2_TOMADOR'      =>$data->nomb2,    
            'FECHA_AGENDADO'        =>$data->fechaAgendado, 
            'ESTATUS'               =>$data->estatus,  
            'ASIGNADO A'            =>$data->usuario,
            'NRO_CUENTA' => $data->num_cuenta_asociar_inst_bancario_sinencriptar,   
            'AREA_TLF_HAB_TOMADOR'  =>$data->cd_area_num_telefono_habitacion_tomador,
            'TELEFONO_HAB_TOMADOR'  =>$data->num_telefono_hab_tomador,
            'AREA_TLF_OFI_TOMADOR'  =>$data->cd_area_num_telefono_trab_ofic_tomador,
            'TELEFONO_OFI_TOMADOR'  =>$data->num_telefono_trab_ofic_tomador,
            'CELULAR_HAB_TOMADOR'   =>$data->num_celular_pers_tomador,
            'CELULAR_OFI_TOMADOR'   =>$data->num_celular_trab_tomador,

            ];
        return $columns;
    }
}