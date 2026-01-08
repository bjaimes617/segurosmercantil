<?php

use App\Http\Controllers\UsersController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes(['verify' => true]);
Route::get('/'                               ,'LoginController@index')->name('login');
Route::post('/init'                          ,['uses'=>'LoginController@logininit','middleware' => 'throttle:4,2'])->name('loginin');
Route::get('/checkemail/{token?}/{email?}'   ,'LoginController@activeemail')->name('emailactive');
Route::post('/password/email'                ,['uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail' ,'middleware' => 'throttle:2,120'])->name('password.email');
Route::post("/check/password/{email}"        ,['uses' => 'Auth\ResetPasswordController@checkNewPassword'    ])->name('guest.checknewpassword');
Route::get("/password/reset/{email}/{token}/",['uses' => 'Auth\ResetPasswordController@showResetForm'       ])->name('password.reset.token');
Route::post("/password/reset"                ,['uses' => 'Auth\ResetPasswordController@reset'               ])->name('password.request');

Route::group(['middleware' => ['auth','activity']], function() {    
    
    Route::get('/home', 'HomeController@index')->name('home');
    //Route::get('/home/runing/', 'HomeController@run')->name('homerum');
    
    ///Permission
    Route::get('permissions/'               ,['uses' => 'PermissionsController@index'   ,'middleware' => 'permission:permissions.show'  ])->name('permissions.index');
    Route::get('permissions/create'         ,['uses' => 'PermissionsController@create'  ,'middleware' => 'permission:permissions.create'])->name('permissions.create');
    Route::post('permissions/create'        ,['uses' => 'PermissionsController@store'   ,'middleware' => 'permission:permissions.create'])->name('permissions.store');    
    Route::get('permissions/edit/{id}'      ,['uses' => 'PermissionsController@edit'    ,'middleware' => 'permission:permissions.edit'  ])->name('permissions.edit');
    Route::put('permissions/{id}/update/'   ,['uses' => 'PermissionsController@update'  ,'middleware' => 'permission:permissions.update'])->name('permissions.update');
    Route::delete('permissions/delete/{id}/',['uses' => 'PermissionsController@destroy' ,'middleware' => 'permission:permissions.delete'])->name('permissions.destroy');
    
    ///Roles
    Route::get('roles/'                 ,['uses' => 'RolesController@index'      ,'middleware' => 'permission:roles.show'  ])->name('roles.index');
    Route::get('roles/create'           ,['uses' => 'RolesController@create'     ,'middleware' => 'permission:roles.create'])->name('roles.create');
    Route::post('roles/create'          ,['uses' => 'RolesController@store'      ,'middleware' => 'permission:roles.create'])->name('roles.store');
    Route::get('roles/edit/{id}'        ,['uses' => 'RolesController@edit'       ,'middleware' => 'permission:roles.edit'  ])->name('roles.edit');
    Route::put('roles/update/{id}'      ,['uses' => 'RolesController@update'     ,'middleware' => 'permission:roles.update'])->name('roles.update');    
    Route::delete('roles/remove/{id}/'  ,['uses' => 'RolesController@remove'     ,'middleware' => 'permission:roles.remove'])->name('roles.remove');
    Route::get('roles/deleted/list'     ,['uses' => 'RolesController@indexRemove','middleware' => 'permission:roles.delete'])->name('roles.remove.index');
    Route::post('roles/delete/{id}/'    ,['uses' => 'RolesController@destroy'    ,'middleware' => 'permission:roles.delete'])->name('roles.destroy');
    Route::get('roles/recovery/{id}/'   ,['uses' => 'RolesController@restore'    ,'middleware' => 'permission:roles.restore'])->name('roles.restore');
    
   ///users    
    Route::get('usuarios/',                     [UsersController::class,'index'                   ])->middleware('permission:view.users')->name('users.index');
    Route::post('usuarios/search/permissions/', [UsersController::class,'SearchPermissionsUsers'  ])->middleware('permission:view.users')->name('users.permissions.search');        
    Route::get('usuarios/create',               [UsersController::class,'create'                  ])->middleware('permission:create.users')->name('users.create');
    Route::post('usuarios/add/permissions/',    [UsersController::class,'AddPermissionsAditionals'])->middleware('permission:create.users')->name('users.permissions.add');        
    Route::post('usuarios/create',              [UsersController::class,'store'                   ])->middleware('permission:create.users')->name('users.store');
    Route::get('usuarios/edit/{id}',            [UsersController::class,'edit'                    ])->middleware('permission:edit.users')->name('users.edit');
    Route::put('usuarios/update/{id}',          [UsersController::class,'update'                  ])->middleware('permission:update.users')->name('users.update');
    Route::delete('usuarios/remove/{id}/',      [UsersController::class,'remove'                  ])->middleware('permission:remove.users')->name('users.remove');
    Route::get('usuarios/remove',               [UsersController::class,'removeIndex'             ])->middleware('permission:remove.users')->name('users.remove.index');
    Route::delete('usuarios/delete/{id}/',      [UsersController::class,'destroy'                 ])->middleware('permission:delete.users')->name('users.destroy');
    Route::get('usuarios/recovery/{id}/',       [UsersController::class,'restore'                 ])->middleware('permission:restore.users')->name('users.restore');  
    
    Route::post('usuarios/administracion/tokens',               [UsersController::class,'StoreTokens'             ])->middleware('permission:view.users')->name('users.tokens.store');
    Route::post('usuarios/administracion/list/token',           [UsersController::class,'ShowTokens'              ])->middleware('permission:view.users')->name('users.tokens.show');
    Route::delete('usuarios/administracion/tokens/delete/{id}/',[UsersController::class,'DeleteTokens'            ])->middleware('permission:view.users')->name('users.tokens.delete');
    
    Route::get('usuarios/profiles/',            [UsersController::class,'profile'                ])->name('users.profile');
    Route::get('/usuarios/change',              [UsersController::class,'changePassword'         ])->name('users.change');
//Reinicio de contraseña para usuarios autenticados
    Route::post("usuarios/checkcurrentpassword",    [UsersController::class,'checkCurrentPassword'   ])->name('users.checkcurrentpassword');
    Route::post("usuarios/checknewpassword",        [UsersController::class,'checkNewPassword'       ])->name('users.checknewpassword');
    Route::post("usuarios/password",                [UsersController::class,'updatePassword'         ])->name('users.password.update');
        
    
    
    
    Route::get('Administracion/index'          ,['uses' => 'AdministrationController@index'        ])->name('administration.index');
    Route::post('Administracion/store'         ,['uses' => 'AdministrationController@store'        ])->name('administration.store');
    
    Route::get('Administracion/deleted'        ,['uses' => 'AdministrationController@deleted'        ])->name('administration.deleted');
    Route::post('Administracion/deleted'       ,['uses' => 'AdministrationController@destroy'        ])->name('administration.deleted');
    
    Route::get('gestion/clientes/{cedula}/callid/{callid}'       ,['uses' => 'SegurosMercantil\VicidialController@index' ])->name('vicidial.index');
     
    Route::get('Gestion/Generar/venta/manual'               ,['uses' => 'SegurosMercantil\GestionController@IndexManual' ])->name('gestion.manual'); 
    Route::post('Gestion/Gcheck/cedula/ventamanual'          ,['uses' => 'SegurosMercantil\GestionController@ValidateCedulaManual' ])->name('check.cedula.manual'); 
    Route::post('Gestion/Generar/venta/manual'              ,['uses' => 'SegurosMercantil\GestionController@StorexManual' ])->name('gestion.manual.store'); 
     
    //// GESTION - AGENDADO
    Route::get('Gestion/clientes/agendados'                 ,['uses' => 'SegurosMercantil\GestionController@IndexAgendados' ])->name('gestion.agendados');
    Route::post('Gestion/clientes/search/agendados'         ,['uses' => 'SegurosMercantil\GestionController@SearchAgendados' ])->name('gestion.agendados.search');
    
    Route::get('Gestion/clientes/asignar/clientes'          ,['uses' => 'SegurosMercantil\GestionController@indexAsignar' ])->name('gestion.asignar');
    Route::post('Gestion/clientes/asignar/clientes'         ,['uses' => 'SegurosMercantil\GestionController@StoreAsignar' ])->name('gestion.asignar.store');
    /// PRINCIPAL GESTION - INDEX
    Route::get('Gestion/clientes/index'                     ,['uses' => 'SegurosMercantil\GestionController@index' ])->name('gestion.index');
    Route::get('Gestion/clientes/show/{id}/{type?}'         ,['uses' => 'SegurosMercantil\GestionController@show' ])->name('gestion.show');
    Route::post('Gestion/clientes/incidencia/store/{id}'    ,['uses' => 'SegurosMercantil\GestionController@storeIncidencia' ])->name('gestion.store.incidencias');
    Route::post('Gestion/clientes/store/{id}'               ,['uses' => 'SegurosMercantil\GestionController@store' ])->name('gestion.store');
    ///GESTION - VENTAS
    Route::get('Gestion/clientes/ventas/'                   ,['uses' => 'SegurosMercantil\GestionController@IndexVentas' ])->name('gestion.ventas');
    Route::get('Gestion/clientes/nocontactos/'              ,['uses' => 'SegurosMercantil\GestionController@IndexNocontactos' ])->name('gestion.nocontactos');
    
    Route::delete('Gestion/clientes/eliminar/ventas/{id}'     ,['uses' => 'SegurosMercantil\GestionController@DeleteVentas' ])->name('gestion.ventas.eliminar');   
    
    Route::get('Gestion/consolidado/ventas/all'             ,['uses' => 'SegurosMercantil\GestionController@IndexConsolidado','middleware' => 'permission:consolidados.ventas' ])->name('consolidado.index');
    Route::post('Gestion/consolidado/ventas/all'            ,['uses' => 'SegurosMercantil\GestionController@ShowConsolidado' ])->name('consolidado.show');   
    
    Route::get('Reporteria/general/'                        ,['uses' => 'SegurosMercantil\ReportesController@index' ])->name('reportes.index');
    Route::post('Reporteria/general/'                       ,['uses' => 'SegurosMercantil\ReportesController@store' ])->name('reportes.store');
    
    Route::get('Reporteria/planes/txt'                      ,['uses' => 'SegurosMercantil\ReportesController@indexTxt' ])->name('reportes.txt');
    Route::post('Reporteria/general/planes/txt'             ,['uses' => 'SegurosMercantil\ReportesController@storeTxt' ])->name('reportes.store.txt');
    
    Route::get('Reporteria/planes/CSV'                      ,['uses' => 'SegurosMercantil\ReportesController@IndexCSV' ])->name('reportes.csv');
    Route::post('Reporteria/general/planes/CSV'             ,['uses' => 'SegurosMercantil\ReportesController@storeCSV' ])->name('reportes.store.csv');
    Route::post('Reporteria/general/clientes/CSV'           ,['uses' => 'SegurosMercantil\ReportesController@storeClientesCSV' ])->name('reportes.store.clientes.csv');
    
    ///selectores de estado municipio, parroquia y demas
    Route::post('gestion/search/domicilio'          ,['uses' => 'SegurosMercantil\FindsController@index'        ])->name('gestion.search.domicilio');
    ///calcula el monto de la prima 
    Route::post('gestion/set/prima/planes'          ,['uses' => 'SegurosMercantil\FindsController@CalculoPrimas'])->name('gestion.search.prima');
    
    ///busqueda del arbol
    Route::post('gestion/get/tipificaciones/'       ,['uses' => 'SegurosMercantil\FindsController@Tipificaciones'])->name('gestion.tipificaciones.search');
        Route::post('gestion/get/tipificaciones3/'       ,['uses' => 'SegurosMercantil\FindsController@Tipificaciones3'])->name('mercantil.tipificacion3');
       
       //rutas para el buscador de tipificaciones por cedula/telefono
    Route::get('gestion/buscador/tipificaciones'                      ,['uses' => 'SegurosMercantil\GestionController@IndexBuscador' ])->name('buscador.index');
    Route::post('gestion/buscador/tipificaciones/search'        ,['uses' => 'SegurosMercantil\GestionController@getTipificaciones'])->name('tipificacion.show');

        ///log Activity 
    Route::get('logout',['uses' => 'Auth\LoginController@logout'])->name('logout');
    
});