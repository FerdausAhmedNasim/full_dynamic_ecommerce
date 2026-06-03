<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\CartController;
use App\Http\Controllers\Public\HomeController;
use App\Http\Controllers\Public\PageController;
use App\Http\Controllers\Public\BrandController;
use App\Http\Controllers\Public\OfferController;
use App\Http\Controllers\Public\CookieController;
use App\Http\Controllers\Public\SellerController;
use App\Http\Controllers\Public\ContactController;
use App\Http\Controllers\Public\ProductController;
use App\Http\Controllers\Public\CheckoutController;
use App\Http\Controllers\Public\WishlistController;
use App\Http\Controllers\Admin\GeneralSettingsController;
use App\Http\Controllers\Public\Auth\GoogleAuthController;
use App\Http\Controllers\Public\Dashboard\MemberDashboard;
use App\Http\Controllers\Public\Dashboard\OrderController;
use App\Http\Controllers\Public\Dashboard\AddressController;
use App\Http\Controllers\Public\Dashboard\ProfileController;
use App\Http\Controllers\Public\SslCommerzPaymentController;
use App\Http\Controllers\Public\Dashboard\NotificationController;

Auth::routes();

Route::get('test', function () {
    //return Product::find(36);
    return parentCategory(4);
});

Route::get('auth/google', [GoogleAuthController::class, 'redirect'])->name('google.auth');
Route::get('auth/google/call-back', [GoogleAuthController::class, 'callBack'])->name('google.auth.callback');
//======================== About =========================== >
Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.', 'middleware' => ['auth', 'verified']], function () {

    Route::get('/', [MemberDashboard::class, 'index'])->name('index');

    //======================== Profile =========================== >
    Route::group(['prefix' => 'profile', 'as' => 'profile.', 'controller' => ProfileController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/update', 'showUpdateForm')->name('update');
        Route::post('/update', 'update')->name('update_profile');

        Route::get('/password/update', 'showPasswordUpdateForm')->name('showPassword.update');
        Route::post('/password/update', 'updatePassword')->name('update_password');
    });

    //======================== Order =========================== >
    Route::group(['prefix' => 'orders', 'as' => 'order.', 'controller' => OrderController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/{order}/products', 'showOrderProduct')->name('products');
        Route::get('{order}/return', 'orderReturn')->name('return');
        Route::post('order/{seller_order}/return', 'orderReturnStore')->name('return.store');

        Route::get('order/returns', 'orderReturnList')->name('return.list');
        Route::get('order/return/{order_return}/details', 'orderReturnShow')->name('return.show');

        Route::get('cancel/{order}', 'orderCancel')->name('cancel');

        Route::get('/{invoice}/invoice', 'orderInvoice')->name('invoice');
        Route::get('/{order}/invoice/download', 'invoiceDownload')->name('invoice.download');
    });

    //======================== Address =========================== >
    Route::group(['prefix' => 'addresses', 'as' => 'address.', 'controller' => AddressController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/address/create', 'showCreateForm')->name('address_create');
        Route::post('/create', 'createAddress')->name('create');

        Route::get('/district/get', 'divisionWiseDistrict')->name('district.get');
        Route::get('/thana/get', 'districtWiseThana')->name('thana.get');
        Route::get('/area/get', 'thanaWiseArea')->name('area.get');


        Route::get('/{address}/update', 'showUpdateForm')->name('address_update');
        Route::post('/update/{address}', 'updateAddress')->name('update');

        Route::get('/{address}/defaultShipping', 'makeDefaultShipping')->name('defaultShipping');
        Route::get('/{address}/delete', 'destroy')->name('delete');
    });

    //======================== Notifications =========================== >
    Route::group(['prefix' => 'notifications', 'as' => 'notification.', 'controller' => NotificationController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{notification}', 'show')->name('show');
    });
});

Route::name('public.')->as('public.')->group(function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/load-more', [HomeController::class, 'loadMoreData'])->name('load.more');

    // page
    Route::group(['prefix' => 'pages', 'as' => 'page.', 'controller' => PageController::class], function () {
        Route::get('/about-us', 'AboutUs')->name('about_us');
        Route::get('/{link}', 'show')->name('show');
        Route::get('/Return-and-refund-policy', 'ReturnAndRefundPolicy')->name('Return_refund_policy');
        // Route::get('/privacyPolicy', 'PrivacyPolicy')->name('privacyPolicy');
    });

    // Wishlist page
    Route::group(['prefix' => 'wishlists', 'as' => 'wishlist.', 'controller' => WishlistController::class], function () {
        Route::get('/', 'index')->name('index');
    });
    Route::post('/add-to-wishlist', [WishlistController::class, 'addToWishlist'])->name('add.to.wishlist');
    Route::get('/wishlist', [WishlistController::class, 'wishlist'])->name('wishlist');
    Route::post('/wishlist/delete', [WishlistController::class, 'destroy'])->name('delete');

    // Product
    Route::group(['prefix' => 'products', 'as' => 'product.', 'controller' => ProductController::class], function () {
        Route::get('/show/{slug}', 'show')->name('show');
        Route::get('/variant', 'variant')->name('variant');
        Route::get('/{slug}/load-more-question', 'loadMoreQuestion');
        Route::post('/questionStore', 'questionStore')->name('question_store');
        Route::get('/filter', 'filterProduct')->name('filter');
        Route::post('/{product}/review', 'review')->name('review.store');
        Route::post('/search', 'searchProduct')->name('search');
        Route::get('/share/{slug}', 'share')->name('share');

    });

    Route::get('/brand/{slug}/products', [ProductController::class, 'brandWiseProduct'])->name('product.brand_wise');
    Route::get('/category/{slug}/products', [ProductController::class, 'categoryWiseProduct'])->name('product.category_wise');

    // Seller
    Route::group(['prefix' => 'sellers', 'as' => 'seller.', 'controller' => SellerController::class], function () {
        Route::get('/create', 'showCreateForm')->name('create');
        Route::post('/create', 'create');
        Route::get('/', 'index')->name('index');
        Route::get('{shop}/seller-shop', 'sellerStore')->name('seller_shop');
        Route::get('{shop}/seller-products', 'showProducts')->name('seller_products');
        Route::post('{seller}/products', 'searchProducts')->name('search.products');
    });

    // Brand Page
    Route::group(['prefix' => 'brands', 'as' => 'brand.', 'controller' => BrandController::class], function () {
        Route::get('/', 'index')->name('index');
    });

    // Offer Page
    Route::group(['prefix' => 'offers', 'as' => 'offer.', 'controller' => OfferController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::get('/load-more', 'loadMoreData')->name('load.more');
    });

    // Contact Us
    Route::group(['prefix' => 'contact-us', 'as' => 'contact.', 'controller' => ContactController::class], function () {
        Route::get('/', 'index')->name('index');
        Route::post('/store', 'store')->name('store');
    });

    // Cookies
    Route::group(['prefix' => 'cookies', 'as' => 'cookie.', 'controller' => CookieController::class], function () {
        Route::get('/get', 'getCookie')->name('get');
        Route::get('/set', 'setCookie')->name('set');
        Route::get('/delete', 'deleteCookie')->name('delete');
    });

    Route::post('/visitor-sign-in', [HomeController::class, 'visitorSignIn'])->name('visitor.sign.in');
    Route::post('/visitor-sign-out', [HomeController::class, 'visitorSignOut'])->name('visitor.sign.out');
    Route::post('/employee-attendance', [HomeController::class, 'EmployeeAttendance'])->name('employee.attendance');


});
Route::get('/page/{slug}', [HomeController::class, 'PageShow'])->name('page.show');


// Customer Order Routes

Route::post('/add-to-cart', [CartController::class, 'addToCart'])->name('add.to.cart');
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart-item-remove', [CartController::class, 'cartItemRemove'])->name('cart.item.remove');
Route::post('/cart-update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/buy-now', [CartController::class, 'addToCart'])->name('buy.now');

Route::get('/checkout', [CheckoutController::class, 'checkout'])->name('checkout');
Route::post('/apply-coupon', [CheckoutController::class, 'applyCoupon'])->name('apply.coupon');
Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('place.order');
Route::get('/order-confirmation', [CheckoutController::class, 'confirmOrder'])->name('confirm.order');

Route::post('/defaultShipping', [CheckoutController::class, 'makeDefaultShipping'])->name('defaultShipping');
Route::post('/address/create', [CheckoutController::class, 'createAddress'])->name('checkout.address.create');
Route::post('/address/{address}/update', [CheckoutController::class, 'updateAddress'])->name('checkout.address.update');
Route::get('/address/delete/{address}', [CheckoutController::class, 'destroy'])->name('checkout.address.delete');

Route::get('/addresses/district/get', [AddressController::class,'divisionWiseDistrict'])->name('address.district.get');
Route::get('/addresses/thana/get', [AddressController::class,'districtWiseThana'])->name('address.thana.get');
Route::get('addresses/area/get', [AddressController::class,'thanaWiseArea'])->name('address.area.get');


// SSLCOMMERZ Start
Route::post('/success', [SslCommerzPaymentController::class, 'success']);
Route::post('/fail', [SslCommerzPaymentController::class, 'fail']);
Route::post('/cancel', [SslCommerzPaymentController::class, 'cancel']);
Route::post('/ipn', [SslCommerzPaymentController::class, 'ipn']);
//SSLCOMMERZ END


Route::get('/frontend-dynamic-css', [GeneralSettingsController::class, 'frontendColorDynamic'])->name('frontendDynamic.css');