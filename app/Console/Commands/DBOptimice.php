<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\SegurosMercantil\LotesModel;
use App\Models\SegurosMercantil\ClientesModel;
use \Illuminate\Support\Facades\DB;

use Carbon\Carbon;

class DBOptimice extends Command
{

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:optimiceforce';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimiza la Base de Datos en General';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $data = $this->choice(
            'Que desea realizar',
            [
                "0" => 'Optimizar',
                "1" => 'Eliminar',
            ],
            0
        );

        switch ($data) {
            case "Optimizar":
                $this->alert('Ajustando Variables de procesamiento...');
                DB::statement("SET SESSION innodb_lock_wait_timeout = 1000");
                $this->alert('Iniciando Optimizacion de Base de Datos');

                $username = env('DB_USERNAME');
                $password = env('DB_PASSWORD');
                $database = DB::connection()->getDatabaseName();

                $command = "mysqlcheck -u $username -p$password $database";
                exec($command, $output, $returnVar);

                if ($returnVar === 0) {
                    $this->info('El comando se ejecutó correctamente: ' . implode("\n", $output));
                } else {
                    $this->error('Hubo un error al ejecutar el comando: ' . implode("\n", $output));
                }

                $this->alert('Realizando Force de las Tablas');

                $this->withProgressBar(DB::select("SELECT table_name FROM information_schema.tables WHERE table_schema = ?", [$database]), function ($tablas) {
                    $this->info($tablas->table_name);
                    DB::statement('ALTER TABLE ' . $tablas->table_name . ' FORCE');
                });

                $this->newLine(1);
                $this->info("== Finalizado ==");
                return Command::SUCCESS;
                break;

            case "Eliminar":
                $pregunta = $this->choice('Que desea ELiminar?', ["0" => 'Clientes_Mayor_6_meses'], 0);

                $this->info('Ajustando Variables de procesamiento.');
                DB::statement("SET SESSION innodb_lock_wait_timeout = 1000");

                $hoy = Carbon::now();
                // calculamos los 6 meses de datos que se deben dejar en meses
                $fechavieja = Carbon::now()->subMonths(5)->startOfMonth();

                switch ($pregunta) {
                    case "Clientes_Mayor_6_meses":
                        $this->alert("Eliminando Datos de Clientes Mayor a 6 Meses de Antiguedad");
                        $lotes = LotesModel::whereDate('created_at', '<=', $fechavieja)->get();
                        $this->withProgressBar($lotes, function ($cobclient) {
                            ClientesModel::where('lote_id', $cobclient->id)->delete();
                        });
                        $this->info('OK');
                        break;
                }

                break;
        }
    }
}
