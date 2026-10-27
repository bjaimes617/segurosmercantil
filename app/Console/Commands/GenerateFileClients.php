<?php

namespace App\Console\Commands;

use App\Models\SegurosMercantil\ClientesModel;
use Illuminate\Console\Command;
use App\Models\SegurosMercantil\ClientesResidencialesModel;
use App\Models\SegurosMercantil\ProcesadosModel;
use App\Models\SegurosMercantil\EstadosModel;
use App\Models\SegurosMercantil\PlanesModel;
use App\Models\SegurosMercantil\SumaAseguradaModel;
use Carbon\Carbon;
use App\Models\SegurosMercantil\BancosModel;


class GenerateFileClients extends Command
{
    private $fd_pdftmp, $ruta_primeraria;

    protected $signature = 'GenerateFileClients';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
            ['Clientes', 'Ventas'],
            0
        );

        switch ($data) {
            case "Clientes":
                $nombre = "Clientes Registrados ";
                $clientes = ClientesModel::cursor();
                $this->Clientes($fechaactual, $nombre, $clientes);
                break;
            case "Ventas":
                $nombre = "Ventas Generadas ";
                $clientes = ProcesadosModel::where('estatus_id', 5)->cursor();
                $this->Ventas($fechaactual, $nombre, $clientes);
                break;
        }
    }

    private function Clientes($fechaactual, $nombre, $clientes)
    {
        $estados = EstadosModel::all()->pluck('id', 'estados')->toArray();
        $listbancos = BancosModel::where('active', 1)->pluck('banco', 'codigo')->toArray();

        $contador = 0;
        $parte = 1;
        $limite = 1000000;

        $cabecera = "nacionalidad_cliente; n_cedula; apelld1; apelld2; apellcasada;nomb1; nomb2; cd_sexo;cd_edo_civil; estado;fecha_de_nacimiento; banco;tipo_cuenta_domiciliar; rfm;created_at\r\n";

        $abrirArchivo = function ($parte) use ($nombre, $fechaactual, $cabecera) {
            $sufijo = $parte > 1 ? "_" . $parte : "";
            $archivoprimerario = "DB_" . $nombre . $fechaactual->copy()->format('dmy') . $sufijo . ".csv";
            $fd = fopen(storage_path('app/public/' . $archivoprimerario), 'w');
            fwrite($fd, $cabecera);
            return $fd;
        };

        $archivoprimerario = "DB_" . $nombre . $fechaactual->copy()->format('dmy') . ".csv";
        $this->ruta_primeraria = storage_path('app/public/' . $archivoprimerario);
        $this->fd_pdftmp = $abrirArchivo($parte);


        $this->withProgressBar($clientes, function ($registro) use ($estados, $listbancos, &$contador, &$parte, $limite, $abrirArchivo) {

            $estado = $registro->region_id != null || isset($estados[$registro->region_id]) ? $estados[$registro->region_id] : null;

            $creado = carbon::create($registro->created_at)->format('d/m/Y');

            $cod = substr($registro->num_cuenta_asociar_inst_bancario_sinencriptar, 0, 4);
            $banco = $cod !== null && isset($listbancos[$cod])
                ? $listbancos[$cod]
                : null;

            $data = $registro->nacionalidad_cliente . ";" . $registro->n_cedula . ";" . $registro->apelld1 . ";" . $registro->apelld2 . ";" . $registro->apellcasada . ";" .
                $registro->nomb1 . ";" . $registro->nomb2 . ";" . $registro->cd_sexo . ";" . $registro->cd_edo_civil . ";" . $estado . ";" . $registro->fecha_de_nacimiento . ";" . $banco . ";" . $registro->tipo_cuenta_domiciliar . ";" . $registro->rfm . ";" . $creado . "\r\n";

            fwrite($this->fd_pdftmp, $data);
            $contador++;

            if ($contador >= $limite) {
                fclose($this->fd_pdftmp);
                $parte++;
                $this->fd_pdftmp = $abrirArchivo($parte);
                $contador = 0;
            }
        });

        if (is_resource($this->fd_pdftmp)) {
            fclose($this->fd_pdftmp);
        }
    }

    private function Ventas($fechaactual, $nombre, $clientes)
    {
        $planes = PlanesModel::all()->pluck('nombre', 'id')->toArray();
        $listbancos = SumaAseguradaModel::where('active', 1)->pluck('nombre', 'id')->toArray();

        $contador = 0;
        $parte = 1;
        $limite = 1000000;

        $cabecera = "Fecha_venta;Producto;Operador;fecha_nacimiento;valor_prima;cedula;cliente\r\n";

        $abrirArchivo = function ($parte) use ($nombre, $fechaactual, $cabecera) {
            $sufijo = $parte > 1 ? "_" . $parte : "";
            $archivoprimerario = "DB_" . $nombre . $fechaactual->copy()->format('dmy') . $sufijo . ".csv";
            $fd = fopen(storage_path('app/public/' . $archivoprimerario), 'w');
            fwrite($fd, $cabecera);
            return $fd;
        };

        $archivoprimerario = "DB_" . $nombre . $fechaactual->copy()->format('dmy') . ".csv";
        $this->ruta_primeraria = storage_path('app/public/' . $archivoprimerario);
        $this->fd_pdftmp = $abrirArchivo($parte);


        $this->withProgressBar($clientes, function ($registro) use ($planes, $listbancos, &$contador, &$parte, $limite, $abrirArchivo) {

            $data_cliente = $registro->RelationCliente;
            $creado = carbon::create($registro->created_at)->format('d/m/Y');
            $plan = $registro->plan_id != null || isset($planes[$registro->plan_id]) ? $planes[$registro->plan_id] : null;


            $data =  $creado . ";" . $plan . ";" . $registro->user_id . ";" . $data_cliente->fecha_de_nacimiento . ";" . $registro->monto_a_pagar . ";" . $data_cliente->nacionalidad_cliente . "-" . $data_cliente->n_cedula . ";" . $data_cliente->nomb1 . " " . $data_cliente->apelld1 . "\r\n";

            fwrite($this->fd_pdftmp, $data);
            $contador++;

            if ($contador >= $limite) {
                fclose($this->fd_pdftmp);
                $parte++;
                $this->fd_pdftmp = $abrirArchivo($parte);
                $contador = 0;
            }
        });

        if (is_resource($this->fd_pdftmp)) {
            fclose($this->fd_pdftmp);
        }
    }
}
