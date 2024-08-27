<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   return response()->json([
        'status' => 'success',
        'data' => [
            'foo' => 'bar'
        ],
        'message' => 'Hello World'
    ], 500);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
