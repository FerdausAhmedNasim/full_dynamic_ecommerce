<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LogController;
use App\Http\Controllers\Admin\PosController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CacheController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ConfigController;
use App\Http\Controllers\Admin\PayoutController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\ReturnController;
use App\Http\Controllers\Admin\TicketController;
use App\Http\Controllers\Admin\AddressController;
use App\Http\Controllers\Admin\ExpenseController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\WithdrawController;
use App\Http\Controllers\Admin\Area\AreaController;
use App\Http\Controllers\Admin\ContactUsController;
use App\Http\Controllers\Admin\PickupHubController;
use App\Http\Controllers\Admin\Area\ThanaController;
use App\Http\Controllers\Admin\AttachmentController;
use App\Http\Controllers\Admin\SettlementController;
use App\Http\Controllers\Admin\SubscriberController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\Website\PageController;
use App\Http\Controllers\Admin\Coupon\CouponController;
use App\Http\Controllers\Admin\Product\BrandController;
use App\Http\Controllers\Admin\Product\ColorController;
use App\Http\Controllers\Admin\Website\VideoController;
use App\Http\Controllers\Admin\EmailSignatureController;
use App\Http\Controllers\Admin\Website\SliderController;
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Admin\Product\ProductController;
use App\Http\Controllers\Admin\Website\BenefitController;
use App\Http\Controllers\Admin\Advertisement\AdController;
use App\Http\Controllers\Admin\EmergencyContactController;
use App\Http\Controllers\Admin\Product\CategoryController;
use App\Http\Controllers\Admin\Website\SettingsController;
use App\Http\Controllers\Admin\Area\AreaSettingsController;
use App\Http\Controllers\Admin\Product\AttributeController;
use App\Http\Controllers\Admin\CourierPricingPlanController;
use App\Http\Controllers\Admin\User\Seller\SellerController;
use App\Http\Controllers\Admin\ProductQuestionAnswerController;
use App\Http\Controllers\Admin\User\Seller\SendMoneyController;
use App\Http\Controllers\Admin\Product\AttributeValueController;
use App\Http\Controllers\Admin\User\Customer\CustomerController;
use App\Http\Controllers\Admin\User\Employee\EmployeeController;
use App\Http\Controllers\Admin\User\Seller\SellerNoteController;

use App\Http\Controllers\Admin\Advertisement\AdLocationController;
use App\Http\Controllers\Admin\User\Seller\ReceiveMoneyController;
use App\Http\Controllers\Admin\User\Seller\SellerProductController;
use App\Http\Controllers\Admin\User\Seller\SellerCategoryController;
use App\Http\Controllers\Admin\User\Customer\CustomerProfileController;

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

Auth::routes();

Route::group(['middleware' => 'role:admin'], function () {

    Route::get('/', function () {
        return redirect()->route('admin.login');
    });

    Route::get('/dashboard', 'HomeController@dashboard')->name('home.dashboard');
    //cache
    Route::get('/cache/clear/fd', [CacheController::class, 'clear'])->name('clear.cache');

    // Users
    Route::group(['prefix' => 'users', 'as' => 'user.'], function () {

        Route::group(['prefix' => 'global', 'controller' => UserController::class], function () {
            Route::post('/{user}/update-status-api', 'updateStatusApi')->name('update_status.api')->middleware('permission:user_update_status');
            Route::post('/{user}/update-password-api', 'updatePasswordApi')->name('update_password.api')->middleware('permission:user_update_password');
            Route::post('/{user}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:user_delete');
            Route::post('/{id}/restore-api', 'restoreApi')->name('restore.api')->middleware('permission:user_restore');
            Route::get('/{user}', 'show');
        });

        // Customer
        Route::group(['prefix' => 'customers', 'as' => 'customer.', 'controller' => CustomerController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:customer_index');
            Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:customer_create');
            Route::post('/create', 'create')->name('store')->middleware('permission:customer_create');
            Route::get('/{user}/update', 'showUpdateForm')->name('update')->middleware(['permission:customer_update']);
            Route::post('/{user}/update', 'update')->middleware(['permission:customer_update']);
            Route::get('/{user}/show', 'show')->name('show');

            Route::group(['controller' => CustomerProfileController::class], function () {
                Route::get('/{user}/show/details', 'showDetails')->name('show.details')->middleware('permission:customer_show');
                Route::get('/{user}/show/address', 'showAddress')->name('show.address')->middleware('permission:customer_show');
                Route::get('/{user}/show/contact', 'showContact')->name('show.contact')->middleware('permission:customer_show');
            });

            Route::group(['controller' => OrderController::class], function () {
                Route::get('/{user}/orders', 'customerOrders')->name('order')->middleware('permission:order_index');
                Route::get('/order/{order}/detail', 'showCustomerOrder')->name('order.show')->middleware('permission:order_show');
            });
        });

        Route::group(['prefix' => '{user_type}'], function () {
            // User Edit Address
            Route::group(['prefix' => 'address', 'as' => 'address.', 'controller' => AddressController::class], function () {
                Route::post('/create', 'store')->name('create');
                Route::post('/{address}/update', 'update')->name('update');
            });
        });

        // Employees
        Route::group(['prefix' => 'employees', 'as' => 'employee.', 'controller' => EmployeeController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:employee_index');
            Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:employee_create');
            Route::post('/create', 'create')->middleware('permission:employee_create');
            Route::get('/{employee}/update', 'showUpdateForm')->name('update')->middleware('permission:employee_update');
            Route::post('/{employee}/update', 'update')->middleware('permission:employee_update');
            Route::post('/{employee}/security/update', 'securityUpdate')->name('security.update')->middleware('permission:employee_update');
            Route::get('/{employee}/show', 'show')->name('show')->middleware('permission:employee_show');

            Route::get('/{employee}/tickets', 'ticketIndex')->name('ticketIndex')->middleware('permission:ticket_index');
            Route::post('/{assign}/stock/accept', 'acceptStock')->name('accept_stock')->middleware(['permission:employee_update']);
            Route::post('{stock}/stock/status/change', 'stockStatusChange')->name('stock_status_change')->middleware(['permission:employee_update']);

            // Attachment
            Route::group(['prefix' => 'attachment', 'as' => 'attachment.', 'controller' => AttachmentController::class], function () {
                Route::get('/{employee}', 'index')->name('index')->middleware('permission:attachment_index');
                Route::get('/create/{employee}', 'create')->middleware('permission:attachment_create');
                Route::post('/store/{employee}', 'store')->name('store')->middleware('permission:attachment_create');
                Route::get('/{attachment}/edit', 'edit')->name('edit')->middleware('permission:attachment_update');
                Route::post('/{attachment}/update', 'update')->name('update')->middleware('permission:attachment_update');
                Route::post('/{attachment}/delete', 'destroy')->name('delete')->middleware('permission:attachment_delete');
            });
        });

        // Emergency Contact
        Route::group(['prefix' => 'emergency', 'as' => 'emergency.', 'controller' => EmergencyContactController::class], function () {

            Route::get('/{user}/create', 'showCreateForm')->name('create')->middleware('permission:emergency_contact_create');
            Route::post('/{user}/create', 'create')->middleware('permission:emergency_contact_create');
            Route::get('/{emergency}/update', 'showUpdateForm')->name('update')->middleware('permission:emergency_contact_update');
            Route::post('/{emergency}/update', 'update')->middleware('permission:emergency_contact_update');
            Route::post('/{emergency}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:emergency_contact_delete');
        });

        // Seller
        Route::group(['prefix' => 'sellers', 'as' => 'seller.', 'controller' => SellerController::class], function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:create');
            Route::post('/create', 'create')->name('store')->middleware('permission:create');
            Route::get('/{user}/update', 'showUpdateForm')->name('update')->middleware(['permission:update']);
            Route::post('/{user}/update', 'update')->middleware(['permission:update']);
            Route::get('/{user}/show', 'show')->name('show')->middleware(['permission:show']);
            Route::get('/{user}/show/details', 'showDetails')->name('show.details')->middleware('permission:show');
            Route::get('/{user}/show/store', 'showStore')->name('show.store')->middleware('permission:show');
            Route::post('/{store}/store/change-status', 'changeShopStatus')->name('store.status.change')->middleware('permission:show');
            Route::get('/{user}/show/banks', 'showBankDetails')->name('show.banks')->middleware('permission:show');

            Route::group(['prefix' => 'products', 'as' => 'product.', 'controller' => SellerProductController::class], function () {
                Route::get('/{user}', 'index')->name('index')->middleware('permission:show');
                Route::get('/{product}/details', 'show')->name('show')->middleware('permission:show');
            });

            // Note
            Route::group(['prefix' => 'notes', 'as' => 'note.', 'controller' => SellerNoteController::class], function () {
                Route::get('/{user}', 'index')->name('index')->middleware('permission:note_index');
                Route::get('/{user}/create', 'create')->name('create')->middleware('permission:note_create');
                Route::post('/{user}/create', 'store')->middleware('permission:note_create');
                Route::get('/{note}/edit', 'edit')->name('edit')->middleware('permission:note_update');
                Route::post('/{note}/update', 'update')->name('update')->middleware('permission:note_update');
                Route::post('/{note}/show', 'show')->name('show')->middleware('permission:note_show');
                Route::post('/{note}/delete', 'destroy')->name('delete')->middleware('permission:note_delete');
            });

            // Seller Category
            Route::group(['prefix' => '{user}/categories', 'as' => 'category.', 'controller' => SellerCategoryController::class], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/create', 'store');
                Route::get('/{sellerCategory}/edit', 'edit')->name('edit');
                Route::post('/{sellerCategory}/update', 'update')->name('update');
                Route::post('/{sellerCategory}/delete', 'destroy')->name('delete');
            });

            // send Money
            Route::group(['prefix' => '{user}/send-money', 'as' => 'send.money.', 'controller' => SendMoneyController::class], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/create', 'store');
                Route::get('/show/{balanceHistory}', 'show')->name('show');
            });

            // send Money
            Route::group(['prefix' => '{user}/receive-money', 'as' => 'receive.money.', 'controller' => ReceiveMoneyController::class], function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/create', 'store');
                Route::get('/show/{balanceHistory}', 'show')->name('show');
            });

            // Balance History
            Route::group(['prefix' => '{user}/balance-history', 'controller' => ReceiveMoneyController::class], function () {
                Route::get('/', 'balanceHistory')->name('balance.history');
            });
        });
    });


    // Logins & Activities
    Route::group(['prefix' => 'logs', 'as' => 'log.', 'controller' => LogController::class], function () {

        Route::get('/logins', 'loginIndex')->name('login.index')->middleware('permission:log_login_index');
        Route::post('/{login}/delete-api', 'deleteLoginApi')->name('delete_login.api')->middleware('permission:log_delete_login');

        Route::get('/activity', 'activityIndex')->name('activity.index')->middleware('permission:log_activity_index');
        Route::get('/activity/{activity}/show', 'activityShow')->name('activity.show')->middleware('permission:log_activity_show');
        Route::post('/activity/{activity}/delete', 'deleteActivity')->name('activity.delete')->middleware('permission:log_activity_delete');

        Route::get('/emails', 'emailIndex')->name('email.index')->middleware('permission:log_email_index');
        Route::get('/emails/{email}/show', 'emailShow')->name('email.show')->middleware('permission:log_email_show');
        Route::post('/emails/{email}/delete', 'deleteEmail')->name('email.delete')->middleware('permission:log_email_delete');
    });

    // Profile
    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'controller' => ProfileController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/update', 'showUpdateForm');
        Route::post('/update', 'update');
        Route::get('/update-password', 'showUpdatePasswordForm')->name('update_password');
        Route::post('/update-password', 'updatePassword');
        Route::get('/notification/all', 'showAllNotifications')->name('notification');
    });

    // Tickets
    Route::group(['prefix' => 'tickets', 'as' => 'ticket.', 'controller' => TicketController::class], function () {

        Route::get('/my-tickets', 'index')->name('index')->middleware('permission:ticket_my_ticket');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:ticket_create');
        Route::post('/create', 'create')->middleware('permission:ticket_create');
        Route::get('/{ticket}/update', 'showUpdateForm')->name('update')->middleware('permission:ticket_update');
        Route::post('/{ticket}/update', 'update')->middleware('permission:ticket_update');
        Route::get('/{ticket}/show', 'show')->name('show')->middleware('permission:ticket_show');
        Route::post('/{ticket}/reply', 'reply')->name('reply')->middleware('permission:ticket_reply');
        Route::post('/{ticket}/assignee', 'changeAssignee')->name('assignee')->middleware('permission:ticket_assignee');
        Route::post('/{ticket}/change-status', 'changeStatus')->name('change_status')->middleware('permission:ticket_change_status');
        Route::get('/{ticket}/reopen', 'reOpen')->name('reopen')->middleware('permission:ticket_reopen');
        Route::get('/all-tickets', 'allTickets')->name('all')->middleware('permission:ticket_all_ticket');
    });

    // Contact Us
    Route::group(['prefix' => 'contactUs', 'as' => 'contactUs.', 'controller' => ContactUsController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:contact_us_index');
        Route::get('/{contact_message}/get-message', 'getMessage')->name('getMessage')->middleware('permission:contact_us_index');
        Route::post('/{contact_message}/status-reply-change', 'changeRepliedStatus')->name('change_reply_status')->middleware('permission:contact_us_status');
        Route::post('/{contact_message}/delete', 'destroy')->name('delete')->middleware('permission:contact_us_delete');
    });


    // Config
    Route::group(['prefix' => 'configs', 'as' => 'config.', 'controller' => ConfigController::class], function () {

        // Roles & Permissions
        Route::group(['prefix' => 'roles', 'as' => 'role.', 'controller' => RoleController::class], function () {
            Route::get('/{type}', 'index')->name('index')->middleware('permission:role_index');
            Route::get('/{role}/show-api', 'showApi')->name('show.api')->middleware('permission:role_show');
            Route::post('/create/{type}', 'createApi')->name('create.api')->middleware('permission:role_create');
            Route::post('/{role}/update-api', 'updateApi')->name('update.api')->middleware('permission:role_update');
            Route::post('/{role}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:role_delete');
            Route::get('/{role}/{type}/permissions', 'permissions')->name('permission')->middleware('permission:role_permission');
            Route::post('/{role}/permissions/update', 'updatePermissions')->name('permission.update')->middleware('permission:role_permission_update');
        });

        // Dropdowns
        Route::group(['prefix' => 'dropdowns', 'as' => 'dropdown.'], function () {
            Route::get('/', 'dropdownMenu')->name('menu')->middleware('permission:dropdown_index');
            Route::get('/{dropdown}', 'dropdowns')->name('index')->middleware('permission:dropdown_index');
            Route::post('/{dropdown}/create-api', 'createDropdownApi')->name('create.api')->middleware('permission:dropdown_create');
            Route::post('/{dropdown}/{id}/update-api', 'updateDropdownApi')->name('update.api')->middleware('permission:dropdown_update');
            Route::post('/{dropdown}/{id}/delete-api', 'deleteDropdownApi')->name('delete.api')->middleware('permission:dropdown_delete');
        });

        Route::group(['prefix' => 'general-settings', 'as' => 'general_settings.', 'controller' => GeneralSettingsController::class], function () {
            Route::get('/system-details', 'systemDetails')->name('systemDetails')->middleware('permission:general_settings_show');
            Route::get('/address', 'address')->name('address')->middleware('permission:general_settings_show');
            Route::get('/communication', 'communication')->name('communication')->middleware('permission:general_settings_show');
            Route::get('/multimedia', 'multimedia')->name('multimedia')->middleware('permission:general_settings_show');
            Route::get('/date-time', 'date_time')->name('date_time')->middleware('permission:general_settings_show');
            Route::get('/currency', 'currency')->name('currency')->middleware('permission:general_settings_show');
            Route::get('/pos-settings', 'posSettings')->name('pos_settings')->middleware('permission:general_settings_show');

            Route::get('/email-settings', 'emailSettings')->name('email.settings')->middleware('permission:email_settings_show');
            Route::post('/update-email-settings', 'updateEmailSettings')->name('email.settings.update')->middleware('permission:email_settings_update');
            Route::post('/send-test-email', 'sendTestMail')->name('send.test.email')->middleware('permission:email_settings_show');

            Route::get('/social-link', 'socialLink')->name('social.link')->middleware('permission:social_link_show');
            Route::post('/social-link', 'updateSocialLink')->name('social.link.update')->middleware('permission:social_link_update');
            Route::get('/preference', 'preference')->name('preference')->middleware('permission:general_settings_show');
            Route::get('/settlement', 'settlement')->name('settlement')->middleware('permission:general_settings_show');
            Route::get('/courier', 'courier')->name('courier')->middleware('permission:general_settings_show');
            Route::get('/shipping-cost', 'shippingCost')->name('shipping_cost')->middleware('permission:general_settings_show');
            Route::post('/shipping-cost', 'updateShippingCost')->name('shipping_cost.update')->middleware('permission:general_settings_show');

            // Backend Color
            Route::get('/backend-color', 'backendColor')->name('backend.color')->middleware('permission:backend_color_index');
            Route::get('/frontend-color', 'frontendColor')->name('frontend.color')->middleware('permission:backend_color_index');
            Route::get('/backend-dynamic-css', 'backendColorDynamic')->name('backendDynamic.css');
            Route::get('/frontend-dynamic-css', 'frontendColorDynamic')->name('frontendDynamic.css');
            Route::post('/color/reset/{website}', 'resetColorSettings')->name('color.reset');

            Route::post('/update', 'updateGeneralSettings')->name('update')->middleware('permission:general_settings_update');

            Route::group(['prefix' => 'pickup-hub', 'as' => 'pickup_hub.', 'controller' => PickupHubController::class], function () {

                Route::get('/', 'index')->name('index')->middleware('permission:pickup_hub_index');
                Route::get('/district/get', 'divisionWiseDistrict')->name('district.get')->middleware('permission:pickup_hub_create');
                Route::get('/thana/get', 'districtWiseThana')->name('thana.get')->middleware('permission:pickup_hub_create');
                Route::get('/area/get', 'thanaWiseArea')->name('area.get')->middleware('permission:pickup_hub_create');
                Route::get('/create', 'create')->name('create')->middleware('permission:pickup_hub_create');
                Route::post('/store', 'store')->name('store')->middleware('permission:pickup_hub_create');
                Route::get('/{pickupHub}/edit', 'edit')->name('edit')->middleware('permission:pickup_hub_update');
                Route::post('/{pickupHub}/update', 'update')->name('update')->middleware('permission:pickup_hub_update');
                Route::post('/{pickupHub}/delete', 'destroy')->name('delete')->middleware('permission:pickup_hub_delete');

            }); 
        });

        Route::group(['prefix' => 'more-settings', 'as' => 'more_settings.', 'controller' => ConfigController::class], function () {
            Route::get('/', 'moreSettings')->name('index');

            // Email templates
            Route::group(['prefix' => 'email-templates', 'as' => 'email_template.'], function () {
                Route::get('/', 'emailTemplates')->name('index')->middleware('permission:email_template_index');
                Route::get('/{email_template}/update', 'updateEmailTemplateForm')->name('update')->middleware('permission:email_template_update');
                Route::post('/{email_template}/update', 'updateEmailTemplate')->middleware('permission:email_template_update');
            });

            // Email Signature
            Route::group(['prefix' => 'email-signature', 'as' => 'email_signature.', 'controller' => EmailSignatureController::class], function () {
                Route::get('/', 'index')->name('index')->middleware('permission:email_signature_index');
                Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:email_signature_create');
                Route::post('/create', 'create')->middleware('permission:email_signature_create');
                Route::get('/{emailSignature}/update', 'showUpdateForm')->name('update')->middleware('permission:email_signature_update');
                Route::post('/{emailSignature}/update', 'update')->middleware('permission:email_signature_update');
                Route::get('/{emailSignature}/show-api', 'show')->name('show')->middleware('permission:email_signature_show');
                Route::post('/{emailSignature}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:email_signature_delete');
            });
        });
    });

    // ad location
    Route::group(['prefix' => 'ad-location', 'as' => 'ad.location.', 'controller' => AdLocationController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:ad_location_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:ad_location_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:ad_location_create');
        Route::get('/{ad_location}/edit', 'edit')->name('edit')->middleware('permission:ad_location_update');
        Route::post('/{ad_location}/update', 'update')->name('update')->middleware('permission:ad_location_update');
        Route::post('/{ad_location}/delete', 'destroy')->name('delete')->middleware('permission:ad_location_delete');
        Route::post('/{ad_location}/status-change', 'changeStatus')->name('change_status')->middleware('permission:ad_location_change_status');
    });

    

    // Coupon
    Route::group(['prefix' => 'coupons', 'as' => 'coupon.', 'controller' => CouponController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:coupon_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:coupon_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:coupon_create');
        Route::get('/{coupon}/edit', 'edit')->name('edit')->middleware('permission:coupon_update');
        Route::post('/{coupon}/update', 'update')->name('update')->middleware('permission:coupon_update');
        Route::post('/{coupon}/delete', 'destroy')->name('delete')->middleware('permission:coupon_delete');
    });

    // ad
    Route::group(['prefix' => 'ad', 'as' => 'ad.', 'controller' => AdController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:ad_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:ad_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:ad_create');
        Route::get('/{ad}/edit', 'edit')->name('edit')->middleware('permission:ad_update');
        Route::post('/{ad}/update', 'update')->name('update')->middleware('permission:ad_update');
        Route::post('/{ad}/delete', 'destroy')->name('delete')->middleware('permission:ad_delete');
        Route::post('/{ad}/status-change', 'changeStatus')->name('change_status')->middleware('permission:ad_change_status');
    });

    // Notifications
    Route::group(['prefix' => 'notifications', 'as' => 'notification.', 'controller' => NotificationController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:notification_index');
        Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:notification_create');
        Route::post('/create', 'create')->middleware('permission:notification_create');
        Route::get('/{notification}/show', 'show')->name('show')->middleware('permission:notification_show');
        Route::post('/{notification}/delete-api', 'deleteApi')->name('delete.api')->middleware('permission:notification_delete');
        Route::get('/{notification}/recipients', 'recipients')->name('recipients')->middleware('permission:notification_recipients');
        Route::post('/{recipient}/resend-api', 'resend')->name('resend.api')->middleware('permission:notification_resend');
    });

    // Category
    Route::group(['prefix' => 'category', 'as' => 'category.', 'controller' => CategoryController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:category_index');
        Route::post('/store', 'store')->name('store')->middleware('permission:category_create');
        Route::get('/{category}/edit', 'edit')->name('edit')->middleware('permission:category_update');
        Route::post('/{category}/update', 'update')->name('update')->middleware('permission:category_update');
        Route::get('/{category}/delete', 'destroy')->name('delete')->middleware('permission:category_delete');
        Route::post('/{category}/status-change', 'changeStatus')->name('change_status')->middleware('permission:category_status');
        Route::post('/{category}/featured-change', 'changeFeatured')->name('change_featured')->middleware('permission:category_status');
    });

    // Brand
    Route::group(['prefix' => 'brands', 'as' => 'brand.', 'controller' => BrandController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:brand_index');
        Route::post('/store', 'store')->name('store')->middleware('permission:brand_create');
        Route::get('/{brand}/edit', 'edit')->name('edit')->middleware('permission:brand_update');
        Route::post('/{brand}/update', 'update')->name('update')->middleware('permission:brand_update');
        Route::get('/{brand}/delete', 'destroy')->name('delete')->middleware('permission:brand_delete');
        Route::post('/{brand}/status-change', 'changeStatus')->name('change_status')->middleware('permission:brand_status');
        Route::post('/{brand}/featured-change', 'changeFeatured')->name('change_featured')->middleware('permission:brand_status');
    });

    // Product
    Route::group(['prefix' => 'products', 'as' => 'product.', 'controller' => ProductController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:product_index');
        Route::get('/alert', 'showAlertProducts')->name('alert')->middleware('permission:product_alert_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:product_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:product_create');
        Route::get('/{product}/edit', 'edit')->name('edit')->middleware('permission:product_update');
        Route::post('/{product}/update', 'update')->name('update')->middleware('permission:product_update');
        Route::post('get-variants', 'variants')->name('getVariants')->middleware('permission:product_create');
        Route::post('/{product}/get-variants-edit', 'variantsEdit')->name('getVariantsEdit')->middleware('permission:product_create');
        Route::post('/{product}/delete', 'destroy')->name('delete')->middleware('permission:product_delete');
        Route::get('/{product}/show', 'show')->name('show')->middleware('permission:product_show');
        Route::post('/{product}/status-change', 'changeStatus')->name('change_status')->middleware('permission:product_status');
        Route::post('/get-attribute-values', 'getAttributeValues')->name('get-attribute-values')->middleware('permission:product_create');
        Route::post('/{product}/refundable', 'isRefundable')->name('refundable')->middleware('permission:product_update');
        Route::post('/{product}/feature-change', 'changeFeature')->name('change_feature')->middleware('permission:product_status');
        Route::post('/{product}/today_deal-change', 'changeTodayDeal')->name('change_today_deal')->middleware('permission:product_status');
        Route::post('/{product}/refundable-status', 'changeRefundStatus')->name('change_refund_status')->middleware('permission:product_status');

        // Reviews
        Route::get('/{product}/reviews', 'showReviews')->name('reviews')->middleware('permission:review_index');
        Route::get('/reviews', 'allReviews')->name('all_reviews')->middleware('permission:review_all_index');
        Route::get('/{review_message}/get-message', 'getMessage')->name('getMessage')->middleware('permission:review_message');
        Route::post('/{review}/review_change_status', 'reviewStatus')->name('review_change_status')->middleware('permission:review_status');

        // Discount
        Route::post('/add-ezzico-discount', 'ezzicoDiscount')->name('add_ezzico_discount');

        // Question & Answer
        Route::group(['prefix' => 'questions', 'as' => 'question.', 'controller' => ProductQuestionAnswerController::class], function () {

            Route::get('/{product}', 'index')->name('index')->middleware('permission:product_question_index');
            Route::get('/', 'showQuestions')->name('all_questions')->middleware('permission:product_question_index');
            Route::get('/{product}/answer/{productQuestion}', 'answer')->name('answer')->middleware('permission:product_question_answer');
            Route::post('/{product}/store_answer/{productQuestion}', 'storeAnswer')->name('storeAnswer')->middleware('permission:product_question_answer');
            Route::post('/{product}/{productQuestion}/status-change', 'changeStatus')->name('change_status')->middleware('permission:product_question_change_status');
            Route::post('/{product}/{productQuestion}/delete', 'destroy')->name('delete')->middleware('permission:product_question_delete');

        });
    });

    // Order
    Route::group(['prefix' => 'order', 'as' => 'order.', 'controller' => OrderController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:order_index');
        Route::get('/create', 'createForm')->name('create');
        Route::post('/create', 'store')->name('store');
        Route::get('/{order}/show', 'show')->name('show')->middleware('permission:order_show');
        Route::get('/{order}/update', 'showUpdateForm')->name('update')->middleware('permission:order_update');
        Route::post('/{order}/update', 'update')->middleware('permission:order_update');
        Route::post('/{order}/order-product-delete', 'deleteOrderProduct')->middleware('permission:order_update');
        Route::post('/{order}/pay', 'pay')->name('pay')->middleware('permission:order_update');
        Route::post('/{order}/status-change', 'changeStatus')->name('change_status')->middleware('permission:order_change_status');
        Route::post('/{order}/payment-status-change', 'changePaymentStatus')->name('change_payment_status')->middleware('permission:order_change_payment_status');

        Route::get('/{order}/return', 'showCreateForm')->name('return')->middleware('permission:return_create');
        Route::post('/{order}/return', 'orderReturnStore')->name('return.store')->middleware('permission:return_create');

        Route::get('/{order}/invoice/view', 'invoiceView')->name('invoice.view')->middleware('permission:order_invoice');
        Route::get('/{order}/invoice/shipping/paid', 'shippingMarkPaid')->name('shipping.paid')->middleware('permission:order_invoice');
        Route::get('/{order}/invoice/download', 'invoiceDownload')->name('invoice.download')->middleware('permission:order_invoice');
    });

    // Pos
    Route::group(['prefix' => 'pos', 'as' => 'pos.', 'controller' => PosController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/initial-data', 'getInitialData');
        Route::get('/stocks', 'getStocks');
        Route::get('/customers', 'getCustomers');
        Route::get('/customers/{customer_id}/due', 'getCustomerDue');
        Route::post('/customer', 'storeCustomer');
        Route::post('/order', 'placeOrder');
    });

    // Report
    Route::group(['prefix' => 'report', 'as' => 'report.', 'controller' => ReportController::class], function () {
        Route::get('/stock', 'stock')->name('stock')->middleware('permission:report_stock');
        Route::get('/order', 'order')->name('order')->middleware('permission:report_order');
        Route::get('/seller-orders', 'sellerOrder')->name('seller.order')->middleware('permission:report_order');
        Route::get('/expense', 'expense')->name('expense')->middleware('permission:report_expense');
        Route::get('/withdraw', 'withdraw')->name('withdraw')->middleware('permission:report_withdraw');
        Route::get('/users', 'users')->name('users')->middleware('permission:report_user');
        Route::get('/settlements', 'settlement')->name('settlements')->middleware('permission:report_user');
        Route::get('/profits', 'profit')->name('profit')->middleware('permission:report_profit');
    });

    // Expense
    Route::group(['prefix' => 'expenses', 'as' => 'expense.', 'controller' => ExpenseController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:expense_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:expense_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:expense_create');
        Route::get('/{expense}/edit', 'edit')->name('edit')->middleware('permission:expense_update');
        Route::post('/{expense}/update', 'update')->name('update')->middleware('permission:expense_update');
        Route::post('/{expense}/delete', 'destroy')->name('delete')->middleware('permission:expense_delete');
    });

    // Payout
    Route::group(['prefix' => 'payouts', 'as' => 'payout.', 'controller' => PayoutController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:payout_index');
        Route::post('/{payout}/status-change', 'changeStatus')->name('change_status')->middleware('permission:payout_change_status');
        Route::get('/{payout}/get-message', 'getMessage')->name('getMessage')->middleware('permission:payout_message');
    });

    // Settlements
    Route::group(['prefix' => 'settlements', 'as' => 'settlement.', 'controller' => SettlementController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:settlement_index');
        Route::get('/{settlement}/details', 'details')->name('details')->middleware('permission:settlement_change_status');
        Route::get('/{settlement}/order-details', 'orderDetails')->name('order.details')->middleware('permission:settlement_change_status');
        Route::post('/{settlement}/money-sent', 'moneySent')->name('money_sent')->middleware('permission:settlement_change_status');
    });

    // Order
    // Route::group(['prefix' => 'order', 'as' => 'order.', 'controller' => OrderController::class], function () {
    //     Route::get('/', 'index')->name('index')->middleware('permission:order_index');
    //     Route::get('/{order}/show', 'show')->name('show')->middleware('permission:order_show');
    //     Route::get('/{order}/update', 'showUpdateForm')->name('update')->middleware('permission:order_update');
    //     Route::post('/{order}/update', 'update')->middleware('permission:order_update');
    //     Route::post('/{order}/pay', 'pay')->name('pay')->middleware('permission:order_update');
    //     Route::post('/{order}/status-change', 'changeStatus')->name('change_status');

    //     Route::get('/{order}/invoice/view', 'invoiceView')->name('invoice.view')->middleware('permission:order_show');
    //     Route::get('/{order}/invoice/download', 'invoiceDownload')->name('invoice.download')->middleware('permission:order_show');
    // });

    // Sale Return
    Route::group(['prefix' => 'returns', 'as' => 'return.', 'controller' => ReturnController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:return_index');
        Route::post('/get', 'getSale')->name('get')->middleware('permission:return_create');
        Route::get('/{order_return}/show', 'show')->name('show')->middleware('permission:return_show');
        Route::post('/{order_return}/update', 'update')->name('update')->middleware('permission:return_change_status');
    });


    // Withdraws
    Route::group(['prefix' => 'withdraws', 'as' => 'withdraw.', 'controller' => WithdrawController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:withdraw_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:withdraw_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:withdraw_create');
        Route::get('/{withdraw}/edit', 'edit')->name('edit')->middleware('permission:withdraw_update');
        Route::post('/{withdraw}/update', 'update')->name('update')->middleware('permission:withdraw_update');
        Route::get('/{withdraw}/delete', 'destroy')->name('delete')->middleware('permission:withdraw_delete');
        Route::post('/{withdraw}/status-change', 'changeStatus')->name('change_status')->middleware('permission:withdraw_status');
    });

    // Colors
    Route::group(['prefix' => 'colors', 'as' => 'color.', 'controller' => ColorController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:color_index');
        Route::post('/store', 'store')->name('store')->middleware('permission:color_create');
        Route::get('/{color}/edit', 'edit')->name('edit')->middleware('permission:color_update');
        Route::post('/{color}/update', 'update')->name('update')->middleware('permission:color_update');
        Route::post('/{color}/delete', 'destroy')->name('delete')->middleware('permission:color_delete');
        Route::post('/{color}/status-change', 'changeStatus')->name('change_status')->middleware('permission:color_change_status');
    });

    // Attributes
    Route::group(['prefix' => 'attributes', 'as' => 'attribute.', 'controller' => AttributeController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:attribute_index');
        Route::post('/store', 'store')->name('store')->middleware('permission:attribute_create');
        Route::get('/{attribute}/edit', 'edit')->name('edit')->middleware('permission:attribute_update');
        Route::post('/{attribute}/update', 'update')->name('update')->middleware('permission:attribute_update');
        Route::post('/{attribute}/delete', 'destroy')->name('delete')->middleware('permission:attribute_delete');
        Route::post('/{attribute}/status-change', 'changeStatus')->name('change_status')->middleware('permission:attribute_change_status');
        Route::get('/{attribute}/value', 'attributeValue')->name('value')->middleware('permission:attribute_value_create');
        Route::post('/{attribute}/value/store', 'attributeValueStore')->name('attributeValueStore')->middleware('permission:attribute_value_create');
    });

    // Attribute Values
    Route::group(['prefix' => 'attribute-values', 'as' => 'attributeValue.', 'controller' => AttributeValueController::class], function () {
        Route::get('/', 'index')->name('index')->middleware('permission:attribute_value_index');
        Route::post('/store', 'store')->name('store')->middleware('permission:attribute_value_create');
        Route::get('/{attributeValue}/edit', 'edit')->name('edit')->middleware('permission:attribute_value_update');
        Route::post('/{attributeValue}/update', 'update')->name('update')->middleware('permission:attribute_value_update');
        Route::post('/{attributeValue}/delete', 'destroy')->name('delete')->middleware('permission:attribute_value_delete');
        Route::post('/{attributeValue}/status-change', 'changeStatus')->name('change_status')->middleware('permission:attribute_value_change_status');
    });

    // Subscriber
    Route::group(['prefix' => 'subscribers', 'as' => 'subscriber.', 'controller' => SubscriberController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:subscriber_index');
        Route::post('/{subscriber}/delete', 'destroy')->name('delete')->middleware('permission:subscriber_delete');
    });

    // Courier Pricing Plan
    Route::group(['prefix' => 'courier-pricing-plans', 'as' => 'courier_pricing_plan.', 'controller' => CourierPricingPlanController::class], function () {

        Route::get('/', 'index')->name('index')->middleware('permission:courier_pricing_plan_index');
        Route::get('/create', 'create')->name('create')->middleware('permission:courier_pricing_plan_create');
        Route::post('/store', 'store')->name('store')->middleware('permission:courier_pricing_plan_create');
        Route::get('/{courierPricingPlan}/edit', 'edit')->name('edit')->middleware('permission:courier_pricing_plan_update');
        Route::post('/{courierPricingPlan}/update', 'update')->name('update')->middleware('permission:courier_pricing_plan_update');
        Route::post('/{courierPricingPlan}/delete', 'destroy')->name('delete')->middleware('permission:courier_pricing_plan_delete');
        Route::post('/{courierPricingPlan}/status-change', 'changeStatus')->name('change_status')->middleware('permission:courier_pricing_plan_change_status');

    });

    // Area Settings
    Route::group(['prefix' => 'area-settings', 'as' => 'area.settings.', 'controller' => AreaSettingsController::class], function () {

        Route::get('/division', 'division')->name('division')->middleware('permission:division_index');
        Route::post('/{division}/division-status-change', 'divisionChangeStatus')->name('division_change_status')->middleware('permission:division_change_status');

        Route::get('/district', 'district')->name('district')->middleware('permission:district_index');
        Route::post('/{district}/district-suburb', 'districtSuburb')->name('district_suburb')->middleware('permission:district_suburbs');
        Route::post('/{district}/district-status-change', 'districtChangeStatus')->name('district_change_status')->middleware('permission:district_change_status');

        Route::group(['prefix' => 'thana', 'as' => 'thana.', 'controller' => ThanaController::class], function () {

            Route::get('/', 'index')->name('index')->middleware('permission:thana_index');
            Route::get('/district/get', 'divisionWiseDistrict')->name('district.get')->middleware('permission:thana_create');
            Route::get('/create', 'create')->name('create')->middleware('permission:thana_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:thana_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:thana_create');
            Route::get('/{thana}/edit', 'edit')->name('edit')->middleware('permission:thana_update');
            Route::post('/{thana}/update', 'update')->name('update')->middleware('permission:thana_update');
            Route::post('/{thana}/delete', 'destroy')->name('delete')->middleware('permission:thana_delete');
            Route::post('/{thana}/suburb', 'suburb')->name('suburb')->middleware('permission:thana_suburbs');
            Route::post('/{thana}/status-change', 'changeStatus')->name('change_status')->middleware('permission:thana_change_status');

        });

        Route::group(['prefix' => 'area', 'as' => 'area.', 'controller' => AreaController::class], function () {

            Route::get('/', 'index')->name('index')->middleware('permission:area_index');
            Route::get('/district/get', 'divisionWiseDistrict')->name('district.get')->middleware('permission:area_create');;
            Route::get('/thana/get', 'districtWiseThana')->name('thana.get')->middleware('permission:area_create');;
            Route::get('/create', 'create')->name('create')->middleware('permission:area_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:area_create');
            Route::post('/store', 'store')->name('store')->middleware('permission:area_create');
            Route::get('/{area}/edit', 'edit')->name('edit')->middleware('permission:area_update');
            Route::post('/{area}/update', 'update')->name('update')->middleware('permission:area_update');
            Route::post('/{area}/delete', 'destroy')->name('delete')->middleware('permission:area_delete');
            Route::post('/{area}/status-change', 'changeStatus')->name('change_status')->middleware('permission:area_change_status');

        });

    });

    Route::group(['prefix' => 'website', 'as' => 'website.'], function () {
        // Slider
        Route::group(['prefix' => 'sliders', 'as' => 'slider.', 'controller' => SliderController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:slider_index');
            Route::post('/store', 'store')->name('store')->middleware('permission:slider_create');
            Route::get('/{slider}/edit', 'edit')->name('edit')->middleware('permission:slider_update');
            Route::post('/{slider}/update', 'update')->name('update')->middleware('permission:slider_update');
            Route::get('/{slider}/delete', 'destroy')->name('delete')->middleware('permission:slider_delete');
            Route::post('/{slider}/status-change', 'changeStatus')->name('change_status')->middleware('permission:slider_status');
            Route::post('/{slider}/featured-change', 'changeFeatured')->name('change_featured')->middleware('permission:slider_status');
        });

        // Video
        Route::group(['prefix' => 'videos', 'as' => 'video.', 'controller' => VideoController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:slider_index');
            Route::post('/store', 'store')->name('store')->middleware('permission:slider_create');
            Route::get('/{video}/edit', 'edit')->name('edit')->middleware('permission:slider_update');
            Route::post('/{video}/update', 'update')->name('update')->middleware('permission:slider_update');
            Route::get('/{video}/delete', 'destroy')->name('delete')->middleware('permission:slider_delete');
            Route::post('/{video}/status-change', 'changeStatus')->name('change_status')->middleware('permission:slider_status');
        });

        // Benefit
        Route::group(['prefix' => 'benefits', 'as' => 'benefit.', 'controller' => BenefitController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:benefit_index');
            Route::post('/store', 'store')->name('store')->middleware('permission:benefit_create');
            Route::get('/{benefit}/edit', 'edit')->name('edit')->middleware('permission:benefit_update');
            Route::post('/{benefit}/update', 'update')->name('update')->middleware('permission:benefit_update');
            Route::get('/{benefit}/delete', 'destroy')->name('delete')->middleware('permission:benefit_delete');
            Route::post('/{benefit}/status-change', 'changeStatus')->name('change_status')->middleware('permission:benefit_status');
            Route::post('/{benefit}/featured-change', 'changeFeatured')->name('change_featured')->middleware('permission:benefit_status');
        });

        // Settings
        Route::group(['as' => 'setting.', 'controller' => SettingsController::class], function () {
            Route::post('/update', 'update')->name('update')->middleware('permission:general_settings_update');
            Route::post('/update/{key}', 'updateStatusConfig')->name('update.status')->middleware('permission:general_settings_update');
            // Route::get('/cookies', 'cookies')->name('cookies')->middleware('permission:website_settings_cookies');
            // Route::post('/cookies/status-change', 'cookieStatusChange')->name('cookies.status_change')->middleware('permission:website_settings_cookies');
            Route::get('/terms-and-conditions', 'terms_and_conditions')->name('terms_and_conditions')->middleware('permission:website_settings_terms_and_conditions');
            // Route::get('/website_popup', 'website_popup')->name('website_popup')->middleware('permission:website_settings_website_popup');
            Route::get('/banners', 'banners')->name('banner')->middleware('permission:website_settings_banner');
        });

        // pages
        Route::group(['prefix' => 'pages', 'as' => 'page.', 'controller' => PageController::class], function () {
            Route::get('/', 'index')->name('index')->middleware('permission:page_index');
            // Route::get('/{slug}', 'index')->name('show')->middleware('permission:page_index');
            Route::get('/create', 'showCreateForm')->name('create')->middleware('permission:page_create');
            Route::post('/create', 'create')->middleware('permission:page_create');
            Route::get('/{page}/edit', 'edit')->name('edit')->middleware('permission:page_update');
            Route::post('/{page}/update', 'update')->name('update')->middleware('permission:page_update');
            Route::get('/{page}/delete', 'destroy')->name('delete')->middleware('permission:page_delete');
            Route::post('/{page}/status-change', 'changeStatus')->name('change_status')->middleware('permission:page_status');
            Route::post('/{page}/featured-change', 'changeFeatured')->name('change_featured')->middleware('permission:page_status');
        });
    });

});
