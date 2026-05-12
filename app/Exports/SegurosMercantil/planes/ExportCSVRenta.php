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
         "18-CD_PERSONA_MEDIADOR_ESPECIAL",
         "19-CD_PERSONA_MEDIADOR_1",
         "20-PO_PARTICIPACION_1",         
         "21-CD_REGION_1",         
         "22-IN_MEDIADOR_PRINCIPAL_1",
         "23-NU_SECUENCIA_ESTRUCTURA",         
         "24-CD_MONEDA",
         "25-CD_PLAN_PAGO",
         "26-CD_FORMA_PAGO",
         "27-TP_NEGOCIO",         
         "28-CD_CLASE_RIESGO",         
         "29-NU_DOMICILIO_BANCARIO",
         "30-PAIS_RESIDENCIA",
         "31-TARIFA_POR_PAIS", 
         "32-SUMA_ASEGURADA",
         "33-SUMA_ASEGURADA_INT",
         "34-FE_NAC_TITULAR",         
         "35-TIENE_CONTINUIDAD",
         "36-COMPANIA_ANTERIOR",
         "37-PAIS_ORIGEN_CO_ANTERIOR",         
         "38-POLIZA_ANTERIOR",         
         "39-SUMA_ASEG_ANTERIOR",
         "40-DEDUCIBLE_ANTERIOR",
         "41-FE_INICIO_POL_ANTERIOR",
         "42-PORC_DESCUENTO",
         "43-BUENA_SALUD",
         "44-NU_POLIZA_1",
         "45-TP_MEDIADOR_ESPECIAL",
         "46- CD_BANCO",
         "47- NU_CUENTA",
         "48- TP_CUENTA",
         "49-TP_TARJETA",
         "50- FE_VENCIMIENTO_TARJETA",
         "51- DIGITO VERIFICADOR",
         "52-990037_Convenio",
         "53-990038_Aliado"         
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
                              
            return $change;
        }, $data);              
    }
    
    public function map($data): array{               
        $columns = [
         "1-TIPO_ACCION"=> $data->tipo_accion,
         "2-TP_REGISTRO" => $data->tipo_registro,
         "3-TP_DOC_CONTRATANTE" => $data->doc_contratante ,
         "4-NU_DOC_CONTRATANTE" => $data->cedula,
         "5-TP_DOC_ASEGURADO"   => $data->doc_contratante ,
         "6-NU_DOC_ASEGURADO"       => $data->cedula,                     
         "7-FE_SOLICITUD"           => $data->solicitud,
         "8-CD_POLIZA_ANTERIOR"     => "",
         "9-FE_INCLUSION"           => $data->solicitud,                        
         "10-FE_HASTA"              => $data->hasta,
         "11-CD_SUCURSAL"           => $data->sucursal,
         "12-CD_CANAL_VENTA"        => 59,
         "13-CD_PERSONA_MEDIADOR_ESPECIAL"=>$data->mediador_especial,            
         "14-CD_PERSONA_MEDIADOR"   =>$data->estado,          
         "15-PO_PARTICIPACION"      => 100,
         "16-CD_REGION"             => 1,            
         "17-IN_MEDIADOR_PRINCIPAL" => 1,
         "18-CD_PERSONA_MEDIADOR_ESPECIAL" =>"",
         "19-CD_PERSONA_MEDIADOR_1" =>$data->estado,
         "20-PO_PARTICIPACION_1" =>"",
         "21-CD_REGION_1" =>"",            
         "22-IN_MEDIADOR_PRINCIPAL_1" =>"",
         "23-NU_SECUENCIA_ESTRUCTURA" =>"",
         "24-CD_MONEDA" =>"2",            
         "25-CD_PLAN_PAGO"   => $data->plan_pago,
         "26-CD_FORMA_PAGO" =>1,
         "27-TP_NEGOCIO"=>1,
         "28-CD_CLASE_RIESGO"    =>"N",            
         "29-NU_DOMICILIO_BANCARIO"=> "",
         "30-PAIS_RESIDENCIA"=> 29,
         "31-TARIFA_POR_PAIS"=> 29,       
         "32-SUMA_ASEGURADA"=> $data->suma_asegurada,
         "33-SUMA_ASEGURADA_INT" => 100,
         "34-FE_NAC_TITULAR"      => $data->fecha_de_nacimiento,      
         "35-TIENE_CONTINUIDAD" => 0,
         "36-COMPANIA_ANTERIOR" => 0,
         "37-PAIS_ORIGEN_CO_ANTERIOR" => 0,
         "38-POLIZA_ANTERIOR"=> "",            
         "39-SUMA_ASEG_ANTERIOR"=> "",
         "40-DEDUCIBLE_ANTERIOR"=> "",
         "41-FE_INICIO_POL_ANTERIOR"=> "",            
         "42-PORC_DESCUENTO"=> '-50',
         "43-BUENA_SALUD"=> "S",         
         "44-NU_POLIZA_1"=> "",
         "45-TP_MEDIADOR_ESPECIAL" => $data->tp_mediador_especial,
         "46- CD_BANCO"         =>$data->banco,
         "47- NU_CUENTA"        =>strval($data->cuenta),
         "48- TP_CUENTA"        => $data->tipo_cuenta_domiciliar,
         "49-TP_TARJETA"        => $data->tipo_tdc_domiciliar,
         "50- FE_VENCIMIENTO_TARJETA"    => $data->fecha_vencimiento_tdc_domiciliar,	
         "51- DIGITO VERIFICADOR"        => null,
         "52-990037_Convenio"            => null,
         "53-990038_Aliado"              => null,
        ];
        return $columns;
    }

}
