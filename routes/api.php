<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('login', [AuthController::class, 'login']);
Route::post('logout', [AuthController::class, 'logout']);

Route::middleware('jwt.verify')->group(function () {
    Route::post('register', [AuthController::class, 'register']);

    //dar permissões ao usuario
    Route::post('user/{user}/give-permission', [UserController::class, 'givePermission']);

    //adicionar permissões a uma role
    Route::post('/role/{role}/add-permission', 'RoleController@addPermission');

    Route::get('/test', function () {
        return response()->json(['message' => 'Você está autenticado!'], 200);
    })->middleware('permission:create-post');
});
