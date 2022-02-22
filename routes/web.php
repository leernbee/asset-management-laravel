<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'WelcomeController@welcome')->name('home');

Auth::routes(['verify' => true, 'register' => false]);

Route::get('redirect', 'SocialAuthGoogleController@redirect');
Route::get('callback', 'SocialAuthGoogleController@callback');

Route::get('2fa/enable', 'SmsVerificationController@enableTwoFactor');
Route::get('2fa/disable', 'SmsVerificationController@disableTwoFactor');
Route::get('2fa/verify', 'SmsVerificationController@show')->name('smsVerify');
Route::post('2fa/verify', 'SmsVerificationController@verify')->name('smsVerify');

Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', 'DashboardController@index')->name('dashboard');

    Route::get('chart/machine-types', 'DashboardController@chartMachineTypes');
    Route::get('chart/software-types', 'DashboardController@chartSoftwareTypes');

    Route::get('profile', 'ProfileController@index')->name('profile');
    Route::patch('profile/{user}/update-profile', 'ProfileController@updateProfile')->name('profile.updateProfile');

    Route::get('preferences', 'PreferencesController@index')->name('preferences');
    Route::patch('preferences/{user}/update-username', 'PreferencesController@updateUsername')->name('preferences.updateUsername');
    Route::patch('preferences/{user}/update-email', 'PreferencesController@updateEmailAddress')->name('preferences.updateEmailAddress');
    Route::patch('preferences/{user}/update-password', 'PreferencesController@updatePassword')->name('preferences.updatePassword');
    Route::patch('preferences/{user}/close-account', 'PreferencesController@closeAccount')->name('preferences.closeAccount');

    Route::resource('roles', 'RoleController');
    Route::resource('permissions', 'PermissionController');
    Route::resource('users', 'UserController');
    Route::resource('machines', 'MachineController');
    Route::resource('machine-types', 'MachineTypeController');
    Route::resource('operating-systems', 'OperatingSystemController');
    Route::resource('status', 'StatusController');
    Route::resource('locations', 'LocationController');

    Route::get('machines/{machine}/checkin', 'MachineController@checkinview')->name('machines.checkinview');
    Route::get('machines/{machine}/checkout', 'MachineController@checkoutview')->name('machines.checkoutview');
    Route::post('machines/checkout', 'MachineController@checkout')->name('machines.checkout');
    Route::post('machines/checkin', 'MachineController@checkin')->name('machines.checkin');

    Route::get('reports/activity', 'ReportController@activity')->name('reports.activity');
    Route::get('reports/activity/export', 'ReportController@export')->name('reports.activityExport');
    Route::get('reports/activity/json', 'ReportController@activityJson')->name('reports.activityJson');

    Route::resource('software-types', 'SoftwareTypeController');
    Route::resource('licenses', 'LicenseController');

    Route::get('licenses/{license}/uninstall', 'LicenseController@uninstallview')->name('licenses.uninstallview');
    Route::get('licenses/{license}/install', 'LicenseController@installview')->name('licenses.installview');
    Route::post('licenses/uninstall', 'LicenseController@uninstall')->name('licenses.uninstall');
    Route::post('licenses/install', 'LicenseController@install')->name('licenses.install');

    Route::resource('requests', 'UserRequestController');
    Route::get('work-orders', 'UserRequestController@workOrders')->name('workOrder');
    Route::post('work-orders', 'UserRequestController@updateWorkOrders')->name('workOrder.update');

    Route::get('messages/{id}', 'ChatsController@fetchMessages');
    Route::post('messages', 'ChatsController@sendMessage');

    Route::get('mark-as-read', 'DashboardController@markAsRead')->name('markAsRead');
});
