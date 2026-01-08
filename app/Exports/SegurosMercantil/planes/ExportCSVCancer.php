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
         "19-CD_PERSONA_MEDIADOR",
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
         "43-TP_DOC_1",
         "44-NU_DOC_1",
         "45-PO_PARTICI_1",
         "46-MT_CEDIDO",
         "47-NU_CONSEC_TP_DOC_PREFE",
         "48-NU_CONSEC_ANEXO",
         "49-NU_POLIZA_1",
         "50-TP_MEDIADOR_ESPECIAL",
         "51- CD_BANCO",
         "52- NU_CUENTA",
         "53- TP_CUENTA",
         "54-TP_TARJETA",
         "55- FE_VENCIMIENTO_TARJETA",
         "56- DIGITO VERIFICADOR",
         "57-990037_Convenio",
         "58-990038_Aliado"
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
         "1-TIPO_ACCION"          => $data->tipo_accion,
         "2-TP_REGISTRO"          => $data->tipo_registro,
         "3-TP_DOC_CONTRATANTE"   => $data->doc_contratante,
         "4-NU_DOC_CONTRATANTE"   => $data->cedula ,
         "5-TP_DOC_ASEGURADO"     => $data->doc_contratante,
         "6-NU_DOC_ASEGURADO"     => $data->cedula ,
         "7-FE_SOLICITUD"         => $data->solicitud,
         "8-CD_POLIZA_ANTERIOR"   => null,
         "9-FE_INCLUSION"         => $data->solicitud,
         "10-FE_HASTA"             => $data->hasta,
         "11-CD_SUCURSAL"          => 1,
         "12-CD_CANAL_VENTA"       => 59,
         "13-CD_PERSONA_MEDIADOR_ESPECIAL" => 70004,
         "14-CD_PERSONA_MEDIADOR"          => 35000,
         "15-PO_PARTICIPACION"             => 100,
         "16-CD_REGION"                    => 1,
         "17-IN_MEDIADOR_PRINCIPAL"        => 1,
         "18-CD_PERSONA_MEDIADOR_ESPECIAL" => 70004, 
         "19-CD_PERSONA_MEDIADOR"          => 35000,
         "20-PO_PARTICIPACION_1"           => "",
         "21-CD_REGION_1_"                  => "",
         "22-IN_MEDIADOR_PRINCIPAL_1_"      => "",
         "23-NU_SECUENCIA_ESTRUCTURA_"      => "",
         "24-CD_MONEDA"                    => 2,
         "25-CD_PLAN_PAGO"                 => $data->plan_pago,
         "26-CD_FORMA_PAGO"                => 1,
         "27-TP_NEGOCIO"                   => 1,
         "28-CD_CLASE_RIESGO"              => "N",
         "29-NU_DOMICILIO_BANCARIO"        => null,
         "30-PAIS_RESIDENCIA"              => 29,
         "31-TARIFA_POR_PAIS"              => 29,
         "32-SUMA_ASEGURADA"               => $data->suma_asegurada,
         "33-FE_NAC_TITULAR"               => $data->fecha_de_nacimiento,
         "34-TIENE_CONTINUIDAD"            => 0,
         "35-COMPANIA_ANTERIOR"            => 0,
         "36-PAIS_ORIGEN_CO_ANTERIOR"      => null,
         "37-POLIZA_ANTERIOR"              => null,
         "38-SUMA_ASEG_ANTERIOR"           => null,
         "39-DEDUCIBLE_ANTERIOR"           => null,
         "40-FE_INICIO_POL_ANTERIOR"       => null,
         "41-PORC_DESCUENTO"               => 0,
         "42-BUENA_SALUD"                  => "S",
         "43-TP_DOC_1"                     => null,
         "44-NU_DOC_1"                     => null,
         "45-PO_PARTICI_1"                 => null,
         "46-MT_CEDIDO"                    => null,
         "47-NU_CONSEC_TP_DOC_PREFE"       => null,
         "48-NU_CONSEC_ANEXO"              => null,
         "49-NU_POLIZA_1"                  => null,
         "50-TP_MEDIADOR_ESPECIAL"         => "C",
         "51- CD_BANCO"                    =>$data->banco,
         "52- NU_CUENTA"                   =>strval($data->cuenta),
         "53- TP_CUENTA"                   => $data->tipo_cuenta_domiciliar,
         "54-TP_TARJETA"                   => $data->tipo_tdc_domiciliar,
         "55- FE_VENCIMIENTO_TARJETA"      => $data->fecha_vencimiento_tdc_domiciliar,
         "56- DIGITO VERIFICADOR"           => null,
         "57-990037_Convenio"               => null,
         "58-990038_Aliado"                 => null
        ];
       // dd($columns);
        return $columns;
    }
}
