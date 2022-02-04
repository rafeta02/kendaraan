<?php

Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:sanctum']], function () {
    // Users
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
    Route::apiResource('log-peminjamen', 'LogPeminjamanApiController');

    // Pinjam
    Route::apiResource('pinjams', 'PinjamApiController');
});
