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

class ExportCSVRenta  implements  FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithChunkReading, WithCustomCsvSettings 
{
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
         "CD_PERSONA_MEDIADOR_1",
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
         "SUMA_ASEGURADA_INT",
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
         "TP_MEDIADOR_ESPECIAL",
         
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
            
            $change->estado = $change->RelationCliente->RelationEstado !== null ? $change->RelationCliente->RelationEstado->cod_estado : 3500;
            $change->mediador_especial      = $change->estado !== "35000" ?  null : "70004";
            $change->tp_mediador_especial   = $change->estado !== "35000" ?  null : "C";
            
            switch ($change->estado) {
                case "35000":
                    $change->sucursal = 1;
                    break;
                case "121":
                    $change->sucursal = 8;
                    break;
                case "521":
                    $change->sucursal = 14;
                    break;
                case "221":
                    $change->sucursal = 17;
                    break;
                case "321":
                    $change->sucursal = 5;
                    break;
                case "421":
                    $change->sucursal = 12;
                    break;
                case "2209":
                    $change->sucursal = 13;
                    break;
                case "21":
                    $change->sucursal = 9;
                    break;
                default:
                     $change->sucursal = 1;
                    break;
            }

            $change->suma_asegurada = $change->suma_asegurada_id != null ? SumaAseguradaModel::find($change->suma_asegurada_id)->nombre : null;
            
            $change->fecha_de_nacimiento = carbon::create($change->RelationCliente->fecha_de_nacimiento)->format('d-m-Y');
            
            $change->cheque                 = $change->RelationCliente->nomb1." ".$change->RelationCliente->nomb2;
            $change->apellidos              = $change->RelationCliente->apelld1." ".$change->RelationCliente->apelld2;
            
            $change->sexo = $change->RelationCliente->cd_sexo;
            $change->cd_edo_civil = $change->RelationCliente->cd_edo_civil;
            
            return $change;
        }, $data);              
    }
    
    public function map($data): array{               
        $columns = [
         "TIPO_ACCION"=> $data->tipo_accion,
         "TP_REGISTRO" => $data->tipo_registro,
         "TP_DOC_CONTRATANTE" => $data->doc_contratante ,
         "NU_DOC_CONTRATANTE" => $data->cedula,
         "TP_DOC_ASEGURADO"   => $data->doc_contratante ,
         "NU_DOC_ASEGURADO"   => $data->cedula,                     
         "FE_SOLICITUD"          => $data->solicitud,
         "CD_POLIZA_ANTERIOR"    => "",
         "FE_INCLUSION"          => $data->solicitud,                        
         "FE_HASTA"              => $data->hasta,
         "CD_SUCURSAL"           => $data->sucursal,
         "CD_CANAL_VENTA"        => 59,
         "CD_PERSONA_MEDIADOR_ESPECIAL"=>$data->mediador_especial,            
         "CD_PERSONA_MEDIADOR"   =>$data->estado,          
         "PO_PARTICIPACION"      => 100,
         "CD_REGION"             => 1,            
         "IN_MEDIADOR_PRINCIPAL" => 1,
         "CD_PERSONA_MEDIADOR_ESPECIAL1" =>"",
         "CD_PERSONA_MEDIADOR_1" =>$data->estado,
         "PO_PARTICIPACION_1" =>"",
         "CD_REGION_1" =>"",            
         "IN_MEDIADOR_PRINCIPAL_1" =>"",
         "NU_SECUENCIA_ESTRUCTURA" =>"",
         "CD_MONEDA" =>"2",            
         "CD_PLAN_PAGO"   => $data->plan_pago,
         "CD_FORMA_PAGO" =>1,
         "TP_NEGOCIO"=>1,
         "CD_CLASE_RIESGO"    =>"N",            
         "NU_DOMICILIO_BANCARIO"=> "",
         "PAIS_RESIDENCIA"=> 29,
         "TARIFA_POR_PAIS"=> 29,       
         "SUMA_ASEGURADA"=> $data->suma_asegurada,
         "SUMA_ASEGURADA_INT" => 100,
         "FE_NAC_TITULAR"      => $data->fecha_de_nacimiento,      
         "TIENE_CONTINUIDAD" => 0,
         "COMPANIA_ANTERIOR" => 0,
         "PAIS_ORIGEN_CO_ANTERIOR" => 0,
         "POLIZA_ANTERIOR"=> "",            
         "SUMA_ASEG_ANTERIOR"=> "",
         "DEDUCIBLE_ANTERIOR"=> "",
         "FE_INICIO_POL_ANTERIOR"=> "",            
         "PORC_DESCUENTO"=> '-50',
         "BUENA_SALUD"=> "S",         
         "TP_DOC_1"=> "",
         "TP_MEDIADOR_ESPECIAL" => $data->tp_mediador_especial,
       
        ];
        return $columns;
    }

}
