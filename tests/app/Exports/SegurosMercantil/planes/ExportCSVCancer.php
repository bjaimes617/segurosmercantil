<?php

namespace App\Exports\SegurosMercantil\planes;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Models\SegurosMercantil\BancosModel;
use App\Models\SegurosMercantil\SumaAseguradaModel;
use Carbon\Carbon;

class ExportCSVCancer implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithChunkReading, WithCustomCsvSettings {

    /**
    * @return \Illuminate\Support\Collection
     * 
     * PUC CANCER CMCANCER
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
            'delimiter' => ';',
            "Content-type" => "text/csv;",
            'use_bom' => true,
            'line_ending' => "\r\n", // Asegúrate de usar el terminador de línea correcto
            'encoding' => 'UTF-8', // Asegúrate de usar UTF-8      
                   
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
         "TIPO_ACCION",
         "TP_REGISTRO",
         "TP_DOC_CONTRATANTE",
         "NU_DOC_CONTRATANTE",
         "TP_DOC_ASEGURADO",
         "NU_DOC_ASEGURADO",
         "FE_SOLICITUD",
         "CD_POLIZA_ANTERIOR",
         "FE_INCLUSION",
         "FE_HASTA",
         "CD_SUCURSAL",
         "CD_CANAL_VENTA",
         "CD_PERSONA_MEDIADOR_ESPECIAL",
         "CD_PERSONA_MEDIADOR",
         "PO_PARTICIPACION",
         "CD_REGION",
         "IN_MEDIADOR_PRINCIPAL",
         "CD_PERSONA_MEDIADOR_ESPECIAL",
         "CD_PERSONA_MEDIADOR",
         "PO_PARTICIPACION_1",
         "CD_REGION_1",
         "IN_MEDIADOR_PRINCIPAL_1",
         "NU_SECUENCIA_ESTRUCTURA",
         "CD_MONEDA",
         "CD_PLAN_PAGO",
         "CD_FORMA_PAGO",
         "TP_NEGOCIO",
         "CD_CLASE_RIESGO",
         "NU_DOMICILIO_BANCARIO",
         "PAIS_RESIDENCIA",
         "TARIFA_POR_PAIS",
         "SUMA_ASEGURADA",
         "FE_NAC_TITULAR",
         "TIENE_CONTINUIDAD",
         "COMPANIA_ANTERIOR",
         "PAIS_ORIGEN_CO_ANTERIOR",
         "POLIZA_ANTERIOR",
         "SUMA_ASEG_ANTERIOR",
         "DEDUCIBLE_ANTERIOR",
         "FE_INICIO_POL_ANTERIOR",
         "PORC_DESCUENTO",
         "BUENA_SALUD",
         "TP_DOC_1",
         "NU_DOC_1",
         "PO_PARTICI_1",
         "MT_CEDIDO",
         "NU_CONSEC_TP_DOC_PREFE",
         "NU_CONSEC_ANEXO",
         "NU_POLIZA_1",
         "TP_MEDIADOR_ESPECIAL"
        ];
         return $columns;
    }
         
    public function prepareRows($data): array {
        return array_map(function ($change) {     
            $change->tipo_accion        = 1;
            $change->tipo_registro      = 1;
            $change->doc_contratante    = "VEN";
            $change->cedula             = $change->RelationCliente->nacionalidad_cliente."-".$change->RelationCliente->n_cedula;
            
            $creadoel                   = carbon::create($change->created_at);    
            $change->solicitud          = $creadoel->copy()->format('d-m-Y')     ;       
            $change->hasta              = $creadoel->copy()->addYear(1)->format('d-m-Y');                  
            
            switch ($change->tipo_pago){
                case"M":
                    $change->plan_pago = 201;
                    break;
                case"T":
                    $change->plan_pago = 202;
                    break;
                case"S":
                    $change->plan_pago = 203;
                    break;
                case"A":
                    $change->plan_pago = 204;
                    break;
            }
            
            $change->suma_asegurada = $change->suma_asegurada_id != null ? SumaAseguradaModel::find($change->suma_asegurada_id)->nombre : null;
            
            $change->fecha_de_nacimiento = carbon::create($change->RelationCliente->fecha_de_nacimiento)->format('d-m-Y');
            
            $change->cheque                 = $change->RelationCliente->nomb1." ".$change->RelationCliente->nomb2;
            $change->apellidos              = $change->RelationCliente->apelld1." ".$change->RelationCliente->apelld2;
            return $change;
        }, $data);              
    }
    
    public function map($data): array{               
        $columns = [
         "TIPO_ACCION"          => $data->tipo_accion,
         "TP_REGISTRO"          => $data->tipo_registro,
         "TP_DOC_CONTRATANTE"   => $data->doc_contratante,
         "NU_DOC_CONTRATANTE"   => $data->cedula ,
         "TP_DOC_ASEGURADO"     => $data->doc_contratante,
         "NU_DOC_ASEGURADO"     => $data->cedula ,
         "FE_SOLICITUD"         => $data->solicitud,
         "CD_POLIZA_ANTERIOR"   => null,
         "FE_INCLUSION"         => $data->solicitud,
         "FE_HASTA"             => $data->hasta,
         "CD_SUCURSAL"          => 1,
         "CD_CANAL_VENTA"       => 59,
         "CD_PERSONA_MEDIADOR_ESPECIAL_" => 70004,
         "CD_PERSONA_MEDIADOR_"          => 35000,
         "PO_PARTICIPACION_"             => 100,
         "CD_REGION_"                    => 1,
         "IN_MEDIADOR_PRINCIPAL"        => 1,
         "CD_PERSONA_MEDIADOR_ESPECIAL" => 70004, 
         "CD_PERSONA_MEDIADOR"          => 35000,
         "PO_PARTICIPACION_1"           => "",
         "CD_REGION_1_"                  => "",
         "IN_MEDIADOR_PRINCIPAL_1_"      => "",
         "NU_SECUENCIA_ESTRUCTURA_"      => "",
         "CD_MONEDA"                    => 2,
         "CD_PLAN_PAGO"                 => $data->plan_pago,
         "CD_FORMA_PAGO"                => 1,
         "TP_NEGOCIO"                   => 1,
         "CD_CLASE_RIESGO"              => "N",
         "NU_DOMICILIO_BANCARIO"        => null,
         "PAIS_RESIDENCIA"              => 29,
         "TARIFA_POR_PAIS"              => 29,
         "SUMA_ASEGURADA"               => $data->suma_asegurada,
         "FE_NAC_TITULAR"               => $data->fecha_de_nacimiento,
         "TIENE_CONTINUIDAD"            => 0,
         "COMPANIA_ANTERIOR"            => 0,
         "PAIS_ORIGEN_CO_ANTERIOR"      => null,
         "POLIZA_ANTERIOR"              => null,
         "SUMA_ASEG_ANTERIOR"           => null,
         "DEDUCIBLE_ANTERIOR"           => null,
         "FE_INICIO_POL_ANTERIOR"       => null,
         "PORC_DESCUENTO"               => 0,
         "BUENA_SALUD"                  => "S",
         "TP_DOC_1"                     => null,
         "NU_DOC_1"                     => null,
         "PO_PARTICI_1"                 => null,
         "MT_CEDIDO"                    => null,
         "NU_CONSEC_TP_DOC_PREFE"       => null,
         "NU_CONSEC_ANEXO"              => null,
         "NU_POLIZA_1"                  => null,
         "TP_MEDIADOR_ESPECIAL"         => "C",
        ];
       // dd($columns);
        return $columns;
    }
}
