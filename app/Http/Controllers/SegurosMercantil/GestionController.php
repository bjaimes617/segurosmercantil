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
use App\Models\SegurosMercantil\ProcesadosModel;
use App\Models\SegurosMercantil\VicidialRecordsModel;
use jeremykenedy\LaravelRoles\Models\Role;
use App\Models\SegurosMercantil\Tipificacion2Model;
use App\Models\User;
use App\Models\SegurosMercantil\EliminadasModel;

use Carbon\Carbon;
use App\Models\SegurosMercantil\SumaAseguradaModel;

class GestionController extends Controller
{
        ///["1"=>"Vivienda","2"=>"Oficina"]
    public function indexAsignar(){
        
       $users = User::whereHas('roles', function ($q) {
            $q->whereIn('slug', ['operador']); // $request->roles needs to be an array
        })->where('users.estatus_id', 1)->orderby('name', 'ASC')->get();

        $cliente = ClientesModel::where('estatus_id',3)->limit(1000)->get();
        return view('gestion.asignaciones.administrador')->with(["clientes"=>$cliente,"users"=>$users]);
    }
    
    public function StoreAsignar(Request $request) {
    
        try{
        foreach($request->cliente as $cliente){
            $cl = ClientesModel::find($cliente);
            $cl->estatus_id = 4;
            $cl->user_id = $request->user;
            $cl->save();
        }
         \Session::flash('success', 'Registros Asignados exitosamente.');
            return back();
        } catch (\Exception $e) {
            \Session::flash('error', 'Ocurrio un problema. ' . $e->getMessage());
            return back();
        }
    }
    
    public function index()
    {
        $client = ClientesModel::where('user_id',\Auth::user()->id)->where('estatus_id',4)->get();
        return view('gestion.asignaciones.operador')->with(["clientes"=>$client,"type"=>"index"])->render();
    }
        
    public function IndexManual() {
        $callid = null;

        $tlf = CodigoTelefonosModel::where('active', 1)->pluck('codigo', 'codigo');
        $planes = PlanesModel::where('active', 1)->get();
        $estado = EstadosModel::where('active', 1)->get();
        $banco = BancosModel::where('active', 1)->orderby('banco', 'ASC')->get();

        $tipificacion1 = Tipificacion1Model::where('active', 1)->pluck('descripcion', 'id');
        //substr($cliente->num_cuenta_asociar_inst_bancario_sinencriptar, 0,4)

        $frecuencias = config('app.tipo_de_pago');
        unset($frecuencias["A"], $frecuencias["T"]);

        return view('gestion.formulario.manual')
        ->with([
        "estado" => $estado,
     
        "cod" => $tlf,
        "planes" => $planes,
        "banco" => $banco,
        //"urbanizacion" => $urb,
        "tipificacion1" => $tipificacion1,       
        "callid" => $callid,
        "frecuencias" => $frecuencias
        ])->render();    

}

    public function ValidateCedulaManual(Request $request){
                       
        if(empty($request->cedula) || ClientesModel::where('n_cedula',$request->cedula)->exists()){
            return json_encode(true);
            //bloquea registro
        } else {
            //continua
            return json_encode(false);
        }
    }
    
     public function StorexManual(Request $request)
    {
     //   dd($request->all());
        try{
        $cliente = new ClientesModel();
        $cliente->nacionalidad_cliente    = $request->nacionalidad;
        $cliente->n_cedula                = $request->n_cedula_manual;
        $cliente->apelld1                 = strtoupper($request->apelld1);
        $cliente->apelld2                 = strtoupper($request->apelld2);
        $cliente->apellcasada             = strtoupper($request->apellcasada);
        $cliente->nomb1                   = strtoupper($request->nomb1);
        $cliente->nomb2                   = strtoupper($request->nomb2);
        $cliente->cd_sexo                 = $request->sexo;     
        $cliente->cd_estado_hab           = $request->estado;
        
        $cliente->cd_edo_civil             = $request->cd_edo_civil;
        $cliente->fecha_de_nacimiento     = carbon::createFromformat('d/m/Y',$request->fecha_de_nacimiento)->format('Y-m-d');
        $cliente->num_cuenta_asociar_inst_bancario_sinencriptar = $request->instrumentonewmanual;
        $cliente->tipo_cuenta_domiciliar    = $request->tipoinstrumentonewmanual;
        $cliente->cd_profesion_ocupacion_cliente = 61;
        ///almacenamiento direccion vieja
        /*$cliente->cd_edo_civil            = $request->cd_edo_civil;        
        $cliente->cd_estado_hab           = $request->estado_id;
        $cliente->cd_ciudad_hab           = $request->ciudad_id;
        $cliente->municipio_hab           = $request->municipio_id;
        $cliente->parroquia_hab           = $request->parroquia_id;
        $cliente->cd_urbanizsector_hab    = $request->urbanizacion_id;
        $cliente->codigo_postal_hab       = $request->codigo_postal_hab;
        $cliente->di_av_calle_hab         = $request->di_av_calle_hab;
        $cliente->di_casa_hab             = $request->di_casa_hab;   */
                
        $cliente->cd_pais               = 29;
        $cliente->tp_vivienda           = 1;
        $cliente->tp_direccion          = 1;
        $cliente->cd_provincia          = 10;
        $cliente->cd_ciudad             = 1;
        $cliente->cd_zona               = 129;       
        $cliente->tp_telefono           = 3; ///celular
       
        $cliente->email_persol_tomador                    = $request->email_persol_tomador;
        $cliente->email_trabajo_u_ofici_tomador           = $request->email_trabajo_u_ofici_tomador;        
        $cliente->cd_area_num_telefono_habitacion_tomador = $request->cd_area_num_telefono_habitacion_tomador;
        $cliente->num_telefono_hab_tomador                = $request->num_telefono_hab_tomador;
        $cliente->cd_area_num_telefono_trab_ofic_tomador  = $request->cd_area_num_telefono_trab_ofic_tomador;
        $cliente->num_telefono_trab_ofic_tomador          = $request->num_telefono_trab_ofic_tomador;
        $cliente->num_celular_pers_tomador                = $request->num_celular_pers_tomador;
        $cliente->num_celular_trab_tomador                = $request->num_celular_trab_tomador;
        $cliente->estatus_id                              = 5; ///estatus Venta
        $cliente->save();
        
        $planes = PlanesModel::where('active',1)->get();
        
        foreach($planes as $checkplan){
            ///recorremos los planes activados, y verificamos que los check esten marcados para procesar la afiliacion
            if($request->input('activarplan'.$checkplan->id) != null){
                
                $procesado = new ProcesadosModel();
                $procesado->clientes_id              = $cliente->id;
                $procesado->estatus_id              = 5; ///estatus Venta
                $procesado->user_id                 =  \Auth::user()->username;
                $procesado->gt_tipificacion1_id     = 4; /// 6 pra venta exitosa
                $procesado->gt_tipificacion2_id     = 17; /// 6 pra venta exitosa
                $procesado->comentario              = "Venta MANUAL del producto Concretada exitosamente.";
                
                $procesado->plan_id                 = $checkplan->id;
                $procesado->suma_asegurada_id       = $request->input('suma_asegurada'.$checkplan->id);
                $procesado->tipo_pago               = $request->input('tipo_de_pago'.$checkplan->id);
                $procesado->monto_a_pagar           = $request->input('prima'.$checkplan->id); 
                $procesado->banco_domiciliado       = $request->input('banco'.$checkplan->id);  
                switch ($request->tipoinstrumentonewmanual){
                    case "A":
                    case "C":
                        $procesado->num_cuenta_asociar_inst_bancario_sinencriptar   = $request->instrumentonewmanual;
                        $procesado->tipo_cuenta_domiciliar                          = $request->tipoinstrumentonewmanual;
                        break;
                    case "VISA":
                    case "MASTERCARD":
                    case "DINERCLUB":                        
                        $procesado->tipo_tdc_domiciliar                             = $request->input('tipoinstrumentonewmanual');
                        $procesado->fecha_vencimiento_tdc_domiciliar                = $request->input('instrumentonewmanual');
                    break;                    
                }
                
                $procesado->save();                                        
                
                $vicidial = new VicidialRecordsModel();
                $vicidial->descripcion      = $request->identificador_llamada_prin;
                $vicidial->gt_procesados_id = $procesado->id;    
                 $vicidial->save();
            }
        }   
        $cliente->user_id = \Auth::user()->id;
        $cliente->save();
       
        \Session::flash('success', 'Activación de planes Manual, realizada correctamente.');
            return back();
        } catch (\Exception $e) {
            if(ClientesModel::where('n_cedula',$request->cedula)->exists()){
                $cliente = ClientesModel::where('n_cedula',$request->cedula)->first();
                ProcesadosModel::where('cliente_id',$cliente->id)->delete();
                $cliente->delete();
            }
            \Session::flash('error', 'Ocurrio un problema. ' . $e->getMessage());
            return back();
        }
    }
    
    public function indexNoContactos()
    {   
        $client = ClientesModel::where('user_id',\Auth::user()->id)->whereIn('estatus_id',[9,10])->get();
        return view('gestion.asignaciones.operador')->with(["clientes"=>$client,"type"=>"nocontacto"])->render();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function IndexAgendados()
    {
      return view('gestion.agendados.index')->with(["type"=>"agendados"]);
    }
    
    public function SearchAgendados(Request $request)
    {
        $data = array();
        $row = array();
        
        $client = ClientesModel::where('fecha_agendado',Carbon::createFromformat('d/m/Y',$request->fecha)->format('Y-m-d'))
            ->where('user_id',\Auth::user()->id)->where('estatus_id',6)->get();
        
        foreach($client as $key => $datos){
        
            $row["num"] = $key +1;
            $row["cedula"]      = $datos->n_cedula;
            $row["nombres"]     = $datos->nomb1." ". $datos->nomb2." ". $datos->ape1ld1." ". $datos->apelld2;
            $row["nacimiento"]  = Carbon::create($datos->fecha_de_nacimiento)->format('d/m/Y');
            $row["comentario"]  = $datos->RelationGestionados->isEmpty() != true ? $datos->RelationGestionados()->where('estatus_id',$datos->estatus_id)->get()->last()->comentario : "-";
            $row["acciones"] =  '<a class="btn btn-primary btn-sm" data-toggle="tooltip" 
                data-placement="top" title="Gestionar Cliente"
                href="'.route('gestion.show',[$datos->id,"agendados"]).'"><i class="fas fa-edit"></i></a>';
            $data[] = $row;
        }
        return json_encode($data);
    }
   
    public function store(Request $request,$id)
    {       
        //try{
        $cliente = ClientesModel::find($id);
        $cliente->apelld1                 = $request->apelld1;
        $cliente->apelld2                 = $request->apelld2;
        $cliente->apellcasada             = $request->apellcasada;
        $cliente->nomb1                   = $request->nomb1;
        $cliente->nomb2                   = $request->nomb2;
        $cliente->cd_sexo                 = $request->sexo;
        $cliente->fecha_de_nacimiento     = carbon::createFromFormat('d/m/Y',$request->fecha_de_nacimiento)->format('Y-m-d');        
        $cliente->cd_estado_hab           = $request->estado;
        
        
        ///almacenamiento direccion vieja
        /*$cliente->cd_edo_civil            = $request->cd_edo_civil;        
        $cliente->cd_estado_hab           = $request->estado_id;
        $cliente->cd_ciudad_hab           = $request->ciudad_id;
        $cliente->municipio_hab           = $request->municipio_id;
        $cliente->parroquia_hab           = $request->parroquia_id;
        $cliente->cd_urbanizsector_hab    = $request->urbanizacion_id;
        $cliente->codigo_postal_hab       = $request->codigo_postal_hab;
        $cliente->di_av_calle_hab         = $request->di_av_calle_hab;
        $cliente->di_casa_hab             = $request->di_casa_hab;   */        
        
        $cliente->cd_pais               = 29;
        $cliente->tp_vivienda           = 1;
        $cliente->tp_direccion          = 1;
        $cliente->cd_provincia          = 10;
        $cliente->cd_ciudad             = 1;
        $cliente->cd_zona               = 129;       
        $cliente->tp_telefono           = 3; ///celular
       
        $cliente->email_persol_tomador                    = $request->email_persol_tomador;
        $cliente->email_trabajo_u_ofici_tomador           = $request->email_trabajo_u_ofici_tomador;        
        $cliente->cd_area_num_telefono_habitacion_tomador = $request->cd_area_num_telefono_habitacion_tomador;
        $cliente->num_telefono_hab_tomador                = $request->num_telefono_hab_tomador;
        $cliente->cd_area_num_telefono_trab_ofic_tomador  = $request->cd_area_num_telefono_trab_ofic_tomador;
        $cliente->num_telefono_trab_ofic_tomador          = $request->num_telefono_trab_ofic_tomador;
        $cliente->num_celular_pers_tomador                = $request->num_celular_pers_tomador;
        $cliente->num_celular_trab_tomador                = $request->num_celular_trab_tomador;
        $cliente->estatus_id                              = 5; ///estatus Venta
      
        
        $planes = PlanesModel::where('active',1)->get();
        
        foreach($planes as $checkplan){
            ///recorremos los planes activados, y verificamos que los check esten marcados para procesar la afiliacion
            if($request->input('activarplan'.$checkplan->id) != null){
                
                $procesado = new ProcesadosModel();
                $procesado->clientes_id              = $id;
                $procesado->estatus_id              = 5; ///estatus Venta
                $procesado->user_id                 =  \Auth::user()->username;
                $procesado->gt_tipificacion1_id     = 4; /// 6 pra venta exitosa
                $procesado->gt_tipificacion2_id     = 17; /// 6 pra venta exitosa
                $procesado->comentario              = "Venta del producto Concretada exitosamente.";
                
                $procesado->plan_id                 = $checkplan->id;
                $procesado->suma_asegurada_id       = $request->input('suma_asegurada'.$checkplan->id);
                $procesado->tipo_pago               = $request->input('tipo_de_pago'.$checkplan->id);
                $procesado->monto_a_pagar           = $request->input('prima'.$checkplan->id); 
                $procesado->banco_domiciliado       = $request->input('banco'.$checkplan->id);  
                switch ($request->input('tipocuenta'.$checkplan->id)){
                    case "A":
                    case "C":
                        $procesado->num_cuenta_asociar_inst_bancario_sinencriptar   = $request->input('instrumento'.$checkplan->id); 
                        $procesado->tipo_cuenta_domiciliar                          = $request->input('tipocuenta'.$checkplan->id); 
                        break;
                    case "VISA":
                    case "MASTERCARD":
                    case "DINERCLUB":                        
                        $procesado->tipo_tdc_domiciliar                             = $request->input('tipocuenta'.$checkplan->id);
                        $procesado->fecha_vencimiento_tdc_domiciliar                = $request->input('instrumento'.$checkplan->id);
                    break;                    
                }
                
                $procesado->save();                                        
                
                $vicidial = new VicidialRecordsModel();
                $vicidial->descripcion      = $request->identificador_llamada_prin;
                $vicidial->gt_procesados_id = $procesado->id;    
                 $vicidial->save();
            }
        }   
        $cliente->user_id = \Auth::user()->id;
        $cliente->save();
       
        \Session::flash('success', 'Activación de planes, realizada correctamente.');
            return redirect()->route('gestion.index');
        /*} catch (\Exception $e) {
            \Session::flash('error', 'Ocurrio un problema. ' . $e->getMessage());
            return back();
        }*/
    }
    
    public function storeIncidencia(Request $request, $id) {
               
      //dd($request->all());
        try {
            $estatusAsignado = Tipificacion2Model::find($request->tipificacion2)->estatus_asignado;

            $cliente = ClientesModel::find($id);
            switch ($estatusAsignado) {
                case 6: ///3 para agendamiento
                    $agendado = carbon::createFromFormat('d/m/Y', $request->agendamiento)->format('Y-m-d');
                    break;
                default:
                    $agendado = null;
                    break;
            }

            $cliente->estatus_id        = $estatusAsignado;
            $cliente->fecha_agendado = $agendado;    
            $cliente->user_id           = \Auth::user()->id;
            $cliente->save();

            $procesado = new ProcesadosModel();
            $procesado->clientes_id              = $id;            
            $procesado->estatus_id              = $estatusAsignado;
            $procesado->fecha_agendado          = $agendado;
            $procesado->gt_tipificacion1_id     = $request->tipificacion1;
            $procesado->user_id                 = \Auth::user()->username;
            $procesado->comentario              = $request->comentario;
            $procesado->gt_tipificacion2_id     = $request->tipificacion2;
            $procesado->gt_tipificacion3_id     = $request->tipificacion3;
            $procesado->save();
            
            $vicidial = new VicidialRecordsModel();
            $vicidial->descripcion = $request->identificador_llamada;
            $vicidial->gt_procesados_id = $procesado->id;
            $vicidial->save();
            
            \Session::flash('success', 'Incidencia Registrada correctamente.');
            return redirect()->route('gestion.index');
        } catch (\Exception $e) {
            \Session::flash('error', 'Ocurrio un problema. ' . $e->getMessage());
            return back();
        }
    }
   
    public function show($id, $type) {
        $callid = null;
        $cliente = ClientesModel::find($id);

        switch ($cliente->estatus_id) {
            case 5:
                return abort(403, "No es posible procesar esta solicitud, Cliente con Emisión de Polizas generada");
                break;
            default:
                /*$urbanizacion = UrbanizacionModel::where('id', $cliente->cd_urbanizsector_hab)
                                ->where('parroquia_id', $cliente->parroquia_hab)
                                ->where('municipio_id', $cliente->municipio_hab)
                                ->where('ciudad_id', $cliente->cd_ciudad_hab)
                                ->where('estado_id', $cliente->cd_estado_hab)
                                ->where('codigo_postal', $cliente->codigo_postal_hab)->first();
                 */
                //$allestados = EstadosModel::pluck('estado', 'id');
                //$ciudad     = $urbanizacion->Relation_Urb_to_Ciudad()->pluck('nombre_ciudad', 'id');
                //$municipio  = $urbanizacion->Relation_Urb_to_Municipio()->pluck('nombre_municipio', 'id');
                //$parroquia  = $urbanizacion->Relation_Urb_to_Parroquia()->pluck('nombre_parroquia', 'id');
                //$urb        = UrbanizacionModel::where('id', $urbanizacion->id)->first();

                $tlf = CodigoTelefonosModel::where('active', 1)->pluck('codigo', 'codigo');
                $planes = PlanesModel::where('active', 1)->get();
                $estado = EstadosModel::where('active',1)->get();
                $banco = BancosModel::where('active', 1)                        
                        ->orderby('banco', 'ASC')->get();

                $tipificacion1 = Tipificacion1Model::where('active', 1)->pluck('descripcion', 'id');
                //substr($cliente->num_cuenta_asociar_inst_bancario_sinencriptar, 0,4)
                
                $frecuencias = config('app.tipo_de_pago');
                unset($frecuencias["A"], $frecuencias["T"]);
                
                return view('gestion.formulario.index')
                                ->with([
                                    "client" => $cliente,
                                    "estado" => $estado,
                                    // "estado" => $allestados,
                                    //"ciudad" => $ciudad,
                                    //"municipio" => $municipio,
                                    //"parroquia" => $parroquia,
                                    "cod" => $tlf,
                                    "planes" => $planes,
                                    "banco" => $banco,
                                    //"urbanizacion" => $urb,
                                    "tipificacion1" => $tipificacion1,
                                    "type" => $type,
                                    "callid" => $callid,
                                             "frecuencias" =>$frecuencias
                                ])->render();
                break;
        }
    }
       
    public function IndexVentas()
    {
        if(\Auth::user()->hasRole(["operador"])){
            $cliente = ClientesModel::where('estatus_id',5)->where('user_id',\Auth::user()->id)->get();
        }else{
            $cliente = ClientesModel::where('estatus_id',5)->get();
        }
        
        return view('gestion.ventas.index')->with([
            "client" => $cliente,
            "type" => "ventas"])->render();
    } 
    
    public function DeleteVentas(Request $request,$id){
      try{
        
        $cliente = ClientesModel::find($id);   
        $cliente->estatus_id = 13;
        
        $cedula     = $cliente->n_cedula;    
        $procesados = $cliente->RelationGestionados()->where('estatus_id',5)->count();
        
        $eliminado = new EliminadasModel();
        $eliminado->clientes_id     = $cliente->id;
        $eliminado->eliminado_por   = \Auth::user()->username;
        $eliminado->cometario_sup   = $request->razones." | Sistema: se Eliminaron ".$procesados." Ventas";
        $eliminado->estatus_id      = 13;
        $eliminado->save();
        
        $cliente->RelationGestionados()->where('estatus_id',5)
                ->update(['estatus_id'=>13,'comentario'=>'Venta Eliminada por '.\Auth::user()->username]);        
        $cliente->save();
        
        \Session::flash('success', 'Se ha eliminado correctamente las ventas del cliente: '.$cedula);
        return back();
      } catch (\exception $e){
         \Session::flash('error', 'Ocurrio un problema durante la eliminacion, '.$e->getMessage());
        return back(); 
      }
    }
    
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
    
    public function IndexConsolidado() {
        
        $init = carbon::now()->startofDay();        
        $end = $init->copy()->endofDay();
        
        $Initmonth = $init->copy()->startOfMonth();
        $endmonth = $Initmonth->copy()->endOfMonth();
        
        $planes = PlanesModel::all();
        $row = array();
        $data = array();
        
        foreach($planes as $key => $plan){
            $row["nro"] = $key+1;
            $row["nombre"] = $plan->nombre;
            
            $row["generadas"] = $plan->RelationGestionados()->where('estatus_id',5)
                    ->whereBetween('created_at',array($init->format('y-m-d H:i:s'),$end->format('y-m-d H:i:s')))->count();
            
            $row["globales"] = $plan->RelationGestionados()->where('estatus_id',5)
                ->whereBetween('created_at',array($Initmonth->format('y-m-d H:i:s'),$endmonth->format('y-m-d H:i:s')))->count();
            $data[] = $row;
        }
       
        return view('gestion.ventas.consolidado')->with(["data"=>$data]);
    }
    
    public function ShowConsolidado(request $request) {
        
        $init = carbon::createFromFormat('m/d/Y',$request->fecha)->startofDay();        
        $end = $init->copy()->endofDay();
        
        $Initmonth = $init->copy()->startOfMonth();
        $endmonth = $Initmonth->copy()->endOfMonth();
        
        $planes = PlanesModel::all();
        $row = array();
        $data = array();
        
        foreach($planes as $key => $plan){
            $row["nro"] = $key+1;
            $row["nombre"] = $plan->nombre;
            
            $row["generadas"] = $plan->RelationGestionados()->where('estatus_id',5)
                    ->whereBetween('created_at',array($init->format('y-m-d H:i:s'),$end->format('y-m-d H:i:s')))->count();
            
            $row["globales"] = $plan->RelationGestionados()->where('estatus_id',5)
                ->whereBetween('created_at',array($Initmonth->format('y-m-d H:i:s'),$endmonth->format('y-m-d H:i:s')))->count();
            $data[] = $row;
        }
        
        return json_encode($data);
    }
    
    //PERMITE GENERAR LA VISTA DEL BUSCADOR POR CEDULA/TELEFONO

    public function IndexBuscador(){
      
      return view('gestion.ventas.buscador');

    }

    //PERMITE TRAER LAS TIPIFICACIONES REALIZADAS POR EL USUARIO

    public function getTipificaciones(Request $request){

        //consultamos el nombre de usuario de la persona

        $user = User::select('username')->where('id',\Auth::user()->id)->first();

        $username = $user->username;
        
        //averiguamos el cliente_id segun la cedula o telefono enviado

        $cliente_id = null;

        if($request->n_cedula != null){

            if(ClientesModel::select('id')->where('n_cedula',$request->n_cedula)
             ->exists()){

        $cliente = ClientesModel::select('id')->where('n_cedula',$request->n_cedula)
        ->first();

                $cliente_id = $cliente->id;

       }

        }elseif($request->telefono != null){

            if(ClientesModel::select('id')->where('num_celular_pers_tomador',$request->telefono)
             ->orWhere('num_telefono_hab_tomador',$request->telefono)
             ->exists()){

             $cliente = ClientesModel::select('id')->where('num_celular_pers_tomador',$request->telefono)
             ->orWhere('num_telefono_hab_tomador',$request->telefono)
             ->first();

                $cliente_id = $cliente->id;
            }
        }

         $row = array();
        $data = array();

         $arrayDate = explode("-", $request->rango_fecha);
            $arrayBegin = explode("/", $arrayDate[0]);
            $begin = trim($arrayBegin[2]) . "-" . trim($arrayBegin[0]) . "-" . trim($arrayBegin[1]). " 00:00:00";
            $arrayEnd = explode("/", $arrayDate[1]);
            $end = trim($arrayEnd[2]) . "-" . trim($arrayEnd[0]) . "-" . trim($arrayEnd[1]). " 23:59:59";

        $procesados = ProcesadosModel::where('clientes_id',$cliente_id)->whereBetween('created_at', array("$begin","$end"))->get();

        $monto = array();
        
        foreach($procesados as $process){
            $row["cedula"] = $process->RelationCliente->n_cedula;
            $row["nombres"] = $process->RelationCliente->nomb1." ".$process->RelationCliente->nomb2." ".$process->RelationCliente->apelld1." ".$process->RelationCliente->apelld2;
            
           $row["fecha_nac"] = date("d/m/Y",strtotime($process->RelationCliente->fecha_de_nacimiento));           
           
           if($process->RelationCliente->email_persol_tomador != null){
            $row["email"] = $process->RelationCliente->email_persol_tomador;
           }else{
            $row["email"] = $process->RelationCliente->email_trabajo_u_ofici_tomador;
           }
           
           $row["telefonos"] = $process->RelationCliente->num_celular_pers_tomador ." ".$process->RelationCliente->num_telefono_hab_tomador;
           $row["operador"] = $process->user_id;           
           $row["fecha_llamada"] = date("d/m/Y H:i:s",strtotime($process->created_at));
           
           $row["tipi1"] = $process->RelationTipiifcacion1->descripcion;
           $row["tipi2"] = $process->RelationTipiifcacion2->descripcion;
           
           if($process->RelationTipificacion3 != null){
           $row["tipi3"] = $process->RelationTipificacion3->descripcion;
           }else{
            $row["tipi3"] = "-";
           }
                     
            if($process->estatus_id == 5){  
                $row["info_cuenta"] = $process->tipo_cuenta_domiciliar." -> ".substr($process->num_cuenta_asociar_inst_bancario_sinencriptar, 0,4)."****".substr($process->num_cuenta_asociar_inst_bancario_sinencriptar, 16,20);
                $concat = SumaAseguradaModel::find($process->suma_asegurada_id)->nombre." -> ".$process->monto_a_pagar;
                $row["primas_montos"] = $concat;
            } else {
                $row["primas_montos"] = "-";
                $row["info_cuenta"] = "-";
            }
                      
            $row["observaciones"] = $process->comentario;
            $data[] = $row;
        }

        return json_encode($data);

    }
}
