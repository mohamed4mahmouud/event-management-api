<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('v1')->group(function(){
    Route::apiResource('/Events', EventController::class);
    Route::apiResource('events.attendees', AttendeeController::class)->scoped(['attendee' => ' event']);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
