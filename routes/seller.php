<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Seller\RoleController;
use App\Http\Controllers\Seller\ConfigController;
use App\Http\Controllers\Seller\PayoutController;
use App\Http\Controllers\Seller\ReportController;
use App\Http\Controllers\Seller\ReturnController;
use App\Http\Controllers\Seller\TicketController;
use App\Http\Controllers\Seller\AddressController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\ProfileController;
use App\Http\Controllers\Seller\ModeratorController;
use App\Http\Controllers\Seller\SettlementController;
use App\Http\Controllers\Seller\Order\OrderController;
use App\Http\Controllers\Seller\Advertise\AdController;
use App\Http\Controllers\Seller\NotificationController;
use App\Http\Controllers\Seller\Coupon\CouponController;
use App\Http\Controllers\Seller\BalanceHistoryController;
use App\Http\Controllers\Seller\EmergencyContactController;
use App\Http\Controllers\Seller\Settings\PickupHubController;
use App\Http\Controllers\Seller\ProductQuestionAnswerController;
use App\Http\Controllers\Seller\BankAccount\BankAccountController;
use App\Http\Controllers\Seller\Settings\GeneralSettingsController;

/*
|--------------------------------------------------------------------------
| Web Routes || Employee Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware' => 'role:seller'], function () {

    Route::get('/', function () {
        return redirect()->route('seller.login');
    });

    Route::get('/cache/clear', [CacheController::class, 'clear'])->name('clear.cache');

    Route::get('/dashboard', 'HomeController@dashboard')->name('home.dashboard');

    // ad
    Route::group(['prefix' => 'ad', 'as' => 'ad.', 'controller' => AdController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:seller_ad_request_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:seller_ad_request_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:seller_ad_request_create');
        Route::get('/{ad}/edit', 'edit')->name('edit')->middleware('permission:seller_ad_request_update');
        Route::post('/{ad}/update', 'update')->name('update')->middleware('permission:seller_ad_request_update');
        Route::post('/{ad}/delete', 'destroy')->name('delete')->middleware('permission:seller_ad_request_delete');
    });

    // Coupon
    Route::group(['prefix' => 'coupons', 'as' => 'coupon.', 'controller' => CouponController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:seller_coupon_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:seller_coupon_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:seller_coupon_create');
        Route::get('/{coupon}/edit', 'edit')->name('edit')->middleware('permission:seller_coupon_update');
        Route::post('/{coupon}/update', 'update')->name('update')->middleware('permission:seller_coupon_update');
        Route::post('/{coupon}/delete', 'destroy')->name('delete')->middleware('permission:seller_coupon_delete');
    });

    // Bank Account
    Route::group(['prefix' => 'bankAccount', 'as' => 'bankAccount.', 'controller' => BankAccountController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:seller_bank_account_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:seller_bank_account_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:seller_bank_account_create');
        Route::get('/{bank_account}/edit', 'edit')->name('edit')->middleware('permission:seller_bank_account_update');
        Route::get('/{bank_account}/show', 'show')->name('show');
        Route::post('/{bank_account}/update', 'update')->name('update')->middleware('permission:seller_bank_account_update');
        Route::post('/{bank_account}/delete', 'destroy')->name('delete')->middleware('permission:seller_bank_account_delete');
    });

    // Order
    Route::group(['prefix' => 'order', 'as' => 'order.', 'controller' => OrderController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:seller_order_index');
        Route::get('/{sellerOrder}/show', 'show')->name('show')->middleware('permission:seller_order_show');
        Route::post('/{seller_order}/status-change', 'changeStatus')->name('change_status');
        Route::get('/{seller_order}/invoice/view', 'invoiceView')->name('invoice.view')->middleware('permission:seller_order_invoice');
        Route::get('/{order}/invoice/download', 'invoiceDownload')->name('invoice.download')->middleware('permission:seller_order_invoice_download');
    });

    // Profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'controller' => ProfileController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/update', 'showUpdateForm')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::get('/shop', 'shop')->name('shop');
        Route::get('/shop/update', 'showShopUpdateForm')->name('shop.update');
        Route::post('shop/update', 'updateShop');
        Route::get('/update-password', 'showUpdatePasswordForm')->name('update_password');
        Route::post('/update-password', 'updatePassword');
        Route::get('/notification/all', 'showAllNotifications')->name('notification');
        Route::get('/attendance', 'attendance')->name('attendance');
        Route::post('/security/update', 'securityUpdate')->name('security.update');
    });

    Route::group(['prefix' => 'address', 'as' => 'address.', 'controller' => AddressController::class], function () {
        Route::post('{user}/create', 'store')->name('create');
        Route::post('{address}/update', 'update')->name('update');
    });

    // Employees
    Route::group(['prefix' => 'moderators', 'as' => 'moderator.', 'controller' => ModeratorController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:seller_moderator_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:seller_moderator_create');
        Route::post('/create', 'create')->middleware('permission:seller_moderator_create');
        Route::get('/{employee}/update', 'showUpdateForm')->name('update')->middleware('permission:seller_moderator_update');
        Route::post('/{employee}/update', 'update')->middleware('permission:seller_moderator_update');
        Route::post('/{employee}/security/update', 'securityUpdate')->name('security.update')->middleware('permission:seller_moderator_update');
        Route::get('/{employee}/show', 'show')->name('show')->middleware('permission:seller_moderator_show');
        Route::post('/{user}/update-status-api', 'updateStatusApi')->name('update_status.api')->middleware('permission:seller_moderator_update');
        Route::post('/{user}/update-password-api', 'updatePasswordApi')->name('update_password.api')->middleware('permission:seller_moderator_change_password');
        Route::post('/{user}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:seller_moderator_delete');
        Route::post('/{id}/restore-api', 'restoreApi')->name('restore.api')->middleware('permission:seller_moderator_restore');
    });

    // Emergency Contact
    Route::group(['prefix' => 'emergency', 'as' => 'emergency.', 'controller' => EmergencyContactController::class], function () {
        Route::get('/{user}/create', 'showCreateForm')->name('create');
        Route::post('/{user}/create', 'create');
        Route::get('/{emergency}/update', 'showUpdateForm')->name('update');
        Route::post('/{emergency}/update', 'update');
        Route::post('/{emergency}/delete-api', 'deleteApi')->name('delete.api');
    });

    // Attachment
    // Route::group(['prefix' => 'attachments', 'as' => 'attachment.', 'controller' => AttachmentController::class], function () {
    //     Route::get('/', 'index')->name('index');
    //     Route::get('/create', 'create');
    //     Route::post('/store', 'store')->name('store');
    //     Route::get('/{attachment}/edit', 'edit')->name('edit');
    //     Route::post('/{attachment}/update', 'update')->name('update');
    //     Route::post('/{attachment}/delete', 'destroy')->name('delete');
    // });

    // Notifications
    Route::group(['prefix' => 'notifications', 'as' => 'notification.', 'controller' => NotificationController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:seller_notification_index');
        Route::get('/{notification}', 'show')->name('show')->middleware('permission:seller_notification_index');
    });

    // Tickets
    Route::group(['prefix' => 'tickets', 'as' => 'ticket.', 'controller' => TicketController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:seller_ticket_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:seller_ticket_create');
        Route::post('/create', 'create')->middleware('permission:seller_ticket_create');
        Route::get('/{ticket}/update', 'showUpdateForm')->name('update')->middleware('permission:seller_ticket_update');
        Route::post('/{ticket}/update', 'update')->middleware('permission:seller_ticket_update');
        Route::get('/{ticket}/show', 'show')->name('show')->middleware('permission:seller_ticket_show');
        Route::post('/{ticket}/reply', 'reply')->name('reply')->middleware('permission:seller_ticket_reply');
        Route::get('/{ticket}/reopen', 'reOpen')->name('reopen')->middleware('permission:seller_ticket_reopen');
    });

    // Start Product Routes
    Route::group(['prefix' => 'products', 'as' => 'product.', 'controller' => ProductController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:seller_product_index');
        Route::get('/alert', 'showAlertProducts')->name('alert')->middleware('permission:seller_product_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:seller_product_create');
        Route::post('get-variants', 'variants')->name('getVariants')->middleware('permission:seller_product_create');
        Route::post('/{product}/get-variants-edit', 'variantsEdit')->name('getVariantsEdit')->middleware('permission:seller_product_create');
        Route::post('/get-attribute-values', 'getAttributeValues')->name('get-attribute-values')->middleware('permission:seller_product_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:seller_product_create');
        Route::post('/{product}/status-change', 'changeStatus')->name('change_status')->middleware('permission:seller_product_change_status');
        Route::post('/{product}/refundable', 'isRefundable')->name('refundable')->middleware('permission:seller_product_refundable');
        Route::post('/{product}/showHomePage', 'isShowHomePage')->name('showHomePage')->middleware('permission:seller_product_showHomePage');
        Route::post('/{product}/delete', 'destroy')->name('delete')->middleware('permission:seller_product_delete');
        Route::get('/{product}/edit', 'edit')->name('edit')->middleware('permission:seller_product_update');
        Route::post('/{product}/update', 'update')->name('update')->middleware('permission:seller_product_update');
        Route::get('/{product}/clone', 'cloneProduct')->name('clone')->middleware('permission:seller_product_create_clone');
        Route::post('/{product}/clone', 'storeCloneProduct')->name('clone.post')->middleware('permission:seller_product_create_clone');

        // Review
        Route::get('/{product}/reviews', 'showReviews')->name('reviews')->middleware('permission:seller_review_index');
        Route::get('/reviews', 'allReviews')->name('all_reviews')->middleware('permission:seller_review_all_index');
        Route::get('/{review_message}/get-message', 'getMessage')->name('getMessage');
        Route::post('/{review}/review_change_status', 'reviewStatus')->name('review_change_status')->middleware('permission:seller_review_index');


        // Question & Answer
        Route::group(['prefix' => '{product}/questions', 'as' => 'question.', 'controller' => ProductQuestionAnswerController::class], function () {

            Route::get('/', 'index')->name('index')->middleware('permission:seller_product_question_index');
            Route::get('/{productQuestion}/answer', 'answer')->name('answer')->middleware('permission:seller_product_question_answer');
            Route::post('/{productQuestion}/store_answer', 'storeAnswer')->name('storeAnswer')->middleware('permission:seller_product_question_answer');
            Route::post('/{productQuestion}/status-change', 'changeStatus')->name('change_status')->middleware('permission:seller_product_question_change_status');
            Route::post('/{productQuestion}/delete', 'destroy')->name('delete')->middleware('permission:seller_product_question_delete');

        });

    });

    // Sale Return
    Route::group(['prefix' => 'returns', 'as' => 'return.', 'controller' => ReturnController::class], function () {

        Route::get('/', 'index')->name('index');
        Route::post('/get', 'getSale')->name('get');
        Route::get('/{order_return}/show', 'show')->name('show');
        Route::post('/{order_return}/update', 'update')->name('update');
    });

    // Config
    Route::group(['prefix' => 'configs', 'as' => 'config.', 'controller' => ConfigController::class], function () {

        // Roles & Permissions
        Route::group(['prefix' => 'roles', 'as' => 'role.', 'controller' => RoleController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:seller_role_index');
            Route::get('/{role}/show-api', 'showApi')->name('show.api')->middleware('permission:seller_role_index');
            Route::post('/create', 'createApi')->name('create.api')->middleware('permission:seller_role_create');
            Route::post('/{role}/update-api', 'updateApi')->name('update.api')->middleware('permission:seller_role_update');
            Route::post('/{role}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:seller_role_delete');
            Route::get('/{role}/permissions', 'permissions')->name('permission')->middleware('permission:seller_role_show_permission');
            Route::post('/{role}/permissions/update', 'updatePermissions')->name('permission.update')->middleware('permission:seller_role_update_permission');
        });

        // General Settings
        Route::group(['prefix' => 'general-settings', 'as' => 'general_settings.', 'controller' => GeneralSettingsController::class], function () {

            Route::get('/', 'index')->name('index');

            Route::group(['prefix' => 'pickup-hub', 'as' => 'pickup_hub.', 'controller' => PickupHubController::class], function () {

                Route::get('/', 'index')->name('index')->middleware('permission:seller_pickup_hub_index');
                Route::get('/district/get', 'divisionWiseDistrict')->name('district.get')->middleware('permission:seller_pickup_hub_create');
                Route::get('/thana/get', 'districtWiseThana')->name('thana.get')->middleware('permission:seller_pickup_hub_create');
                Route::get('/area/get', 'thanaWiseArea')->name('area.get')->middleware('permission:seller_pickup_hub_create');
                Route::get('/create', 'create')->name('create')->middleware('permission:seller_pickup_hub_create');
                Route::post('/store', 'store')->name('store')->middleware('permission:seller_pickup_hub_create');
                Route::get('/{pickupHub}/edit', 'edit')->name('edit')->middleware('permission:seller_pickup_hub_update');
                Route::post('/{pickupHub}/update', 'update')->name('update')->middleware('permission:seller_pickup_hub_update');
                Route::post('/{pickupHub}/delete', 'destroy')->name('delete')->middleware('permission:seller_pickup_hub_delete');

            });

        });

    });

    // Payout Request
    Route::group(['prefix' => 'payouts', 'as' => 'payout.', 'controller' => PayoutController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:seller_payout_index');
        Route::post('/store', 'store')->name('store')->middleware('permission:seller_payout_create');
        Route::get('/{payout}/edit', 'edit')->name('edit')->middleware('permission:seller_payout_update');
        Route::post('/{payout}/update', 'update')->name('update')->middleware('permission:seller_payout_update');
        Route::post('/{payout}/delete', 'destroy')->name('delete')->middleware('permission:seller_payout_delete');
    });

    // Payout Request
    Route::group(['prefix' => 'balance-history', 'controller' => BalanceHistoryController::class], function () {
        Route::get('/', 'index')->name('balance.history')->middleware('permission:seller_payout_index');
    });

    // Settlements
    Route::group(['prefix' => 'settlements', 'as' => 'settlement.', 'controller' => SettlementController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:seller_payout_index');
        Route::get('/{settlement}/details', 'details')->name('details')->middleware('permission:seller_payout_index');
    });

    // Report
    Route::group(['prefix' => 'report', 'as' => 'report.', 'controller' => ReportController::class], function () {
        Route::get('/stock', 'stock')->name('stock')->middleware('permission:seller_payout_index');
        Route::get('/order', 'order')->name('order')->middleware('permission:seller_payout_index');
        Route::get('/settlements', 'settlement')->name('settlements')->middleware('permission:seller_payout_index');
    });
});
