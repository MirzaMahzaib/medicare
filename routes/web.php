<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/login');
Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.home')->with('status', session('status'));
    }

    return redirect()->route('admin.home');
});

Auth::routes(['register' => false]);

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Purchase Invoice
    Route::delete('purchaseinvoice/destroy', 'PruchaseInvoiceController@massDestroy')->name('purchaseinvoice.massDestroy');
    Route::resource('purchaseinvoice','PruchaseInvoiceController');

    // Purchases
    Route::delete('purchases/destroy', 'PurchasesController@massDestroy')->name('purchases.massDestroy');
    Route::resource('purchases','PurchasesController');

    // stocks
    Route::delete('stocks/destroy', 'StockController@massDestroy')->name('stocks.massDestroy');
    Route::resource('stocks','StockController');

    // products
    Route::delete('products/destroy', 'ProductController@massDestroy')->name('products.massDestroy');
    Route::resource('products','ProductController');

    // sales
    Route::delete('sales/destroy', 'ProductController@massDestroy')->name('sales.massDestroy');
    Route::resource('sales','SaleController');
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
