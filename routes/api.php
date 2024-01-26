<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
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

    //grupo de rotas para user
    Route::prefix('users')->group(function(){
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{user}', [UserController::class, 'show']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/{user}', [UserController::class, 'update']);
        Route::delete('/{user}', [UserController::class, 'destroy']);
        
        //dar permissões ao usuario
        Route::post('/{user}/give-role', [UserController::class, 'giveRole']);
    });

    Route::prefix('roles')->group(function(){
        Route::get('/', [RoleController::class, 'index']);

        //adicionar permissões a uma role
        Route::post('/{role}/add-permission', [RoleController::class, 'addPermission']);
    });

    Route::prefix('permissions')->group(function(){
        Route::get('/', [PermissionController::class, 'index']);
    });

});
