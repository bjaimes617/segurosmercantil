<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Support\Facades\Session;

class PermissionsController extends Controller
{
   public function __construct() {
        $this->middleware(['auth','verified','check.password']);
    }
    
    public function index()
    {
         $permissions = Permission::all();
        return view('permissions.index')->with('permission',$permissions);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
         return view('permissions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:permissions',
            'descripcion' => 'required'
        ]);
         
        $permission = new Permission();
        $permission->name = $request->name;
        $permission->slug = $request->slug; // optional
        $permission->description = $request->descripcion; // optional
        $permission->save();
        Session::flash('success', "La información fue registrada exitosamente.");
        
        return redirect(route('permissions.index'));
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
        $permission = Permission::find($id);
        return view("permissions.edit")->with("permission",$permission);
        
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
         $this->validate($request, [
            'name' => 'required',
            'slug' => 'required|unique:permissions,id,'.$id,
            'descripcion' => 'required'
        ]);
        $permission = Permission::find($id);
        $permission->name = $request->name;
        $permission->slug = $request->slug; // optional
        $permission->description = $request->descripcion; // optional
        $permission->save();
        
        Session::flash('success', "El permiso fue actualizado exitosamente");
        
        return redirect(route('permissions.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();        
        \Session::flash('success', "El permiso Seleccionado ha sido eliminado de la plataforma");        
        return redirect(route('permissions.index'));
        
    }
}
