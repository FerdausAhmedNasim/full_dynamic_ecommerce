import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue'
import path from 'path'

export default defineConfig({
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel([
            'resources/js/app.js',
            'resources/admin_assets/js/select2.js',

            //========================================Admin Main========================================================
            'resources/admin_assets/sass/app.scss',
            'resources/admin_assets/js/app.js',

            // Address
            'resources/admin_assets/js/pages/address/autofill.js',
            'resources/admin_assets/js/pages/address/index.js',

            //==============--Users--=================//
            //Seller
            'resources/admin_assets/js/pages/user/seller/create.js',
            'resources/admin_assets/js/pages/user/seller/index.js',
            'resources/admin_assets/js/pages/user/seller/note/create.js',
            'resources/admin_assets/js/pages/user/seller/note/index.js',
            'resources/admin_assets/js/pages/user/seller/order/index.js',
            'resources/admin_assets/js/pages/user/seller/product/index.js',
            'resources/admin_assets/js/pages/user/seller/show.js',
            'resources/admin_assets/js/pages/user/seller/update.js',

            //==============--Users End--=================//

            // AMS
            'resources/admin_assets/js/pages/product/category/index.js',

            'resources/admin_assets/js/pages/product/create.js',
            'resources/admin_assets/js/pages/product/index.js',
            'resources/admin_assets/js/pages/product/alert.js',

            'resources/admin_assets/js/pages/stock/index.js',
            'resources/admin_assets/js/pages/stock/create.js',
            'resources/admin_assets/js/pages/stock/edit.js',
            'resources/admin_assets/js/pages/stock/history.js',

            'resources/admin_assets/js/pages/stock_transfer/index.js',
            'resources/admin_assets/js/pages/stock_transfer/create.js',

            'resources/admin_assets/js/pages/supplier/index.js',

            // Config
            'resources/admin_assets/js/pages/config/dropdown/index.js',
            'resources/admin_assets/js/pages/config/dropdown/list.js',

            'resources/admin_assets/js/pages/config/email/index.js',

            'resources/admin_assets/js/pages/config/email_signature/index.js',
            'resources/admin_assets/js/pages/config/email_signature/update.js',

            'resources/admin_assets/js/pages/config/email_template/index.js',
            'resources/admin_assets/js/pages/config/email_template/update.js',

            'resources/admin_assets/js/pages/config/role/index.js',

            'resources/admin_assets/js/pages/config/location/index.js',

            'resources/admin_assets/js/pages/product/brand/index.js',

            //===== Website Start ======//
            'resources/admin_assets/js/pages/website/slider/index.js',
            'resources/admin_assets/js/pages/website/benefit/index.js',
            'resources/admin_assets/js/pages/website/page/index.js',
            'resources/admin_assets/js/pages/website/video/index.js',
            //===== Website End ======//

            //===== Employee Start ======//
            'resources/admin_assets/js/pages/user/employee/index.js',
            'resources/admin_assets/js/pages/user/employee/create.js',
            'resources/admin_assets/js/pages/user/employee/update.js',
            'resources/admin_assets/js/pages/user/employee/show.js',
            'resources/admin_assets/js/pages/user/employee/ticket/index.js',

            // Employee Attachment
            'resources/admin_assets/js/pages/user/employee/attachment/index.js',
            // Employee Ticket
            'resources/admin_assets/js/pages/user/employee/ticket/index.js',

            // Asset Assigned
            'resources/admin_assets/js/pages/user/employee/index.js',

            'resources/admin_assets/js/jquery.easing.js',
            //===== Employee End ======//

            // Event
            // 'resources/admin_assets/js/pages/event/index.js',
            // 'resources/admin_assets/js/pages/event/create.js',

            // FAQ
            // 'resources/admin_assets/js/pages/faq/index.js',

            // Logs
            'resources/admin_assets/js/pages/logs/activity_log.js',
            'resources/admin_assets/js/pages/logs/login_history.js',
            'resources/admin_assets/js/pages/logs/email_history.js',

            //========== Customer Start ============//
            'resources/admin_assets/js/pages/user/customer/index.js',
            'resources/admin_assets/js/pages/user/customer/create.js',
            'resources/admin_assets/js/pages/user/customer/update.js',
            'resources/admin_assets/js/pages/user/customer/show.js',
            //Client Attachment
            'resources/admin_assets/js/pages/user/customer/attachment/index.js',

            //Order
            'resources/admin_assets/js/pages/user/customer/order/index.js',

            //========== Member End ============//

            // Notifications
            'resources/admin_assets/js/pages/notification/index.js',
            'resources/admin_assets/js/pages/notification/create.js',
            'resources/admin_assets/js/pages/notification/show.js',

            //Profile
            'resources/admin_assets/js/pages/profile/all_nofification.js',

            // Tickets
            'resources/admin_assets/js/pages/ticket/index.js',
            'resources/admin_assets/js/pages/ticket/create.js',
            'resources/admin_assets/js/pages/ticket/show.js',
            'resources/admin_assets/js/pages/ticket/all.js',

            // Report
            'resources/admin_assets/js/pages/report/stock.js',
            'resources/admin_assets/js/pages/report/order.js',
            'resources/admin_assets/js/pages/report/expense.js',
            'resources/admin_assets/js/pages/report/withdraw.js',
            'resources/admin_assets/js/pages/report/user.js',
            'resources/admin_assets/js/pages/report/seller_order.js',
            'resources/admin_assets/js/pages/report/profit.js',


            // Branch
            'resources/admin_assets/js/pages/branch/index.js',
            'resources/admin_assets/js/pages/branch/show.js',

            // Return
            'resources/admin_assets/js/pages/return/index.js',
            'resources/admin_assets/js/pages/return/create.js',

            // Subscriber
            'resources/admin_assets/js/pages/subscriber/index.js',

            // Expense
            'resources/admin_assets/js/pages/expense/index.js',

            // Payout
            'resources/admin_assets/js/pages/payout/index.js',

            // Settlement
            'resources/admin_assets/js/pages/settlement/index.js',
            'resources/admin_assets/js/pages/settlement/details.js',
            'resources/admin_assets/js/pages/settlement/order_details.js',

            //Contact Us
            'resources/admin_assets/js/pages/contact_us/index.js',

            // Purchase
            'resources/admin_assets/js/pages/purchase/index.js',
            'resources/admin_assets/js/pages/purchase/create.js',
            'resources/admin_assets/js/pages/purchase/edit.js',

            // Review
            'resources/admin_assets/js/pages/review/index.js',
            'resources/admin_assets/js/pages/review/show_allReview.js',

            // Order
            'resources/admin_assets/js/pages/order/index.js',
            'resources/admin_assets/js/pages/order/create.js',
            'resources/admin_assets/js/pages/order/edit.js',

            // Quotation
            'resources/admin_assets/js/pages/quotation/index.js',
            'resources/admin_assets/js/pages/quotation/create.js',
            'resources/admin_assets/js/pages/quotation/edit.js',

            // Discount
            'resources/admin_assets/js/pages/config/discount/index.js',

            // POS & Quotation
            'resources/admin_assets/js/pages/pos/index.js',
            'resources/admin_assets/js/pages/pos/quotation.js',

            // Withdraw
            'resources/admin_assets/js/pages/withdraw/index.js',
            'resources/admin_assets/js/pages/withdraw/create.js',
            // 'resources/admin_assets/js/pages/withdraw/edit.js',

            'resources/admin_assets/js/pages/user/employee/ams/index.js',

            // Color
            'resources/admin_assets/js/pages/product/color/index.js',

            // Attribute
            'resources/admin_assets/js/pages/product/attribute/index.js',

            // Attribute Value
            'resources/admin_assets/js/pages/product/attributeValue/index.js',

            // advertisement
            'resources/admin_assets/js/pages/advertisement/location/index.js',
            'resources/admin_assets/js/pages/advertisement/index.js',
            'resources/admin_assets/js/pages/config/role/seller.js',


            'resources/admin_assets/js/pages/user/seller/category/index.js',
            'resources/admin_assets/js/pages/user/seller/receive_money/index.js',
            'resources/admin_assets/js/pages/user/seller/send_money/index.js',
            'resources/admin_assets/js/pages/user/seller/balance_history/index.js',

            //================ Start Seller panel ==========================//
            // Product
            'resources/seller_assets/js/pages/product/index.js',
            'resources/seller_assets/js/pages/product/create.js',

            // Reviews
            'resources/seller_assets/js/pages/review/index.js',
            'resources/seller_assets/js/pages/review/allReviews.js',

            //Ticket
            'resources/seller_assets/js/pages/ticket/create.js',
            'resources/seller_assets/js/pages/ticket/index.js',
            'resources/seller_assets/js/pages/ticket/show.js',

            //AMS
            'resources/seller_assets/js/pages/moderator/ams/index.js',
            //Attachment
            'resources/seller_assets/js/pages/moderator/attachment/index.js',
            //Ticket
            'resources/seller_assets/js/pages/moderator/ticket/index.js',

            //Moderator
            'resources/seller_assets/js/pages/moderator/create.js',
            'resources/seller_assets/js/pages/moderator/index.js',
            'resources/seller_assets/js/pages/moderator/show.js',
            'resources/seller_assets/js/pages/moderator/update.js',

            // Order, ad, coupon, Bank Account
            'resources/seller_assets/js/pages/order/index.js',
            'resources/seller_assets/js/pages/advertise/index.js',
            'resources/seller_assets/js/pages/coupon/index.js',
            'resources/seller_assets/js/pages/bank-account/index.js',
            'resources/admin_assets/js/pages/coupon/index.js',

            //Notification
            'resources/seller_assets/js/pages/notification/index.js',
            //Return
            'resources/seller_assets/js/pages/return/index.js',

            'resources/seller_assets/js/pages/config/role/index.js',

            // Payout Request
            'resources/seller_assets/js/pages/payouts/index.js',
            'resources/seller_assets/js/pages/balance_history/index.js',

            // Seller Report
            'resources/seller_assets/js/pages/report/settlement.js',
            'resources/seller_assets/js/pages/report/stock.js',
            'resources/seller_assets/js/pages/report/order.js',

            'resources/seller_assets/js/pages/settlement/index.js',
            'resources/seller_assets/js/pages/settlement/order_details.js',
            'resources/seller_assets/js/pages/product/alert.js',

            //======================= End Seller panel ==========================//

            //======================= Start Website ==========================//
            'resources/frontend_assets/sass/app.scss',
            'resources/frontend_assets/js/app.js',

            'resources/frontend_assets/js/pages/product/show.js',
            'resources/frontend_assets/js/pages/return/create.js',
            'resources/frontend_assets/js/my-wishlist.js',
            'resources/frontend_assets/js/pages/cart/addToCart.js',
            'resources/frontend_assets/js/pages/product/filter.js',
            'resources/frontend_assets/js/pages/cart/cart.js',
            'resources/frontend_assets/js/pages/checkout/checkout.js',
            'resources/frontend_assets/js/pages/checkout/createAddress.js',
            'resources/frontend_assets/js/pages/checkout/updateAddress.js',
            //======================= End Website ==========================//

            // Courier Settings
            'resources/admin_assets/js/pages/courier/create.js',
            'resources/admin_assets/js/pages/courier/index.js',

            // Area Settings
            'resources/admin_assets/js/pages/areaSettings/division/index.js',
            'resources/admin_assets/js/pages/areaSettings/district/index.js',
            'resources/admin_assets/js/pages/areaSettings/thana/index.js',
            'resources/admin_assets/js/pages/areaSettings/thana/create.js',
            'resources/admin_assets/js/pages/areaSettings/area/index.js',
            'resources/admin_assets/js/pages/areaSettings/area/create.js',

            //Address
            'resources/frontend_assets/js/pages/address/create.js',

            // Pickup Hub
            'resources/admin_assets/js/pages/config/pickupHub/index.js',
            'resources/admin_assets/js/pages/config/pickupHub/create.js',

            // Product Question Answer
            // 'resources/seller_assets/js/pages/product/questions/index.js',

            // Product Question Answer
            'resources/admin_assets/js/pages/product/questions/index.js',
            'resources/admin_assets/js/pages/product/questions/questions.js',
            
        ]),
        // {
        //     name: 'blade',
        //     handleHotUpdate({file, server}) {
        //         if (file.endsWith('.blade.php')) {
        //             server.ws.send({
        //                 type: 'full-reload',
        //                 path: '*'
        //             });
        //         }
        //     }
        // },
    ],
    resolve: {
        alias: {
            'vue': 'vue/dist/vue.esm-bundler.js',
            '~bootstrap': path.resolve(__dirname, 'node_modules/bootstrap'),
            '@': '/resources/js',
        }
    },
    build: {
        chunkSizeWarningLimit: 1600,
        rollupOptions: {
            output: {
                assetFileNames: (asset) => {
                    let typePath = 'styles'
                    const type = asset.name.split('.').at(1)
                    if (/png|jpe?g|webp|svg|gif|tiff|bmp|ico/i.test(type)) {
                        typePath = 'images'
                    }
                    return `${typePath}/[name]-[hash][extname]`
                },
                chunkFileNames: 'scripts/chunks/[name]-[hash].js',
                entryFileNames: 'scripts/[name]-[hash].js',
            },
        },
    },
});
