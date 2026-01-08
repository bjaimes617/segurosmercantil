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

class ExportCSVTranquilidad implements  FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithChunkReading, WithCustomCsvSettings {
     /**
    * @return \Illuminate\Support\Collection
     * 
     * TRANQUILIDAD FUNENARIO
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
         "1-TIPO_ACCION",
         "2-TP_REGISTRO",
         "3-TP_DOC_CONTRATANTE-1--",
         "4-NU_DOC_CONTRATANTE-1--",
         "5-TP_DOC_ASEGURADO-1--",
         "6-NU_DOC_ASEGURADO-1--",
         "7-TP_DOCUMENTO-1--",
         "8-NU_DOCUMENTO-1--",
         "9-FE_NACIMIENTO-1--",
         "10-CD_SEXO-1--",
         "11-CD_ESTADO_CIVIL-1--",
         "12-NM_PRIMER_NOMBRE-1--",
         "13-NM_PRIMER_APELLIDO-1--",
         "14-FE_SOLICITUD",
         "15-CD_POLIZA_ANTERIOR",
         "16-FE_INCLUSION",
         "17-FE_HASTA",
         "18-CD_SUCURSAL",
         "19-CD_CANAL_VENTA",
         "20-CD_PERSONA_MEDIADOR_ESPECIAL",
         "21-CD_PERSONA_MEDIADOR",
         "22-PO_PARTICIPACION",
         "23-CD_REGION",
         "24-IN_MEDIADOR_PRINCIPAL",
         "25-CD_PERSONA_MEDIADOR_ESPECIAL1",
         "26-CD_PERSONA_MEDIADOR_1",
         "27-PO_PARTICIPACION_1",
         "28-CD_REGION_1",
         "29-IN_MEDIADOR_PRINCIPAL_1",
         "30-NU_SECUENCIA_ESTRUCTURA",
         "31-CD_MONEDA",
         "32-CD_PLAN_PAGO",
         "33-CD_FORMA_PAGO",
         "34-TP_NEGOCIO",
         "35-CD_CLASE_RIESGO",
         "36-NU_DOMICILIO_BANCARIO",
         "37-PAIS_RESIDENCIA",
         "38-TARIFA_POR_PAIS",
         "39-TIPO_TARIFA",
         "40-SUMA_ASEGURADA",
         "41-PARENTESCO",
         "42-TIENE_CONTINUIDAD",
         "43-COMPANIA_ANTERIOR",
         "44-PAISORIGEN_ANTERIOR",
         "45-POLIZAANTERIOR",
         "46-SUMA_ASEG_ANTERIOR",
         "47-DEDUCIBLE_ANTERIOR",
         "48-FE_INICIO_POL_ANTERIOR",
         "49-PORC_DESCUENTO",
         "50-BUENA_SALUD",
         "51-NU_POLIZA_1",
         "52-FE_EXCLUSION",
         "53-TP_MEDIADOR_ESPECIAL",
         "54-42170_Servicio Oftamologico"
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
          "1-TIPO_ACCION"=> $data->tipo_accion,
         "2-TP_REGISTRO" => $data->tipo_registro,
         "3-TP_DOC_CONTRATANTE-1--" => $data->doc_contratante ,
         "4-NU_DOC_CONTRATANTE-1--" => $data->cedula,
         "5-TP_DOC_ASEGURADO-1--"   => $data->doc_contratante ,
         "6-NU_DOC_ASEGURADO-1--"   => $data->cedula,
         "7-TP_DOCUMENTO-1--"       => $data->doc_contratante ,
         "8-NU_DOCUMENTO-1--"       => $data->cedula,
         "9-FE_NACIMIENTO-1--"      => $data->fecha_de_nacimiento,
         "10-CD_SEXO-1--"           =>$data->sexo,
         "11-CD_ESTADO_CIVIL-1--"   =>$data->cd_edo_civil,
         "12-NM_PRIMER_NOMBRE-1--"  =>$data->RelationCliente->nomb1,
         "13-NM_PRIMER_APELLIDO-1--"=>$data->RelationCliente->apelld1,
         "14-FE_SOLICITUD"          => $data->solicitud,
         "15-CD_POLIZA_ANTERIOR"    => "",
         "16-FE_INCLUSION"          => $data->solicitud,
         "17-FE_HASTA"              => $data->hasta,
         "18-CD_SUCURSAL"           => $data->sucursal,
         "19-CD_CANAL_VENTA"        => 59,
         "20-CD_PERSONA_MEDIADOR_ESPECIAL"=>$data->mediador_especial,            
         "21-CD_PERSONA_MEDIADOR_"   =>$data->estado,           
         "22-PO_PARTICIPACION"      => 100,
         "23-CD_REGION"             => 1,
         "24-IN_MEDIADOR_PRINCIPAL" => 1,
         "25-CD_PERSONA_MEDIADOR_ESPECIAL1" =>"",
         "26-CD_PERSONA_MEDIADOR_1_" =>$data->estado,
         "27-PO_PARTICIPACION_1" =>"",
         "28-CD_REGION_1" =>"",
         "29-IN_MEDIADOR_PRINCIPAL_1" =>"",
         "30-NU_SECUENCIA_ESTRUCTURA" =>"",
         "31-CD_MONEDA" =>"2",
         "32-CD_PLAN_PAGO"   => $data->plan_pago,
         "33-CD_FORMA_PAGO" =>1,
         "34-TP_NEGOCIO"=>1,
         "35-CD_CLASE_RIESGO"    =>"N",
         "36-NU_DOMICILIO_BANCARIO"=> "",
         "37-PAIS_RESIDENCIA"=> 29,
         "38-TARIFA_POR_PAIS"=> 29,
         "39-TIPO_TARIFA"=> 2,
         "40-SUMA_ASEGURADA"=> $data->suma_asegurada,
         "41-PARENTESCO"=>1,
         "42-TIENE_CONTINUIDAD" => 0,
         "43-COMPANIA_ANTERIOR" => 0,
         "44-PAISORIGEN_ANTERIOR" => 0,
         "45-POLIZAANTERIOR"=> "",
         "46-SUMA_ASEG_ANTERIOR"=> "",
         "47-DEDUCIBLE_ANTERIOR"=> "",
         "48-FE_INICIO_POL_ANTERIOR"=> "",
         "49-PORC_DESCUENTO"=> 0,
         "50-BUENA_SALUD"=> "S",
         "51-NU_POLIZA_1"=> "",
         "52-FE_EXCLUSION"=> "",
         "53-TP_MEDIADOR_ESPECIAL"=> $data->tp_mediador_especial,
          "54-42170_Servicio Oftamologico" => "1"
        ];
        return $columns;
    }
}