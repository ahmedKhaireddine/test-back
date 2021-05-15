<?php

use App\Http\Controllers\Auth\SigninController;
use App\Http\Controllers\AvailabilityController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\CancelBookingController;
use App\Http\Controllers\DoctorController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:api')->group(function () {
    Route::apiResource('bookings', BookingController::class)
    ->only(['index', 'store']);

    Route::get(
        '/bookings/{bookingId}/cancel',
        CancelBookingController::class
    )->name('booking_canceled')
    ->where(['bookingId' => '[0-9]+']);
});

Route::apiResource('doctors', DoctorController::class)->only(['index']);

Route::apiResource(
    '/doctors/{doctorId}/availabilities',
    AvailabilityController::class
)->only(['index'])
->names(['index' => 'doctor_availabilities.index'])
->where(['doctorId' => '[0-9]+']);

Route::post('signin', [SigninController::class, 'authenticate']);
