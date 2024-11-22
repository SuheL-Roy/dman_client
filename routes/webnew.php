<?php

use App\Http\Controllers\Admin\MerchantHistoryPaymentController;
use App\Http\Controllers\AgentDeliveryBypassController;
use App\Http\Controllers\AgentOrderBypassController;
use App\Http\Controllers\AgentPickupBypassController;
use App\Http\Controllers\Backend\Auth\MerchantRegistrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BusinessTypeController;
use App\Http\Controllers\BypassController;
use App\Http\Controllers\CollectController;
use App\Http\Controllers\CoverageAreaController;
use App\Http\Controllers\DistrictAreaController;
use App\Http\Controllers\MerchantAdvancePaymentController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderStatusHistoryController;
use App\Http\Controllers\PaymentConfirmationController;
use App\Http\Controllers\RiderCollectController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\OtpController;
use App\Http\Controllers\AdminPanelController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\Scheduler\SchedulerController;
use App\Http\Controllers\LoginBlockController;
use App\Http\Controllers\AutoAssignController;
use App\Http\Controllers\Expense\ExpenseController;
use App\Http\Controllers\IncomeController;
use Illuminate\Support\Facades\Artisan;

//-------------------------- Order ------------------------ create return list edit
Route::prefix('order/')->middleware('auth')->name('order.')->group(function () {
    Route::get('order-list', [OrderController::class, 'index'])->name('list.index');
    Route::get('reason-category', [OrderController::class, 'delivery_category'])->name('delivery_category');
    Route::get('reason-category-destroy', [OrderController::class, 'reason_category_destroy'])->name('reason_category_destroy');
    Route::post('delivery-category-store', [OrderController::class, 'delivery_category_store'])->name('delivery_category_store');
    Route::get('create-order-list', [OrderController::class, 'create_order_list'])->name('create_order_list');
    Route::get('delivery-amount-list', [OrderController::class, 'delivery_amount_list'])->name('delivery_amount_list');
    Route::get('payment-processing-list', [OrderController::class, 'payment_processing_list'])->name('payment_processing_list');
    Route::get('paid-amount-list', [OrderController::class, 'paid_amount_list'])->name('paid_amount_list');
    Route::get('success-order-list', [OrderController::class, 'success_order_list'])->name('success_order_list');
    Route::get('return-order-list', [OrderController::class, 'return_order_list'])->name('return_order_list');
    Route::get('transit-order-list', [OrderController::class, 'transit_order_list'])->name('transit_order_list');
    Route::get('payment-print-all', [OrderController::class, 'payment_print_all'])->name('payment_print_all');
    Route::get('order-list-new', [OrderController::class, 'order_list_new'])->name('list.order_list_new');
    Route::get('order-list-get', [OrderController::class, 'order_list_get'])->name('list.order_list_get');
    Route::get('order-activities', [OrderController::class, 'order_activities'])->name('list.order_activities');
    Route::get('order-list-date-wise', [OrderController::class, 'order_list_date_wise'])->name('list.order_list_date_wise');
    Route::get('order-activities-date-wise', [OrderController::class, 'order_activities_date_wise'])->name('list.order_activities_date_wise');
    Route::post('order-list', [OrderController::class, 'index'])->name('index');

    Route::get('order-list/status-change', [OrderController::class, 'status_change_index'])->name('status.list.index');
    Route::post('order-list/status-change', [OrderController::class, 'status_change_index'])->name('status.index');


    Route::post('change-status', [OrderController::class, 'change_status'])->name('status.change');



    Route::get('order-report', [OrderController::class, 'indexFiltering'])->name('report.filtering');
    Route::get('order-pickup', [OrderController::class, 'indexFilteringPickup'])->name('report.filtering.pickup');
    Route::get('order-pickup-onehour', [OrderController::class, 'indexFilteringPickupOneHour'])->name('report.filtering.pickup.one');
    Route::get('order-pickup-regular', [OrderController::class, 'indexFilteringPickupRegular'])->name('report.filtering.pickup.regular');

    Route::get('order-report-t', [OrderController::class, 'indexFilteringT'])->name('report.filteringt');
    Route::get('order-pickup-t', [OrderController::class, 'indexFilteringPickupT'])->name('report.filtering.pickupt');
    Route::get('order-pickup-onehour-t', [OrderController::class, 'indexFilteringPickupOneHourT'])->name('report.filtering.pickup.onet');
    Route::get('order-pickup-regular-t', [OrderController::class, 'indexFilteringPickupRegularT'])->name('report.filtering.pickup.regulart');

    Route::get('order-regular-delivery', [OrderController::class, 'regularFilteringDelivery'])->name('report.regular.delivery');
    Route::get('order-regular-delivery-one', [OrderController::class, 'regularFilteringDeliveryOne'])->name('report.regular.delivery.one');
    Route::get('order-cancel', [OrderController::class, 'orderCancelFiltering'])->name('report.cancel.filtering');
    Route::get('pickup-cancel', [OrderController::class, 'orderPickupFiltering'])->name('report.pickup.filtering');


    Route::get('order-regular-delivery-t', [OrderController::class, 'regularFilteringDeliveryT'])->name('report.regular.deliveryt');
    Route::get('order-regular-delivery-one-t', [OrderController::class, 'regularFilteringDeliveryOneT'])->name('report.regular.delivery.onet');
    Route::get('order-cancel-t', [OrderController::class, 'orderCancelFilteringT'])->name('report.cancel.filteringt');
    Route::get('pickup-cancel-t', [OrderController::class, 'orderPickupFilteringT'])->name('report.pickup.filteringt');



    Route::post('list', [OrderController::class, 'list'])->name('list');
    Route::post('confirm-edit', [OrderController::class, 'confirm_edit'])->name('confirm_edit');
    Route::get('confirm-edit-new', [OrderController::class, 'confirm_edit_new'])->name('confirm_edit_new');
    Route::post('confirm-edit/store', [OrderController::class, 'confirm_store'])->name('confirm.store');
    Route::get('view', [OrderController::class, 'order_view'])->name('view');
    Route::get('invoice/view', [OrderController::class, 'invoice_view'])->name('invoice.view');
    Route::get('print', [OrderController::class, 'Print'])->name('print');
    Route::get('create', [OrderController::class, 'create'])->name('create');
    Route::get('new-order-create', [OrderController::class, 'backup_create'])->name('backup_create');
    Route::post('store', [OrderController::class, 'store'])->name('store');
    Route::get('charge-calculation', [OrderController::class, 'charge_calculation'])->name('charge_calculation');
    Route::get('charge-calculation-setup', [OrderController::class, 'charge_calculation_setup'])->name('charge_calculation_setup');
    Route::get('weight-wise-charge-calculation', [OrderController::class, 'weight_wise_charge'])->name('weight_wise_charge');
    Route::post('admin-store', [OrderController::class, 'adminStore'])->name('admin.store');
    Route::get('preview', [OrderController::class, 'preview'])->name('preview');
    Route::get('edit', [OrderController::class, 'edit'])->name('edit');
    Route::get('draft-edit', [OrderController::class, 'draft_edit'])->name('draft_edit');
    Route::post('update', [OrderController::class, 'update'])->name('update');
    Route::post('confirm', [OrderController::class, 'confirm'])->name('confirm');
    Route::get('draft', [OrderController::class, 'draft'])->name('draft');
    Route::get('list', [OrderController::class, 'list'])->name('lists');
    Route::get('destroy', [OrderController::class, 'destroy'])->name('destroy');

    Route::get('status-track', 'FrontEndController@track')->name('status.track');
    Route::get('status-history', 'OrderStatusHistoryController@index')->name('status.history');
    Route::get('transfer-remove', 'OrderStatusHistoryController@remove')->name('transfer.remove');
    Route::get('transfer-confirm', 'OrderStatusHistoryController@confirm')->name('transfer.confirm.list');
    Route::post('transfer-confirm', 'OrderStatusHistoryController@con_firm')->name('transfer.confirm');
    Route::get('in-collection-hub', [OrderStatusHistoryController::class, 'inCollectionHub'])->name('collection');
    Route::post('in-collection-hub', [OrderStatusHistoryController::class, 'inCollectionHubLoad'])->name('collection.load');
    Route::get('collect-inhub', [OrderStatusHistoryController::class, 'collect'])->name('collect.inhub');
    Route::get('collect-inhub-all', [OrderStatusHistoryController::class, 'collectAll'])->name('collect.all.inhub');
    Route::get('collect-calcel-inhub', [OrderStatusHistoryController::class, 'cancel_by_branch'])->name('collect.cancel.inhub');
    Route::get('collect-cancel', [OrderStatusHistoryController::class, 'cancel'])->name('collect.cancel');
    Route::get('collect-print', [OrderStatusHistoryController::class, 'collect_print'])->name('collect.print');
    Route::get('latest-collect-print', [OrderStatusHistoryController::class, 'latest_collect_print'])->name('latest_collect_print');
    Route::post('collect-print-generate', [OrderStatusHistoryController::class, 'collect_print_generate'])->name('collect_print_generate');

    Route::get('collection-hub', [OrderStatusHistoryController::class, 'hub_collection'])->name('collection.hub');
    Route::get('collection-hub-scan', [OrderStatusHistoryController::class, 'hub_collection_scan'])->name('collection.hub_scan');
    Route::post('collection-hub-scan-store', [OrderStatusHistoryController::class, 'hub_collection_scan_store'])->name('collection.hub_scan_store');
    Route::get('collection-hub-scan-remove', [OrderStatusHistoryController::class, 'hub_collection_scan_remove'])->name('collection.hub_scan_remove');


    Route::get('collect/hub/cancel', [OrderStatusHistoryController::class, 'hub_collection_cancel'])->name('collection.hub.cancel');
    Route::get('transfer/hub/cancel', [OrderStatusHistoryController::class, 'transfer_hub_cancel'])->name('transfer.hub.cancel');

    Route::get('collect/hub/store/return', [OrderStatusHistoryController::class, 'hub_collection_store_return'])->name('collection.hub.store.return');


    Route::get('in-destination-hub', [OrderStatusHistoryController::class, 'inDestinationHub'])->name('destination');
    Route::get('in-destination-hub-scan', [OrderStatusHistoryController::class, 'inDestinationHubScan'])->name('destination_scan');
    Route::post('in-destination-hub-scan-store', [OrderStatusHistoryController::class, 'inDestinationHubScanStore'])->name('destination_scan_store');

    Route::get('destination-hub', [OrderStatusHistoryController::class, 'destiny'])->name('destiny');
    Route::get('move-return-assign-agent', [OrderStatusHistoryController::class, 'moveToReturnAssign'])->name('move.return.assign.agent');

    Route::get('destination-hub/collect-all', [OrderStatusHistoryController::class, 'inDestinationHub_collect_all'])->name('destination.collect.all');
    Route::get('destination-hub/collect-all-scan', [OrderStatusHistoryController::class, 'inDestinationHub_collect_all_scan'])->name('destination.collect.all_scan');



    Route::get('return', [OrderController::class, 'return_list'])->name('return');

    Route::post('order-return', [OrderController::class, 'return_list2'])->name('return_list2');

    Route::get('return_to_delivery_assign', 'OrderController@return_to_delivery_assign')->name('return.delivery.assign');

    Route::get('delivery/update', [OrderController::class, 'delivery_update'])->name('delivery.data.update');

    Route::get('collect/hub/store', [OrderStatusHistoryController::class, 'hub_collection_store'])->name('collection.hub.store');
    Route::get('collect/hub/store-all', [OrderStatusHistoryController::class, 'hub_all_collection_store'])->name('collection.hub.store.all');
});


//-------------------------- Slider ------------------------
Route::prefix('slider/')->middleware('auth')->name('slider.')->group(function () {
    Route::get('index', [SliderController::class, 'index'])->name('index');
    Route::post('store', [SliderController::class, 'store'])->name('store');
    Route::get('edit', [SliderController::class, 'edit'])->name('edit');
    Route::post('update', [SliderController::class, 'update'])->name('update');
    Route::get('status', [SliderController::class, 'status'])->name('status');
    Route::get('delete', [SliderController::class, 'destroy'])->name('destroy');
});

//-------------------------- Business Type ------------------------
Route::prefix('business-type/')->middleware('auth')->name('business.type.')->group(function () {
    Route::get('index', [BusinessTypeController::class, 'index'])->name('index');
    Route::post('store', [BusinessTypeController::class, 'store'])->name('store');
    Route::get('edit', [BusinessTypeController::class, 'edit'])->name('edit');
    Route::post('update', [BusinessTypeController::class, 'update'])->name('update');
    Route::get('status', [BusinessTypeController::class, 'status'])->name('status');
    Route::get('delete', [BusinessTypeController::class, 'destroy'])->name('destroy');
});






//-------------------------- Coverage Area ------------------------
Route::prefix('coverage-area/')->middleware('auth')->name('coverage.area.')->group(function () {
    Route::get('index', [CoverageAreaController::class, 'index'])->name('index');
    Route::post('store', [CoverageAreaController::class, 'store'])->name('store');
    Route::post('edit', [CoverageAreaController::class, 'edit'])->name('edit');
    Route::post('update', [CoverageAreaController::class, 'update'])->name('update');
    Route::get('status', [CoverageAreaController::class, 'status'])->name('status');
    Route::get('destroy', [CoverageAreaController::class, 'destroy'])->name('destroy');
});

//--------------------------  District List  ------------------------
Route::prefix('district-list/')->middleware('auth')->name('district.list.')->group(function () {
    Route::get('index', [DistrictAreaController::class, 'index'])->name('index');
    Route::post('store', [DistrictAreaController::class, 'store'])->name('store');
    Route::post('edit', [DistrictAreaController::class, 'edit'])->name('edit');
    Route::post('update', [DistrictAreaController::class, 'update'])->name('update');
    Route::get('status', [DistrictAreaController::class, 'status'])->name('status');
    Route::get('destroy', [DistrictAreaController::class, 'destroy'])->name('destroy');
});




//-------------------------- Merchant ------------------------
Route::prefix('shop-merchant/')->middleware('auth')->name('shop.merchant.')->group(function () {
    Route::get('index', [MerchantController::class, 'index'])->name('index');
    Route::get('password-manage', [MerchantController::class, 'password_manage'])->name('password_manage');
    Route::get('password-id-get', [MerchantController::class, 'get_id'])->name('get_id');
    Route::post('update-password', [MerchantController::class, 'update_password'])->name('update_password');
    Route::get('preview', [MerchantController::class, 'preview'])->name('preview');
    Route::get('preview-print', [MerchantController::class, 'print'])->name('preview.print');
    Route::get('edit', [MerchantController::class, 'edit'])->name('edit');
    Route::post('update', [MerchantController::class, 'update'])->name('update');
    Route::get('status', [MerchantController::class, 'status'])->name('status');
    Route::get('dashboard', [MerchantController::class, 'dashboard'])->name('dashboard');
});

//-------------------------- Expense Type ------------------------
Route::prefix('expense/')->middleware('auth')->name('Expense.')->group(function () {
    Route::get('index', [ExpenseController::class, 'index'])->name('index');
    Route::get('report-print', [ExpenseController::class, 'Report_Print'])->name('Report_Print');
    Route::get('report', [ExpenseController::class, 'report'])->name('report');
    Route::post('store-expense-type', [ExpenseController::class, 'ExpenseType'])->name('ExpenseType');
    Route::post('store-expense-list', [ExpenseController::class, 'Expense_List'])->name('Expense_List');
    Route::get('list', [ExpenseController::class, 'list'])->name('list');
    Route::get('edit', [ExpenseController::class, 'edit'])->name('edit');
    Route::get('expense-list-edit', [ExpenseController::class, 'expense_list_edit'])->name('expense_list_edit');
    Route::post('expense-list-update', [ExpenseController::class, 'expense_list_update'])->name('expense_list_update');
    Route::get('destroy', [ExpenseController::class, 'destroy'])->name('destroy');
    Route::get('Expense-destroy', [ExpenseController::class, 'expense_destroy'])->name('expense_destroy');
    Route::post('update', [ExpenseController::class, 'update'])->name('update');
});

//-------------------------- Income Type And Income Management ------------------------
Route::prefix('income/')->middleware('auth')->name('Income.')->group(function () {
    Route::get('index', [IncomeController::class, 'index'])->name('index');
    Route::get('edit', [IncomeController::class, 'edit'])->name('edit');
    Route::post('store', [IncomeController::class, 'store'])->name('store');
    Route::post('update', [IncomeController::class, 'update'])->name('update');
    Route::get('destroy', [IncomeController::class, 'destroy'])->name('destroy');
    Route::get('list', [IncomeController::class, 'list'])->name('list');
    Route::get('list-edit', [IncomeController::class, 'list_edit'])->name('list.edit');
    Route::post('list-store', [IncomeController::class, 'list_store'])->name('list.store');
    Route::post('list-update', [IncomeController::class, 'list_update'])->name('list.update');
    Route::get('list-destroy', [IncomeController::class, 'list_destroy'])->name('list.destroy');
    Route::get('income-report', [IncomeController::class, 'income_report'])->name('report');
    Route::get('income-report-print', [IncomeController::class, 'income_report_print'])->name('report.print');
   
});

//-------------------------- Income Type And Income Management ------------------------
Route::prefix('income-expense-summary')->middleware('auth')->name('Summary.')->group(function () {
    Route::get('view', [IncomeController::class, 'view'])->name('view');
   // Route::get('edit', [IncomeController::class, 'edit'])->name('edit');
  
   
});

Route::prefix('agent-collect')->middleware('auth')->name('agent.collect.')->group(function () {
    Route::get('/', [CollectController::class, 'agent_collect'])->name('index');
    Route::get('/show/{agent}', [CollectController::class, 'agent_collect_show'])->name('show');
    Route::get('/print/{agent}', [CollectController::class, 'agent_collect_print'])->name('print');
    Route::get('/collected/{agent}', [CollectController::class, 'agent_payment_collec'])->name('agent.collected');
});

Route::prefix('merchant-collect')->middleware('auth')->name('merchant.payment.collect.')->group(function () {
    Route::get('/', [CollectController::class, 'merchant_payment_collect'])->name('index');
    Route::get('/show', [CollectController::class, 'merchant_payment_show'])->name('show');
    Route::get('/conform', [CollectController::class, 'merchant_payment_conform'])->name('conform');
});

Route::prefix('rider-payment-processing')->middleware('auth')->name('rider.payment.collect.')->group(function () {
    Route::get('/', [CollectController::class, 'rider_payment_collect'])->name('index');
    Route::get('/print', [CollectController::class, 'rider_payment_collect_history'])->name('print');
    // Route::get('/conform', [CollectController::class, 'merchant_payment_conform'])->name('conform');
});

Route::prefix('branch-payment-processing')->middleware('auth')->name('branch.payment.collect.')->group(function () {
    Route::get('/', [CollectController::class, 'branch_payment_collect'])->name('index');
    Route::get('/print', [CollectController::class, 'branch_payment_collect_history'])->name('print');
    // Route::get('/conform', [CollectController::class, 'merchant_payment_conform'])->name('conform');
});


Route::prefix('rider-attendance')->middleware('auth')->name('rider.attendance.')->group(function () {
    Route::get('/', [CollectController::class, 'rider_attendance'])->name('index');
    Route::get('/employee-get', [CollectController::class, 'branch_wise_employee'])->name('branch_wise_employee');
    Route::get('/daily-attendance', [CollectController::class, 'daily_attendance'])->name('daily.attendance');
    Route::get('/daily-attendance-print', [CollectController::class, 'daily_attendance_print'])->name('daily.attendance.print');
    Route::get('/date-wise-attendance', [CollectController::class, 'date_wise_attendance'])->name('date_wise.attendance');
    Route::get('/date-wise-attendance-print', [CollectController::class, 'date_wise_attendance_print'])->name('date_wise.attendance.print');
    Route::get('/monthly-attendance-all-employee', [CollectController::class, 'monthly_attendance_all_employee'])->name('monthly.attendance.all.employee');
    Route::get('/monthly-attendance-all-employee-print', [CollectController::class, 'monthly_attendance_all_employee_print'])->name('monthly.attendance.all.employee.print');
    Route::get('/monthly-attendance-employee-wise', [CollectController::class, 'monthly_attendance'])->name('monthly.attendance');
    Route::get('/branch-wise-monthly-attendance', [CollectController::class, 'branch_wise_monthly_attendance'])->name('branch.wise.monthly.attendance');
    Route::get('/branch-wise-monthly-attendance-print', [CollectController::class, 'branch_wise_monthly_attendance_print'])->name('branch.wise.monthly.attendance.print');
    Route::get('/employee-wise-monthly-attendance-summary', [CollectController::class, 'employee_wise_monthly_attendance_summary'])->name('employee.wise.monthly.attendance.summary');
    Route::get('/monthly-attendance-employee-wise-print', [CollectController::class, 'monthly_attendance_print'])->name('monthly.attendance.print');
    Route::get('/all-confirmed-attendance', [CollectController::class, 'rider_confirm_attendance'])->name('all');
    Route::post('/all-attendance-store', [CollectController::class, 'rider_all_attendance_store'])->name('all.store');
    Route::post('/temp-store', [CollectController::class, 'rider_attendance_temp_store'])->name('rider_attendance_temp_store');
    Route::get('/print', [CollectController::class, 'branch_payment_collect_history'])->name('print');
    // Route::get('/conform', [CollectController::class, 'merchant_payment_conform'])->name('conform');
});

Route::prefix('employee-attendance')->middleware('auth')->name('employee.attendance.')->group(function () {
    Route::get('/', [CollectController::class, 'employee_attendance'])->name('index');
    Route::post('/all-attendance-store', [CollectController::class, 'employee_all_attendance_store'])->name('all.store');
    Route::get('/print', [CollectController::class, 'branch_payment_collect_history'])->name('print');
    // Route::get('/conform', [CollectController::class, 'merchant_payment_conform'])->name('conform');
});







Route::prefix('rider-collect')->middleware('auth')->name('rider.collect.')->group(function () {
    Route::get('/', [RiderCollectController::class, 'rider_collect'])->name('index');
    Route::get('/show/{rider}', [RiderCollectController::class, 'rider_collect_show'])->name('show');
    Route::get('/collected/{rider}', [RiderCollectController::class, 'rider_payment_collec'])->name('rider.collected');
});
Route::prefix('merchent-pay-info')->middleware('auth')->name('merchent.pay.info.')->group(function () {
    Route::get('/', [MerchantAdvancePaymentController::class, 'merchent_pay_info'])->name('index');
    Route::post('/load', [MerchantAdvancePaymentController::class, 'merchent_pay_info_load'])->name('load');
    Route::get('/show/{merchantpay}', [MerchantAdvancePaymentController::class, 'merchent_pay_info_show'])->name('show');
    Route::get('/print/{merchantpay}', [MerchantAdvancePaymentController::class, 'merchent_pay_info_print'])->name('print');
});

Route::prefix('merchent-pay-information')->middleware('auth')->name('merchent.pay.information.')->group(function () {
    Route::get('/', [MerchantHistoryPaymentController::class, 'merchent_pay_info'])->name('index');
    Route::post('/load', [MerchantHistoryPaymentController::class, 'merchent_pay_info_load'])->name('load');
    Route::get('/show/{invoice_id?}', [MerchantHistoryPaymentController::class, 'merchent_pay_info_show'])->name('show');
    Route::get('/print/{invoice_id?}', [MerchantHistoryPaymentController::class, 'merchent_pay_info_print'])->name('print');
    Route::get('/export-print-details', [MerchantHistoryPaymentController::class, 'export_details_print'])->name('export_details_print');
    Route::get('/confirm/{merchantpay}', [MerchantHistoryPaymentController::class, 'merchent_pay_info_confirm'])->name('confirm');
});

   



Route::prefix('admin-bypass-to-return')->middleware('auth')->name('admin.bypass.to.return.')->group(function () {
    Route::get('/', [BypassController::class, 'index'])->name('index');
    Route::get('/cancel-aprove/{id}', [BypassController::class, 'aprove'])->name('cancel.aprove');
    Route::get('/cancel-reject/{id}', [BypassController::class, 'reject'])->name('cancel.reject');
    // Route::get('category/category-{category:slug}', [FrontendController::class, 'getProductCategory'])->name('product.category');
});


Route::prefix('rider-transfer/pickup')->middleware('auth')->name('rider.transfer.pickup.')->group(function () {
    Route::get('/', [AdminPanelController::class, 'rider_transfer_pickup'])->name('index');
    Route::get('/load', [AdminPanelController::class, 'rider_transfer_pickup_load'])->name('load');
    Route::post('/bypass_order', [AdminPanelController::class, 'rider_transfer_pickup_bypass_order'])->name('order.bypass');
});

Route::prefix('rider-transfer/delivery')->middleware('auth')->name('rider.transfer.delivery.')->group(function () {
    Route::get('/', [AdminPanelController::class, 'rider_transfer_delivery'])->name('index');
    Route::get('/load', [AdminPanelController::class, 'rider_transfer_delivery_load'])->name('load');
    Route::post('/bypass_order', [AdminPanelController::class, 'rider_transfer_delivery_bypass_order'])->name('order.bypass');
});


Route::prefix('agent-pickup-bypass')->middleware('auth')->name('agent.pickup.bypass.')->group(function () {
    Route::get('/', [AgentPickupBypassController::class, 'index'])->name('index');
    Route::get('/load', [AgentPickupBypassController::class, 'load'])->name('load');
    Route::post('/order-pickup', [AgentPickupBypassController::class, 'bypass_order'])->name('order.pickup');
});

Route::prefix('agent-delivery-bypass')->middleware('auth')->name('agent.delivery.bypass.')->group(function () {
    Route::get('/', [AgentDeliveryBypassController::class, 'index'])->name('index');
    Route::get('/load', [AgentDeliveryBypassController::class, 'load'])->name('load');
    Route::post('/order-delivery', [AgentDeliveryBypassController::class, 'bypass_order'])->name('order.delivery');
});

Route::prefix('agent-order-bypass')->middleware('auth')->name('agent.order.bypass.')->group(function () {
    Route::get('/', [AgentOrderBypassController::class, 'index'])->name('index');
    Route::get('/aprove', [AgentOrderBypassController::class, 'aprove'])->name('aprove');
    Route::post('/order-order', [AgentOrderBypassController::class, 'bypass_order'])->name('order.order');
    Route::post('/confirm', [AgentOrderBypassController::class, 'confirm'])->name('confirm');
});




Route::prefix('payment-confirmation')->middleware('auth')->name('payment.confirmation.')->group(function () {
    Route::get('/', [PaymentConfirmationController::class, 'index'])->name('index');
});



Route::prefix('merchant')->middleware('auth')->name('merchant.')->group(function () {
    Route::get('/payment-adjustment', [MerchantController::class, 'payment_adjustment'])->name('payment.adjustment');
    Route::get('/payment-adjustment-print', [MerchantController::class, 'payment_adjustment_print'])->name('payment.adjustment.print');
    Route::get('/advance-payment', [MerchantController::class, 'advance_payment'])->name('advance.payment');
    Route::get('/advance-payment-print', [MerchantController::class, 'advance_payment_print'])->name('advance.payment.print');
});



Route::prefix('scheduler')->middleware('auth')->name('scheduler.')->group(function () {

    Route::get('/', [SchedulerController::class, 'index'])->name('index');
    Route::post('store', [SchedulerController::class, 'store'])->name('store');
    Route::get('edit', [SchedulerController::class, 'edit'])->name('edit');
    Route::post('update', [SchedulerController::class, 'update'])->name('update');
    Route::get('status', [SchedulerController::class, 'status'])->name('status');
    Route::get('delete', [SchedulerController::class, 'destroy'])->name('destroy');
});


Route::prefix('autoassign')->middleware('auth')->name('autoassign.')->group(function () {

    Route::get('/', [AutoAssignController::class, 'index'])->name('index');
    Route::post('store', [AutoAssignController::class, 'store'])->name('store');
    Route::get('edit', [AutoAssignController::class, 'edit'])->name('edit');
    Route::post('update', [AutoAssignController::class, 'update'])->name('update');
    Route::get('status', [AutoAssignController::class, 'status'])->name('status');
    Route::get('delete', [AutoAssignController::class, 'destroy'])->name('destroy');
});



Route::post('inactive-user-info', [MerchantRegistrationController::class, 'inactive_user_info'])->name('merchant.user.infoadd');





// Artisan command
// Route::get('route-clear', function () {
//     Artisan::call('route:clear');
//     dd("Route Cleared");
// });
// Route::get('optimize', function () {
//     Artisan::call('optimize');
//     dd("Optimized");
// });
// Route::get('view-clear', function () {
//     Artisan::call('view:clear');
//     dd("View Cleared");
// });
// Route::get('view-cache', function () {
//     Artisan::call('view:cache');
//     dd("View cleared and cached again");
// });
// Route::get('config-cache', function () {
//     Artisan::call('config:cache');
//     dd("configuration cleared and cached again");
// });


Route::get('loginblock', [LoginBlockController::class, 'logout'])->name('login.block.logout');
Route::get('loginblock', [LoginBlockController::class, 'redirect'])->name('login.block.redirect');
