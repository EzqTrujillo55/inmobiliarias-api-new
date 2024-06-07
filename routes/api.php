<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PropertyController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register',[AuthController::class,'register']);

Route::middleware('auth:sanctum')->group(function () 
{
    Route::get('/user', [AuthController::class, 'getCurrentUser']);
    Route::post('logout',[AuthController::class,'logout']);    

    Route::group(['middleware' => ['can:manage_properties']], function () {
        Route::get('properties',                [PropertyController::class, 'index']);
        Route::post('properties',               [PropertyController::class, 'store']);
        Route::get('properties/{id}',           [PropertyController::class, 'show']);
        Route::post('properties/{id}',          [PropertyController::class, 'update']);
        Route::delete('properties/{id}',        [PropertyController::class, 'destroy']);
        Route::get('properties/restore/{id}',   [PropertyController::class, 'restore']);
    });


    Route::group(['middleware' => ['can:manage_roles']], function () {
        Route::get('roles',                         [RoleController::class, 'index']);
        Route::post('roles',                        [RoleController::class, 'store']);
        Route::get('roles/{id}',                    [RoleController::class, 'show']);
        Route::post('roles/{id}',                   [RoleController::class, 'update']);
        Route::post('roles/syncPermissions/{id}',   [RoleController::class, 'syncPermissionsToRole']);
    });

    Route::group(['middleware' => ['can:manage_permissions']], function () {
        Route::get('permissions',       [PermissionController::class, 'index']);
        Route::post('permissions',      [PermissionController::class, 'store']);
        Route::get('permissions/{id}',  [PermissionController::class, 'show']);
        Route::post('permissions/{id}', [PermissionController::class, 'update']);    
    });

    Route::group(['middleware' => ['can:manage_users']], function () {
        Route::get('users',                     [UserController::class, 'index']);
        Route::get('users/byRole/{role}',       [UserController::class, 'byRole']);
        Route::post('users/{id}',               [UserController::class, 'update']);
    });

});



