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
         "14-FE_SOLICITUD-1--",
         "15-CD_POLIZA_ANTERIOR-1--",
         "16-FE_INCLUSION-1--",
         "17-FE_HASTA-1--",
         "18-CD_SUCURSAL-1--",
         "19-CD_CANAL_VENTA-1--",
         "20_CD_PERSONA_MEDIADOR_ESPECIAL",
         "21-CD_PERSONA_MEDIADOR-1--",
         "22-PO_PARTICIPACION-1--",
         "23-CD_REGION-1--",
         "24-IN_MEDIADOR_PRINCIPAL-1--",
         "25-CD_PERSONA_MEDIADOR-1--",
         "26_CD_PERSONA_MEDIADOR_1",
         "27-PO_PARTICIPACION-1--",
         "28-CD_REGION-1--",
         "29-IN_MEDIADOR_PRINCIPAL-1--",
         "30-NU_SECUENCIA_ESTRUCTURA-1--",
         "31-CD_MONEDA-1--",
         "32-CD_PLAN_PAGO-1--",
         "33-CD_FORMA_PAGO-1--",
         "34-TP_NEGOCIO-1--",
         "35-CD_CLASE_RIESGO-1--",
         "36-NU_DOMICILIO_BANCARIO-1--",
         "37-VA_DATO-1-990140-Pa¡s de Residencia",
         "38-VA_DATO-1-990141-Tarifa por Pa¡s",
         "39-VA_DATO-1-420160-Tipo de Tarifa",
         "40-VA_DATO-1-990191-Suma Asegurada",
         "41-VA_DATO-1-420150-Parentesco",
         "42-VA_DATO-1-990218-Tiene continuidad la p¢liza?",
         "43-VA_DATO-1-990211-Nombre de la Compa¤¡a de Seguros anterior",
         "44-VA_DATO-1-990212-Pa¡s de origen de la Compa¤¡a de Seguros anterior",
         "45-VA_DATO-1-990213-N£mero de P¢liza anterior",
         "46-VA_DATO-1-990214-Suma Asegurada anterior",
         "47-VA_DATO-1-990215-Deducible anterior",
         "48-VA_DATO-1-990216-Fecha de inicio de la p¢liza anterior",
         "49-VA_DATO-1-990217-% Descuento/Recargo",
         "50-VA_DATO-1-990205-Asegurado Goza de Buena Salud?",
         "51-Poliza",
         "52- Fecha de Exclusion",
         "53-TP_MEDIADOR_ESPECIAL",
         "54-42170_Servicio Oftamologico",
         "55- CD_BANCO",
         "56- NU_CUENTA",
         "57- TP_CUENTA",
         "58-TP_TARJETA",
         "59- FE_VENCIMIENTO_TARJETA",
         "60- DIGITO VERIFICADOR",	
         "61-990037_Convenio",
         "62-990038_Aliado"
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
            
            
            $change->banco      = $change->banco_domiciliado != null ?
                    BancosModel::find($change->banco_domiciliado)->id 
                    : BancosModel::where('codigo',substr($change->num_cuenta_asociar_inst_bancario_sinencriptar, 0,4))->first()->id ;
            
            $change->cuenta     = $change->num_cuenta_asociar_inst_bancario_sinencriptar != null ? $change->num_cuenta_asociar_inst_bancario_sinencriptar : null;
            
            $change->tipo_tdc_domiciliar = $change->tipo_tdc_domiciliar != null ? $change->tipo_tdc_domiciliar : null;
            
            $change->fecha_vencimiento_tdc_domiciliar = $change->fecha_vencimiento_tdc_domiciliar != null ? $change->fecha_vencimiento_tdc_domiciliar : null;
            
            $change->banco      = $change->banco_domiciliado != null ?
                    BancosModel::find($change->banco_domiciliado)->id 
                    : BancosModel::where('codigo',substr($change->num_cuenta_asociar_inst_bancario_sinencriptar, 0,4))->first()->id ;
            
            $change->cuenta     = $change->num_cuenta_asociar_inst_bancario_sinencriptar != null ? $change->num_cuenta_asociar_inst_bancario_sinencriptar : null;
            
            $change->tipo_tdc_domiciliar = $change->tipo_tdc_domiciliar != null ? $change->tipo_tdc_domiciliar : null;
            
            $change->fecha_vencimiento_tdc_domiciliar = $change->fecha_vencimiento_tdc_domiciliar != null ? $change->fecha_vencimiento_tdc_domiciliar : null;
       
            
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
         "14-FE_SOLICITUD-1--"          => $data->solicitud,
         "15-CD_POLIZA_ANTERIOR-1--"    => "",
         "16-FE_INCLUSION-1--"          => $data->solicitud,
         "17-FE_HASTA-1--"              => $data->hasta,
         "18-CD_SUCURSAL-1--"           => $data->sucursal,
         "19-CD_CANAL_VENTA-1--"        => 59,
         "20_CD_PERSONA_MEDIADOR_ESPECIAL"=>$data->mediador_especial,            
         "21-CD_PERSONA_MEDIADOR-1--R_"   =>$data->estado,           
         "22-PO_PARTICIPACION-1--"      => 100,
         "23-CD_REGION-1--"             => 1,
         "24-IN_MEDIADOR_PRINCIPAL-1--" => 1,
         "25-CD_PERSONA_MEDIADOR-1--" =>"",
         "26_CD_PERSONA_MEDIADOR_1_" =>$data->estado,
         "27-PO_PARTICIPACION-1--" =>"",
         "28-CD_REGION-1--" =>"",
         "29-IN_MEDIADOR_PRINCIPAL-1--" =>"",
         "30-NU_SECUENCIA_ESTRUCTURA-1--" =>"",
         "31-CD_MONEDA-1--" =>"2",
         "32-CD_PLAN_PAGO-1--"   => $data->plan_pago,
         "33-CD_FORMA_PAGO-1--" =>1,
         "34-TP_NEGOCIO-1-"=>1,
         "35-CD_CLASE_RIESGO-1--"    =>"N",
         "36-NU_DOMICILIO_BANCARIO-1--"=> "",
         "37-VA_DATO-1-990140-Pa¡s de Residencia"=> 29,
         "38-VA_DATO-1-990141-Tarifa por Pa¡s"=> 29,
         "39-VA_DATO-1-420160-Tipo de Tarifa"=> 2,
         "40-VA_DATO-1-990191-Suma Asegurada"=> $data->suma_asegurada,
         "41-VA_DATO-1-420150-Parentesco"=>1,
         "42-VA_DATO-1-990218-Tiene continuidad la p¢liza?" => 0,
         "43-VA_DATO-1-990211-Nombre de la Compa¤¡a de Seguros anterior" => 0,
         "44-VA_DATO-1-990212-Pa¡s de origen de la Compa¤¡a de Seguros anterior" => 0,
         "45-VA_DATO-1-990213-N£mero de P¢liza anterior"=> "",
         "46-VA_DATO-1-990214-Suma Asegurada anterior"=> "",
         "47-VA_DATO-1-990215-Deducible anterior"=> "",
         "48-VA_DATO-1-990216-Fecha de inicio de la p¢liza anterior"=> "",
         "49-VA_DATO-1-990217-% Descuento/Recargo"=> 0,
         "50-VA_DATO-1-990205-Asegurado Goza de Buena Salud?"=> "S",
         "51-Poliza"=> "",
         "52- Fecha de Exclusion"=> "",
         "53-TP_MEDIADOR_ESPECIAL"=> $data->tp_mediador_especial,
         "54-42170_Servicio Oftamologico" => "1",
         "55- CD_BANCO"         =>$data->banco,
         "56- NU_CUENTA"        =>strval($data->cuenta),
         "57- TP_CUENTA"        => $data->tipo_cuenta_domiciliar,
         "58-TP_TARJETA"        => $data->tipo_tdc_domiciliar,
         "59- FE_VENCIMIENTO_TARJETA"    => $data->fecha_vencimiento_tdc_domiciliar,	
         "60- DIGITO VERIFICADOR"   => null,
         "61-990037_Convenio"       => null,
         "62-990038_Aliado"         => null,
        ];
        return $columns;
    }
}