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
class ExportCSVProteccion implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithChunkReading, WithCustomCsvSettings {
    /**
    * @return \Illuminate\Support\Collection
     * 
     * CMVITALINDIV proteccion
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
         "7-FE_SOLICITUD-1--",
         "8-CD_POLIZA_ANTERIOR-1--",
         "9-FE_INCLUSION-1--",
         "10-FE_HASTA-1--",
         "11-CD_SUCURSAL-1--",
         "12-CD_CANAL_VENTA-1--",
         "13-CD_PERSONA_MEDIADOR_ESPECIAL",
         "14-CODIGOMEDIADOR-1--",
         "15-PO_PARTICIPACION-1--",
         "16-CD_REGION-1--",
         "17-IN_MEDIADOR_PRINCIPAL-1--",
         "18-CD_PERSONA_MEDIADOR_ESPECIAL_1",
         "19-CD_PERSONA_MEDIADOR-1--",
         "20-PO_PARTICIPACION-1--",
         "21-CD_REGION-1--",
         "22-IN_MEDIADOR_PRINCIPAL-1--",
         "23-NU_SECUENCIA_ESTRUCTURA-1--",
         "24-CD_MONEDA-1--",
         "25-CD_PLAN_PAGO-1--",
         "26-CD_FORMA_PAGO-1--",
         "27-TP_NEGOCIO-1--",
         "28-CD_CLASE_RIESGO-1--",
         "29-NU_DOMICILIO_BANCARIO-1--",
         "30-VA_DATO-1-990140-Pais de Residencia",
         "31-VA_DATO-1-990141-Tarifa por PaÐs",
         "32-VA_DATO-1-990150-Suma Asegurada",
         "33-VA_DATO-1-990160-Fechadenaci",
         "34-VA_DATO-1-990218-Tiene continuidad la poliza?",
         "35-VA_DATO-1-990211-Nombre de la Compañia de Seguros anterior",
         "36-VA_DATO-1-990214-Suma Asegurada anterior",
         "37-VA_DATO-1-990215-Deducible anterior",
         "38-VA_DATO-1-990216-Fecha de inicio de la poliza anterior",
         "39-VA_DATO-1-990217-% Descuento-Recargo ",
         "40-VA_DATO-1-990205-Asegurado Goza de Buena Salud?",
         "41-VA_DATO-1-100130-Asistencia en Viaje",
         "42-VA_DATO-1-100135-Gastos Medicos",
         "43-NU_POLIZA",
         "44-100002Clientetarifa",
         "45-100150Cuida tu Salud",
         "46-100154Funerario",
         "47-100156Responsabilidad Civil General",
         "48-100158Venemergencia",
         "49-TP_DOCUMENTO",
         "50-NU_DOCUMENTO",
         "51-CD_SEXO",
         "52-CD_PARENTESCO",
         "53-PO_PARTICIPACION",
         "54-TP_MEDIADOR_ESPECIAL",
         "55-100159_Servicio de Odontologia"
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
            return $change;
        }, $data);              
    }
    
    public function map($data): array{               
        $columns = [
         "1-TIPO_ACCION"        => $data->tipo_accion,
         "2-TP_REGISTRO"        => $data->tipo_registro,
         "3-TP_DOC_CONTRATANTE-1--" => $data->doc_contratante ,
         "4-NU_DOC_CONTRATANTE-1--" => $data->cedula,
         "5-TP_DOC_ASEGURADO-1--"   => $data->doc_contratante ,
         "6-NU_DOC_ASEGURADO-1--"   => $data->cedula ,
         "7-FE_SOLICITUD-1--"       => $data->solicitud,
         "8-CD_POLIZA_ANTERIOR-1--" => null,
         "9-FE_INCLUSION-1--"       => $data->solicitud,
         "10-FE_HASTA-1--"          => $data->hasta,
         "11-CD_SUCURSAL-1--"               => $data->sucursal,
         "12-CD_CANAL_VENTA-1--"            => 59 ,
         "13-CD_PERSONA_MEDIADOR_ESPECIAL"  => $data->mediador_especial,
         "14-CODIGOMEDIADOR-1--"            => $data->estado,
         "15-PO_PARTICIPACION-1--"          => 100,
         "16-CD_REGION-1--"                 => 1,
         "17-IN_MEDIADOR_PRINCIPAL-1--"     => 1,
         "18-CD_PERSONA_MEDIADOR_ESPECIAL_1"=> $data->mediador_especial, 
         "19-CD_PERSONA_MEDIADOR-1--"       => $data->estado, 
         "20-PO_PARTICIPACION-1--"          => null, 
         "21-CD_REGION-1--"                 => null, 
         "22-IN_MEDIADOR_PRINCIPAL-1--"     => null, 
         "23-NU_SECUENCIA_ESTRUCTURA-1--"   => null, 
         "24-CD_MONEDA-1--"                 => 2,
         "25-CD_PLAN_PAGO-1--"              => $data->plan_pago,
         "26-CD_FORMA_PAGO-1--"             => 1,
         "27-TP_NEGOCIO-1--"                => 1,
         "28-CD_CLASE_RIESGO-1--"           =>"N",
         "29-NU_DOMICILIO_BANCARIO-1--"     => null,
         "30-VA_DATO-1-990140-Pais de Residencia"   => 29,
         "31-VA_DATO-1-990141-Tarifa por PaÐs"      => 29,
         "32-VA_DATO-1-990150-Suma Asegurada"       => $data->suma_asegurada,
         "33-VA_DATO-1-990160-Fechadenaci"          => $data->fecha_de_nacimiento,
         "34-VA_DATO-1-990218-Tiene continuidad la poliza?"             => 0,
         "35-VA_DATO-1-990211-Nombre de la Compañia de Seguros anterior"=> 0,
         "36-VA_DATO-1-990214-Suma Asegurada anterior"=> null, 
         "37-VA_DATO-1-990215-Deducible anterior"=> null, 
         "38-VA_DATO-1-990216-Fecha de inicio de la poliza anterior"=> null, 
         "39-VA_DATO-1-990217-% Descuento-Recargo "         => 0, 
         "40-VA_DATO-1-990205-Asegurado Goza de Buena Salud?"   => "S", 
         "41-VA_DATO-1-100130-Asistencia en Viaje"      => 0, 
         "42-VA_DATO-1-100135-Gastos Medicos"           => 1, 
         "43-NU_POLIZA"                                 => null, 
         "44-100002Clientetarifa"                       => null, 
         "45-100150Cuida tu Salud"                      => null, 
         "46-100154Funerario"                           => null, 
         "47-100156Responsabilidad Civil General"   => null, 
         "48-100158Venemergencia"                   => null, 
         "49-TP_DOCUMENTO"          => null, 
         "50-NU_DOCUMENTO"          => null, 
         "51-CD_SEXO"               => null, 
         "52-CD_PARENTESCO"         => null, 
         "53-PO_PARTICIPACION"      => null, 
         "54-TP_MEDIADOR_ESPECIAL"  => $data->tp_mediador_especial,
         "55-100159_Servicio de Odontologia"=>"1"
        ];
        return $columns;
    }
}
