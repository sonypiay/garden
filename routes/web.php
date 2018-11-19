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
// Route frontend
Route::get('/', 'Frontend\HomepageController@index')->name('homepage');

// customers
Route::group(['prefix' => 'customers'], function() {
  Route::get('/', function(){ return redirect()->route('accountcustomer_page'); });
  Route::get('/login', 'Frontend\Customers\LoginRegisterController@login')->name('loginpage_customer');
  Route::get('/register', 'Frontend\Customers\LoginRegisterController@register')->name('registerpage_customer');
  Route::post('/doRegister', 'Frontend\Customers\LoginRegisterController@doRegister');
  Route::post('/doLogin', 'Frontend\Customers\LoginRegisterController@doLogin');
  Route::get('/logout', 'Frontend\Customers\LoginRegisterController@logout')->name('logoutcustomer');

  Route::group(['prefix' => 'account'], function() {
    Route::get('/', 'Frontend\Customers\AccountCustomers@index')->name('accountcustomer_page');
    Route::get('/edit_profile', 'Frontend\Customers\AccountCustomers@editprofile')->name('editprofilecustomer_page');
    Route::get('/change_password', 'Frontend\Customers\AccountCustomers@change_password')->name('changepasswordcustomer_page');
    Route::get('/edit_email', 'Frontend\Customers\AccountCustomers@editemail')->name('editemailcustomer_page');
    Route::get('/edit_notelepon', 'Frontend\Customers\AccountCustomers@editnotelepon')->name('editteleponcustomer_page');

    Route::get('/rekeningbank', 'Frontend\Customers\AccountCustomers@rekeningbank')->name('rekeningbankcustomer_page');
    Route::get('/listrekeningbank', 'Frontend\Customers\AccountCustomers@listrekeningbank');
    Route::post('/addrekeningbank', 'Frontend\Customers\AccountCustomers@store_rekeningbank');
    Route::put('/edit_rekeningbank/{id}', 'Frontend\Customers\AccountCustomers@save_rekeningbank');
    Route::delete('hapusbank/{id}', 'Frontend\Customers\AccountCustomers@delete_rekeningbank');

    Route::put('/edit_profile', 'Frontend\Customers\AccountCustomers@saveprofile');
    Route::put('/change_password', 'Frontend\Customers\AccountCustomers@savepassword');
    Route::put('/edit_email', 'Frontend\Customers\AccountCustomers@saveemail');
    Route::put('/edit_notelepon', 'Frontend\Customers\AccountCustomers@savephone');
  });
});
// customers

// vendors
Route::group(['prefix' => 'vendor'], function() {
  Route::get('/', function(){ return redirect()->route('registerpage_vendor'); });
  Route::get('/register', 'Frontend\Vendor\LoginRegisterController@registerpage')->name('registerpage_vendor');
});
// vendors

// Route frontend

// Route Administrator
Route::group(['prefix' => 'cp'], function() {
  Route::get('/', function(){ return redirect( route('dashboard_admin') ); });
  Route::get('/dashboard', 'Administrator\DashboardController@index')->name('dashboard_admin');
  Route::get('/login', 'Administrator\LoginController@index')->name('loginadminpage');
  Route::get('/logout', 'Administrator\LoginController@logout')->name('logoutadminpage');
  Route::post('/login', 'Administrator\LoginController@dologin');

  // users
  Route::group(['prefix' => 'users'], function() {
    Route::get('/', 'Administrator\UsersController@index')->name('userspage');
    Route::get('/datausers', 'Administrator\UsersController@datauser');
    Route::post('/add', 'Administrator\UsersController@store');
    Route::put('/update/{id}', 'Administrator\UsersController@update');
  });
  // users

  Route::group(['prefix' => 'management'], function() {
    Route::group(['prefix' => 'bankpayment'], function() {
      Route::get('/', 'Administrator\BankPaymentController@index')->name('admin_bankpayment');
      Route::get('/banklist', 'Administrator\BankPaymentController@banklist');
      Route::post('/add', 'Administrator\BankPaymentController@store');
      Route::post('/update/{id}', 'Administrator\BankPaymentController@update');
      Route::delete('/delete/{id}', 'Administrator\BankPaymentController@destroy');
    });

    Route::group(['prefix' => 'bankcustomer'], function() {
      Route::get('/', 'Administrator\BankCustomerController@index')->name('admin_bankcustomer');
      Route::get('/banklist', 'Administrator\BankCustomerController@banklist');
      Route::post('/add', 'Administrator\BankCustomerController@store');
      Route::post('/update/{id}', 'Administrator\BankCustomerController@update');
      Route::delete('/delete/{id}', 'Administrator\BankCustomerController@destroy');
    });
  });
});
// Route Administrator
