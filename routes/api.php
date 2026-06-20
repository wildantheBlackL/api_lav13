<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Utama;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get("/cekstatus", [Utama::class, "statusAPI"]);
Route::post("/backup", [Utama::class, "backupData"]);
Route::get('/heartbeat-test', [Utama::class, 'kirim']);