<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SegurosMercantil\ClientesModel;
use Carbon\Carbon;

class GenerateDataClientes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GenerarCSVClientesAll';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera CSV con la data de todos los clientes segun el modulo';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $fechaactual = carbon::now();

        $data = $this->choice(
            'Indique cuales son los datos que necesita extraer?',
            ['Empresas'],
            0
        );

        switch ($data) {
            case "Empresas":
                $nombre = "Registros Clientes ";
                $modelClass = ClientesModel::class;
                break;
        }

        $clientes = $modelClass::all();

        $archivoprimerario      = "DB_" . $nombre . $fechaactual->copy()->format('dmy') . ".csv";
        $fd_pdftmp              = fopen(storage_path('app/public/' . $archivoprimerario), 'w');
        $this->fd_pdftmp        = $fd_pdftmp;
        $this->ruta_primeraria  = storage_path('app/public/' . $archivoprimerario);


        if ($this->fd_pdftmp) {
            $tableName = (new $modelClass)->getTable();
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing($tableName);

            $cabecera = implode(";", $columns) . "\r\n";
            fwrite($this->fd_pdftmp, $cabecera);

            $this->withProgressBar($clientes, function ($registro) use ($columns) {
                $rowData = [];
                foreach ($columns as $column) {

                    if ($column == 'region_id') {
                        $rowData[] = $registro->Relationregion !== null ? $registro->Relationregion->estados : null;
                        continue;
                    }

                    $rowData[] = $registro->$column;
                }

                $line = implode(";", $rowData) . "\r\n";
                fwrite($this->fd_pdftmp, $line);
            });
        }
        fclose($this->fd_pdftmp);

        return Command::SUCCESS;
    }
}
