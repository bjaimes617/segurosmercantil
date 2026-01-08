<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Api\ApiController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 * 
*/


Route::middleware(['auth:sanctum','activity'])->post('/Reporte/general/tipificaciones',[ ApiController::class, 'ReporteGeneral']);
Route::middleware(['auth:sanctum','activity'])->post('/Reporte/clientes',[ ApiController::class, 'ReporteClientes']);