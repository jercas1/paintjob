<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PaintJobController;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('paintjob-create', [PaintJobController::class, 'create']);
Route::get('paintjob-get', [PaintJobController::class, 'get']);
Route::get('paintjob-mark-completed/{paint_job_id}', [PaintJobController::class, 'markCompleted']);
Route::get('paintjob-get-breakdown', [PaintJobController::class, 'getBreakDown']);
