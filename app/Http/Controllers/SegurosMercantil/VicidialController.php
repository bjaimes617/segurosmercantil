<?php

namespace App\Http\Controllers\SegurosMercantil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SegurosMercantil\ClientesModel;
use App\Models\SegurosMercantil\UrbanizacionModel;
use App\Models\SegurosMercantil\EstadosModel;
use App\Models\SegurosMercantil\CodigoTelefonosModel;
use App\Models\SegurosMercantil\PlanesModel;
use App\Models\SegurosMercantil\BancosModel;
use App\Models\SegurosMercantil\Tipificacion1Model;

class VicidialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($cedula,$callid)
    {
        $cliente = ClientesModel::where('n_cedula',$cedula)->first();
        
        if($cliente != null){
            //dd($cliente->estatus_id);
        if(!in_array($cliente->estatus_id, [5,4,2])){
            $type = "vicidial";
             /*$urbanizacion = UrbanizacionModel::where('id', $cliente->cd_urbanizsector_hab)
                                ->where('parroquia_id', $cliente->parroquia_hab)
                                ->where('municipio_id', $cliente->municipio_hab)
                                ->where('ciudad_id', $cliente->cd_ciudad_hab)
                                ->where('estado_id', $cliente->cd_estado_hab)
                              ->where('codigo_postal', $cliente->codigo_postal_hab)->first();

               $allestados = EstadosModel::pluck('estado', 'id');
               $ciudad     = $urbanizacion->Relation_Urb_to_Ciudad()->pluck('nombre_ciudad', 'id');
               $municipio  = $urbanizacion->Relation_Urb_to_Municipio()->pluck('nombre_municipio', 'id');
               $parroquia  = $urbanizacion->Relation_Urb_to_Parroquia()->pluck('nombre_parroquia', 'id');
               $urb        = UrbanizacionModel::where('id', $urbanizacion->id)->first();
*/
                $tlf = CodigoTelefonosModel::where('active', 1)->pluck('codigo', 'codigo');
                $planes = PlanesModel::where('active', 1)->get();
                $banco = BancosModel::where('active', 1)->orderby('banco', 'ASC')->get();
                $estado = EstadosModel::where('active',1)->get();
                $tipificacion1 = Tipificacion1Model::where('active', 1)->pluck('descripcion', 'id');
                //substr($cliente->num_cuenta_asociar_inst_bancario_sinencriptar, 0,4)
                
                $frecuencias = config('app.tipo_de_pago');
               unset($frecuencias["A"], $frecuencias["T"]);
                
                                                                        
                return view('gestion.formulario.index')
                                ->with([
                                    "client" => $cliente,
                                    "estado" => $estado,
                                   // "estado" => $allestados,
                                   // "ciudad" => $ciudad,
                                   // "municipio" => $municipio,
                                   // "parroquia" => $parroquia,
                                    "cod" => $tlf,
                                    "planes" => $planes,
                                    "banco" => $banco,
                                  //  "urbanizacion" => $urb,
                                    "tipificacion1" => $tipificacion1,
                                    "type" => $type,
                                    "callid" => $callid,
                                    "frecuencias" =>$frecuencias
                                ])->render();
        } else {
            return abort(403,"El Cliente que intenta visualizar posee un estatus de ".$cliente->RelationEstatus->descripcion);
        }
        } else {
            return abort(404,"el Cliente ".$cedula." No existe en nuestra Base de datos.");
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
}
