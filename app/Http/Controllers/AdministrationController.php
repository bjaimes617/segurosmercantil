<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\SegurosMercantil\ClientesImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SegurosMercantil\ClientesModel;
use App\Models\SegurosMercantil\LotesModel;

class AdministrationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('administration.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function deleted()
    {
        $lotes = ClientesModel::select(DB::raw('count("lote_id") as conteos'), 'lote_id')->groupby('lote_id')->get();
        
        return view('administration.deleted')->with(["lote"=>$lotes]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request()->validate([
            'archivo' => 'required'
        ]);
       
        Excel::import(new ClientesImport($request->archivo->getClientOriginalName()), request()->file('archivo'));       
        
        return redirect()->back();
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
    public function destroy(Request $request)
    {
        try{
        foreach($request->check as $lotes){
            LotesModel::find($lotes)->delete();            
        }
         \Session::flash('success', 'Registros ELiminados exitosamente.');
            return back();
        } catch (\Exception $e) {
            \Session::flash('error', 'Ocurrio un problema. ' . $e->getMessage());
            return back();
        }
    }
}
