<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CaliberController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\HabitualityController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WeaponController;
use App\Http\Controllers\WeaponModelController;
use App\Http\Controllers\WeaponTypeController;
use App\Http\Controllers\ClubUserController;
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
        Route::get('/', [RoleController::class, 'index'])->middleware('permission:view-Permission');

        //adicionar permissões a uma role
        Route::post('/{role}/add-permission', [RoleController::class, 'addPermission'])->middleware('permission:toggle-Permission');
    });

    Route::prefix('permissions')->group(function(){
        Route::get('/', [PermissionController::class, 'index']);
        Route::put('/{permission}', [PermissionController::class, 'update'])->middleware('permission:update-Permission');
    });

    Route::resource('my-club', ClubUserController::class);

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

        //rotas para modelos de armas
        Route::prefix('/{club}/weapon-models')->group(function(){
            Route::get('/', [WeaponModelController::class, 'index'])->middleware('permission:read-Model');
            Route::post('/', [WeaponModelController::class, 'store'])->middleware('permission:create-Model');
            Route::put('/{weaponModel}', [WeaponModelController::class, 'update'])->middleware('permission:update-Model');
            Route::delete('/{weaponModel}', [WeaponModelController::class, 'destroy'])->middleware('permission:delete-Model');
        });

        //rotas para calibres
        Route::prefix('/{club}/calibres')->group(function(){
            Route::get('/', [CaliberController::class, 'index'])->middleware('permission:read-Caliber');
            Route::post('/', [CaliberController::class, 'store'])->middleware('permission:create-Caliber');
            Route::put('/{caliber}', [CaliberController::class, 'update'])->middleware('permission:update-Caliber');
            Route::delete('/{caliber}', [CaliberController::class, 'destroy'])->middleware('permission:delete-Caliber');
            Route::get('/{caliber}', [CaliberController::class, 'show']);
        });

        //rotas para eventos
        Route::prefix('/{club}/events')->group(function(){
            Route::get('/', [EventController::class, 'index'])->middleware('permission:read-Event');
            Route::post('/', [EventController::class, 'store'])->middleware('permission:create-Event');
            Route::put('/{event}', [EventController::class, 'update'])->middleware('permission:update-Event');
            Route::delete('/{event}', [EventController::class, 'destroy'])->middleware('permission:delete-Event');
            Route::get('/{event}', [EventController::class, 'show']);
        });

        //rotas para locais
        Route::prefix('/{club}/locations')->group(function(){
            Route::get('/', [LocationController::class, 'index'])->middleware('permission:read-Location');
            Route::post('/', [LocationController::class, 'store'])->middleware('permission:create-Location');
            Route::put('/{location}', [LocationController::class, 'update'])->middleware('permission:update-Location');
            Route::delete('/{location}', [LocationController::class, 'destroy'])->middleware('permission:delete-Location');
        });

        //rotas para habitualidades
        Route::prefix('/{club}/habitualities')->group(function(){
            Route::get('/', [HabitualityController::class, 'index'])->middleware('permission:read-Habituality');
            Route::post('/', [HabitualityController::class, 'store'])->middleware('permission:create-Habituality');
            Route::put('/{habituality}', [HabitualityController::class, 'update'])->middleware('permission:update-Habituality');
            Route::delete('/{habituality}', [HabitualityController::class, 'destroy'])->middleware('permission:delete-Habituality');
        });
        
    });

    //rotas para armas
    Route::prefix('/weapons')->group(function(){
        Route::get('/', [WeaponController::class, 'index'])->middleware('permission:read-Weapon');
        Route::post('/', [WeaponController::class, 'store'])->middleware('permission:create-Weapon');
        Route::put('/{weapon}', [WeaponController::class, 'update'])->middleware('permission:update-Weapon');
        Route::delete('/{weapon}', [WeaponController::class, 'destroy'])->middleware('permission:delete-Weapon');
    });

    //rotas para habitualidades
    // Route::prefix('/habitualities')->group(function(){
    //     Route::get('/', [HabitualityController::class, 'index'])->middleware('permission:read-Habituality');
    //     Route::post('/', [HabitualityController::class, 'store'])->middleware('permission:create-Habituality');
    //     Route::put('/{habituality}', [HabitualityController::class, 'update'])->middleware('permission:update-Habituality');
    //     Route::delete('/{habituality}', [HabitualityController::class, 'destroy'])->middleware('permission:delete-Habituality');
    // });

});
