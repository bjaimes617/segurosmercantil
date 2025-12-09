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

class ExportCSVida implements  FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithChunkReading, WithCustomCsvSettings {

    ///Vida (CMVIDAINDV):

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
         "3-TP_DOC_CONTRATANTE",
         "4-NU_DOC_CONTRATANTE",
         "5-TP_DOC_ASEGURADO",
         "6-NU_DOC_ASEGURADO",
         "7-FE_SOLICITUD",
         "8-CD_POLIZA_ANTERIOR",
         "9-FE_INCLUSION",
         "10-FE_HASTA",
         "11-CD_SUCURSAL",
         "12-CD_CANAL_VENTA",
         "13-CD_PERSONA_MEDIADOR_ESPECIAL",
         "14-CD_PERSONA_MEDIADOR",
         "15-PO_PARTICIPACION",
         "16-CD_REGION",
         "17-IN_MEDIADOR_PRINCIPAL",
         "18-CD_PERSONA_MEDIADOR_ESPECIAL_1",
         "19-CD_PERSONA_MEDIADOR_1",
         "20-PO_PARTICIPACION_1",
         "21-CD_REGION_1",
         "22-IN_MEDIADOR_PRINCIPAL_1",
         "23-NU_SECUENCIA_ESTRUCTURA",
         "24-CD_MONEDA","25-CD_PLAN_PAGO",
         "26-CD_FORMA_PAGO",
         "27-TP_NEGOCIO",
         "28-CD_CLASE_RIESGO",
         "29-NU_DOMICILIO_BANCARIO",
         "30-PAIS_RESIDENCIA",
         "31-TARIFA_POR_PAIS",
         "32-SUMA_ASEGURADA",
         "33-FE_NAC_TITULAR",
         "34-TIENE_CONTINUIDAD",
         "35-COMPANIA_ANTERIOR",
         "36-PAIS_ORIGEN_CO_ANTERIOR",
         "37-POLIZA_ANTERIOR",
         "38-SUMA_ASEG_ANTERIOR",
         "39-DEDUCIBLE_ANTERIOR",
         "40-FE_INICIO_POL_ANTERIOR",
         "41-PORC_DESCUENTO",
         "42-BUENA_SALUD",
         "43-MUERTE_ACCIDENTAL",
         "44-ITP",
         "45-PUC",
         "46-ASISTENCIA_VIAJE",
         "47-NOMBRE_TITULAR",
         "48-APELLIDO_TITULAR",
         "49-TELEFONO",
         "50-EMAIL",
         "51-TP_DOCUMENTO_BENEF",
         "52-NU_DOCUMENTO_BENEF",
         "53-SEXO_BENEFICIARIO",
         "54-CD_PARENTESCO_BENEF",
         "55-PO_PARTICIPACION_BENEF",
         "56-TP_DOC_1",
         "57-NU_DOC_1",
         "58-PO_PARTICI_1",
         "59-MT_CEDIDO",
         "60-NU_CONSEC_TP_DOC_PREFE",
         "61-NU_CONSEC_ANEXO",
         "62-NU_POLIZA_1",
         "63-TP_MEDIADOR_ESPECIAL",
         "64-500197-Consulta medica interna"
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

            $change->mediador_especial      = $change->estado !== "35000" ?  null : "70004";
            $change->tp_mediador_especial   = $change->estado !== "35000" ?  null : "C";
            
            
            $change->suma_asegurada = $change->suma_asegurada_id != null ? SumaAseguradaModel::find($change->suma_asegurada_id)->nombre : null;
            
            $change->fecha_de_nacimiento = carbon::create($change->RelationCliente->fecha_de_nacimiento)->format('d-m-Y');
            
            $change->cheque                 = $change->RelationCliente->nomb1." ".$change->RelationCliente->nomb2;
            $change->apellidos              = $change->RelationCliente->apelld1." ".$change->RelationCliente->apelld2;
            return $change;
        }, $data);              
    }
    
    public function map($data): array{               
        $columns = [
         "1-TIPO_ACCION"                => $data->tipo_accion,
         "2-TP_REGISTRO"                => $data->tipo_registro,
         "3-TP_DOC_CONTRATANTE"         => $data->doc_contratante,
         "4-NU_DOC_CONTRATANTE"         => $data->cedula ,
         "5-TP_DOC_ASEGURADO"           => $data->doc_contratante,
         "6-NU_DOC_ASEGURADO"           => $data->cedula ,
         "7-FE_SOLICITUD"               => $data->solicitud,
         "8-CD_POLIZA_ANTERIOR"         => null,
         "9-FE_INCLUSION"               => $data->solicitud,
         "10-FE_HASTA"                  => $data->hasta,
         "11-CD_SUCURSAL"                   => $data->sucursal,
         "12-CD_CANAL_VENTA"                => 59,
         "13-CD_PERSONA_MEDIADOR_ESPECIAL"  => $data->mediador_especial,
         "14-CD_PERSONA_MEDIADOR"           => $data->estado,
         "15-PO_PARTICIPACION"              => 100,
         "16-CD_REGION"                     => 1,
         "17-IN_MEDIADOR_PRINCIPAL"         => 1,
         "18-CD_PERSONA_MEDIADOR_ESPECIAL_1"=> $data->mediador_especial,
         "19-CD_PERSONA_MEDIADOR_1"         => $data->estado,
         "20-PO_PARTICIPACION_1"            => null,
         "21-CD_REGION_1"                   => null,
         "22-IN_MEDIADOR_PRINCIPAL_1"       => null,
         "23-NU_SECUENCIA_ESTRUCTURA"       => null,
         "24-CD_MONEDA"                     => 2,
         "25-CD_PLAN_PAGO"                  => $data->plan_pago,
         "26-CD_FORMA_PAGO"                 => 1,
         "27-TP_NEGOCIO"                    => 1,
         "28-CD_CLASE_RIESGO"               => "N",
         "29-NU_DOMICILIO_BANCARIO"         => null,
         "30-PAIS_RESIDENCIA"               => 29,
         "31-TARIFA_POR_PAIS"               => 29,
         "32-SUMA_ASEGURADA"                => $data->suma_asegurada,
         "33-FE_NAC_TITULAR"                => $data->fecha_de_nacimiento,
         "34-TIENE_CONTINUIDAD"             => 0,
         "35-COMPANIA_ANTERIOR"             => 0,
         "36-PAIS_ORIGEN_CO_ANTERIOR"       => null,
         "37-POLIZA_ANTERIOR"               => null,
         "38-SUMA_ASEG_ANTERIOR"            => null,
         "39-DEDUCIBLE_ANTERIOR"            => null,
         "40-FE_INICIO_POL_ANTERIOR"        => null,
         "41-PORC_DESCUENTO"                => null,
         "42-BUENA_SALUD"                   => "S",
         "43-MUERTE_ACCIDENTAL"             => null,
         "44-ITP"                           => null,
         "45-PUC"                           => null,
         "46-ASISTENCIA_VIAJE"              => null,
         "47-NOMBRE_TITULAR"                => $data->cheque,
         "48-APELLIDO_TITULAR"              => $data->apellidos,
         "49-TELEFONO"                      => null,
         "50-EMAIL"                         => null,
         "51-TP_DOCUMENTO_BENEF"            => null,
         "52-NU_DOCUMENTO_BENEF"            => null,
         "53-SEXO_BENEFICIARIO"             => null,
         "54-CD_PARENTESCO_BENEF"           => null,
         "55-PO_PARTICIPACION_BENEF"        => null,
         "56-TP_DOC_1"                      => null,
         "57-NU_DOC_1"                      => null,
         "58-PO_PARTICI_1"                  => null,
         "59-MT_CEDIDO"                     => null,
         "60-NU_CONSEC_TP_DOC_PREFE"        => null,
         "61-NU_CONSEC_ANEXO"               => null,
         "62-NU_POLIZA_1"                   => null,
         "63-TP_MEDIADOR_ESPECIAL"          => $data->tp_mediador_especial,
         "64-500197-Consulta medica interna" => "1"
        ];
        return $columns;
    }
}
