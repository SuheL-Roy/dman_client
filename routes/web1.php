<?php

use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\AgentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\AjaxDataController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\PaymentController;
use App\Http\Controllers\Api\ProblemController;
use App\Http\Controllers\Backend\Auth\MerchantRegistrationController;
use App\Http\Controllers\BranchsDistrictController;
use App\Http\Controllers\CategoryController as ControllersCategoryController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ComplainController;
use App\Http\Controllers\DeliveryAssignController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\Frontend\FrontendController as FrontendFrontendController;
use App\Http\Controllers\FrontEndController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MerchantAdvancePaymentController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\OrderReportController;
use App\Http\Controllers\OrderStatusHistoryController;
use App\Http\Controllers\OrderTrackingController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\PaymentInfoController;
use App\Http\Controllers\PickUpRequestAssignController;
use App\Http\Controllers\PickUpTimeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RiderController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WeightPriceController;
use App\Http\Controllers\ZoneController;




Auth::routes();



Route::get('/inactive', 'FrontEndController@inactive')->middleware('auth')->name('inactive');

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::get('/pickup-destroy', [HomeController::class, 'pickup_destroy'])->name('pickup_destroy')->middleware('auth');
Route::get('/payment-reject', [HomeController::class, 'payment_reject'])->name('payment_reject')->middleware('auth');
Route::post('/payment-rejects', [HomeController::class, 'payment_rejects'])->name('payment_rejects')->middleware('auth');
Route::post('/payment-destroy', [HomeController::class, 'payment_destroy'])->name('payment_destroy')->middleware('auth');
Route::post('/store-pickup-request', [HomeController::class, 'pickup_request'])->name('pickup_request')->middleware('auth');
Route::get('/get-pickup-address', [HomeController::class, 'pickup_address'])->name('pickup_address')->middleware('auth');
Route::get('/pickup-request-list', [HomeController::class, 'pickup_request_list'])->name('pickup_request_list')->middleware('auth');
Route::get('/payment-request-list', [HomeController::class, 'payment_request_list'])->name('payment_request_list')->middleware('auth');
Route::post('/store-payment-request', [HomeController::class, 'payment_request'])->name('payment_request')->middleware('auth');

//------------------ Admin Panel Login -----------------
Route::get('admin-panel-login', [AdminPanelController::class, 'login'])->name('admin.panel.login');
Route::get('admin-panel-registration', [AdminPanelController::class, 'registration'])->name('admin.panel.register');
Route::get('edit-exclusive', [AdminPanelController::class, 'editEx'])->name('exclusive.editex');
Route::get('exclusive-edit', [AdminPanelController::class, 'edit_exclusive'])->name('edit.exclusive');
Route::post('update', [AdminPanelController::class, 'updateEx'])->name('exclusive.update');
Route::post('admin-panel-registration', 'AdminPanelController@regis_tration')->name('admin.panel.registration');
Route::get('change-password', 'AdminPanelController@change_password')->middleware('auth')->name('change.password');
Route::get('changepassword', 'AdminPanelController@changePassword')->middleware('auth')->name('changePassword');
Route::post('change/password', 'AdminPanelController@changepass_word')->middleware('auth')->name('change.old.password');
Route::post('change-new-password', 'AdminPanelController@change_pass_word')->middleware('auth')->name('change.new.password');
Route::get('admin-panel-logout', [AdminPanelController::class, 'logout'])->name('admin.panel.logout');

//------------------ Admin Panel Registration -----------------
Route::prefix('admin-panel/')->middleware('auth')->name('admin.panel.')->group(function () {
    Route::get('admin', 'AdminPanelController@admin')->name('admin');
    Route::get('manager', 'AdminPanelController@manager')->name('manager');
    Route::get('agent-dashboard', [AgentController::class, 'dashboard'])->name('agent.dashboard');
    Route::get('agent-dashboard-new', [AgentController::class, 'dashboard_new'])->name('agent.dashboard.new');
    Route::get('agent-incharge-dashboard', [AgentController::class, 'incharge_dashboard'])->name('agent.incharge_dashboard');
    Route::get('manager-dashboard', [AdminPanelController::class, 'manager_dashboard'])->name('manager.dashboard');
    Route::get('manager-dashboards', [AdminPanelController::class, 'manager_dashboards'])->name('manager.dashboards');
    Route::get('super-admin-dashboard-today', [AdminPanelController::class, 'super_dashboard'])->name('super.dashboard');
    Route::get('super-admin-dashboard-total', [AdminPanelController::class, 'super_dashboard_total'])->name('super.dashboard.total');
    Route::get('super-admin-dashboard-new', [AdminPanelController::class, 'super_dashboard_new'])->name('super.dashboard.new');
    Route::get('accounts', 'AdminPanelController@accounts')->name('accounts');
    Route::get('callCenter', 'AdminPanelController@callCenter')->name('callCenter');
});


//------------------ Admin Panel Registration -----------------
Route::prefix('merchant-panel/')->middleware('auth')->name('merchant.panel.')->group(function () {
   
    Route::get('merchant-dashboard', [AgentController::class, 'merchant_dashboard'])->name('merchant_dashboard');
   
});

//-------------------------- Company ------------------------
Route::prefix('company/')->middleware('auth')->name('company.')->group(function () {
    Route::get('index', [CompanyController::class, 'index'])->name('index');
    Route::post('store', [CompanyController::class, 'store'])->name('store');
    Route::get('edit', [CompanyController::class, 'edit'])->name('edit');
    Route::post('update', [CompanyController::class, 'update'])->name('update');
});

//------------------ Agent Registration -----------------
Route::get('branch-registration', [AdminPanelController::class, 'agent_register'])->name('agent.register');
Route::post('branch-registration', [AdminPanelController::class, 'agent_regis_ter'])->name('agent.registration');

//------------------ Rider Registration -----------------
Route::get('rider-registration', [AdminPanelController::class, 'rider_register'])->name('rider.register');
Route::post('rider-registration', [AdminPanelController::class, 'rider_regis_ter'])->name('rider.registration');

//------------------ Merchant Profile & Payment -----------------
Route::prefix('merchant/')->middleware('auth')->name('merchant.')->group(function () {
    Route::get('profile-update', 'HomeController@profile')->name('profile.updation');
    Route::post('profile-update', [HomeController::class, 'profile_update'])->name('profile.update');
    Route::post('merchant-profile-update', [HomeController::class, 'merchant_profile_update'])->name('merchant_profile_update');
    Route::post('image-update', 'HomeController@image_update')->name('image.update');
    Route::get('info', 'PaymentInfoController@payment_info')->name('payment.info');
    Route::post('info-update', 'PaymentInfoController@payment_update')->name('payment.update');
    Route::get('payment-info-add', 'PaymentInfoController@add_info')->name('payment.info.add');
    Route::post('payment-info-save', 'PaymentInfoController@paymentInfoSave')->name('payment.info.save');
    Route::post('merchant-complain', [ComplainController::class, 'merchant_complain'])->name('merchant.complain');
    Route::get('complain-create', [ComplainController::class, 'complain_create'])->name('complain.create');
    Route::get('complain', [ComplainController::class, 'complain'])->name('complain');
});


Route::prefix('otp')->name('otp.')->group(function () {
    Route::post('/send', [OtpController::class, 'send'])->name('send');
    Route::get('/otp-submit', [OtpController::class, 'otp_submit'])->name('submit');
    Route::post('/otp-submit', [OtpController::class, 'otp_confirm'])->name('confirm');
});



//-------------------------- Shop ------------------------
Route::prefix('shop/')->middleware('auth')->name('shop.')->group(function () {
    Route::get('index', [ShopController::class, 'index'])->name('index');
    Route::post('store', [ShopController::class, 'store'])->name('store');
    Route::get('edit', [ShopController::class, 'edit'])->name('edit');
    Route::post('update', [ShopController::class, 'update'])->name('update');
    Route::get('status', [ShopController::class, 'status'])->name('status');
    Route::get('delete', [ShopController::class, 'destroy'])->name('destroy');
});

//-------------------------- Product ------------------------
Route::prefix('product/')->middleware('auth')->name('product.')->group(function () {
    Route::get('index', [ProductController::class, 'index'])->name('index');
    Route::post('store', [ProductController::class, 'store'])->name('store');
    Route::get('edit', [ProductController::class, 'edit'])->name('edit');
    Route::post('update', [ProductController::class, 'update'])->name('update');
    Route::get('status', [ProductController::class, 'status'])->name('status');
    Route::get('destroy', [ProductController::class, 'destroy'])->name('destroy');
});

Route::get('transfer-to-hub', [OrderStatusHistoryController::class, 'transfer'])->name('order.transfer_index');
Route::get('transfer-to-hub-scan', [OrderStatusHistoryController::class, 'transfer_scan'])->name('order.transfer_index_scan');
Route::post('session-search', [OrderStatusHistoryController::class, 'session_search'])->name('order.session_search');
Route::post('transfer-to-hub-scan-store', [OrderStatusHistoryController::class, 'transfer_scan_store'])->name('order.transfer_index_scan_store');
Route::get('get-area', [OrderStatusHistoryController::class, 'get_area'])->name('get_area');
Route::get('transfer-to-third-party', [OrderStatusHistoryController::class, 'transfer_to_third_party'])->name('order.transfer_to_third_party');
Route::get('transfer-to-pathao', [OrderStatusHistoryController::class, 'transfer_to_third_pathao'])->name('order.transfer_to_third_pathao');
Route::post('transfer-to-hub', [OrderStatusHistoryController::class, 'transfer'])->name('order.transfer');
Route::post('transfer-to-agent/store', [OrderStatusHistoryController::class, 'transfer_to_agent_store'])->name('order.transfer.agent.store');
Route::post('transfer-to-agent-scan/store', [OrderStatusHistoryController::class, 'transfer_to_agent_store_scan'])->name('order.transfer.agent.store_scan');
Route::post('redx-store', [OrderStatusHistoryController::class, 'transfer_to_redx_store'])->name('order.transfer.redx.store');
Route::post('pathao-store', [OrderStatusHistoryController::class, 'transfer_to_pathao_store'])->name('order.transfer.pathao.store');
Route::get('pathao-get-zone', [OrderStatusHistoryController::class, 'pathao_get_zone'])->name('pathao_get_zone');
Route::get('pathao-get-area', [OrderStatusHistoryController::class, 'pathao_get_area'])->name('pathao_get_area');
Route::get('pathao-get-store-list', [OrderStatusHistoryController::class, 'pathao_get_store_list'])->name('pathao_get_store_list');
Route::get('thirdparty-transfer-list', [OrderStatusHistoryController::class, 'pathao_transfer_list'])->name('pathao_transfer_list');
Route::get('thirdparty-status-change', [OrderStatusHistoryController::class, 'third_party_status_change'])->name('third_party_status_change');
Route::get('thirdparty-delivery-cancel-list', [OrderStatusHistoryController::class, 'third_party_delivery_cancel_list'])->name('third_party_delivery_cancel_list');
Route::post('thirdparty-payment', [OrderStatusHistoryController::class, 'third_party_payment'])->name('third_party_payment');
Route::get('redx-transfer-list', [OrderStatusHistoryController::class, 'redx_transfer_list'])->name('redx_transfer_list');
Route::post('/callback', [OrderStatusHistoryController::class, 'callback'])->name('callback');

// ======================== asif route ==========================
Route::prefix('return-to-hub/')->middleware('auth')->name('admin.return.to.')->group(function () {
    Route::get('/', [OrderStatusHistoryController::class, 'returnToHub'])->name('hub_index');
    Route::get('/remove', [OrderStatusHistoryController::class, 'removes'])->name('removes');
    Route::get('/scan', [OrderStatusHistoryController::class, 'returnToHubScan'])->name('hub_index_scan');
    Route::post('/scan-store', [OrderStatusHistoryController::class, 'returnToHubScanStore'])->name('hub_index_scan_store');
    Route::post('/', [OrderStatusHistoryController::class, 'returnToHub'])->name('hub');
    Route::post('/store', [OrderStatusHistoryController::class, 'returnToStore'])->name('store');
    Route::post('/store-scan', [OrderStatusHistoryController::class, 'returnToStoreScan'])->name('store_scan');
});





Route::get('order-transfer-area', 'OrderStatusHistoryController@transferArea')->name('order.transfer.area');
Route::get('get-order', 'OrderStatusHistoryController@getOrder')->name('get.order.area');
Route::get('transfer-add/{id}', 'OrderStatusHistoryController@transfer_add')->name('order.transfer.add');

Route::get('transfer-to-headoffice', [OrderStatusHistoryController::class, 'transfer_to_head_office'])->name('order.transfer.head_office');
Route::get('transfer-to-headoffice-scan', [OrderStatusHistoryController::class, 'transfer_to_head_office_scan'])->name('order.transfer.head_office_scan');
Route::post('transfer-to-headoffice-scan-store', [OrderStatusHistoryController::class, 'transfer_to_head_office_scan_store'])->name('order.transfer.head_office_scan_store');
Route::post('transfer-to-headoffice', [OrderStatusHistoryController::class, 'transfer_to_head_office'])->name('order.transfer.headoffice');
Route::post('transfer-to-headoffice-store', [OrderStatusHistoryController::class, 'transfer_to_head_office_store_scan'])->name('order.transfer.headoffice_store_scan');

Route::post('transfer-to-headoffice/store', [OrderStatusHistoryController::class, 'transfer_to_head_office_store'])->name('order.transfer.headoffice.store');



Route::get('move-to-reschedule', 'OrderStatusHistoryController@move_to_reschedule')->name('order.move.reschedule');
Route::get('move-to-return', 'OrderStatusHistoryController@move_to_return')->name('order.move.return');
Route::get('move-to-delivery-assign', 'OrderStatusHistoryController@move_to_delivery_assign')->name('order.move.delivery.assign');


//asifman
Route::get('move-to-return-assign', [DeliveryAssignController::class, 'agentReturnList'])->name('order.move.return.assign.list');
Route::get('move-to-return-assign-scan', [DeliveryAssignController::class, 'agentReturnListScan'])->name('order.move.return.assign.list_scan');
Route::post('move-to-return-assign-scan-store', [DeliveryAssignController::class, 'agentReturnListScanStore'])->name('order.move.return.assign.list_scan_store');
Route::post('move-to-return-assign', [DeliveryAssignController::class, 'agentReturnLoad'])->name('admin.move.return.assign.load');
Route::post('move-to-return-assign-store', [DeliveryAssignController::class, 'agentReturnStore'])->name('admin.move.return.assign.store');
Route::post('move-to-return-assign-store-scan', [DeliveryAssignController::class, 'agentReturnStoreScan'])->name('admin.move.return.assign.store_scan');
Route::get('move-to-return-assign-print/{returnasign}', [DeliveryAssignController::class, 'agentReturnPrint'])->name('admin.move.return.assign.print');




//-------------------------- Category ------------------------
Route::prefix('category/')->middleware('auth')->name('category.')->group(function () {
    Route::get('index', [ControllersCategoryController::class, 'index'])->name('index');
    Route::post('store', [ControllersCategoryController::class, 'store'])->name('store');
    Route::get('edit', [ControllersCategoryController::class, 'edit'])->name('edit');
    Route::post('update', [ControllersCategoryController::class, 'update'])->name('update');
    Route::get('status', [ControllersCategoryController::class, 'status'])->name('status');
    Route::get('destroy', [ControllersCategoryController::class, 'destroy'])->name('destroy');
});

//-------------------------- Pickup Time ------------------------
Route::prefix('pickup/')->middleware('auth')->name('pickup.')->group(function () {
    Route::get('index', [PickUpTimeController::class, 'index'])->name('index');
    Route::post('store', [PickUpTimeController::class, 'store'])->name('store');
    Route::get('edit', [PickUpTimeController::class, 'edit'])->name('edit');
    Route::post('update', [PickUpTimeController::class, 'update'])->name('update');
    Route::get('status', [PickUpTimeController::class, 'status'])->name('status');
    Route::get('delete', [PickUpTimeController::class, 'destroy'])->name('destroy');
});

//-------------------------- Problem ------------------------
Route::prefix('problem/')->middleware('auth')->name('problem.')->group(function () {
    Route::get('index', [ProblemController::class, 'index'])->name('index');
    Route::post('store', 'ProblemController@store')->name('store');
    Route::get('edit', 'ProblemController@edit')->name('edit');
    Route::post('update', 'ProblemController@update')->name('update');
    Route::get('status', 'ProblemController@status')->name('status');
    Route::get('delete', 'ProblemController@destroy')->name('destroy');
});

//-------------------------- Complain ------------------------
Route::prefix('complain/')->middleware('auth')->name('complain.')->group(function () {
    Route::get('create', [ComplainController::class, 'create'])->name('create');
    Route::get('find-user', 'ComplainController@find_user')->name('find.user');
    Route::get('find-details', 'ComplainController@find_details')->name('find.details');
    Route::get('index', [ComplainController::class, 'index'])->name('index');
    Route::post('store', 'ComplainController@store')->name('store');
    Route::get('edit', 'ComplainController@edit')->name('edit');
    Route::post('update', [ComplainController::class, 'update'])->name('update');
    Route::get('payment-request', [ComplainController::class, 'payment_request'])->name('payment.request');
    Route::get('status', 'ComplainController@status')->name('status');
    Route::get('delete', 'ComplainController@destroy')->name('destroy');
    Route::get('report', [ComplainController::class, 'report'])->name('report');
    Route::get('datewise-print', 'ComplainController@datewise_print')->name('datewise.print');
    Route::get('filtering', [ComplainController::class, 'statuswise'])->name('report.statuswise');
    Route::get('statuswise-print', 'ComplainController@statuswise_print')->name('print.statuswise');
});

//-------------------------- Notice ------------------------
Route::prefix('notice/')->name('notice.')->group(function () {
    Route::get('index', [NoticeController::class, 'index'])->name('index');
    Route::get('edit', [NoticeController::class, 'edit'])->name('edit');
    Route::post('update', [NoticeController::class, 'update'])->name('update');
});

//-------------------------- Shop Employee ------------------------
Route::prefix('employee/')->middleware('auth')->name('employee.')->group(function () {
    Route::get('index', [EmployeeController::class, 'index'])->name('index');
    Route::post('store', 'EmployeeController@store')->name('store');
    Route::get('edit', 'EmployeeController@edit')->name('edit');
    Route::post('update', 'EmployeeController@update')->name('update');
    Route::get('status', 'EmployeeController@status')->name('status');
    Route::get('delete', 'EmployeeController@destroy')->name('destroy');
});

//-------------------------- Agent ------------------------
Route::prefix('agent/')->middleware('auth')->name('agent.')->group(function () {
    Route::get('index', [AgentController::class, 'index'])->name('index');
    Route::get('preview', 'AgentController@preview')->name('preview');
    Route::get('preview-print', 'AgentController@print')->name('preview.print');
    Route::get('edit', [AgentController::class, 'edit'])->name('edit');
    Route::post('update', 'AgentController@update')->name('update');
    Route::get('status', [AgentController::class, 'status'])->name('status');
});
// [RiderController::class, 'index']
//-------------------------- Rider ------------------------
Route::prefix('rider/')->middleware('auth')->name('rider.')->group(function () {
    Route::get('index', [RiderController::class, 'index'])->name('index');
    Route::get('preview', [RiderController::class, 'preview'])->name('preview');
    Route::get('preview-print', [RiderController::class, 'print'])->name('preview.print');
    Route::get('edit', [RiderController::class, 'edit'])->name('edit');
    Route::post('update', [RiderController::class, 'update'])->name('update');
    Route::get('status', [RiderController::class, 'status'])->name('status');
    Route::get('dashboard', [RiderController::class, 'dashboard'])->name('dashboard');
    Route::get('dashboard-new', [RiderController::class, 'dashboard_new'])->name('dashboard_new');
});

//-------------------------- Pick Up Request Assign ------------------------
Route::prefix('pick-up-request-assign/')->middleware('auth')->name('request.assign.')->group(function () {
    Route::get('pickup', 'PickUpRequestAssignController@pickup')->name('pickup');
    Route::get('index', 'PickUpRequestAssignController@index')->name('index');
    Route::get('list', [PickUpRequestAssignController::class, 'list'])->name('list');
    Route::get('list/auto', [PickUpRequestAssignController::class, 'list_auto'])->name('auto.lists');
    Route::post('list/auto', [PickUpRequestAssignController::class, 'list_auto'])->name('auto.list');
    Route::get('collect/auto', [PickUpRequestAssignController::class, 'collect_auto'])->name('auto.collect');
    Route::get('collect-all/auto', [PickUpRequestAssignController::class, 'collectAll_auto'])->name('auto.collect.all');
    Route::post('list-load', [PickUpRequestAssignController::class, 'collect_list_load'])->name('list.load');
    Route::post('store', 'PickUpRequestAssignController@store')->name('store');
    Route::get('edit', 'PickUpRequestAssignController@edit')->name('edit');
    Route::post('update', 'PickUpRequestAssignController@update')->name('update');
    Route::get('-add/{id}', 'PickUpRequestAssignController@add')->name('add');
    Route::get('/remove', 'PickUpRequestAssignController@remove')->name('remove');
    Route::get('/confirm', 'PickUpRequestAssignController@confirm')->name('confirm_list');
    Route::post('/confirm', 'PickUpRequestAssignController@con_firm')->name('confirm');
    Route::get('collect', [PickUpRequestAssignController::class, 'collect'])->name('collect');
    Route::get('collect-all', [PickUpRequestAssignController::class, 'collectAll'])->name('collect.all');
    Route::get('cancel', [PickUpRequestAssignController::class, 'cancel'])->name('cancel');

    Route::post('deleteOrderAdmin', [PickUpRequestAssignController::class, 'deleteOrderAdmin'])->name('delete.order.admin');
    Route::get('admin-order-delete', [PickUpRequestAssignController::class, 'admin_order_delete'])->name('admin_order_delete');


    Route::get('order-print/{id}', 'PickUpRequestAssignController@order_print')->name('order_print');
    Route::post('/pickUP-confirm', 'PickUpRequestAssignController@pickUP_confirm')->name('pickUP.confirm_list');
    Route::get('/pickUP-confirm', 'PickUpRequestAssignController@pickUP_confirm')->name('pickUP.confirm');
    Route::post('/confirm-pickUP', [PickUpRequestAssignController::class, 'confirm_pickUP'])->name('confirm.pickUP');

    Route::post('/confirm-pickup-invoice', [PickUpRequestAssignController::class, 'pickup_invoice'])->name('confirm.invoice');

    Route::get('pickup-asign', [PickUpRequestAssignController::class, 'request_pickup'])->name('request_pickup');
});

//-------------------------- Delivery Assign ------------------------
Route::prefix('delivery-assign')->middleware('auth')->name('delivery.assign.')->group(function () {
    Route::get('/', [DeliveryAssignController::class, 'index'])->name('index');
    Route::get('/by-scan', [DeliveryAssignController::class, 'delivery_assign_by_scan'])->name('delivery_assign_by_scan');
    Route::get('/order-export', [DeliveryAssignController::class, 'order_export'])->name('order_export');
    Route::post('/scan-search', [DeliveryAssignController::class, 'scan_search'])->name('scan_search');
    Route::post('/scan-remove', [DeliveryAssignController::class, 'scan_remove'])->name('scan_remove');
    Route::post('/export-search', [DeliveryAssignController::class, 'export_search'])->name('export_search');
    Route::get('/list', [DeliveryAssignController::class, 'list'])->name('list');
    Route::get('/hold-reschedule', [DeliveryAssignController::class, 'hold_reschedule'])->name('hold_reschedule');

    Route::get('/return-request', [DeliveryAssignController::class, 'return_request'])->name('return.request');


    Route::get('/list-transfer', [DeliveryAssignController::class, 'transfer_list'])->name('transfer');

    Route::get('/list-hold', 'DeliveryAssignController@hold_list')->name('hold');

    Route::get('/transfer-confirm/{transfer}', [DeliveryAssignController::class, 'transfer_list_confirm'])->name('transfered');

    Route::get('/transfer-confirm/show/{transfer}', [DeliveryAssignController::class, 'transfer_list_confirm_show'])->name('transfered.show');
    Route::get('/transfer-confirm/print/{transfer}', [DeliveryAssignController::class, 'transfer_list_confirm_print'])->name('transfered.print');

    Route::get('/edit', 'DeliveryAssignController@edit')->name('edit');
    Route::post('/update', 'DeliveryAssignController@update')->name('update');
    Route::get('-add/{id}', 'DeliveryAssignController@add')->name('add');
    Route::get('/remove', 'DeliveryAssignController@remove')->name('remove');
    Route::get('/confirm', 'DeliveryAssignController@confirm')->name('confirm_list');
    Route::post('/confirm', [DeliveryAssignController::class, 'con_firm'])->name('confirm');
    Route::post('/confirm-scan', [DeliveryAssignController::class, 'confirm_scan'])->name('confirm_scan');
    Route::get('/delivered', [DeliveryAssignController::class, 'delivered'])->name('delivered');
    Route::get('/deliveredc', [DeliveryAssignController::class, 'deliveredc'])->name('deliveredc');
    Route::get('/delivered-option', [DeliveryAssignController::class, 'deliveredOption'])->name('deliveredOption');
    Route::get('/pending', 'DeliveryAssignController@pending')->name('pending');


    Route::get('/branch', [DeliveryAssignController::class, 'branch'])->name('branch.list');
    Route::post('/branch', [DeliveryAssignController::class, 'branch'])->name('branch');
    Route::post('/branch/confirm', [DeliveryAssignController::class, 'branch_con_firm'])->name('branch.confirm');
});

//-------------------------- Delivered Order ------------------------
Route::prefix('delivered-order/')->middleware('auth')->name('delivered.order.')->group(function () {
    Route::get('/', [DeliveryAssignController::class, 'delivered_order'])->name('index');
    Route::get('status', [DeliveryAssignController::class, 'order_delivered'])->name('status');
});



//-------------------------- Rider Payment ------------------------ 
Route::prefix('delivered-order/')->middleware('auth')->name('delivered.order.')->group(function () {
    Route::get('/rider-payment', [DeliveryAssignController::class, 'rider_payment'])->name('rider.payment');
    Route::get('/rider-payment-print', [DeliveryAssignController::class, 'rider_payment_print'])->name('rider.payment.print');
    Route::get('/rider-payment-load', [DeliveryAssignController::class, 'rider_payment_load'])->name('rider.payment.load');
    Route::post('/rider-payment-store', [DeliveryAssignController::class, 'rider_payment_store'])->name('rider.payment.store');
});






//-------------------------- Pending Order ------------------------
Route::prefix('pending-order/')->middleware('auth')->name('pending.delivery.')->group(function () {
    Route::get('index', [DeliveryAssignController::class, 'pending_delivery'])->name('list_index');
    Route::post('index', [DeliveryAssignController::class, 'pending_delivery'])->name('index');
    Route::get('status', [DeliveryAssignController::class, 'delivery_pending'])->name('status');
});

//-------------------------- Order Return asifreturn ------------------------  order.return.admin.merchant.confirm
Route::prefix('order-return-to')->middleware('auth')->name('order.return.')->group(function () {
    Route::get('/', [DeliveryAssignController::class, 'return_list'])->name('list');
    Route::post('/merchant', [DeliveryAssignController::class, 'admin_return_merchant'])->name('rider.merchant.store');
    Route::get('/confirm-now/{orderinv}', [DeliveryAssignController::class, 'admin_return_confirm'])->name('admin.merchant.confirm.dfgmndfkg');



    Route::get('headoffice', 'DeliveryAssignController@headoffice')->name('headoffice');
    Route::get('head-office', 'DeliveryAssignController@head_office')->name('head_office');
    Route::get('head-office-collection', 'DeliveryAssignController@collection')->name('collection');
    Route::get('merchant', 'DeliveryAssignController@merchant')->name('merchant');
    Route::get('rider-add/{id}', 'DeliveryAssignController@rider_add')->name('rider.add');
    Route::get('rider-confirm', 'DeliveryAssignController@rider_confirm')->name('rider.confirm');
    Route::get('rider-remove', 'DeliveryAssignController@rider_remove')->name('rider.remove');
    Route::post('rider-save', 'DeliveryAssignController@rider_save')->name('rider.save');
    Route::get('merchant-confirm', 'DeliveryAssignController@merchant_confirm')->name('merchant.confirm');
    Route::get('merchant-print', 'DeliveryAssignController@return_print')->name('print');
});

//-------------------------- Accounts ------------------------
Route::prefix('accounts/')->middleware('auth')->name('accounts.')->group(function () {
    Route::get('dashboard', [AdminPanelController::class, 'accounts_dashboard'])->name('dashboard');
    Route::get('dashboards', [AdminPanelController::class, 'accounts_dashboards'])->name('dashboards');
    Route::get('payment-collection', 'PickUpRequestAssignController@payment_collect')->name('payment.collection');
    Route::get('payment-collect', 'PickUpRequestAssignController@paymentCollect')->name('payment.collect');
    Route::get('merchant-payment', [PickUpRequestAssignController::class, 'merchant_payment'])->name('merchant.payment');
    Route::get('rider-payment', [PickUpRequestAssignController::class, 'rider_payment'])->name('rider.payment');
    Route::post('rider-payment-store', [PickUpRequestAssignController::class, 'rider_payment_store'])->name('rider.payment.store');
    Route::post('branch-payment-store', [PickUpRequestAssignController::class, 'branch_payment_store'])->name('branch.payment.store');
    Route::get('branch-payment', [PickUpRequestAssignController::class, 'branch_payment'])->name('branch.payment');
    Route::post('merchant-payment', [PickUpRequestAssignController::class, 'paymentComplete'])->name('payment.complete');
    Route::get('merchant-payment-print', 'PickUpRequestAssignController@paymentPrint')->name('payment.complete.print');
    Route::get('merchant-payment-collect', 'OrderReportController@merchant_payment')->name('merchant.payment.collect');

    Route::get('merchant-advance-payment', [MerchantAdvancePaymentController::class, 'merchant_advance_payment'])->name('merchant.advance.payment');
    Route::any('save-advance-payment', [MerchantAdvancePaymentController::class, 'saveAdvancePayment'])->name('save.advance.payment');
    Route::any('get-merchant', 'MerchantAdvancePaymentController@getMerchant')->name('merchant.getMerchant');
    // payments
    Route::get('merchant-payment-info', [PaymentInfoController::class, 'payment_info'])->name('merchant.paymentinfo');
    Route::get('merchant-payment-info-edit', [PaymentInfoController::class, 'payment_info_edit'])->name('merchant.paymentinfo.edit');
    Route::post('merchant-payment-info-update', [PaymentInfoController::class, 'payment_info_update'])->name('merchant.paymentinfo.update');
});

//-------------------------- Order Report ------------------------ return-datewise order.report.delivery.confirm
Route::prefix('order-report/')->middleware('auth')->name('order.report.')->group(function () {
    Route::get('date-wise', [OrderReportController::class, 'datewise'])->name('datewise');
    Route::get('daily-collection-report', [OrderReportController::class, 'daily_collection_report'])->name('daily_collection_report');
    Route::get('daily-collection-report-date-wise', [OrderReportController::class, 'daily_collection_report_date_wise'])->name('daily_collection_report_date_wise');
    Route::get('daily-collection-report-print', [OrderReportController::class, 'daily_collection_report_print'])->name('daily_collection_report_print');
    Route::get('date-wise-print', [OrderReportController::class, 'date_wise'])->name('datewise.print');
    Route::get('status-wise', 'OrderReportController@statuswise')->name('statuswise');
    Route::get('status-wise-print', 'OrderReportController@status_wise')->name('statuswise.print');
    Route::get('pending', 'OrderReportController@pending')->name('pending');
    Route::get('delivered', 'OrderReportController@delivered')->name('delivered');
    Route::get('confirm-delivered', 'OrderReportController@confirm_delivery')->name('confirm.delivery');
    Route::get('delivered-confirm', [OrderReportController::class, 'delivery_confirm'])->name('delivery.confirm');
    Route::get('delivered-rider', [OrderReportController::class, 'delivery_rider'])->name('delivery.rider');


    //merchant history
    Route::get('merchant-status-wise', [OrderReportController::class, 'merchantwise'])->name('merchantwise');
    // agent history
    Route::get('admin-branch-history', [OrderReportController::class, 'adminAgentHistory'])->name('admin.agent.history');









    Route::get('merchant-status-wise-print', [OrderReportController::class, 'merchant_wise'])->name('merchant_wise');
    Route::get('transfer-order', [OrderReportController::class, 'collected'])->name('collected');
    Route::get('confirm-collected', [OrderReportController::class, 'confirm_collected'])->name('confirm.collected');
    Route::get('pickup-cancel', 'OrderReportController@pickup_cancel')->name('pickup_cancel');
    Route::get('payment-complete', 'OrderReportController@paymentComplete')->name('payment');
    Route::get('payment-complete-print', 'OrderReportController@payment_Complete')->name('payment.print');
    Route::get('pick-up-request', 'OrderReportController@pickuprequest')->name('pickup.request');
    Route::get('pick-up-request-print', 'OrderReportController@pickup_request')->name('pickup.request.print');
    Route::get('payment-processing', 'OrderReportController@processing')->name('processing');
    Route::get('payment-processing-print', 'OrderReportController@pro_cessing')->name('processing.print');
    Route::get('payment-collect', 'OrderReportController@payCollect')->name('pay.collect');
    Route::get('payment-collect-print', 'OrderReportController@pay_collect')->name('pay.collect.print');
    Route::get('rider-status-wise', 'OrderReportController@riderwise')->name('riderwise');
    Route::get('rider-status-wise-print', 'OrderReportController@rider_wise')->name('riderwise.print');
    Route::get('rider-status-date', [OrderReportController::class, 'rider_status_date'])->name('rider.status.date');
    Route::get('rider-status-date-print', [OrderReportController::class, 'rider_status_date_print'])->name('rider.status.date.print');
    Route::get('payment-complete', 'OrderReportController@payComplete')->name('pay.complete');
    Route::get('payment-complete-print', 'OrderReportController@pay_Complete')->name('pay.complete.print');
    Route::get('payment-processing-agent-wise', 'OrderReportController@agent_wise')->name('agent.wise.processing');
    Route::get('payment-processing-agent-wise-print', 'OrderReportController@agent_wise_print')->name('agent.wise.processing.print');
    Route::get('payment-processing-area-wise', 'OrderReportController@area_wise')->name('area.wise.processing');
    Route::get('payment-processing-area-wise-print', 'OrderReportController@area_wise_print')->name('area.wise.processing.print');
    Route::get('payment-collect-agent-wise', 'OrderReportController@payCollectagent')->name('agent.wise.pay.collect');
    Route::get('payment-collect-agent-wise-print', 'OrderReportController@pay_collect_agent')->name('agent.wise.pay.collect.print');
    Route::get('payment-collect-area-wise', 'OrderReportController@area_wiseCollect')->name('area.wise.pay.collect');
    Route::get('payment-collect-area-wise-print', 'OrderReportController@area_collect_print')->name('area.wise.pay.collect.print');
    Route::get('payment-complete-merchant-wise', 'OrderReportController@merchant_pay_complete')->name('merchant.wise.pay.complete');
    Route::get('payment-complete-merchant-wise-print', 'OrderReportController@merchantpaycomplete')->name('merchant.wise.pay.complete.print');
    Route::get('payment-collect-merchant-wise', 'OrderReportController@merchant_pay_collect')->name('merchant.wise.pay.collect');
    Route::get('payment-collect-merchant-wise-print', 'OrderReportController@merchantpaycollect')->name('merchant.wise.pay.collect.print');
    Route::get('return-datewise', [OrderReportController::class, 'return_datewise'])->name('return.datewise');
    Route::get('urgent-order', 'OrderReportController@urgent_order')->name('urgent.order');
    Route::get('status-pickup', 'OrderReportController@status_pickup')->name('status.pickup');
    Route::get('datewise-adjustment', 'OrderReportController@adjustment')->name('datewise.adjustment');
    Route::get('datewise-adjustment-print', 'OrderReportController@adjustment_print')->name('datewise.adjustment.print');
    Route::get('merchant-adjustment', 'OrderReportController@merchant_adjustment')->name('merchant.wise.adjustment');
    Route::get('merchant-adjustment-print', 'OrderReportController@merchant_adjustment_print')->name('merchant.wise.adjustment.print');
    Route::get('merchant-history', 'OrderReportController@merchant_history')->name('merchant.history');
    Route::get('merchant-history-print', [OrderReportController::class, 'merchant_history_print'])->name('merchant.history.print');

    Route::get('merchant-history2', 'OrderReportController@merchant_history2')->name('merchant.history2');

    Route::get('merchant-payment-', [OrderReportController::class, 'merchantPayment'])->name('merchant.payment');
    Route::get('merchant-payment-print', 'OrderReportController@merchantPayment_print')->name('merchant.payment.print');





    //Rider Payment Report order.report.
    Route::get('transition-history-agent-rider', [OrderReportController::class, 'rider_payment_report'])->name('rider.payment.report');
    Route::get('rider-payment-report/print', [OrderReportController::class, 'rider_payment_report_print'])->name('rider.payment.report.print');



    //Admin Transfer History
    Route::get('transition-history', [OrderReportController::class, 'rider_payment_report'])->name('admin.transfer.history');

    //Agent Transfer History

    Route::get('agent-transition-history', [OrderReportController::class, 'agent_payment_report'])->name('agent.transfer.history.index');
    Route::post('agent-transition-history-load', [OrderReportController::class, 'agent_payment_report'])->name('agent.transfer.history');
    Route::get('agent-transition-history-load', [OrderReportController::class, 'agent_payment_report'])->name('agent.transfer.history.load');




    // Route::get('transfer-history/print', [OrderReportController::class, 'rider_payment_report_print'])->name('rider.payment.report.print');



    // rider payment info asif rider-payment-report  order.report.admin.rider.return.info

    // Route('return-info-list')
    Route::get('return-info', [OrderReportController::class, 'rider_info'])->name('admin.rider.return.info');
    Route::get('return-show/{returnassign}', [OrderReportController::class, 'rider_info_show'])->name('admin.rider.return.show');
    Route::get('return-print/{returnassign}', [OrderReportController::class, 'rider_info_print'])->name('admin.rider.return.print');
    // Route::post('return-info', [OrderReportController::class, 'rider_info'])->name('admin.rider.return.info');


    Route::get('/merchant-return-rquest', [OrderReportController::class, 'merchantList'])->name('admin.merchant.list');



    Route::get('rider-payment-show/{rider}', [OrderReportController::class, 'rider_payment_show'])->name('rider.payment.show');

    // Route::get('agent-transaction-show/{rider}', [OrderReportController::class, 'rider_transaction_show'])->name('agent.transaction.payment.show');


    //Agent  Transation Report order.report.
    Route::get('rider-collection-history', [OrderReportController::class, 'agent_transaction_report'])->name('agent.transaction.report');

    Route::get('agent-transaction-show/{rider}', [OrderReportController::class, 'agent_transaction_show'])->name('agent.transaction.show');

    Route::get('rider-today-delivered', [OrderReportController::class, 'rider_today_delivered_report'])->name('rider.today.delivered');

    Route::get('rider-monthly-delivered', [OrderReportController::class, 'rider_monthly_delivered_report'])->name('rider.monthly.delivered');
});

///Order Status Report
Route::prefix('merchant-wise/')->middleware('auth')->name('order.status.')->group(function () {
    Route::get('order-status', [OrderStatusHistoryController::class, 'order_status'])->name('merchant');
    Route::get('order-status/print', 'OrderStatusHistoryController@orderstatus')->name('merchant.print');
});


//-------------------------- Weight Price ------------------------
Route::prefix('weight-price/')->middleware('auth')->name('weight_price.')->group(function () {
    Route::get('index', [WeightPriceController::class, 'index'])->name('index');
    Route::get('add', [WeightPriceController::class, 'add'])->name('add');
    Route::post('store', [WeightPriceController::class, 'store'])->name('store');
    Route::get('edit', [WeightPriceController::class, 'edit'])->name('edit');
    Route::get('destroy', [WeightPriceController::class, 'destroy'])->name('destroy');
    Route::post('update', [WeightPriceController::class, 'update'])->name('update');
});

//-------------------------- Zone ------------------------
Route::prefix('zone/')->middleware('auth')->name('zone.')->group(function () {
    Route::get('index', [ZoneController::class, 'index'])->name('index');
    Route::post('store', [ZoneController::class, 'store'])->name('store');
    Route::get('edit', [ZoneController::class, 'edit'])->name('edit');
    Route::post('update', [ZoneController::class, 'update'])->name('update');
    Route::get('status', [ZoneController::class, 'status'])->name('status');
});
//-------------------------- Branch Districts ------------------------
Route::prefix('brnach-district/')->middleware('auth')->name('branch_district.')->group(function () {
    Route::get('index', [BranchsDistrictController::class, 'index'])->name('list.index');
    Route::post('index', [BranchsDistrictController::class, 'index'])->name('index');
    Route::post('store', [BranchsDistrictController::class, 'store'])->name('store');
    Route::post('edit', [BranchsDistrictController::class, 'edit'])->name('edit');
    Route::post('update', [BranchsDistrictController::class, 'update'])->name('update');
    Route::get('destroy', [BranchsDistrictController::class, 'destroy'])->name('destroy');
});


//bulk csv import
Route::get('/csv-file-upload', [CsvController::class, 'file_upload'])->middleware('auth')->name('csv-file-upload');
Route::get('/csv-file-upload-express', [CsvController::class, 'file_upload_express'])->middleware('auth')->name('csv-file-upload-express');

Route::post('/csv-data', [CsvController::class, 'import'])->name('file-import-store');
Route::post('/csv-express-data', [CsvController::class, 'import_express'])->name('file-import-express-store');

Route::post('/csv-data-submit', [CsvController::class, 'submit'])->middleware('auth')->name('file-data-submit');

Route::post('/csv-data-submit-express', [CsvController::class, 'submit_express'])->middleware('auth')->name('file-data-submit-express');

Route::get('/csv-file-download', [CsvController::class, 'file_download'])->middleware('auth')->name('csv-file-download');


//district ajax data


Route::post('/area-data', [AjaxDataController::class, 'area_data'])->name('ajaxdata.area.index');

Route::post('/area-data-data', [AjaxDataController::class, 'area_data_data'])->name('ajaxdata.area.data');

Route::post('/rider-hub-data', [AjaxDataController::class, 'rider_hub_data'])->name('ajaxdata.rider.hub');

Route::post('/zone-data', [AjaxDataController::class, 'zone_data'])->name('ajaxdata.zone');
Route::post('/shop-data', [AjaxDataController::class, 'shop_data'])->name('ajaxdata.shop');
Route::post('/dist-data', [AjaxDataController::class, 'drict_data'])->name('ajaxdata.dist');
Route::post('/coverage-data', [AjaxDataController::class, 'coverage_data'])->name('ajaxdata.coverage_data');
Route::post('/singleZone', [AjaxDataController::class, 'singleZone'])->name('ajaxdata.singleZone');
Route::post('/dist-data1', [AjaxDataController::class, 'drict_data1'])->name('ajaxdata.dist1');

Route::get('/fetch/subcategory/value', [AjaxDataController::class, 'fetch_subcategory_value'])->name('fetch.subcategory.value');





/*------------------ Merchant Registration -----------------*/
// Route::any('merchant-registration', [MerchantRegistrationController::class, 'registration'])->name('admin.merchant.registration');
// Route::post('merchant-registration', [MerchantRegistrationController::class, 'registration_store'])->name('admin.merchant.registration');



Route::get('mobile-otp-code', [MerchantRegistrationController::class, 'mobileOTPcode'])->name('mobile.otp.send.login');

Route::get('mobile-otp-forget', [MerchantRegistrationController::class, 'mobileOTPcodeForget'])->name('mobile.otp.send.forget');



// frontend route

Route::get('/', [FrontEndController::class, 'frontend'])->name('frontend');

Route::post('/order-tracking', [OrderTrackingController::class, 'order_tracking'])->name('frontend.order.tracking');

Route::get('/order-tracking/tracking={id}', [OrderTrackingController::class, 'order_tracking_id'])->name('frontend.order.tracking.id');


Route::get('/about', [FrontendFrontendController::class, 'about'])->name('frontend.order.about');
Route::get('/services', [FrontendFrontendController::class, 'services'])->name('frontend.order.services');
Route::get('/price', [FrontendFrontendController::class, 'price'])->name('frontend.order.price');
Route::get('/contact', [FrontendFrontendController::class, 'contact'])->name('frontend.order.contact');





Route::get('agent-transaction-show/{rider}', [OrderReportController::class, 'rider_transaction_show'])->name('order.report.agent.transaction.payment.show');
Route::get('agent-transaction-print/{rider}', [OrderReportController::class, 'rider_transaction_print'])->name('order.report.agent.transaction.payment.print');

Route::get('transaction-show', [OrderReportController::class, 'rider_transaction_show_agent'])->name('order.report.agent_a.transaction.payment.show');
Route::get('transaction-print', [OrderReportController::class, 'rider_transaction_print_agent'])->name('order.report.agent_a.transaction.payment.print');


Route::post('inactive-user-info', [MerchantRegistrationController::class, 'inactive_user_info'])->name('merchant.user.infoadd');


// <a class="btn btn-success col-lg-1" href="{{ route('csv-file-download') }}">Sample
//                                         Download</a>


//------------------ Merchant Registration -----------------
Route::get('merchant-registration', [AdminPanelController::class, 'merchant_register'])->name('merchant.register');
Route::post('merchant-registration', [AdminPanelController::class, 'merchant_regis_ter'])->name('merchant.registration');

//-------test register-login------//
Route::get('login-new', [AdminPanelController::class, 'login_new'])->name('login_new');
Route::get('new-registration', [AdminPanelController::class, 'new_register'])->name('new_register');

Route::get('forget-password-otp', [AdminPanelController::class, 'forget_password_otp'])->name('forget_password_otp');
Route::post('forget-password-store', [AdminPanelController::class, 'forget_password_store'])->name('forget_password_store');

Route::get('forget-password-reset', [AdminPanelController::class, 'forget_password_reset'])->name('forget_password_reset');
Route::post('forget-password-reset-store', [AdminPanelController::class, 'forget_password_reset_store'])->name('forget_password_reset_store');

Route::get('parcel-tracking', [AdminPanelController::class, 'parcel_tracking'])->name('parcel_tracking');
Route::get('live-tracking-parcel', [AdminPanelController::class, 'live_tracking_parcel'])->name('live_tracking_parcel');



//--------------------- OTP Login -------------------------
Route::get('otp-login', [OtpController::class, 'login'])->name('otp.login');
Route::post('otp-login-phone', [OtpController::class, 'login_phone'])->name('otp.login.phone');

Route::get('otp-verification', [OtpController::class, 'otp_verification'])->name('otp.verification');

Route::get('user-info', [OtpController::class, 'user_info'])->name('otp.user_info');

Route::post('otp-verification-confirm', [OtpController::class, 'otp_verification_confirm'])->name('otp.verification.confirm');


// Frontend page route

Route::get('/', [FrontEndController::class, 'superhome'])->name('frontend.home.paghe');











Route::post('area_data', [AjaxDataController::class, 'area_data'])->name('ajaxdata.area');

Route::post('merchant_rider', [AjaxDataController::class, 'merchant_rider'])->name('ajaxdata.merchant_rider');

Route::get('/tracking_details', [FrontEndController::class, 'tracking_details'])->name('frontend.home.tracking_details');


//
