<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
    Route::post('users/media', 'UsersApiController@storeMedia')->name('users.storeMedia');
    Route::apiResource('users', 'UsersApiController');

    // Unit
    Route::apiResource('units', 'UnitApiController');

    // Sub Unit
    Route::apiResource('sub-units', 'SubUnitApiController');

    // Driver
    Route::apiResource('drivers', 'DriverApiController');

    // Kendaraan
    Route::apiResource('kendaraans', 'KendaraanApiController');

    // Log Peminjaman
    Route::post('log-peminjamen/media', 'LogPeminjamanApiController@storeMedia')->name('log-peminjamen.storeMedia');
    Route::apiResource('log-peminjamen', 'LogPeminjamanApiController');

    // Pinjam
    Route::apiResource('pinjams', 'PinjamApiController');
});
