<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ZktecoController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('zkteco_index');
});

Route::get('/connexion', [ZktecoController::class, 'ConnexionMethod']);
Route::get('/presence_employes', [ZktecoController::class, 'PresenceEmployes']);
Route::get('/action_test_zkteco', [ZktecoController::class, 'ListeAction']);
Route::get('/action_test_zkteco/restart', [ZktecoController::class, 'Restart']);
Route::get('/action_test_zkteco/shutdown', [ZktecoController::class, 'Shutdown']);

Route::get('/action_test_zkteco/alarm', [ZktecoController::class, 'Alarm']);
Route::get('/getAttendance', [ZktecoController::class, 'Attendance']);
Route::post('/ajout-de-employe', [ZktecoController::class, 'AddUser']);
Route::delete('/supprimer-employe/{employeId}', [ZktecoController::class, 'SupprimerEmploye']);
Route::get('/action', [ZktecoController::class, 'Action']);
Route::post('/modifier-employe/{id}', [ZktecoController::class, 'ModifierEmploye']);
Route::post('/set-time', [ZktecoController::class, 'SetTime']);