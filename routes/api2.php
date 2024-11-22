<?php

use App\Http\Controllers\API\DashboardController;

use App\Http\Controllers\API\DeliveryController;
use App\Http\Controllers\API\OrderinforController;
use App\Http\Controllers\API\PickuprequestController;
use App\Http\Controllers\API\ProblemController;
use App\Http\Controllers\API\RegisterController;
use App\Http\Controllers\API\ReportController;
use App\Http\Controllers\API\ShopController;
use App\Http\Controllers\Api\SupplierController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*Forget Password Api*/
Route::post('otp-send', [UserController::class, 'otp_send']);
Route::post('forget-password', [UserController::class, 'forget_password']);

Route::post('login', [UserController::class, 'login']);
Route::post('register-merchant', [UserController::class, 'register_merchant']);
Route::post('rider-registration', [RegisterController::class, 'rider_register']);

Route::group(['middleware' => 'auth:api'], function () {
    Route::post('details', 'Api\UserController@details');
});


Route::group(['middleware' => 'auth:api'], function () {

    // Route::get('{userIdentifier?}', 'UsersController@getUsers');

    Route::post('delete-my-id', [UserController::class, 'deleteID']);
});


/*Public Order store Api*/

Route::post('add-parcel', [OrderinforController::class, 'parcel_store']);

Route::get('reason-category', [OrderinforController::class, 'reason_category']);

/*callback*/
Route::post('callback', [OrderinforController::class, 'callback']);


Route::group(['middleware' => 'auth:api'], function () {

    //Route::post('details', 'Api\UserController@details');
    Route::get('business-type-list', [OrderinforController::class, 'business_type_list']);
    Route::post('return-order-store', [OrderinforController::class, 'return_order_store']);
    Route::post('reschedule-order-store', [OrderinforController::class, 'reschedule_order_store']);
    Route::post('partial-order-store', [OrderinforController::class, 'partial_order_store']);
    Route::post('exchange-order-store', [OrderinforController::class, 'exchange_order_store']);
    Route::get('return-request', [OrderinforController::class, 'return_request']);
    //Merchant
    Route::get('datewise-create-order-list', [OrderinforController::class, 'datewise_create_order_list']);
    Route::get('datewise-delivery-order-list', [OrderinforController::class, 'datewise_delivery_order_list']);
    Route::get('datewise-return-order-list', [OrderinforController::class, 'datewise_return_order_list']);
    Route::get('datewise-transit-order-list', [OrderinforController::class, 'datewise_transit_order_list']);


    Route::get('hub-wise-area', [OrderinforController::class, 'hub_wise_area']);

    Route::get('get-merchant-info', [OrderinforController::class, 'merchant_info']);
    Route::get('get-merchant-info', [OrderinforController::class, 'merchant_info']);
    Route::post('pick-up-request', [OrderinforController::class, 'pickup_request']);
    Route::post('payment-request', [OrderinforController::class, 'payment_request']);

    Route::get('confirm_orders', [OrderinforController::class, 'confirmorder_datewise']);
    Route::get('confirm-orders-list', [OrderinforController::class, 'confirm_orders_list']);
    Route::get('search-orders-list', [OrderinforController::class, 'search_orders_list']);
    Route::get('last-invoice', [OrderinforController::class, 'last_invoice']);
    Route::get('slider-list', [OrderinforController::class, 'slider_list']);
    Route::post('slider-store', [OrderinforController::class, 'slider_store']);
    Route::post('payment-info-add', [OrderinforController::class, 'payment_info_add']);
    Route::get('order-view', [OrderinforController::class, 'order_view']);
    Route::get('showshoplist', [ShopController::class, 'showshoplist']);
    Route::post('shop_store', [ShopController::class, 'store']);
    Route::post('shop_edit', [ShopController::class, 'edit']);
    Route::get('shop-status', [ShopController::class, 'shop_status']);
    Route::get('merchantdashboard', [DashboardController::class, 'merchantdashboard']);
    Route::get('merchantdashboard-test', [DashboardController::class, 'merchantdashboard']);
    Route::get('merchantdashboard-list', [DashboardController::class, 'merchantdashboard_list']);
    Route::get('invoice-wise-payment-detail', [DashboardController::class, 'invoice_wise_payment']);


    Route::post('orderstor', [OrderinforController::class, 'orderstore']);
    //Merchant view n update bank info
    Route::get('merchant-info', [UserController::class, 'merchant_info']);
    Route::post('user-bank-update', [UserController::class, 'user_bank_update']);
    Route::post('merchant-info-update', [UserController::class, 'info_update']);
    Route::post('merchant-profile-update', [UserController::class, 'merchant_update']);


    Route::get('employees', [UserController::class, 'employees']);
    Route::post('create-employee', [UserController::class, 'employee_register']);
    Route::get('employee-status', [UserController::class, 'employee_status']);
    Route::get('return-history', [OrderinforController::class, 'return_history_datewise']);
    Route::get('return-history-details', [OrderinforController::class, 'return_history_details']);

    // Route::post('asifmanq', [OrderinforController::class, 'asifmanq']);

    Route::get('return-history-report', [OrderinforController::class, 'return_history_datewise']);



    //Payment Repost
    Route::post('payment-history', [OrderinforController::class, 'merchant_Collect_report']);
    Route::get('payment-history-details-merchant', [OrderinforController::class, 'merchant_payment_history_details_report']);


    //Complain
    Route::get('problems', [ProblemController::class, 'problems']);
    Route::get('merchant-complains', [ProblemController::class, 'merchant_complains']);
    Route::post('merchant-complain-submit', [ProblemController::class, 'merchant_complain_store']);


    Route::post('changePassword', [UserController::class, 'changePassword']);
    Route::post('logout', [UserController::class, 'logout']);

    //Merchant Utils

    Route::get('showorder', [OrderinforController::class, 'showorder']);


    //Rider

    Route::get('user-info', [UserController::class, 'userInfo']);
    Route::get('payment-history-rider', [OrderinforController::class, 'rider_Collect_report']);


    Route::post('rider-return', [OrderinforController::class, 'rider_return']);

    Route::post('rider-return-confirm', [OrderinforController::class, 'rider_return_confirm']);


    Route::get('pickupdashboard', [DashboardController::class, 'pickupdashboard']);
    //Pickup
    Route::get('pickupreq', [PickuprequestController::class, 'pickupreq']);
    Route::get('Collect', [PickuprequestController::class, 'Collect']);
    Route::get('cancel', [PickuprequestController::class, 'cancel']);

    Route::get('rider-today-delivered', [PickuprequestController::class, 'rider_today_delivered_data']);

    Route::get('rider-monthly-delivered', [PickuprequestController::class, 'rider_monthly_delivered_data']);

    //Delivery
    Route::get('deliveryAssign', [DeliveryController::class, 'deliveryAssign']);
    Route::get('hold-reschedule', [DeliveryController::class, 'hold_and_reschedule']);
    Route::post('rider_code_check', [DeliveryController::class, 'code_check']);
    Route::post('rider_code_resend', [DeliveryController::class, 'code_resend']);
    Route::post('delivered', [DeliveryController::class, 'delivered']);
    Route::post('deliveredOption', [DeliveryController::class, 'deliveredOption']);
    Route::post('partialDelivery', [DeliveryController::class, 'partialDelivery']);
    //Return
    Route::get('return_order', [ReportController::class, 'return_list']);
    Route::post('rider_return_confirm', [OrderinforController::class, 'rider_return_merchant']);
    Route::get('rider_return_details', [OrderinforController::class, 'rider_return_details']);

    //Transfer
    Route::get('transfer_order', [ReportController::class, 'transfer_list']);
    Route::post('rider_transfer_confirm', [OrderinforController::class, 'rider_transfer_to']);
    Route::get('rider_transfer_details', [OrderinforController::class, 'rider_transfer_details']);

    //Report
    Route::get('collect_order', [ReportController::class, 'collect_order']);
    Route::post('order-report-status', [ReportController::class, 'order_report_status']);
    Route::post('transfer_order_report', [ReportController::class, 'transfer_orderReport']);
    Route::post('return_datewise', [ReportController::class, 'return_datewise']);

    // Delivered 

    Route::post('/order-delivered', [OrderinforController::class, 'deliveredc']);



    Route::get('/pick-up-request-assign/list/auto', [OrderinforController::class, 'list_auto']);
    Route::post('/pick-up-request-assign/list/auto', [OrderinforController::class, 'list_auto']);
    Route::post('/pick-up-request-assign/collect/auto', [OrderinforController::class, 'collect_auto']);
    Route::post('/pick-up-request-assign/collect-all/auto', [OrderinforController::class, 'collectAll_auto']);



    //
    Route::get('resetPass', [UserController::class, 'resetPass']);
});

/*----- Live Tracking------*/
Route::get('order-live-tracking', [OrderinforController::class, 'order_live_tracking']);
//Otp Sent
Route::get('resetOtpCodeSend', [UserController::class, 'resetOtpCodeSend']);

// Route::group(['middleware' => 'auth:api'], function() {
// });

Route::get('weights', [ShopController::class, 'weights']);
Route::get('zone_list', [ShopController::class, 'zoneList']);
Route::get('distList', [ShopController::class, 'distList']);
Route::get('orderDatas', [ShopController::class, 'orderDatas']);
Route::get('gee', [ShopController::class, 'gee']);
Route::get('dist-area', [ShopController::class, 'dist_wise_areaList']);


Route::get('pickUpTime', [ShopController::class, 'pickUpTime']);

Route::get('category', [ShopController::class, 'category']);

Route::post('otp_login', [UserController::class, 'otp_login']);

Route::post('otp_verification', [UserController::class, 'otp_verification']);
//Old


//Route::get('rider_print/{id}', 'Api\ReportController@rider_print');



// Route::get('preview', 'Api\OrderinforController@preview');

// Route::get('coverageArealist', [ShopController::class, 'coverageArealist']);

/* this CoverageAreaList api local server working  but live server not working */
Route::get('/coverageArealist', [SupplierController::class, 'coverageArealist']);

/* this CoverageAreaList api live server working */
Route::get('/coverage-area', [ShopController::class, 'CoverageAreaLists']);




// Route::get('pending', 'Api\DeliveryController@pending');

// Route::get('showuser', 'Api\UserController@showuser');




// Route::get('admindashboard', 'Api\DashboardController@adminDashboard');

// Route::get('reportmerchant', 'Api\ReportController@reportmerchant');

// Route::get('customertrack', 'Api\CustomerController@customertrack');

// Route::get('pickreport', 'Api\ReportController@pickreport');



// Route::get('index', 'Api\DeliveryController@index');

// Route::post('shopadd', 'Api\ShopaddController@shopadd');




// Route::post('confirmorder', 'Api\OrderinforController@confirmorder');

// Route::get('draftorder', 'Api\DraftorderController@draftorder');

// Route::get('draftshow/{id}', 'Api\DraftorderController@draftshow');

// Route::put('draftupdete/{id}', 'Api\DraftorderController@draftupdete');

// // Route::get('showshoplist', [ShopController::class, 'showshoplist']);


// // order
// Route::get('status-wise', 'Api\OrderinforController@statuswise');

// //Rider
// Route::get('collect_order', 'Api\ReportController@collect_order');
// Route::get('delivery_confirm', 'Api\ReportController@delivery_confirm');


// //Problem
// Route::get('problem', 'Api\ProblemController@index');

// //Complain
// Route::get('complain', 'Api\ProblemController@complain');
// Route::get('complain_create', 'Api\ProblemController@complainCreate');
// Route::post('complain_submit', 'Api\ProblemController@store');

// Route::get('merchant_complain/{id}', 'Api\ProblemController@merchant_complain_view');
// Route::get('merchant_complain_create/{id}', 'Api\ProblemController@merchant_complain_create');
// Route::post('merchant_complain_submit', 'Api\ProblemController@merchant_complain_store');
