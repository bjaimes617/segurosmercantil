<?php

namespace App\Http\Controllers\SegurosMercantil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SegurosMercantil\MunicipiosModel;
use App\Models\SegurosMercantil\CiudadesModel;
use App\Models\SegurosMercantil\ParroquiaModel;
use App\Models\SegurosMercantil\UrbanizacionModel;
use App\Models\SegurosMercantil\PlanesModel;
use App\Models\SegurosMercantil\SumaAseguradaModel;
use App\Models\SegurosMercantil\RangodeEdadModel;
use App\Models\SegurosMercantil\DesglocePorEdadModel;
use App\Models\SegurosMercantil\Tipificacion1Model;
use App\Models\SegurosMercantil\Tipificacion2Model;
use App\Models\SegurosMercantil\Tipificacion3Model;
use Illuminate\Support\Facades\DB;

class FindsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        switch ($request->tipo){
            case "estado":
                $ciudad = CiudadesModel::where('estado_id',$request->estado)->get();
                return json_encode($ciudad);
                break;
             case "ciudad":
                $municipio = MunicipiosModel::where('estado_id',$request->estado)->where('ciudad_id',$request->ciudad)->get();
                return json_encode($municipio);
                break;
            case "municipio":
                $parroquia = ParroquiaModel::where('ciudad_id',$request->ciudad)->where('municipio_id',$request->municipio)->get();
                return json_encode($parroquia);
                break;
            case "parroquia":
                
                $urbanizacion = UrbanizacionModel::where('estado_id',$request->estado)
                ->where('ciudad_id',$request->ciudad)
                ->where('municipio_id',$request->municipio)
                ->where('parroquia_id',$request->parroquia)->get();
                
                return json_encode($urbanizacion);
                break;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function Tipificaciones(Request $request)
    {
        $tipi2 = Tipificacion2Model::select('id','descripcion')->where('gt_tipificacion1_id',$request->tipificacion1)
        ->where('active',1)->get();
            
        return json_encode($tipi2);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function CalculoPrimas(Request $request)
    {    
        $plan = PlanesModel::find($request->plan);
       // dd($request->all());
        /// validamos si el plan requiere desgloce por rango de edad, en caso contrario, se calculara en funcion a la edad
        if ($plan->required_planes_rango_edad == 1) {
           
            $montos = RangodeEdadModel::where('gt_suma_asegurada_id', $request->sumaasegurada)
            ->where('minEdad', '<=', (int) $request->campoedad)
            ->where('maxEdad', '>=', (int) $request->campoedad)->first();
            
         //  dd($montos->toSql(),$montos->getBindings(),$montos->first(),$request->sumaasegurada, $request->campoedad);
        }
        else {
            $montos = DesglocePorEdadModel::where('gt_suma_asegurada_id', $request->sumaasegurada)
            ->where('edad',(int) $request->campoedad)->first();
        }
        if ($montos != null) {
            switch ($request->tipodePago) {
                case "M":
                    $prima = $montos->prima_mensual != null ? $montos->prima_mensual : "1";
                    break;
                case "S":
                    $prima = $montos->prima_semestral != null ? $montos->prima_semestral : "0.0";
                    break;
                case "T":
                    $prima = $montos->prima_trimestral != null ? $montos->prima_trimestral : "0.0";
                    break;
                case "A":
                    $prima = $montos->prima_anual != null ? $montos->prima_anual : "0.0";
                    break;
            }
        }
        else {
            $prima = "1";
        }

        return json_decode($prima);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function Tipificaciones3(Request $request){

         $tipi3 = Tipificacion3Model::select('id','descripcion')->where('gt_tipificacion2_id',$request->tipificacion2)
         ->where('active',1)->get();

         return json_encode($tipi3);
    }
}
