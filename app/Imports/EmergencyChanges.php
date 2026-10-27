<?php

namespace App\Imports;

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
use App\Models\SegurosMercantil\ProcesadosModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\SegurosMercantil\EstadosModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class EmergencyChanges  implements ToCollection, WithChunkReading, WithHeadingRow
{
    use Importable;



    public function chunkSize(): int
    {
        return 1000;
    }

    public function headingRow(): int
    {
        return 1;
    }


    public function collection(Collection $collection)
    {

        // Extraer nro_cta y cedula_del_tomador del archivo
        $newCuentas = $collection->pluck('nro_cta', 'cedula_del_tomador');
        $cedulas = $collection->pluck('cedula_del_tomador')->filter()->unique();

        if ($cedulas->isEmpty()) {
            return;
        }
        // Buscar clientes por n_cedula en ClientesModel
        $clientesActuales = ClientesModel::where('estatus_id', 5)->whereIn('n_cedula', $cedulas)->get();

        DB::transaction(function () use ($clientesActuales, $newCuentas) {
            foreach ($clientesActuales as $cliente) {
                if (isset($newCuentas[$cliente->n_cedula])) {
                    $nuevaCuenta = (string) $newCuentas[$cliente->n_cedula];
                    // Actualizar número de cuenta en ClientesModel
                    $cliente->update([
                        'num_cuenta_asociar_inst_bancario_sinencriptar' => $nuevaCuenta,
                    ]);

                    // Actualizar número de cuenta en ProcesadosModel asociado al ID del cliente
                    ProcesadosModel::where('clientes_id', $cliente->id)->where('estatus_id', 5)->update([
                        'num_cuenta_asociar_inst_bancario_sinencriptar' => $nuevaCuenta,
                        'updated_at' => Carbon::now(),
                    ]);
                }
            }
        });

        return true;
    }
}
