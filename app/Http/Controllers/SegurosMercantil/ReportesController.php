<?php

namespace App\Http\Controllers\SegurosMercantil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

use App\Exports\TipificacionesExport;
use App\Exports\EstatusClientesExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\SegurosMercantil\PlanesModel;
use App\Models\SegurosMercantil\ProcesadosModel;
use App\Models\SegurosMercantil\ClientesModel;
use App\libs\GenerarTXTPlanes;
use App\libs\GenerarTXTCancerPlanes;

use App\Exports\SegurosMercantil\clientes\ExportCLienteCARGAPN2;
use App\Exports\SegurosMercantil\clientes\ExportCLienteCARGAPNDOMI;
use App\Exports\SegurosMercantil\planes\ExportCSVida;
use App\Exports\SegurosMercantil\planes\ExportCSVCancer;
use App\Exports\SegurosMercantil\planes\ExportCSVProteccion;
use App\Exports\SegurosMercantil\planes\ExportCSVTranquilidad;
use App\Exports\SegurosMercantil\planes\ExportCSVRenta;

class ReportesController extends Controller
{

    public function index()
    {
        return view('reportes.index');
    }

    public function store(Request $request)
    {
        $arrayfechas = explode("-", $request->rango_fecha);

        $init = Carbon::createFromformat('m/d/Y', trim($arrayfechas[0]))->startOfDay()->format('Y-m-d H:i:s');
        $finish = Carbon::createFromformat('m/d/Y', trim($arrayfechas[1]))->endOfDay()->format('Y-m-d H:i:s');

        switch ($request->tipo_reporte) {
            case "general":
                $data = Cache::remember('Tipificacion_general_MerSeg', 60, function () use ($init, $finish) {
                    return ProcesadosModel::with(
                        'RelationCliente',
                        'RelationTipiifcacion1',
                        'RelationTipiifcacion2',
                        'RelationTipificacion3',
                    )->whereBetween('created_at', array($init, $finish))->get();
                });

                $tipoarchivo = "Tipificaciones Generales";
                $level = 1;
                break;
            case "ultimo_estatus":

                $data =  Cache::remember('Ultimo_Estatus_Clientes_MerSeg', 60, function () use ($init, $finish) {
                    return ProcesadosModel::whereIn('id', ProcesadosModel::select(DB::raw('max(id)'))
                        ->whereBetween('created_at', array($init, $finish))
                        ->groupby('clientes_id'))->get();
                });
                $tipoarchivo = "Ultimo Estatus";
                $level = 1;
                break;

            case "clientes":
                $data = Cache::remember('Estatus_Clientes_MerSeg', 60, function () use ($init, $finish) {
                    return ClientesModel::whereBetween('created_at', array($init, $finish))->get();
                });

                $tipoarchivo = "Estatus Por Clientes";
                $level = 2;
                break;
        }

        switch ($level) {
            case 1:
                return Excel::download(new TipificacionesExport($data), $tipoarchivo . ' ' . $init . ' al ' . $finish . '.csv');
                break;
            case 2:
                return Excel::download(new EstatusClientesExport($data), $tipoarchivo . ' ' . $init . ' al ' . $finish . '.csv');
                break;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function IndexTxt()
    {
        $planes = PlanesModel::all();
        return view('reportes.generateTxt')->with(["planes" => $planes]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeTxt(Request $request)
    {
        try {
            $plan = PlanesModel::find($request->tipo_reporte);
            $init = Carbon::createFromformat('m/d/Y', $request->rango_fecha);


            $rango_nombre = $init->copy()->format('dmY');

            $tipoarchivo = $plan->nombre_archivo . $rango_nombre;
            $data = ProcesadosModel::where('estatus_id', 5)->where('plan_id', $request->tipo_reporte)
                ->whereBetween('created_at', array($init->format('Y-m-d') . " 00:00:01", $init->format('Y-m-d') . " 23:59:59"))->get();

            if ($request->tipo_reporte != 3) {
                $init = new GenerarTXTPlanes($data, $tipoarchivo);
                $rs = $init->GenerateTXT();
            } else {
                $init = new GenerarTXTCancerPlanes($data, $tipoarchivo);
                $rs = $init->GenerateTXT();
            }

            if ($rs == true) {
                return response()->download(storage_path("app/public/{$tipoarchivo}.txt"))->deleteFileAfterSend(true);
            }
        } catch (\exception $e) {
            Session::flash('error', 'Ocurrio un problema. ' . $e->getMessage());
            return back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function IndexCSV()
    {
        $planes = PlanesModel::all();
        return view('reportes.generateCSV')->with(["planes" => $planes]);
    }

    public function StoreCSV(Request $request)
    {

        $init = Carbon::createFromformat('m/d/Y', $request->rango_fecha);

        $rango_nombre = $init->copy()->format('dmY');
        $tipoarchivo = PlanesModel::find($request->tipo_reporte)->nombre_archivo;

        $data = Cache::remember('Data_polizas_MerSeg' . $tipoarchivo, 60, function () use ($init, $request) {
            return ProcesadosModel::where('estatus_id', 5)->where('plan_id', $request->tipo_reporte)
                ->whereBetween('created_at', array($init->format('Y-m-d') . " 00:00:01", $init->format('Y-m-d') . " 23:59:59"))->get();
        });

        switch ($request->tipo_reporte) {
            case 1:
                return Excel::download(new ExportCSVida($data), $tipoarchivo . '.csv', \Maatwebsite\Excel\Excel::CSV, []);
                break;
            case 2:
                return Excel::download(new ExportCSVProteccion($data), $tipoarchivo . '.csv', \Maatwebsite\Excel\Excel::CSV, []);
                break;
            case 3:
                return Excel::download(new ExportCSVCancer($data), $tipoarchivo . '.csv', \Maatwebsite\Excel\Excel::CSV, []);
                break;
            case 4:
                return Excel::download(new ExportCSVRenta($data), $tipoarchivo . '.csv', \Maatwebsite\Excel\Excel::CSV, []);
                break;
            case 5:
                return Excel::download(new ExportCSVTranquilidad($data), $tipoarchivo . '.csv', \Maatwebsite\Excel\Excel::CSV, []);
                break;
        }
    }

    public function storeClientesCSV(Request $request)
    {

        $init = Carbon::createFromformat('m/d/Y', $request->rango_fecha);
        $tipoarchivo = $request->tipo_reporte;
        $data = ProcesadosModel::where('estatus_id', 5)
            ->whereBetween('created_at', array($init->format('Y-m-d') . " 00:00:01", $init->format('Y-m-d') . " 23:59:59"))->groupby('clientes_id')->get();

        switch ($request->tipo_reporte) {
            case "CARGAPNDOMI":

                return Excel::download(new ExportCLienteCARGAPNDOMI($data), $tipoarchivo . '.csv', \Maatwebsite\Excel\Excel::CSV, []);
                break;
            case "CARGAPN2":
                return Excel::download(new ExportCLienteCARGAPN2($data), $tipoarchivo . '.csv', \Maatwebsite\Excel\Excel::CSV, []);
                break;
        }
    }
}
