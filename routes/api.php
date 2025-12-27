<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Species;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Add your new routes here:
Route::get('/species', function () {
    return Species::all();
});

Route::get('/species/{id}', function ($id) {
    return Species::with('records')->find($id);
});