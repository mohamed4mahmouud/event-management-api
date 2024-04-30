<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function(){
    Route::apiResource('/events', EventController::class);
    Route::apiResource('events.attendees', AttendeeController::class)->scoped()->except('update');
    Route::post('/login', [AuthController::class ,'login']);
    Route::post('/logout' , [AuthController::class , 'logout'])->middleware('auth:sanctum');
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
