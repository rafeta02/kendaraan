<?php

Route::view('/', 'landing/index')->name('landing');
Route::view('/features', 'landing/features')->name('features');
Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::post('users/parse-csv-import', 'UsersController@parseCsvImport')->name('users.parseCsvImport');
    Route::post('users/process-csv-import', 'UsersController@processCsvImport')->name('users.processCsvImport');
    Route::resource('users', 'UsersController');

    // Audit Logs
    Route::resource('audit-logs', 'AuditLogsController', ['except' => ['create', 'store', 'edit', 'update', 'destroy']]);

    // Unit
    Route::delete('units/destroy', 'UnitController@massDestroy')->name('units.massDestroy');
    Route::post('units/parse-csv-import', 'UnitController@parseCsvImport')->name('units.parseCsvImport');
    Route::post('units/process-csv-import', 'UnitController@processCsvImport')->name('units.processCsvImport');
    Route::resource('units', 'UnitController');

    // Sub Unit
    Route::delete('sub-units/destroy', 'SubUnitController@massDestroy')->name('sub-units.massDestroy');
    Route::post('sub-units/parse-csv-import', 'SubUnitController@parseCsvImport')->name('sub-units.parseCsvImport');
    Route::post('sub-units/process-csv-import', 'SubUnitController@processCsvImport')->name('sub-units.processCsvImport');
    Route::resource('sub-units', 'SubUnitController');

    // Satpam
    Route::delete('satpams/destroy', 'SatpamController@massDestroy')->name('satpams.massDestroy');
    Route::resource('satpams', 'SatpamController');

    // Driver
    Route::delete('drivers/destroy', 'DriverController@massDestroy')->name('drivers.massDestroy');
    Route::post('drivers/parse-csv-import', 'DriverController@parseCsvImport')->name('drivers.parseCsvImport');
    Route::post('drivers/process-csv-import', 'DriverController@processCsvImport')->name('drivers.processCsvImport');
    Route::resource('drivers', 'DriverController');

    // Kendaraan
    Route::delete('kendaraans/destroy', 'KendaraanController@massDestroy')->name('kendaraans.massDestroy');
    Route::post('kendaraans/parse-csv-import', 'KendaraanController@parseCsvImport')->name('kendaraans.parseCsvImport');
    Route::post('kendaraans/process-csv-import', 'KendaraanController@processCsvImport')->name('kendaraans.processCsvImport');
    Route::resource('kendaraans', 'KendaraanController');

    // Log Peminjaman
    Route::delete('log-peminjamen/destroy', 'LogPeminjamanController@massDestroy')->name('log-peminjamen.massDestroy');
    Route::post('log-peminjamen/media', 'LogPeminjamanController@storeMedia')->name('log-peminjamen.storeMedia');
    Route::post('log-peminjamen/ckmedia', 'LogPeminjamanController@storeCKEditorImages')->name('log-peminjamen.storeCKEditorImages');
    Route::resource('log-peminjamen', 'LogPeminjamanController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::get('user-alerts/read', 'UserAlertsController@read');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Pinjam
    Route::delete('pinjams/destroy', 'PinjamController@massDestroy')->name('pinjams.massDestroy');
    Route::resource('pinjams', 'PinjamController');

    // Proceed
    Route::delete('process/destroy', 'AdminAccController@massDestroy')->name('process.massDestroy');
    Route::post('process/accept', 'AdminAccController@acceptPengajuan')->name('process.accept');
    Route::get('process/choose-driver', 'AdminAccController@chooseDriver')->name('process.chooseDriver');
    Route::post('process/save-driver', 'AdminAccController@saveDriver')->name('process.saveDriver');
    Route::post('process/send-satpam', 'AdminAccController@sendSatpam')->name('process.sendSatpam');
    Route::post('process/borrowed', 'AdminAccController@telahDipinjam')->name('process.borrowed');
    Route::post('process/done', 'AdminAccController@selesai')->name('process.done');
    Route::post('process/reject', 'AdminAccController@reject')->name('process.reject');
    Route::resource('process', 'AdminAccController');

    Route::get('system-calendar', 'SystemCalendarController@index')->name('systemCalendar');
});
Route::group(['prefix' => 'profile', 'as' => 'profile.', 'namespace' => 'Auth', 'middleware' => ['auth']], function () {
    // Change password
    if (file_exists(app_path('Http/Controllers/Auth/ChangePasswordController.php'))) {
        Route::get('password', 'ChangePasswordController@edit')->name('password.edit');
        Route::post('password', 'ChangePasswordController@update')->name('password.update');
        Route::post('profile', 'ChangePasswordController@updateProfile')->name('password.updateProfile');
        Route::post('profile/destroy', 'ChangePasswordController@destroy')->name('password.destroyProfile');
    }
});
Route::group(['as' => 'frontend.', 'namespace' => 'Frontend', 'middleware' => ['auth']], function () {
    Route::get('/home', 'HomeController@index')->name('home');

    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::post('users/media', 'UsersController@storeMedia')->name('users.storeMedia');
    Route::post('users/ckmedia', 'UsersController@storeCKEditorImages')->name('users.storeCKEditorImages');
    Route::resource('users', 'UsersController');

    // Unit
    Route::delete('units/destroy', 'UnitController@massDestroy')->name('units.massDestroy');
    Route::resource('units', 'UnitController');

    // Sub Unit
    Route::delete('sub-units/destroy', 'SubUnitController@massDestroy')->name('sub-units.massDestroy');
    Route::resource('sub-units', 'SubUnitController');

    // Satpam
    Route::delete('satpams/destroy', 'SatpamController@massDestroy')->name('satpams.massDestroy');
    Route::resource('satpams', 'SatpamController');

    // Driver
    Route::delete('drivers/destroy', 'DriverController@massDestroy')->name('drivers.massDestroy');
    Route::resource('drivers', 'DriverController');

    // Kendaraan
    Route::delete('kendaraans/destroy', 'KendaraanController@massDestroy')->name('kendaraans.massDestroy');
    Route::resource('kendaraans', 'KendaraanController');

    // Log Peminjaman
    Route::delete('log-peminjamen/destroy', 'LogPeminjamanController@massDestroy')->name('log-peminjamen.massDestroy');
    Route::post('log-peminjamen/media', 'LogPeminjamanController@storeMedia')->name('log-peminjamen.storeMedia');
    Route::post('log-peminjamen/ckmedia', 'LogPeminjamanController@storeCKEditorImages')->name('log-peminjamen.storeCKEditorImages');
    Route::resource('log-peminjamen', 'LogPeminjamanController');

    // User Alerts
    Route::delete('user-alerts/destroy', 'UserAlertsController@massDestroy')->name('user-alerts.massDestroy');
    Route::resource('user-alerts', 'UserAlertsController', ['except' => ['edit', 'update']]);

    // Pinjam
    Route::delete('pinjams/destroy', 'PinjamController@massDestroy')->name('pinjams.massDestroy');
    Route::resource('pinjams', 'PinjamController');

    Route::get('frontend/profile', 'ProfileController@index')->name('profile.index');
    Route::post('frontend/profile', 'ProfileController@update')->name('profile.update');
    Route::post('frontend/profile/destroy', 'ProfileController@destroy')->name('profile.destroy');
    Route::post('frontend/profile/password', 'ProfileController@password')->name('profile.password');
});
