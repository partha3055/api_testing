<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/user', function () {
    return "Hello World";
});

Route::post('/user', function () {
    return response()->json("Post request hit successfully");
});

Route::delete('/user/{id}', function ($id) {
    return response("Delete " . $id, 200);
});

Route::put('/user/{id}', function ($id) {
    return response("Put " . $id, 200);
});