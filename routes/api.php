<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Etudiant;
use APp\Http\Controllers\resolutionController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//tsy mandeha
Route::post('/img', [AuthController::class, 'updateImage'])->middleware('auth:sanctum');

//mandeha
Route::post('/inscriptionEtudiant', [AuthController::class, 'InscriEtudiant']);

//mandeha
Route::post('/connexion', [AuthController::class, 'AuthentificationEtudiant']);

//mandeha
Route::put('/updateInfo', [AuthController::class, 'UpdateNomPrenom'])->middleware('auth:sanctum');

//mandeha
Route::put('/mdpupdate', [AuthController::class, 'UpdatePassword'])->middleware('auth:sanctum');

//mandeha
Route::delete('/supp',[AuthController::class, 'destroy'])->middleware('auth:sanctum');

//optionelle
Route::post('/demandeMdp',[AuthController::class, 'password_resset']);

//mandeha
Route::get('/take', [AuthController::class, 'index'])->middleware('auth:sanctum');

//route middleware
Route::get('/myInfo', [AuthController::class, 'myInfo']);

//tsy mety 
Route::get('/getOneUser/{id}', [AuthController::class, 'getOneUser']);


Route::post('/resolution', [resolutionController::class, 'resolution']);


