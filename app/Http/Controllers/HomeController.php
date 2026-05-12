<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller {

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['auth', 'check.password']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        
        
        return view('home.index');
    }

    public function run() {
        $personal = \App\Models\personal\PersonalModel::all();       
        
        foreach ($personal as $rs) {           
            
           // dd($rs);
           
           if($rs->estatus_id == 4){//ingreso no efectivo pasa a situacion contractual como Pendiente por contrato y estatus abandono
                
                $rs->situacion_contractual = 7;
                $rs->estatus_id = 1;               
                 $rs->save();
                 
                 
            } else if($rs->estatus_id == 5){//ingreso no efectivo pasa a situacion contractual como Pendiente por contrato y estatus abandono
                
                $rs->situacion_contractual = 7;
                $rs->estatus_id = 6;               
                 $rs->save();
                 
                 
            } else if($rs->getoriginal('situacion_contractual') == 6){//abandono situacion contractual pasa a contratado.
               
                $rs->situacion_contractual = 1;
                $rs->save();
                
            } else {
                continue;
            }
         
            
            
           
            
        }
        //return view('home.index');
    }

}
