<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use jeremykenedy\LaravelRoles\Models\Role;
use Illuminate\Support\Facades\Session;
use App\Models\PasswordUpdate;
use Carbon\Carbon;
use App\Notifications\NewUser;
use App\Models\personal\PersonalModel;

class UsersController extends Controller
{
    public function __construct() {
        $this->middleware(['auth', 'verified']);
        $this->middleware('check.password')->except(['changePassword', 'checkCurrentPassword', 'checkNewPassword', 'updatePassword']);
    }
    
    public function index()
    {       
        $users = User::all();
        return view('users.index')->with(["users"=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Auth::user()->hasRole(['admin'])) {
            $roles = Role::orderBy('slug', 'asc')->pluck('name', 'id');
        } else {
            $roles = Role::where('slug', '<>', 'admin')->orderBy('slug', 'asc')->pluck('name', 'id');
        }
        
        return view('users.create')->with(["roles"=>$roles]);
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
            'name' => 'required',
            'username' => 'required|unique:users',
            'email' => 'email|required|unique:users'
        ]);
        $password = 'directagroup';        
        $user = new User();
        $user->name = ucfirst(strtolower($request->name));
        $user->cedula = $request->cedula;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $password;
        $user->estatus_id = 3;
        $user->save();       
               
        $user->attachRole($request->roles);
        
    try {
           /* $data = ['name' => $user->name, 'username' => $user->username, 'password' => $password];
            $mail = $user->notify(new NewUser($data));*/
            
            Session::flash('success', 'Usuario Generado Exitosamente.  la contraseña es: directagroup');
        } catch (\Exception $e) { // Using a generic exception
            Session::flash('warning', 'No se pudo enviar el email al usuario, la contraseña es: directagroup');
        }       
        
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $user = User::find($id);
        $roles = Role::orderBy('name', 'asc')->pluck('name','id');        
        $roleuser = array();
        foreach ($user->roles()->get() as $ru) {
            array_push($roleuser, $ru->id);            
        }
        
        return view("users.edit", ["roles" => $roles, 'user' => $user, 'roleuser' => $roleuser]);
    }
    
    public function update(Request $request, $id) {   
        
        //dd($request->all(),isset($request->resetpassword));
        $data = request()->validate([
            'name' => 'required',    
            'email' => 'email|required|unique:users,id,' . $id,     
            'estatus'=>'required'
        ]);
        $user = User::find($id);
        $user->name = ucfirst(strtolower($request->name));
        $user->cedula = $request->cedula;
        $user->email = $request->email;
        $user->estatus_id = $request->estatus;
        if(isset($request->resetpassword)){
            $user->password = "directagroup";
            $user->password_updated_at = null;       
        } 
        
        $user->save();  
        
        if ($request->filled('roles')){
            $user->roles()->sync($request->roles);
        }else{
            $user->detachAllRoles();
        }        
        \Session::flash('success', "El Usuario ha sido Actualizado Exitosamente.");
        return redirect()->route('users.index');
    }    
       
    public function remove($id){
        $user = User::findOrFail($id);        
        $user->delete();
        \Session::flash('success', "El Usuario ha sido movido a la papelera.");
        return redirect()->route('users.index');
    }
    
    public function removeIndex() {
        
        $users = User::onlyTrashed()->get();
        return view('users.remove')->with("users", $users);
    }
        
    public function destroy($id) {
      
        $user = User::withTrashed()->find($id);
        
        if(PersonalModel::where('cedula_empleado',$user->cedula)->exists()){
            
            $prs = PersonalModel::where('cedula_empleado',$user->cedula)->first();
            $prs->user_id = null;
            $prs->save();
        }        
          $user->forceDelete(); 
        
        \Session::flash('success', "El Usuario ha sido eliminado completamente de la plataforma.");
        return redirect()->route('users.remove.index');       
    }
    
    public function restore($id) {
      
        $user = User::withTrashed()->find($id)->restore();        
        
        \Session::flash('success', "El Usuario ha sido restaurado correctamente");
        return redirect()->route('users.remove.index');       
    }
    
    public function changePassword() {
        if (Session::has('password'))
            return response()->view('users/changepassword');
        else
            return redirect()->route('home');
    }
    
    public function checkNewPassword(Request $request) {
        if ($request->ajax()) {
            $lastPassword = PasswordUpdate::where('user_id', '=', \Auth::user()->id)->orderBy('id', 'desc')->take(config('app.lastpassword'))->get();
            if (count($lastPassword) > 0 && \Auth::user()->estatus_id != 3) {
                foreach ($lastPassword as $pass) {
                    if (\Hash::check($request->newpassword, $pass->password)) {
                        return 'false';
                    }
                }
                return 'true';
            } else {
                return 'true';
            }
        }
    }

    public function updatePassword(Request $request) {
        //\Session::flash('success', 'Su sdf contraseña fue actualizada exitosamente.');
        //    return redirect()->route('home');
        
        $this->validate($request, [
            //'currentpassword' => "required",
            'newpassword' => 'required',
        ]);

        $user = \Auth::user();

        //if ($request->currentpassword && !\Hash::check($request->currentpassword, Auth::user()->password)) {
        //    Session::flash('error', 'La contraseña actual no coincide con la que ingreso, intente de nuevo');
        //    return redirect()->back();
        //}
        $lastPassword = PasswordUpdate::where('user_id', '=', \Auth::user()->id)->orderBy('id', 'desc')->take(config('app.lastpassword'))->get();
        if (count($lastPassword) > 0 && \Auth::user()->estatus_id != 3) {
            foreach ($lastPassword as $pass) {
                if (\Hash::check($request->newpassword, $pass->password)) {
                    \Session::flash('error', 'La contraseña nueva no puede ser igual a las ultimas tres (03) que utilizaste, intente de nuevo');
                    return redirect()->back();
                }
            }
        } else {
            $user->estatus_id = 1;
        }
        $user->password = $request->newpassword;
        $user->password_updated_at = Carbon::now();
        $pwu = new PasswordUpdate();
        $pwu->password = $user->password;
        $pwu->user_id = \Auth::user()->id;
        $pwu->save();

        if ($user->save()) {
            \Session::forget('password');
            \Session::flash('success', 'Su contraseña fue actualizada exitosamente.');
            return redirect()->route('home');
        }
    }
    
    public function profile() {
        
        return view ('users.profile');
    }     
}
