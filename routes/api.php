<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaliberController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeaponTypeController;
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

    Route::prefix('clubs')->group(function(){
        Route::get('/', [ClubController::class, 'index'])->middleware('permission:read-Club');
        Route::post('/', [ClubController::class, 'store'])->middleware('permission:create-Club');
        Route::put('/{club}', [ClubController::class, 'update'])->middleware('permission:update-Club');
        Route::delete('/{club}', [ClubController::class, 'destroy'])->middleware('permission:delete-Club');

        //rotas para tipos de armas
        Route::prefix('/{club}/weapon-types')->group(function(){
            Route::get('/', [WeaponTypeController::class, 'index'])->middleware('permission:read-Type');
            Route::post('/', [WeaponTypeController::class, 'store'])->middleware('permission:create-Type');
            Route::put('/{weaponType}', [WeaponTypeController::class, 'update'])->middleware('permission:update-Type');
            Route::delete('/{weaponType}', [WeaponTypeController::class, 'destroy'])->middleware('permission:delete-Type');
        });
    });

    route::prefix('calibres')->group(function(){
        Route::get('/', [CaliberController::class, 'index'])->middleware('permission:read-Caliber');
        Route::post('/', [CaliberController::class, 'store'])->middleware('permission:create-Caliber');
        Route::put('/{caliber}', [CaliberController::class, 'update'])->middleware('permission:update-Caliber');
        Route::delete('/{caliber}', [CaliberController::class, 'destroy'])->middleware('permission:delete-Caliber');
    });

});
