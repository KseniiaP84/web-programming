
<?php

use App\Http\Controllers\PlaceController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/health', function () {
    return response()->json([
        'status' => 'OK',
        'timestamp' => now(),
    ]);
})->name('health');

Route::prefix('places')->name('places.')->group(function () {

    Route::get('/', [PlaceController::class, 'index'])
        ->name('index');

    Route::post('/', [PlaceController::class, 'store'])
        ->middleware('place.owner')
        ->name('store');

    Route::get('/{id}', [PlaceController::class, 'show'])
        ->whereNumber('id')
        ->name('show');

    Route::put('/{id}', [PlaceController::class, 'update'])
        ->whereNumber('id')
        ->name('update');

    Route::delete('/{id}', [PlaceController::class, 'destroy'])
        ->whereNumber('id')
        ->name('destroy');
});
