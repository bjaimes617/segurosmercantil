<?php

namespace App\Http\Controllers\SegurosMercantil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SegurosMercantil\ProcesadosModel;
use App\Models\SegurosMercantil\ClientesModel;
use App\Exports\TipificacionesExport;
use App\Exports\EstatusClientesExport;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;
use App\Models\SegurosMercantil\PlanesModel;
use App\libs\GenerarTXTPlanes;
use App\libs\GenerarTXTCancerPlanes;
use App\Exports\SegurosMercantil\clientes\ExportCLienteCARGAPN2;
use App\Exports\SegurosMercantil\clientes\ExportCLienteCARGAPNDOMI;

use App\Exports\SegurosMercantil\planes\ExportCSVida;
use App\Exports\SegurosMercantil\planes\ExportCSVCancer;
use App\Exports\SegurosMercantil\planes\ExportCSVProteccion;
use App\Exports\SegurosMercantil\planes\ExportCSVTranquilidad;
use App\Exports\SegurosMercantil\planes\ExportCSVRenta;
class ReportesController extends Controller {
    
    public function index() {
        return view('reportes.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $arrayfechas = explode("-", $request->rango_fecha);

        $init = Carbon::createFromformat('m/d/Y', trim($arrayfechas[0]))->format('Y-m-d');
        $finish = Carbon::createFromformat('m/d/Y', trim($arrayfechas[1]))->format('Y-m-d');

        switch ($request->tipo_reporte) {
            case "general":
                $data = ProcesadosModel::whereBetween('created_at', array("$init 00:00:01", "$finish 23:59:59"))->get();
                $tipoarchivo = "Tipificaciones Generales";
                $level = 1;
                break;
            case "ultimo_estatus":
                $data = ProcesadosModel::whereIn('id', ProcesadosModel::select(DB::raw('max(id)'))
                                        ->whereBetween('created_at', array("$init 00:00:01", "$finish 23:59:59"))
                                        ->groupby('clientes_id'))->get();
                $tipoarchivo = "Ultimo Estatus";
                $level = 1;
                break;
            
            case "clientes":
                $data = ClientesModel::whereBetween('created_at', array("$init 00:00:01", "$finish 23:59:59"))->get();
                $tipoarchivo = "Estatus Por Clientes";
                $level = 2;
                break;
        }
        switch ($level)
        {
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
    public function IndexTxt() {
        $planes = PlanesModel::where('active', 1)->get();
        return view('reportes.generateTxt')->with(["planes" => $planes]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function storeTxt(Request $request) {
        try {
            $plan = PlanesModel::find($request->tipo_reporte);          
            $init = Carbon::createFromformat('m/d/Y', $request->rango_fecha);            

            $rango_nombre = $init->copy()->format('dmY');

            $tipoarchivo = $plan->nombre_archivo . $rango_nombre;
            $data = ProcesadosModel::where('estatus_id', 5)->where('plan_id', $request->tipo_reporte)
                            ->whereBetween('created_at', array($init->format('Y-m-d') . " 00:00:01", $init->format('Y-m-d') . " 23:59:59"))->get();

            if($request->tipo_reporte != 3){
                $init = new GenerarTXTPlanes($data, $tipoarchivo);
                $rs = $init->GenerateTXT();
            } else {
                $init = new GenerarTXTCancerPlanes($data, $tipoarchivo);
                $rs = $init->GenerateTXT();
            }
            
            if($rs == true){
              return response()->download(storage_path("app/public/{$tipoarchivo}.txt"))->deleteFileAfterSend(true);  
            }
           
        } catch (\exception $e) {
            \Session::flash('error', 'Ocurrio un problema. ' . $e->getMessage());
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
    public function IndexCSV() {
         $planes = PlanesModel::where('active', 1)->get();
        return view('reportes.generateCSV')->with(["planes" => $planes]);
    }
    
    public function StoreCSV(Request $request) {
        
         $init = Carbon::createFromformat('m/d/Y', $request->rango_fecha);            

        $rango_nombre = $init->copy()->format('dmY');
            
        $tipoarchivo = PlanesModel::find($request->tipo_reporte)->nombre_archivo;
        
        $data = ProcesadosModel::where('estatus_id', 5)->where('plan_id', $request->tipo_reporte)
        ->whereBetween('created_at', array($init->format('Y-m-d') . " 00:00:01", $init->format('Y-m-d') . " 23:59:59"))->get();
        
        switch ($request->tipo_reporte){
        case 1:
            return Excel::download(new ExportCSVida($data), $tipoarchivo.'.csv',\Maatwebsite\Excel\Excel::CSV, [                  
            ]);     
           break;
        case 2:
             return Excel::download(new ExportCSVProteccion($data), $tipoarchivo.'.csv',\Maatwebsite\Excel\Excel::CSV, [                  
            ]); 
           break;
        case 3:
             return Excel::download(new ExportCSVCancer($data), $tipoarchivo.'.csv',\Maatwebsite\Excel\Excel::CSV, [                  
            ]); 
           break;
       case 4:
             return Excel::download(new ExportCSVRenta($data), $tipoarchivo.'.csv',\Maatwebsite\Excel\Excel::CSV, [                  
            ]); 
           break;
        case 5:
             return Excel::download(new ExportCSVTranquilidad($data), $tipoarchivo.'.csv',\Maatwebsite\Excel\Excel::CSV, [                  
            ]); 
           break;
       
        }
    }
    
    public function storeClientesCSV(Request $request) {
        
            $init = Carbon::createFromformat('m/d/Y', $request->rango_fecha);           
            $tipoarchivo = $request->tipo_reporte;            
            $data = ProcesadosModel::where('estatus_id', 5)
            ->whereBetween('created_at', array($init->format('Y-m-d') . " 00:00:01", $init->format('Y-m-d') . " 23:59:59"))->groupby('clientes_id')->get();
            
            switch ($request->tipo_reporte){
            case "CARGAPNDOMI":
                
                return Excel::download(new ExportCLienteCARGAPNDOMI($data), $tipoarchivo.'.csv',\Maatwebsite\Excel\Excel::CSV, [                  
                ]);     
               break;
           case "CARGAPN2":
                 return Excel::download(new ExportCLienteCARGAPN2($data), $tipoarchivo.'.csv',\Maatwebsite\Excel\Excel::CSV, [                  
                ]); 
               break;
            }
            
    }
}
