<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\SegurosMercantil\ClientesModel;
use App\Models\SegurosMercantil\LotesModel;
use App\Imports\SegurosMercantil\ClientesImport;
use App\Exports\DataClientesProcess;

class AdministrationController extends Controller
{

    public function FileClientesSave($file)
    {
        $name_file = time() . '_' . $file->getClientOriginalName();
        if (Storage::disk('clientesfiles')->put($name_file, file_get_contents($file->getRealPath()))) {
            return $name_file;
        } else {
            return false;
        }
    }

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

        $lotes = ClientesModel::select(DB::raw('count("lote_id") as conteos'), 'lote_id')->whereNotNull('lote_id')->groupby('lote_id')->get();

        return view('administration.deleted')->with(["lote" => $lotes]);
    }

    public function store(Request $request)
    {

        $identystorage = $this->FileClientesSave($request->archivo);
        Excel::import(new ClientesImport($request->archivo->getClientOriginalName(), $identystorage), request()->file('archivo'));

        return redirect()->back();
    }

    public function descargarIndex()
    {
        $lotes = LotesModel::all();

        foreach ($lotes as $key => $lote) {
            $lote->conteos = $lote->RelationClientes()->count();
            if ($lote->RelationClientes()->count() == 0) {
                $lote->delete();
            }
        }

        $lotes = LotesModel::all();
        return view('administration.download')->with(["lote" => $lotes]);
    }

    public function descargar(Request $request, $id)
    {
        $lote = LotesModel::find($id);
        switch ($request->type) {
            case 'origin':
                return Storage::disk('clientesfiles')->exists($lote->identificacion_storage) ? Storage::disk('clientesfiles')->download($lote->identificacion_storage) : abort(404, "Archivo no encontrado en el servidor");
                break;
            case 'processed':
                $data = Cache::remember('clientes_processed_' . $id, 60, function () use ($id) {
                    return ClientesModel::where('lote_id', $id)->get();
                });
                return Excel::download(new DataClientesProcess($data), 'clientes_processed.csv');
                break;
        }
    }

    public function destroy(Request $request)
    {
        try {
            foreach ($request->check as $lotes) {
                $lote = LotesModel::find($lotes);
                $lote->identificacion_storage !== null ?? Storage::disk('clientesfiles')->delete($lote->identificacion_storage);
                $lote->delete();
            }
            Session::flash('success', 'Registros ELiminados exitosamente.');
            return back();
        } catch (\Exception $e) {
            Session::flash('error', 'Ocurrio un problema. ' . $e->getMessage());
            return back();
        }
    }
}
