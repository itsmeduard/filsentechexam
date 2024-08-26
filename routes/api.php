<?php

use App\Http\Controllers\Api\V1\Admin\PermissionApiController;
use App\Http\Controllers\Api\V1\Admin\RoleApiController;
use App\Http\Controllers\Api\V1\Admin\TaskApiController;
use App\Http\Controllers\Api\V1\Admin\UserApiController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'v1', 'as' => 'api.', 'middleware' => ['auth:sanctum']], function () {
    // Permissions
    Route::apiResource('permissions', PermissionApiController::class);

    // Roles
    Route::apiResource('roles', RoleApiController::class);

    // Users
    Route::apiResource('users', UserApiController::class);

    // Task
    Route::apiResource('tasks', TaskApiController::class);
});
