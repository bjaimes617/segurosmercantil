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

class ClientesEliminadosExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithChunkReading, WithCustomCsvSettings {

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
            'APELL CASADA TOMADOR',
            'NOMBRE_1_TOMADOR',
            'NOMBRE_2_TOMADOR',     
            'MOTIVO DE LA ELIMINACION',
            'ELIMINADO POR',
            'ESTATUS',
            ];
        return $columns;
    }

    public function prepareRows($data): array {
         return array_map(function ($change) {            
         
          $change->nacionalidad     = $change->RelationCliente->nacionalidad_cliente;
          $change->n_cedula         = $change->RelationCliente->n_cedula;
          $change->apelld1          = $change->RelationCliente->apelld1;
          $change->apelld2          = $change->RelationCliente->apelld2;
          $change->apellcasada      = $change->RelationCliente->apellcasada;
          $change->nomb1            = $change->RelationCliente->nomb1;
          $change->nomb2            = $change->RelationCliente->nomb2;
          $change->estatus          = $change->RelationEstatus->descripcion;                    
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
            'APELL CASADA TOMADOR'  =>$data->apellcasada,
            'NOMBRE_1_TOMADOR'      =>$data->nomb1,
            'NOMBRE_2_TOMADOR'      =>$data->nomb2,    
            'MOTIVO DE LA ELIMINACION'=>$data->cometario_sup,
            'ELIMINADO POR'     =>$data->eliminado_por,
            'ESTATUS'           =>$data->estatus,
            ];
        return $columns;
    }
}