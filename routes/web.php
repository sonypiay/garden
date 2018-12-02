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

Route::group(['prefix' => 'discovery'], function() {
  Route::get('/', 'Frontend\DiscoveryVendor@index')->name('discoveryvendor_page');
  Route::get('/vendor/{id}', 'Frontend\DiscoveryVendor@selectvendor')->name('detailvendor_page');
  Route::get('/vendors', 'Frontend\DiscoveryVendor@discovervendor');
});

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
  Route::get('/login', 'Frontend\Vendor\LoginRegisterController@loginpage')->name('loginpage_vendor');
  Route::get('/register', 'Frontend\Vendor\LoginRegisterController@registerpage')->name('registerpage_vendor');
  Route::get('/logout', 'Frontend\Vendor\LoginRegisterController@logout')->name('logoutvendor');
  Route::post('/doregister', 'Frontend\Vendor\LoginRegisterController@doregister');
  Route::post('/dologin', 'Frontend\Vendor\LoginRegisterController@dologin');

  Route::group(['prefix' => 'account'], function() {
    Route::get('/', 'Frontend\Vendor\AccountVendor@index')->name('accountvendor_page');
    Route::get('/datavendor', 'Frontend\Vendor\AccountVendor@datavendor');

    Route::get('/edit_account', 'Frontend\Vendor\AccountVendor@settingpage')->name('editaccountvendor_page');
    Route::put('/edit_account', 'Frontend\Vendor\AccountVendor@saveaccount');

    Route::get('change_password', 'Frontend\Vendor\AccountVendor@change_password')->name('changepasswordvendor_page');
    Route::put('change_password', 'Frontend\Vendor\AccountVendor@savepassword');

    Route::get('/edit_email', 'Frontend\Vendor\AccountVendor@edit_email')->name('editemailvendor_page');
    Route::put('/edit_email', 'Frontend\Vendor\AccountVendor@saveemail');

    Route::get('/edit_notelepon', 'Frontend\Vendor\AccountVendor@edit_notelepon')->name('editteleponvendor_page');
    Route::put('/edit_mobileprivate', 'Frontend\Vendor\AccountVendor@save_mobileprivate');
    Route::put('/edit_mobilebusiness', 'Frontend\Vendor\AccountVendor@save_mobilebusiness');

    Route::get('/rekeningpencairan', 'Frontend\Vendor\AccountVendor@rekeningpencairan')->name('rekeningbankvendor_page');
    Route::get('/listrekeningbank', 'Frontend\Vendor\AccountVendor@listrekeningbank');
    Route::post('/addrekeningbank', 'Frontend\Vendor\AccountVendor@store_rekeningbank');
    Route::put('/edit_rekeningbank/{id}', 'Frontend\Vendor\AccountVendor@save_rekeningbank');
    Route::delete('/hapusbank/{id}', 'Frontend\Vendor\AccountVendor@delete_rekeningbank');

    Route::get('/brandinglogo', 'Frontend\Vendor\AccountVendor@brandinglogo')->name('brandinglogovendor_page');
    Route::post('/brandinglogo', 'Frontend\Vendor\AccountVendor@uploadlogo');
  });

  Route::group(['prefix' => 'portfolio'], function() {
    Route::get('/', 'Frontend\Vendor\PortfolioController@index')->name('vendorportfolio_page');
    Route::get('/list', 'Frontend\Vendor\PortfolioController@listportfolio');
    Route::post('/add', 'Frontend\Vendor\PortfolioController@store_portfolio');
    Route::put('/update/{id}', 'Frontend\Vendor\PortfolioController@save_portfolio');
  });
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
    Route::group(['prefix' => 'provinsi'], function() {
      Route::get('/', 'Administrator\ProvinsiController@index')->name('admin_provinsipage');
      Route::get('/data_provinsi', 'Administrator\ProvinsiController@data_provinsi');
      Route::post('/add', 'Administrator\ProvinsiController@store');
      Route::put('/update/{id}', 'Administrator\ProvinsiController@update');
      Route::delete('/delete/{id}', 'Administrator\ProvinsiController@destroy');
    });
    Route::group(['prefix' => 'kabupaten'], function() {
      Route::get('/', 'Administrator\KabupatenController@index')->name('admin_kabupatenpage');
      Route::get('/data_kabupaten', 'Administrator\KabupatenController@data_kabupaten');
      Route::post('/add', 'Administrator\KabupatenController@store');
      Route::put('/update/{id}', 'Administrator\KabupatenController@update');
      Route::delete('/delete/{id}', 'Administrator\KabupatenController@destroy');
    });
    Route::group(['prefix' => 'kecamatan'], function() {
      Route::get('/', 'Administrator\KecamatanController@index')->name('admin_kecamatanpage');
      Route::get('/data_kecamatan', 'Administrator\KecamatanController@data_kecamatan');
      Route::post('/add', 'Administrator\KecamatanController@store');
      Route::put('/update/{id}', 'Administrator\KecamatanController@update');
      Route::delete('/delete/{id}', 'Administrator\KecamatanController@destroy');
    });
  });
});
// Route Administrator
