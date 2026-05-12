<?php

namespace App\Imports\SegurosMercantil;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithCustomCsvSettings;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\SegurosMercantil\LotesModel;
use App\Models\SegurosMercantil\ClientesModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\SegurosMercantil\EstadosModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ClientesImport implements ToCollection, WithChunkReading, WithHeadingRow, WithCustomCsvSettings
{

    use Importable;
    private $lote;
    private $file;
    private $user_id;
    private $archivo;
    private $identstorage;

    public function __construct($file, $identystorage)
    {
        $this->file = $file;
        $this->identstorage = $identystorage;

        $lote = new LotesModel();
        $lote->archivo = $this->file;
        $lote->user_id = Auth::user()->id;
        $lote->identificacion_storage = $identystorage;
        $lote->save();

        $this->lote = $lote->id;
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function getCsvSettings(): array
    {
        return [
            'delimiter' => ';',
        ];
    }

    public function collection(Collection $collection)
    {

        try {

            $records = [];
            $estados = EstadosModel::pluck('id', 'estado')->toArray();
            $now = Carbon::now();

            foreach ($collection as $colection) {

                $fechaNacimiento = null;
                if (!empty($colection["fecha_de_nacimiento"])) {
                    try {
                        $fechaNacimiento = Carbon::createFromFormat('d/m/Y', $colection["fecha_de_nacimiento"])->format('Y-m-d');
                    } catch (\Exception $e) {

                        $fechaNacimiento = null;
                    }
                }

                $records[] = [
                    'nacionalidad_cliente' => $colection["nacionalidad_cliente"],
                    'n_cedula' => $colection["n_cedula"],
                    'apelld1' => $colection["apelld1"],
                    'apelld2' => $colection["apelld2"],
                    'apellcasada' => $colection["apellcasada"],
                    'nomb1' => $colection["nomb1"],
                    'nomb2' => $colection["nomb2"],
                    'cd_sexo' => $colection["cd_sexo"],
                    'cd_edo_civil' => $colection["cd_edo_civil"],
                    'fecha_de_nacimiento' => $fechaNacimiento,
                    'cd_estado_hab' => $colection["estado_habitacion"] !== null && isset($estados[$colection["estado_habitacion"]])
                        ? $estados[$colection["estado_habitacion"]]
                        : null,
                    'di_av_calle_hab' => $colection["di_av_calle_hab"],
                    'di_casa_hab' => $colection["di_casa_hab"],
                    'email_persol_tomador' => $colection["email_persol_tomador"],
                    'email_trabajo_u_ofici_tomador' => $colection["email_trabajo_u_ofici_tomador"],
                    'cd_area_num_telefono_habitacion_tomador' => $colection["cd_area_num_telefono_habitacion_tomador"],
                    'num_telefono_hab_tomador' => $colection["num_telefono_hab_tomador"],
                    'cd_area_num_telefono_trab_ofic_tomador' => $colection["cd_area_num_telefono_trab_ofic_tomador"],
                    'num_telefono_trab_ofic_tomador' => $colection["num_telefono_trab_ofic_tomador"],
                    'num_celular_pers_tomador' => $colection["num_celular_pers_tomador"],
                    'num_celular_trab_tomador' => $colection["num_celular_trab_tomador"],
                    'cd_profesion_ocupacion_cliente' => $colection["cd_profesion_ocupacion_cliente"],
                    'num_cuenta_asociar_inst_bancario_sinencriptar' => (string)$colection["num_cuenta_asociar_inst_bancario_sinencriptar"],
                    'tipo_cuenta_domiciliar' => $colection["tipo_cuenta_domiciliar"],
                    'estatus_id' => 3,
                    'user_id' => null,
                    'rfm' => $colection["rfm"],
                    'lote_id' => $this->lote,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
            $now = Carbon::now();
            $records = array_map(function ($record) use ($now) {
                $record['created_at'] = $now;
                $record['updated_at'] = $now;
                return $record;
            }, $records);

            DB::table('gt_clientes')->upsert(
                $records,
                ['n_cedula'],
                [
                    'nacionalidad_cliente',
                    'apelld1',
                    'apelld2',
                    'apellcasada',
                    'nomb1',
                    'nomb2',
                    'cd_sexo',
                    'cd_edo_civil',
                    'fecha_de_nacimiento',
                    'cd_estado_hab',
                    'di_av_calle_hab',
                    'di_casa_hab',
                    'email_persol_tomador',
                    'email_trabajo_u_ofici_tomador',
                    'cd_area_num_telefono_habitacion_tomador',
                    'num_telefono_hab_tomador',
                    'cd_area_num_telefono_trab_ofic_tomador',
                    'num_telefono_trab_ofic_tomador',
                    'num_celular_pers_tomador',
                    'num_celular_trab_tomador',
                    'cd_profesion_ocupacion_cliente',
                    'num_cuenta_asociar_inst_bancario_sinencriptar',
                    'tipo_cuenta_domiciliar',
                    'estatus_id',
                    'user_id',
                    'rfm',
                    'lote_id',
                    'created_at',
                    'updated_at',
                ]
            );

            Session::flash('uploadssuccess', 'Base de clientes Registrada correctamente.');

            return true;
        } catch (\Throwable $e) {

            Session::flash('uploadserror', $e->getMessage());

            if (!ClientesModel::where('lote_id', $this->lote)->exists()) {
                ClientesModel::where('lote_id', $this->lote)->delete();
            }

            Storage::disk('clientesfiles')->delete($this->identstorage);
            return false;
        }
    }
}
