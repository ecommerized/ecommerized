<?php

use App\Http\Controllers\Admin\OrderTaskBoardController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\ClientInvoiceController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\Admin\ClientOrderController as AdminOrderController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\PlanController;
use App\Http\Controllers\User\TicketController;
use Illuminate\Support\Facades\Route;


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
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('order-summery', [DashboardController::class, 'orderSummery'])->name('order-summery');

//notification  route start
Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
    Route::get('all', [NotificationController::class, 'allNotification'])->name('all');
    Route::get('mark-as-read', [NotificationController::class, 'notificationMarkAsRead'])->name('mark-as-read');
    Route::get('view/{id}', [NotificationController::class, 'notificationView'])->name('view');
    Route::get('delete/{id}', [NotificationController::class, 'notificationDelete'])->name('delete');

    Route::get('notification-mark-all-as-read', [NotificationController::class, 'notificationMarkAllAsRead'])->name('notification-mark-all-as-read');
    Route::get('notification-mark-as-read/{id}', [NotificationController::class, 'notificationMarkAsRead'])->name('notification-mark-as-read');
});
// notification route end

// order route start
Route::group(['prefix' => 'orders', 'as' => 'orders.'], function () {
    Route::get('/', [AdminOrderController::class, 'list'])->name('list');
    Route::get('service-list/{id}', [AdminOrderController::class, 'serviceList'])->name('service.list');
    Route::get('details/{id}', [OrderController::class, 'details'])->name('details');
    Route::post('conversation', [OrderController::class, 'conversationStore'])->name('conversation.store');

    Route::group(['prefix' => 'task-board', 'as' => 'task-board.'], function () {
        Route::get('/{order_item_id}', [OrderTaskBoardController::class, 'list'])->name('index');
        Route::get('/{order_item_id}/view/{id}', [OrderTaskBoardController::class, 'view'])->name('view');
        Route::get('/{order_item_id}/upload-requirements/{id}', [OrderTaskBoardController::class, 'uploadRequirementModal'])->name('upload_requirements');
        Route::post('/{order_item_id}/upload-requirements/{id}', [OrderTaskBoardController::class, 'uploadRequirement'])->name('upload_requirements.store');
        Route::group(['prefix' => 'conversation', 'as' => 'conversation.'], function () {
            Route::post('{order_id}/{id}', [OrderTaskBoardController::class, 'conversationStore'])->name('store');
        });
    });
});
// order route end

Route::group(['prefix' => 'plans', 'as' => 'plans.'], function () {
    Route::get('/', [PlanController::class, 'list'])->name('list');
    Route::get('details/{id}', [PlanController::class, 'details'])->name('details');
    Route::get('search', [PlanController::class, 'search'])->name('search');
});

// client-profile
Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::post('update', [ProfileController::class, 'update'])->name('update')->middleware('isDemo');
    Route::get('password', [ProfileController::class, 'password'])->name('password');
    Route::post('password-update', [ProfileController::class, 'passwordUpdate'])->name('password.update')->middleware('isDemo');
});

Route::group(['prefix' => 'ticket', 'as' => 'ticket.'], function () {
    Route::get('/', [TicketController::class, 'list'])->name('list');
    Route::get('add-new', [TicketController::class, 'addNew'])->name('add-new');
    Route::get('edit/{id}', [TicketController::class, 'edit'])->name('edit');
    Route::post('store', [TicketController::class, 'store'])->name('store');
    Route::get('details/{id}', [TicketController::class, 'details'])->name('details');
    Route::post('delete/{id}', [TicketController::class, 'delete'])->name('delete');
    Route::get('assign-member', [TicketController::class, 'assignMember'])->name('assign-member');
    Route::get('priority-change/{ticket_id}/{priority}', [TicketController::class, 'priorityChange'])->name('priority-change');
    Route::post('conversations-store', [TicketController::class, 'conversationsStore'])->name('conversations.store');
    Route::post('conversations-edit', [TicketController::class, 'conversationsEdit'])->name('conversations.edit');
    Route::post('conversations-delete/{id}', [TicketController::class, 'conversationsDelete'])->name('conversations.delete');
    Route::get('status-change', [TicketController::class, 'statusChange'])->name('status.change');
});

Route::post('gateway-list', [CheckoutController::class, 'gatewayList'])->name('gateway.list');
Route::get('currency-list', [CheckoutController::class, 'currencyList'])->name('currency.list');
Route::get('checkout/{id}/{type}', [CheckoutController::class, 'checkoutModal'])->name('checkout.modal');
Route::post('checkout/order', [CheckoutController::class, 'checkoutOrderPlace'])->name('checkout.order.place');


// invoice route
Route::group(['prefix' => 'client-invoice', 'as' => 'client-invoice.'], function () {
    Route::get('/', [ClientInvoiceController::class, 'list'])->name('list');
    Route::get('details/{id}', [ClientInvoiceController::class, 'details'])->name('details');
    Route::get('print/{id}', [ClientInvoiceController::class, 'invoicePrint'])->name('print');
});
