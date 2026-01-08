<?php

namespace App\Imports\SegurosMercantil;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Maatwebsite\Excel\Concerns\WithValidation;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\SegurosMercantil\LotesModel;
use App\Models\SegurosMercantil\ClientesModel;

class ClientesImport implements ToCollection, WithChunkReading, WithHeadingRow, WithCustomCsvSettings {

    use Importable;

    public function __construct($file) {
        $this->file = $file;
        
        $lote = new LotesModel();
        $lote->archivo = $this->file;
        $lote->user_id = \Auth::user()->id;
        $lote->save();        
        $this->lote = $lote->id;
    }

    public function chunkSize(): int {
        return 500;
    }

    public function getCsvSettings(): array {
        return [
            'delimiter' => ';',
        ];
    }

    public function collection(Collection $collection) {
     
        try {
                
            foreach ($collection as $colection) {
                if(ClientesModel::where('n_cedula',$colection["n_cedula"])->exists())
                {
                    $client = ClientesModel::where('n_cedula',$colection["n_cedula"])->first();
                } else {
                    $client = new ClientesModel(); 
                }
               
                $client->nacionalidad_cliente = $colection["nacionalidad_cliente"];
                $client->n_cedula = $colection["n_cedula"];
                $client->apelld1 = $colection["apelld1"];
                $client->apelld2 = $colection["apelld2"];
                $client->apellcasada = $colection["apellcasada"];
                $client->nomb1          = $colection["nomb1"];
                $client->nomb2          = $colection["nomb2"];
                $client->cd_sexo        = $colection["cd_sexo"];
                $client->cd_edo_civil   = $colection["cd_edo_civil"];
                $client->fecha_de_nacimiento = $colection["fecha_de_nacimiento"];
                $client->cd_estado_hab = $colection["cd_estado_hab"];
                $client->cd_ciudad_hab = $colection["cd_ciudad_hab"];
                $client->municipio_hab = $colection["municipio_hab"];
                $client->parroquia_hab = $colection["parroquia_hab"];
                $client->cd_urbanizsector_hab = $colection["cd_urbanizsector_hab"];
                $client->codigo_postal_hab = $colection["codigo_postal_hab"];
                $client->di_av_calle_hab = $colection["di_av_calle_hab"];
                $client->di_casa_hab = $colection["di_casa_hab"];
                $client->email_persol_tomador = $colection["email_persol_tomador"];
                $client->email_trabajo_u_ofici_tomador = $colection["email_trabajo_u_ofici_tomador"];
                $client->cd_area_num_telefono_habitacion_tomador = $colection["cd_area_num_telefono_habitacion_tomador"];
                $client->num_telefono_hab_tomador = $colection["num_telefono_hab_tomador"];
                $client->cd_area_num_telefono_trab_ofic_tomador = $colection["cd_area_num_telefono_trab_ofic_tomador"];
                $client->num_telefono_trab_ofic_tomador = $colection["num_telefono_trab_ofic_tomador"];
                $client->num_celular_pers_tomador = $colection["num_celular_pers_tomador"];
                $client->num_celular_trab_tomador = $colection["num_celular_trab_tomador"];
                $client->cd_profesion_ocupacion_cliente = $colection["cd_profesion_ocupacion_cliente"];
                $client->num_cuenta_asociar_inst_bancario_sinencriptar = $colection["num_cuenta_asociar_inst_bancario_sinencriptar"];
                $client->tipo_cuenta_domiciliar = $colection["tipo_cuenta_domiciliar"];
                $client->estatus_id = 3;
                $client->user_id    = null;
                $client->lote_id    = $this->lote;
                $client->save();
            }
              \Session::flash('success', 'Base de clientes Registrada correctamente.');
              return redirect()->back();
        } catch (\exception $e) {  
           
            \Session::flash('uploadserror', $e->getMessage());
            return redirect()->back();
        }
    }

    public function rules(): array {
        return [
            'nacionalidad_cliente' => function ($attribute, $value, $onFailure) {
                if (trim($value) == "") {
                    $onFailure('La Nacionalidad del cliente es obligatoria.');
                }
            },
            'n_cedula' => function ($attribute, $value, $onFailure) {
                if (trim($value) == "") {
                    $onFailure('La cedula del cliente es obligatoria.');
                }
            },
            'num_cuenta_asociar_inst_bancario_sinencriptar' => function ($attribute, $value, $onFailure) {
                if (strlen($value) < 20 && strlen($value) != 0) {
                    $onFailure('La cuenta Bancaria debe tener una longitud de 20 Digitos');
                }
            },
            'tipo_cuenta_domiciliar' => function ($attribute, $value, $onFailure) {
                if (trim($value) == "") {
                    $onFailure('El tipo de cuenta es obligatorio.');
                }
            },
            /* 'nomb1' => function ($attribute, $value, $onFailure) {
                if (trim($value) == "") {
                    $onFailure('El Nombre del Cliente es obligatorio.');
                }
            },
            'apelld1' => function ($attribute, $value, $onFailure) {
                if (trim($value) == "") {
                    $onFailure('El Apellido del Cliente es obligatorio.');
                }
            },
             'cd_sexo' => function ($attribute, $value, $onFailure) {
              if (trim($value) == "") {
              $onFailure('El Codigo del Sexo es obligatorio.');
              }
              },
              'cd_edo_civil' => function ($attribute, $value, $onFailure) {
              if (trim($value) == "") {
              $onFailure('El Estado civil es obligatorio.');
              }
              }, */
            /* 'fecha_de_nacimiento' => function ($attribute, $value, $onFailure) {
              if (trim($value) == "") {
              $onFailure('La fecha de Nacmiento es obligatoria.');
              } else if ($value != "" && Carbon::createFromFormat('Y-m-d', $value) === false) {
              $onFailure('La fecha de Nacimiento no cumple con el formato YYY-MM-DD.');
              }
              },
              'cd_edo_civil' => function ($attribute, $value, $onFailure) {
              if (trim($value) == "") {
              $onFailure('El Estado civil es obligatorio.');
              }
              }, */
            /*  'email_persol_tomador' => function ($attribute, $value, $onFailure) {
              if (trim($value) == "") {
              $onFailure('El Email del Tomador es obligatorio.');
              }
              }, */
            /* 'cd_area_num_telefono_habitacion_tomador' => function ($attribute, $value, $onFailure) {
              if (trim($value) == "") {
              $onFailure('Cdigo de area Tlf. Habitacion del tomador  es obligatorio.');
              }
              },
              'num_telefono_hab_tomador' => function ($attribute, $value, $onFailure) {
              if (trim($value) == "") {
              $onFailure('El Número de Telefono del Tomador es obligatorio.');
              }
              }, */
            /* 'num_celular_pers_tomador' => function ($attribute, $value, $onFailure) {
              if (trim($value) == "") {
              $onFailure('El Número Cedular del Tomador es obligatorio.');
              }
              }, */
            
        ];
    }
}
