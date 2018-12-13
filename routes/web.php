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
Route::get('/tentang_kami', 'Frontend\HomepageController@aboutus')->name('aboutus');
Route::get('/login', 'Frontend\HomepageController@loginpage')->name('loginpage');
Route::get('/join', 'Frontend\HomepageController@signuppage')->name('signuppage');
Route::post('/sendmessage', 'Frontend\MessagesController@sendmessage');
Route::get('/premium', 'Frontend\HomepageController@premium')->name('premium');
Route::get('/premium_checkout', 'Frontend\HomepageController@premium_checkout');
Route::get('/complete_payment_premium/{orderid}', 'Frontend\HomepageController@complete_payment_premium');

Route::group(['prefix' => 'discovery'], function() {
  Route::get('/', 'Frontend\DiscoveryVendor@index')->name('discoveryvendor_page');
  Route::get('/vendor/{id}', 'Frontend\DiscoveryVendor@selectvendor')->name('detailvendor_page');
  Route::get('/vendor/portfolio/{id}', 'Frontend\DiscoveryVendor@portfolio_vendor');
  Route::get('/vendors', 'Frontend\DiscoveryVendor@discovervendor');
  Route::get('/vendor/portfolio_image/{id}', 'Frontend\DiscoveryVendor@view_portfolio_image');
});
Route::get('/booking/{name}', 'Frontend\Customers\BookingTransactionController@bookingpage');
Route::post('/booking_process', 'Frontend\Customers\BookingTransactionController@bookingprocess');
Route::put('/booking_checkout/{orderid}', 'Frontend\Customers\BookingTransactionController@booking_checkout');
Route::get('/edit_booking/{orderid}', 'Frontend\Customers\BookingTransactionController@editbooking_page');
Route::post('/edit_booking/{orderid}', 'Frontend\Customers\BookingTransactionController@editbooking');
// customers
Route::group(['prefix' => 'customers'], function() {
  Route::get('/', function(){ return redirect()->route('accountcustomer_page'); });
  Route::get('/login', 'Frontend\Customers\LoginRegisterController@login')->name('loginpage_customer');
  Route::get('/register', 'Frontend\Customers\LoginRegisterController@register')->name('registerpage_customer');
  Route::post('/doRegister', 'Frontend\Customers\LoginRegisterController@doRegister');
  Route::post('/doLogin', 'Frontend\Customers\LoginRegisterController@doLogin');
  Route::get('/logout', 'Frontend\Customers\LoginRegisterController@logout')->name('logoutcustomer');
  Route::get('/lupa_password', 'Frontend\Customers\LoginRegisterController@lupapassword')->name('lupapasswordcustomer_page');
  Route::post('/checkemail', 'Frontend\Customers\LoginRegisterController@checkemail');
  Route::get('/change_password', 'Frontend\Customers\LoginRegisterController@change_password');
  Route::put('/reset_password', 'Frontend\Customers\LoginRegisterController@reset_password');

  Route::get('/order_list', 'Frontend\Customers\BookingTransactionController@order_list')->name('customerorderlist_page');
  Route::get('/data_orderlist', 'Frontend\Customers\BookingTransactionController@data_orderlist');
  Route::get('/summary_order/{orderid}', 'Frontend\Customers\BookingTransactionController@summary_order')->name('summaryordercustomer_page');
  Route::get('/view_summaryorder/{orderid}', 'Frontend\Customers\BookingTransactionController@view_summaryorder');
  Route::get('/summary_transaction', 'Frontend\Customers\BookingTransactionController@mytransaction');
  Route::get('/main_orders/{orderid}', 'Frontend\Customers\BookingTransactionController@main_orders')->name('customermainorder_page');
  Route::get('/process_checkout/{orderid}', 'Frontend\Customers\BookingTransactionController@booking_process_checkout')->name('process_checkout_page');
  Route::put('/confirmreport/{orderid}', 'Frontend\Customers\BookingTransactionController@confirmreport');

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
  Route::get('/lupa_password', 'Frontend\Vendor\LoginRegisterController@lupapassword')->name('lupapasswordvendor_page');
  Route::post('/checkemail', 'Frontend\Vendor\LoginRegisterController@checkemail');
  Route::get('/change_password', 'Frontend\Vendor\LoginRegisterController@change_password');
  Route::put('/reset_password', 'Frontend\Vendor\LoginRegisterController@reset_password');

  Route::get('/order_list', 'Frontend\Vendor\BookingTransactionController@index')->name('orderlistvendor_page');
  Route::get('/data_orderlist', 'Frontend\Vendor\BookingTransactionController@data_orderlist');
  Route::get('/summary_order/{orderid}', 'Frontend\Vendor\BookingTransactionController@summary_order')->name('summaryordervendor_page');
  Route::put('/order_approval/{orderid}', 'Frontend\Vendor\BookingTransactionController@approval_order');
  Route::put('/process_order/{orderid}', 'Frontend\Vendor\BookingTransactionController@process_order');
  Route::put('/progress_order/{orderid}', 'Frontend\Vendor\BookingTransactionController@progress_order');
  Route::post('/createreport/{orderid}', 'Frontend\Vendor\BookingTransactionController@createreport');

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

    Route::get('/withdraw', 'Frontend\Vendor\WithdrawController@withdraw_page')->name('withdrawvendor_page');
    Route::post('/withdraw', 'Frontend\Vendor\WithdrawController@process_withdraw');

    Route::get('/premium', 'Frontend\Vendor\AccountVendor@premium')->name('vendorpremium_page');
    Route::get('/getpremium', 'Frontend\Vendor\AccountVendor@getpremium');
  });

  Route::group(['prefix' => 'portfolio'], function() {
    Route::get('/', 'Frontend\Vendor\PortfolioController@index')->name('vendorportfolio_page');
    Route::get('/view/{id}', 'Frontend\Vendor\PortfolioController@detail_portfolio')->name('vendordetailportfolio_page');
    Route::get('/view/{id}/list', 'Frontend\Vendor\PortfolioController@portfolio_image');
    Route::get('/list', 'Frontend\Vendor\PortfolioController@listportfolio');
    Route::post('/add', 'Frontend\Vendor\PortfolioController@store_portfolio');
    Route::post('/add/image', 'Frontend\Vendor\PortfolioController@store_portfolio_image');
    Route::put('/update/{id}', 'Frontend\Vendor\PortfolioController@save_portfolio');
    Route::post('/update/image/{id}', 'Frontend\Vendor\PortfolioController@save_portfolio_image');
    Route::delete('/delete/{id}', 'Frontend\Vendor\PortfolioController@delete_portfolio');
  });

  Route::group(['prefix' => 'message'], function() {
    Route::get('/', 'Frontend\Vendor\MessagesVendor@index')->name('messagevendor_page');
    Route::get('/message_list', 'Frontend\Vendor\MessagesVendor@messagelist');
    Route::get('/readmessage/{msgid}', 'Frontend\Vendor\MessagesVendor@readmessage');
  });
});
// vendors

// Route frontend

// Route Administrator
Route::group(['prefix' => 'cp'], function() {
  Route::get('/', function(){ return redirect( route('dashboard_admin') ); });
  Route::get('/login', 'Administrator\LoginController@index')->name('loginadminpage');
  Route::get('/logout', 'Administrator\LoginController@logout')->name('logoutadminpage');
  Route::post('/login', 'Administrator\LoginController@dologin');
  Route::get('/dashboard', 'Administrator\DashboardController@index')->name('dashboard_admin');

  Route::group(['prefix' => 'vendor'], function() {
    Route::get('/', 'Administrator\VendorsController@index')->name('admin_vendorpage');
    Route::get('/list', 'Administrator\VendorsController@list');
  });

  Route::group(['prefix' => '/analytic'], function() {
    Route::get('/allusers', 'Administrator\DashboardController@total_vendor_customer');
    Route::get('/total_transaction', 'Administrator\DashboardController@total_current_analytic_transaction');
    Route::get('/activity_transaction', 'Administrator\DashboardController@analytic_activity_transaction');
    Route::get('/withdraw', 'Administrator\DashboardController@analytic_withdraw');
  });

  Route::group(['prefix' => '/transaction'], function() {
    Route::get('/order_list', 'Administrator\BookingOrdersController@index')->name('orderlist_admin');
    Route::get('/data_orderlist', 'Administrator\BookingOrdersController@data_orderlist');
    Route::get('/view_transaction/{orderid}', 'Administrator\BookingOrdersController@view_transaction');
    Route::put('/update_order/{orderid}', 'Administrator\BookingOrdersController@update');
    Route::get('/report', 'Administrator\ReportsController@order_transaction');
  });

  // users
  Route::group(['prefix' => 'users'], function() {
    Route::get('/', 'Administrator\UsersController@index')->name('userspage');
    Route::get('/datausers', 'Administrator\UsersController@datauser');
    Route::post('/add', 'Administrator\UsersController@store');
    Route::put('/update/{id}', 'Administrator\UsersController@update');
  });
  // users

  Route::group(['prefix' => 'withdraw'], function() {
    Route::get('/', 'Administrator\WithdrawTransactionController@index')->name('admin_withdraw');
    Route::get('/list', 'Administrator\WithdrawTransactionController@data_withdraw');
    Route::put('/approval/{ticket}', 'Administrator\WithdrawTransactionController@approval_withdraw');
  });

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
