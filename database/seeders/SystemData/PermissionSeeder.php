<?php

namespace Database\Seeders\SystemData;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    // Menu group
    public const MENU_GROUP_NOTIFICATION = 'notification';
    public const MENU_GROUP_ORDER = 'order';
    public const MENU_GROUP_PRODUCT = 'product';
    public const MENU_GROUP_USER = 'user';
    public const MENU_GROUP_RETURN = 'return';
    public const MENU_GROUP_SUPPORT = 'support';
    // public const MENU_GROUP_SUBSCRIBERS = 'subscribers';
    public const MENU_GROUP_ACCOUNTS = 'accounts';
    public const MENU_GROUP_AD = 'ad';
    public const MENU_GROUP_WEBSITE = 'website';
    public const MENU_GROUP_SETTINGS = 'settings';
    public const MENU_GROUP_FOOT_PRINT = 'foot_print';
    public const MENU_GROUP_REPORT = 'report';
    public const MENU_GROUP_COURIER_PRICING = 'courier';
    // public const MENU_GROUP_AREA_SETTINGS = 'area_settings';

    // Seller Menu group
    // public const SELLER_MENU_GROUP_AD = 'ad';
    // public const SELLER_MENU_GROUP_ORDER = 'order';
    // public const SELLER_MENU_GROUP_PRODUCT = 'product';
    // public const SELLER_MENU_GROUP_MODERATOR = 'moderator';
    // public const SELLER_MENU_GROUP_RETURN = 'return';
    // public const SELLER_MENU_GROUP_TICKET = 'ticket';
    // public const SELLER_MENU_GROUP_BANK_ACCOUNT = 'bank_account';
    // public const SELLER_MENU_GROUP_SETTINGS = 'settings';
    // public const SELLER_MENU_GROUP_REPORT = 'report';
    // public const SELLER_MENU_GROUP_COUPON = 'coupon';
    // public const SELLER_MENU_GROUP_NOTIFICATION = 'notification';
    // public const SELLER_MENU_GROUP_PAYOUT = 'payout';

    // Admin permission group
    public const GROUP_USER = 'user';
    public const GROUP_NOTIFICATION = 'notification';
    public const GROUP_EMP = 'employee';
    // public const GROUP_SELLER = 'seller';
    // public const GROUP_MODERATOR = 'moderator';
    public const GROUP_CUSTOMER = 'customer';
    public const GROUP_TICKET = 'ticket';
    public const GROUP_LOG = 'log';
    public const GROUP_ROLE = 'role';
    public const GROUP_PROFILE = 'profile';
    public const GROUP_ADDRESS = 'address';
    public const GROUP_EMERGENCY_CONTACT = 'emergency_contact';
    public const GROUP_CATEGORY = 'category';
    public const GROUP_BRAND = 'brand';
    public const GROUP_PRODUCT = 'product';
    public const GROUP_ATTACHMENT = 'attachment';
    public const GROUP_NOTE = 'note';
    public const GROUP_EMPLOYEE_DETAILS = 'employee_details';
    public const GROUP_REPORT = 'report';
    public const GROUP_MENU = 'menu';
    public const GROUP_DROPDOWN = 'dropdown';
    public const GROUP_EMAIL_TEMPLATE = 'email_template';
    public const GROUP_EMAIL_SIGNATURE = 'email_signature';
    public const GROUP_EMAIL_SETTINGS = 'email_settings';
    public const GROUP_GENERAL_SETTINGS = 'general_settings';
    public const GROUP_SOCIAL_LINK = 'social_link';
    public const GROUP_EXPENSE = 'expense';
    public const GROUP_REFUND = 'return';
    // public const GROUP_SUBSCRIBER = 'subscriber';
    public const GROUP_CONTACT_US = 'contact_us';
    public const GROUP_ORDER = 'order';
    // public const GROUP_WITHDRAW = 'withdraw';
    public const GROUP_COLOR = 'color';
    public const GROUP_ATTRIBUTE = 'attribute';
    public const GROUP_ATTRIBUTE_VALUE = 'attribute_value';
    public const GROUP_AD_LOCATION = 'ad_location';
    public const GROUP_COUPON = 'coupon';
    public const GROUP_AD = 'ad';
    public const GROUP_SLIDER = 'slider';
    // public const GROUP_BENEFIT = 'benefit';
    public const GROUP_PAGE = 'page';
    public const GROUP_SETTINGS = 'website_settings';
    public const GROUP_REVIEW = 'review';
    public const GROUP_PRODUCT_ALERT = 'product_alert';
    // public const GROUP_PAYOUT = 'payout';
    // public const GROUP_SETTLEMENT = 'settlement';
    public const GROUP_COURIER_PRICING = 'courier_pricing_plan';
    public const GROUP_DIVISION = 'division';
    public const GROUP_DISTRICT = 'district';
    public const GROUP_THANA = 'thana';
    public const GROUP_AREA = 'area';
    public const GROUP_PICKUP_HUB = 'pickup_hub';
    public const GROUP_PRODUCT_QUESTION = 'product_question';
    public const GROUP_BACKEND_COLOR = 'backend_color';
    public const GROUP_FRONTEND_COLOR = 'frontend_color';

    // Seller group
    // public const SELLER_GROUP_MODERATOR = 'seller_moderator';
    // public const SELLER_GROUP_PROFILE = 'seller_profile';
    // public const SELLER_GROUP_TICKET = 'seller_ticket';
    // public const SELLER_GROUP_PRODUCT = 'seller_product';
    // public const SELLER_GROUP_REPORT = 'seller_report';
    // public const SELLER_GROUP_ROLE = 'seller_role';
    // public const SELLER_GROUP_REVIEW = 'seller_review';
    // public const SELLER_GROUP_COUPON = 'seller_coupon';
    // public const SELLER_GROUP_ORDER = 'seller_order';
    // public const SELLER_GROUP_BANK_ACCOUNT = 'seller_bank_account';
    // public const SELLER_GROUP_AD_REQUEST = 'seller_ad_request';
    // public const SELLER_GROUP_EMERGENCY_CONTACT = 'seller_emergency_contact';
    // public const SELLER_GROUP_ADDRESS = 'seller_address';
    // public const SELLER_GROUP_NOTIFICATION = 'seller_notification';
    // public const SELLER_GROUP_REFUND = 'seller_refund';
    // public const SELLER_GROUP_PAYOUT = 'seller_payout';
    // public const SELLER_GROUP_PICKUP_HUB = 'seller_pickup_hub';
    // public const SELLER_GROUP_PRODUCT_QUESTION = 'seller_product_question';

    public function run()
    {
        Permission::whereNotNull('id')->delete();

        $admin_role = Role::where('slug', 'super-admin')->first();
        //$seller_role = Role::where('for', 'seller')->first();

        foreach ($this->adminPermissions() as $p) {
            $permission = new Permission();
            $permission->name = $p['name'];
            $permission->slug = $p['slug'];
            $permission->group = $p['group'];
            $permission->menu_group = $p['menu_group'];
            $permission->for = 'employee';
            $permission->save();

            if ($admin_role) {
                $admin_role->permissions()->attach($permission);
            }
        }

        // foreach ($this->sellerPermissions() as $sp) {
        //     $sellerPermission = new Permission();
        //     $sellerPermission->name = $sp['name'];
        //     $sellerPermission->slug = $sp['slug'];
        //     $sellerPermission->group = $sp['group'];
        //     $sellerPermission->menu_group = $sp['menu_group'];
        //     $sellerPermission->for = 'seller';
        //     $sellerPermission->save();

        //     if ($seller_role) {
        //         $seller_role->permissions()->attach($sellerPermission);
        //     }
        // }
    }

    private function adminPermissions()
    {
        return [


            // Notification
            [
                'name' => 'List',
                'slug' => self::GROUP_NOTIFICATION . '_index',
                'group' => self::GROUP_NOTIFICATION,
                'menu_group' => self::MENU_GROUP_NOTIFICATION,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_NOTIFICATION . '_create',
                'group' => self::GROUP_NOTIFICATION,
                'menu_group' => self::MENU_GROUP_NOTIFICATION,
            ],
            [
                'name' => 'Show',
                'slug' => self::GROUP_NOTIFICATION . '_show',
                'group' => self::GROUP_NOTIFICATION,
                'menu_group' => self::MENU_GROUP_NOTIFICATION,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_NOTIFICATION . '_delete',
                'group' => self::GROUP_NOTIFICATION,
                'menu_group' => self::MENU_GROUP_NOTIFICATION,
            ],
            [
                'name' => 'Recipients',
                'slug' => self::GROUP_NOTIFICATION . '_recipients',
                'group' => self::GROUP_NOTIFICATION,
                'menu_group' => self::MENU_GROUP_NOTIFICATION,
            ],
            [
                'name' => 'Resend',
                'slug' => self::GROUP_NOTIFICATION . '_resend',
                'group' => self::GROUP_NOTIFICATION,
                'menu_group' => self::MENU_GROUP_NOTIFICATION,
            ],

            // Order
            [
                'name' => 'List',
                'slug' => self::GROUP_ORDER . '_index',
                'group' => self::GROUP_ORDER,
                'menu_group' => self::MENU_GROUP_ORDER,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_ORDER . '_create',
                'group' => self::GROUP_ORDER,
                'menu_group' => self::MENU_GROUP_ORDER,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_ORDER . '_update',
                'group' => self::GROUP_ORDER,
                'menu_group' => self::MENU_GROUP_ORDER,
            ],
            [
                'name' => 'View',
                'slug' => self::GROUP_ORDER . '_show',
                'group' => self::GROUP_ORDER,
                'menu_group' => self::MENU_GROUP_ORDER,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_ORDER . '_change_status',
                'group' => self::GROUP_ORDER,
                'menu_group' => self::MENU_GROUP_ORDER,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_ORDER . '_change_payment_status',
                'group' => self::GROUP_ORDER,
                'menu_group' => self::MENU_GROUP_ORDER,
            ],
            [
                'name' => 'Invoice',
                'slug' => self::GROUP_ORDER . '_invoice',
                'group' => self::GROUP_ORDER,
                'menu_group' => self::MENU_GROUP_ORDER,
            ],

            // Category
            [
                'name' => 'List',
                'slug' => self::GROUP_CATEGORY . '_index',
                'group' => self::GROUP_CATEGORY,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_CATEGORY . '_create',
                'group' => self::GROUP_CATEGORY,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_CATEGORY . '_update',
                'group' => self::GROUP_CATEGORY,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_CATEGORY . '_delete',
                'group' => self::GROUP_CATEGORY,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_CATEGORY . '_status',
                'group' => self::GROUP_CATEGORY,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],

            // Brand
            [
                'name' => 'List',
                'slug' => self::GROUP_BRAND . '_index',
                'group' => self::GROUP_BRAND,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_BRAND . '_create',
                'group' => self::GROUP_BRAND,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_BRAND . '_update',
                'group' => self::GROUP_BRAND,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_BRAND . '_delete',
                'group' => self::GROUP_BRAND,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_BRAND . '_status',
                'group' => self::GROUP_BRAND,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],

            // Color
            [
                'name' => 'List',
                'slug' => self::GROUP_COLOR . '_index',
                'group' => self::GROUP_COLOR,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_COLOR . '_create',
                'group' => self::GROUP_COLOR,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_COLOR . '_update',
                'group' => self::GROUP_COLOR,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_COLOR . '_delete',
                'group' => self::GROUP_COLOR,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Change Status',
                'slug' => self::GROUP_COLOR . '_change_status',
                'group' => self::GROUP_COLOR,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],

            // Product
            [
                'name' => 'List',
                'slug' => self::GROUP_PRODUCT . '_index',
                'group' => self::GROUP_PRODUCT,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_PRODUCT . '_create',
                'group' => self::GROUP_PRODUCT,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_PRODUCT . '_update',
                'group' => self::GROUP_PRODUCT,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_PRODUCT . '_delete',
                'group' => self::GROUP_PRODUCT,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_PRODUCT . '_status',
                'group' => self::GROUP_PRODUCT,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'View',
                'slug' => self::GROUP_PRODUCT . '_show',
                'group' => self::GROUP_PRODUCT,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],

            // Attribute
            [
                'name' => 'List',
                'slug' => self::GROUP_ATTRIBUTE . '_index',
                'group' => self::GROUP_ATTRIBUTE,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_ATTRIBUTE . '_create',
                'group' => self::GROUP_ATTRIBUTE,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_ATTRIBUTE . '_update',
                'group' => self::GROUP_ATTRIBUTE,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_ATTRIBUTE . '_delete',
                'group' => self::GROUP_ATTRIBUTE,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Change Status',
                'slug' => self::GROUP_ATTRIBUTE . '_change_status',
                'group' => self::GROUP_ATTRIBUTE,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],

            // Attribute Value
            [
                'name' => 'List',
                'slug' => self::GROUP_ATTRIBUTE_VALUE . '_index',
                'group' => self::GROUP_ATTRIBUTE_VALUE,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_ATTRIBUTE_VALUE . '_create',
                'group' => self::GROUP_ATTRIBUTE_VALUE,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_ATTRIBUTE_VALUE . '_update',
                'group' => self::GROUP_ATTRIBUTE_VALUE,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_ATTRIBUTE_VALUE . '_delete',
                'group' => self::GROUP_ATTRIBUTE_VALUE,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Change Status',
                'slug' => self::GROUP_ATTRIBUTE_VALUE . '_change_status',
                'group' => self::GROUP_ATTRIBUTE_VALUE,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],

            // Review
            [
                'name' => 'List',
                'slug' => self::GROUP_REVIEW . '_index',
                'group' => self::GROUP_REVIEW,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'All List',
                'slug' => self::GROUP_REVIEW . '_all_index',
                'group' => self::GROUP_REVIEW,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Show Message',
                'slug' => self::GROUP_REVIEW . '_message',
                'group' => self::GROUP_REVIEW,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_REVIEW . '_status',
                'group' => self::GROUP_REVIEW,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],

            // Product Question & Answer
            [
                'name' => 'List',
                'slug' => self::GROUP_PRODUCT_QUESTION . '_index',
                'group' => self::GROUP_PRODUCT_QUESTION,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Answer',
                'slug' => self::GROUP_PRODUCT_QUESTION . '_answer',
                'group' => self::GROUP_PRODUCT_QUESTION,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Change Status',
                'slug' => self::GROUP_PRODUCT_QUESTION . '_change_status',
                'group' => self::GROUP_PRODUCT_QUESTION,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_PRODUCT_QUESTION . '_delete',
                'group' => self::GROUP_PRODUCT_QUESTION,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],

            // Product Alert
            [
                'name' => 'List',
                'slug' => self::GROUP_PRODUCT_ALERT . '_index',
                'group' => self::GROUP_PRODUCT_ALERT,
                'menu_group' => self::MENU_GROUP_PRODUCT,
            ],

            // Common permission for User (Employee/Member)
            [
                'name' => 'Update Status',
                'slug' => self::GROUP_USER . '_update_status',
                'group' => self::GROUP_USER,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Update Password',
                'slug' => self::GROUP_USER . '_update_password',
                'group' => self::GROUP_USER,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_USER . '_delete',
                'group' => self::GROUP_USER,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Restore',
                'slug' => self::GROUP_USER . '_restore',
                'group' => self::GROUP_USER,
                'menu_group' => self::MENU_GROUP_USER,
            ],


            //Emergency Contact
            [
                'name' => 'List',
                'slug' => self::GROUP_EMERGENCY_CONTACT . '_index',
                'group' => self::GROUP_EMERGENCY_CONTACT,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            // [
            //     'name' => 'Create',
            //     'slug' => self::GROUP_EMERGENCY_CONTACT . '_create',
            //     'group' => self::GROUP_EMERGENCY_CONTACT,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_EMERGENCY_CONTACT . '_update',
                'group' => self::GROUP_EMERGENCY_CONTACT,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            // [
            //     'name' => 'View',
            //     'slug' => self::GROUP_EMERGENCY_CONTACT . '_show',
            //     'group' => self::GROUP_EMERGENCY_CONTACT,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'Delete',
            //     'slug' => self::GROUP_EMERGENCY_CONTACT . '_delete',
            //     'group' => self::GROUP_EMERGENCY_CONTACT,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],


            //Address
            [
                'name' => 'List',
                'slug' => self::GROUP_ADDRESS . '_index',
                'group' => self::GROUP_ADDRESS,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            // [
            //     'name' => 'Create',
            //     'slug' => self::GROUP_ADDRESS . '_create',
            //     'group' => self::GROUP_ADDRESS,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_ADDRESS . '_update',
                'group' => self::GROUP_ADDRESS,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            // [
            //     'name' => 'View',
            //     'slug' => self::GROUP_ADDRESS . '_show',
            //     'group' => self::GROUP_ADDRESS,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'Delete',
            //     'slug' => self::GROUP_ADDRESS . '_delete',
            //     'group' => self::GROUP_ADDRESS,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],

            //========== permission for (Employee/Member/Supplier) ===========//
            //Employee
            [
                'name' => 'List',
                'slug' => self::GROUP_EMP . '_index',
                'group' => self::GROUP_EMP,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_EMP . '_create',
                'group' => self::GROUP_EMP,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_EMP . '_update',
                'group' => self::GROUP_EMP,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'View',
                'slug' => self::GROUP_EMP . '_show',
                'group' => self::GROUP_EMP,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Details',
                'slug' => self::GROUP_EMP . '_details',
                'group' => self::GROUP_EMP,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Security',
                'slug' => self::GROUP_EMP . '_security',
                'group' => self::GROUP_EMP,
                'menu_group' => self::MENU_GROUP_USER,
            ],

            // Customer
            [
                'name' => 'List',
                'slug' => self::GROUP_CUSTOMER . '_index',
                'group' => self::GROUP_CUSTOMER,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_CUSTOMER . '_create',
                'group' => self::GROUP_CUSTOMER,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_CUSTOMER . '_update',
                'group' => self::GROUP_CUSTOMER,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'View',
                'slug' => self::GROUP_CUSTOMER . '_show',
                'group' => self::GROUP_CUSTOMER,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Details',
                'slug' => self::GROUP_CUSTOMER . '_details',
                'group' => self::GROUP_CUSTOMER,
                'menu_group' => self::MENU_GROUP_USER,
            ],
            [
                'name' => 'Orders',
                'slug' => self::GROUP_CUSTOMER . '_orders',
                'group' => self::GROUP_CUSTOMER,
                'menu_group' => self::MENU_GROUP_USER,
            ],

            // Seller
            // [
            //     'name' => 'List',
            //     'slug' => self::GROUP_SELLER . '_index',
            //     'group' => self::GROUP_SELLER,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'Create',
            //     'slug' => self::GROUP_SELLER . '_create',
            //     'group' => self::GROUP_SELLER,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'Update',
            //     'slug' => self::GROUP_SELLER . '_update',
            //     'group' => self::GROUP_SELLER,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'View',
            //     'slug' => self::GROUP_SELLER . '_show',
            //     'group' => self::GROUP_SELLER,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'Delete',
            //     'slug' => self::GROUP_SELLER . '_delete',
            //     'group' => self::GROUP_SELLER,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'Status Update',
            //     'slug' => self::GROUP_SELLER . '_status',
            //     'group' => self::GROUP_SELLER,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],

            // Note
            // [
            //     'name' => 'List',
            //     'slug' => self::GROUP_NOTE . '_index',
            //     'group' => self::GROUP_NOTE,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'Create',
            //     'slug' => self::GROUP_NOTE . '_create',
            //     'group' => self::GROUP_NOTE,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'Update',
            //     'slug' => self::GROUP_NOTE . '_update',
            //     'group' => self::GROUP_NOTE,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'View',
            //     'slug' => self::GROUP_NOTE . '_show',
            //     'group' => self::GROUP_NOTE,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],
            // [
            //     'name' => 'Delete',
            //     'slug' => self::GROUP_NOTE . '_delete',
            //     'group' => self::GROUP_NOTE,
            //     'menu_group' => self::MENU_GROUP_USER,
            // ],

            // Return
            [
                'name' => 'List',
                'slug' => self::GROUP_REFUND . '_index',
                'group' => self::GROUP_REFUND,
                'menu_group' => self::MENU_GROUP_RETURN,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_REFUND . '_create',
                'group' => self::GROUP_REFUND,
                'menu_group' => self::MENU_GROUP_RETURN,
            ],
            [
                'name' => 'View',
                'slug' => self::GROUP_REFUND . '_show',
                'group' => self::GROUP_REFUND,
                'menu_group' => self::MENU_GROUP_RETURN,
            ],
            [
                'name' => 'Change Status',
                'slug' => self::GROUP_REFUND . '_change_status',
                'group' => self::GROUP_REFUND,
                'menu_group' => self::MENU_GROUP_RETURN,
            ],

            //================= Support menu =====================//
            //Ticket
            [
                'name' => 'List',
                'slug' => self::GROUP_TICKET . '_index',
                'group' => self::GROUP_TICKET,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_TICKET . '_create',
                'group' => self::GROUP_TICKET,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_TICKET . '_update',
                'group' => self::GROUP_TICKET,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'View',
                'slug' => self::GROUP_TICKET . '_show',
                'group' => self::GROUP_TICKET,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'Reply',
                'slug' => self::GROUP_TICKET . '_reply',
                'group' => self::GROUP_TICKET,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'Assignee',
                'slug' => self::GROUP_TICKET . '_assignee',
                'group' => self::GROUP_TICKET,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'Change Status',
                'slug' => self::GROUP_TICKET . '_change_status',
                'group' => self::GROUP_TICKET,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'Re-Open',
                'slug' => self::GROUP_TICKET . '_reopen',
                'group' => self::GROUP_TICKET,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'My Ticket Menu',
                'slug' => self::GROUP_TICKET . '_my_ticket',
                'group' => self::GROUP_TICKET,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'All Ticket Menu',
                'slug' => self::GROUP_TICKET . '_all_ticket',
                'group' => self::GROUP_TICKET,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],

            // Contact us
            [
                'name' => 'List',
                'slug' => self::GROUP_CONTACT_US . '_index',
                'group' => self::GROUP_CONTACT_US,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'Status',
                'slug' => self::GROUP_CONTACT_US . '_status',
                'group' => self::GROUP_CONTACT_US,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_CONTACT_US . '_delete',
                'group' => self::GROUP_CONTACT_US,
                'menu_group' => self::MENU_GROUP_SUPPORT,
            ],

            // Subscriber
            // [
            //     'name' => 'List',
            //     'slug' => self::GROUP_SUBSCRIBER . '_index',
            //     'group' => self::GROUP_SUBSCRIBER,
            //     'menu_group' => self::MENU_GROUP_SUBSCRIBERS,
            // ],
            // [
            //     'name' => 'Delete',
            //     'slug' => self::GROUP_SUBSCRIBER . '_delete',
            //     'group' => self::GROUP_SUBSCRIBER,
            //     'menu_group' => self::MENU_GROUP_SUBSCRIBERS,
            // ],

            //================= Accounts menu =====================//
            // Withdraw
            // [
            //     'name' => 'List',
            //     'slug' => self::GROUP_WITHDRAW . '_index',
            //     'group' => self::GROUP_WITHDRAW,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],
            // [
            //     'name' => 'Create',
            //     'slug' => self::GROUP_WITHDRAW . '_create',
            //     'group' => self::GROUP_WITHDRAW,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],
            // [
            //     'name' => 'Update',
            //     'slug' => self::GROUP_WITHDRAW . '_update',
            //     'group' => self::GROUP_WITHDRAW,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],
            // [
            //     'name' => 'Delete',
            //     'slug' => self::GROUP_WITHDRAW . '_delete',
            //     'group' => self::GROUP_WITHDRAW,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],
            // [
            //     'name' => 'View',
            //     'slug' => self::GROUP_WITHDRAW . '_show',
            //     'group' => self::GROUP_WITHDRAW,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],

            // Expense
            [
                'name' => 'List',
                'slug' => self::GROUP_EXPENSE . '_index',
                'group' => self::GROUP_EXPENSE,
                'menu_group' => self::MENU_GROUP_ACCOUNTS,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_EXPENSE . '_create',
                'group' => self::GROUP_EXPENSE,
                'menu_group' => self::MENU_GROUP_ACCOUNTS,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_EXPENSE . '_update',
                'group' => self::GROUP_EXPENSE,
                'menu_group' => self::MENU_GROUP_ACCOUNTS,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_EXPENSE . '_delete',
                'group' => self::GROUP_EXPENSE,
                'menu_group' => self::MENU_GROUP_ACCOUNTS,
            ],

            // Payouts
            // [
            //     'name' => 'List',
            //     'slug' => self::GROUP_PAYOUT . '_index',
            //     'group' => self::GROUP_PAYOUT,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],
            // [
            //     'name' => 'Update Status',
            //     'slug' => self::GROUP_PAYOUT . '_change_status',
            //     'group' => self::GROUP_PAYOUT,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],
            // [
            //     'name' => 'Message',
            //     'slug' => self::GROUP_PAYOUT . '_message',
            //     'group' => self::GROUP_PAYOUT,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],

            // Settlement
            // [
            //     'name' => 'List',
            //     'slug' => self::GROUP_SETTLEMENT . '_index',
            //     'group' => self::GROUP_SETTLEMENT,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],
            // [
            //     'name' => 'Update Status',
            //     'slug' => self::GROUP_SETTLEMENT . '_change_status',
            //     'group' => self::GROUP_SETTLEMENT,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],
            // [
            //     'name' => 'Message',
            //     'slug' => self::GROUP_SETTLEMENT . '_message',
            //     'group' => self::GROUP_SETTLEMENT,
            //     'menu_group' => self::MENU_GROUP_ACCOUNTS,
            // ],

            // Courier Pricing Plan
            [
                'name' => 'List',
                'slug' => self::GROUP_COURIER_PRICING . '_index',
                'group' => self::GROUP_COURIER_PRICING,
                'menu_group' => self::MENU_GROUP_COURIER_PRICING,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_COURIER_PRICING . '_create',
                'group' => self::GROUP_COURIER_PRICING,
                'menu_group' => self::MENU_GROUP_COURIER_PRICING,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_COURIER_PRICING . '_update',
                'group' => self::GROUP_COURIER_PRICING,
                'menu_group' => self::MENU_GROUP_COURIER_PRICING,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_COURIER_PRICING . '_delete',
                'group' => self::GROUP_COURIER_PRICING,
                'menu_group' => self::MENU_GROUP_COURIER_PRICING,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_COURIER_PRICING . '_change_status',
                'group' => self::GROUP_COURIER_PRICING,
                'menu_group' => self::MENU_GROUP_COURIER_PRICING,
            ],

            //================= Ad menu =====================//
            // Ad Location
            [
                'name' => 'List',
                'slug' => self::GROUP_AD_LOCATION . '_index',
                'group' => self::GROUP_AD_LOCATION,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_AD_LOCATION . '_create',
                'group' => self::GROUP_AD_LOCATION,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_AD_LOCATION . '_update',
                'group' => self::GROUP_AD_LOCATION,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_AD_LOCATION . '_delete',
                'group' => self::GROUP_AD_LOCATION,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_AD_LOCATION . '_change_status',
                'group' => self::GROUP_AD_LOCATION,
                'menu_group' => self::MENU_GROUP_AD,
            ],

            // Coupon
            [
                'name' => 'List',
                'slug' => self::GROUP_COUPON . '_index',
                'group' => self::GROUP_COUPON,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_COUPON . '_create',
                'group' => self::GROUP_COUPON,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_COUPON . '_update',
                'group' => self::GROUP_COUPON,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_COUPON . '_delete',
                'group' => self::GROUP_COUPON,
                'menu_group' => self::MENU_GROUP_AD,
            ],

            // Ad
            [
                'name' => 'List',
                'slug' => self::GROUP_AD . '_index',
                'group' => self::GROUP_AD,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_AD . '_create',
                'group' => self::GROUP_AD,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_AD . '_update',
                'group' => self::GROUP_AD,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_AD . '_delete',
                'group' => self::GROUP_AD,
                'menu_group' => self::MENU_GROUP_AD,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_AD . '_change_status',
                'group' => self::GROUP_AD,
                'menu_group' => self::MENU_GROUP_AD,
            ],

            //================= Website Menu =====================//
            // Slider
            [
                'name' => 'List',
                'slug' => self::GROUP_SLIDER . '_index',
                'group' => self::GROUP_SLIDER,
                'menu_group' => self::MENU_GROUP_WEBSITE,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_SLIDER . '_create',
                'group' => self::GROUP_SLIDER,
                'menu_group' => self::MENU_GROUP_WEBSITE,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_SLIDER . '_update',
                'group' => self::GROUP_SLIDER,
                'menu_group' => self::MENU_GROUP_WEBSITE,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_SLIDER . '_delete',
                'group' => self::GROUP_SLIDER,
                'menu_group' => self::MENU_GROUP_WEBSITE,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_SLIDER . '_status',
                'group' => self::GROUP_SLIDER,
                'menu_group' => self::MENU_GROUP_WEBSITE,
            ],

            // Benefit
            // [
            //     'name' => 'List',
            //     'slug' => self::GROUP_BENEFIT . '_index',
            //     'group' => self::GROUP_BENEFIT,
            //     'menu_group' => self::MENU_GROUP_WEBSITE,
            // ],
            // [
            //     'name' => 'Create',
            //     'slug' => self::GROUP_BENEFIT . '_create',
            //     'group' => self::GROUP_BENEFIT,
            //     'menu_group' => self::MENU_GROUP_WEBSITE,
            // ],
            // [
            //     'name' => 'Update',
            //     'slug' => self::GROUP_BENEFIT . '_update',
            //     'group' => self::GROUP_BENEFIT,
            //     'menu_group' => self::MENU_GROUP_WEBSITE,
            // ],
            // [
            //     'name' => 'Delete',
            //     'slug' => self::GROUP_BENEFIT . '_delete',
            //     'group' => self::GROUP_BENEFIT,
            //     'menu_group' => self::MENU_GROUP_WEBSITE,
            // ],
            // [
            //     'name' => 'Status Update',
            //     'slug' => self::GROUP_BENEFIT . '_status',
            //     'group' => self::GROUP_BENEFIT,
            //     'menu_group' => self::MENU_GROUP_WEBSITE,
            // ],

            // Page
            [
                'name' => 'List',
                'slug' => self::GROUP_PAGE . '_index',
                'group' => self::GROUP_PAGE,
                'menu_group' => self::MENU_GROUP_WEBSITE,
            ],
            // [
            //     'name' => 'Create',
            //     'slug' => self::GROUP_PAGE . '_create',
            //     'group' => self::GROUP_PAGE,
            //     'menu_group' => self::MENU_GROUP_WEBSITE,
            // ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_PAGE . '_update',
                'group' => self::GROUP_PAGE,
                'menu_group' => self::MENU_GROUP_WEBSITE,
            ],
            // [
            //     'name' => 'Delete',
            //     'slug' => self::GROUP_PAGE . '_delete',
            //     'group' => self::GROUP_PAGE,
            //     'menu_group' => self::MENU_GROUP_WEBSITE,
            // ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_PAGE . '_status',
                'group' => self::GROUP_PAGE,
                'menu_group' => self::MENU_GROUP_WEBSITE,
            ],

            // Website Settings
            // [
            //     'name' => 'Cookies',
            //     'slug' => self::GROUP_SETTINGS . '_cookies',
            //     'group' => self::GROUP_SETTINGS,
            //     'menu_group' => self::MENU_GROUP_WEBSITE,
            // ],
            [
                'name' => 'Terms & Conditions',
                'slug' => self::GROUP_SETTINGS . '_terms_and_conditions',
                'group' => self::GROUP_SETTINGS,
                'menu_group' => self::MENU_GROUP_WEBSITE,
            ],
            // [
            //     'name' => 'Website Popup',
            //     'slug' => self::GROUP_SETTINGS . '_website_popup',
            //     'group' => self::GROUP_SETTINGS,
            //     'menu_group' => self::MENU_GROUP_WEBSITE,
            // ],
            [
                'name' => 'Banner',
                'slug' => self::GROUP_SETTINGS . '_banner',
                'group' => self::GROUP_SETTINGS,
                'menu_group' => self::MENU_GROUP_WEBSITE,
            ],

            //Foot print
            // [
            //     'name' => 'Footprint Menu',
            //     'slug' => self::GROUP_LOG . '_footprint_menu',
            //     'group' => self::GROUP_LOG,
            //     'menu_group' => self::MENU_GROUP_FOOT_PRINT,
            // ],
            [
                'name' => 'Login List',
                'slug' => self::GROUP_LOG . '_login_index',
                'group' => self::GROUP_LOG,
                'menu_group' => self::MENU_GROUP_FOOT_PRINT,
            ],
            [
                'name' => 'Login Delete',
                'slug' => self::GROUP_LOG . '_delete_login',
                'group' => self::GROUP_LOG,
                'menu_group' => self::MENU_GROUP_FOOT_PRINT,
            ],
            [
                'name' => 'Activity List',
                'slug' => self::GROUP_LOG . '_activity_index',
                'group' => self::GROUP_LOG,
                'menu_group' => self::MENU_GROUP_FOOT_PRINT,
            ],
            [
                'name' => 'Activity View',
                'slug' => self::GROUP_LOG . '_activity_show',
                'group' => self::GROUP_LOG,
                'menu_group' => self::MENU_GROUP_FOOT_PRINT,
            ],
            [
                'name' => 'Email List',
                'slug' => self::GROUP_LOG . '_email_index',
                'group' => self::GROUP_LOG,
                'menu_group' => self::MENU_GROUP_FOOT_PRINT,
            ],
            [
                'name' => 'Email View',
                'slug' => self::GROUP_LOG . '_email_show',
                'group' => self::GROUP_LOG,
                'menu_group' => self::MENU_GROUP_FOOT_PRINT,
            ],

            //================== Settings menu =====================//
            // Role Permissions
            [
                'name' => 'List',
                'slug' => self::GROUP_ROLE . '_index',
                'group' => self::GROUP_ROLE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_ROLE . '_create',
                'group' => self::GROUP_ROLE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'View',
                'slug' => self::GROUP_ROLE . '_show',
                'group' => self::GROUP_ROLE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_ROLE . '_update',
                'group' => self::GROUP_ROLE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_ROLE . '_delete',
                'group' => self::GROUP_ROLE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Permission',
                'slug' => self::GROUP_ROLE . '_permission',
                'group' => self::GROUP_ROLE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Permission Update',
                'slug' => self::GROUP_ROLE . '_permission_update',
                'group' => self::GROUP_ROLE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],

            // Dropdown
            [
                'name' => 'Dropdown List',
                'slug' => self::GROUP_DROPDOWN . '_index',
                'group' => self::GROUP_DROPDOWN,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Create Dropdown',
                'slug' => self::GROUP_DROPDOWN . '_create',
                'group' => self::GROUP_DROPDOWN,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Update Dropdown',
                'slug' => self::GROUP_DROPDOWN . '_update',
                'group' => self::GROUP_DROPDOWN,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Delete Dropdown',
                'slug' => self::GROUP_DROPDOWN . '_delete',
                'group' => self::GROUP_DROPDOWN,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Genaral Settings View',
                'slug' => self::GROUP_GENERAL_SETTINGS . '_show',
                'group' => self::GROUP_GENERAL_SETTINGS,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Genaral Settings Update',
                'slug' => self::GROUP_GENERAL_SETTINGS . '_update',
                'group' => self::GROUP_GENERAL_SETTINGS,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Email Settings View',
                'slug' => self::GROUP_EMAIL_SETTINGS . '_show',
                'group' => self::GROUP_EMAIL_SETTINGS,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Email Settings Update',
                'slug' => self::GROUP_EMAIL_SETTINGS . '_update',
                'group' => self::GROUP_EMAIL_SETTINGS,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Email Template List',
                'slug' => self::GROUP_EMAIL_TEMPLATE . '_index',
                'group' => self::GROUP_EMAIL_TEMPLATE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Email Template Update',
                'slug' => self::GROUP_EMAIL_TEMPLATE . '_update',
                'group' => self::GROUP_EMAIL_TEMPLATE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],

            //Email Signature
            [
                'name' => 'Email Signature List',
                'slug' => self::GROUP_EMAIL_SIGNATURE . '_index',
                'group' => self::GROUP_EMAIL_SIGNATURE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Email Signature Create',
                'slug' => self::GROUP_EMAIL_SIGNATURE . '_create',
                'group' => self::GROUP_EMAIL_SIGNATURE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Email Signature View',
                'slug' => self::GROUP_EMAIL_SIGNATURE . '_show',
                'group' => self::GROUP_EMAIL_SIGNATURE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Email Signature Update',
                'slug' => self::GROUP_EMAIL_SIGNATURE . '_update',
                'group' => self::GROUP_EMAIL_SIGNATURE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Email Signature Delete',
                'slug' => self::GROUP_EMAIL_SIGNATURE . '_delete',
                'group' => self::GROUP_EMAIL_SIGNATURE,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],

            [
                'name' => 'Social Link View',
                'slug' => self::GROUP_SOCIAL_LINK . '_show',
                'group' => self::GROUP_SOCIAL_LINK,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Social Link Update',
                'slug' => self::GROUP_SOCIAL_LINK . '_update',
                'group' => self::GROUP_SOCIAL_LINK,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],

            // Area Settings
            // Division
            [
                'name' => 'List',
                'slug' => self::GROUP_DIVISION . '_index',
                'group' => self::GROUP_DIVISION,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_DIVISION . '_change_status',
                'group' => self::GROUP_DIVISION,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],

            // District
            [
                'name' => 'List',
                'slug' => self::GROUP_DISTRICT . '_index',
                'group' => self::GROUP_DISTRICT,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_DISTRICT . '_change_status',
                'group' => self::GROUP_DISTRICT,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Suburbs',
                'slug' => self::GROUP_DISTRICT . '_suburbs',
                'group' => self::GROUP_DISTRICT,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],

            // Thana
            [
                'name' => 'List',
                'slug' => self::GROUP_THANA . '_index',
                'group' => self::GROUP_THANA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_THANA . '_create',
                'group' => self::GROUP_THANA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_THANA . '_update',
                'group' => self::GROUP_THANA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_THANA . '_delete',
                'group' => self::GROUP_THANA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_THANA . '_change_status',
                'group' => self::GROUP_THANA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Suburbs',
                'slug' => self::GROUP_THANA . '_suburbs',
                'group' => self::GROUP_THANA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],

            // Area
            [
                'name' => 'List',
                'slug' => self::GROUP_AREA . '_index',
                'group' => self::GROUP_AREA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_AREA . '_create',
                'group' => self::GROUP_AREA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_AREA . '_update',
                'group' => self::GROUP_AREA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_AREA . '_delete',
                'group' => self::GROUP_AREA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Status Update',
                'slug' => self::GROUP_AREA . '_change_status',
                'group' => self::GROUP_AREA,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],

            // Pickup Hub
            [
                'name' => 'List',
                'slug' => self::GROUP_PICKUP_HUB . '_index',
                'group' => self::GROUP_PICKUP_HUB,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Create',
                'slug' => self::GROUP_PICKUP_HUB . '_create',
                'group' => self::GROUP_PICKUP_HUB,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_PICKUP_HUB . '_update',
                'group' => self::GROUP_PICKUP_HUB,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Delete',
                'slug' => self::GROUP_PICKUP_HUB . '_delete',
                'group' => self::GROUP_PICKUP_HUB,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],


            // Report
            [
                'name' => 'Stock Report',
                'slug' => self::GROUP_REPORT . '_stock',
                'group' => self::GROUP_REPORT,
                'menu_group' => self::MENU_GROUP_REPORT,
            ],
            [
                'name' => 'Purchase/Sale Report',
                'slug' => self::GROUP_REPORT . '_order',
                'group' => self::GROUP_REPORT,
                'menu_group' => self::MENU_GROUP_REPORT,
            ],
            [
                'name' => 'Expense Report',
                'slug' => self::GROUP_REPORT . '_expense',
                'group' => self::GROUP_REPORT,
                'menu_group' => self::MENU_GROUP_REPORT,
            ],
            // [
            //     'name' => 'Withdraw Report',
            //     'slug' => self::GROUP_REPORT . '_withdraw',
            //     'group' => self::GROUP_REPORT,
            //     'menu_group' => self::MENU_GROUP_REPORT,
            // ],
            [
                'name' => 'User Report',
                'slug' => self::GROUP_REPORT . '_user',
                'group' => self::GROUP_REPORT,
                'menu_group' => self::MENU_GROUP_REPORT,
            ],
            [
                'name' => 'Profit Report',
                'slug' => self::GROUP_REPORT . '_profit',
                'group' => self::GROUP_REPORT,
                'menu_group' => self::MENU_GROUP_REPORT,
            ],

            //Backend Color Settings
            [
                'name' => 'List',
                'slug' => self::GROUP_BACKEND_COLOR . '_index',
                'group' => self::GROUP_BACKEND_COLOR,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_BACKEND_COLOR . '_update',
                'group' => self::GROUP_BACKEND_COLOR,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],

            //Frontend Color Settings
            [
                'name' => 'List',
                'slug' => self::GROUP_FRONTEND_COLOR . '_index',
                'group' => self::GROUP_FRONTEND_COLOR,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
            [
                'name' => 'Update',
                'slug' => self::GROUP_FRONTEND_COLOR . '_update',
                'group' => self::GROUP_FRONTEND_COLOR,
                'menu_group' => self::MENU_GROUP_SETTINGS,
            ],
        ];
    }

    // private function sellerPermissions()
    // {
    //     return [
    //         //Order
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_ORDER . '_index',
    //             'group' => self::SELLER_GROUP_ORDER,
    //             'menu_group' => self::SELLER_MENU_GROUP_ORDER,
    //         ],
    //         [
    //             'name' => 'View',
    //             'slug' => self::SELLER_GROUP_ORDER . '_show',
    //             'group' => self::SELLER_GROUP_ORDER,
    //             'menu_group' => self::SELLER_MENU_GROUP_ORDER,
    //         ],
    //         [
    //             'name' => 'Invoice',
    //             'slug' => self::SELLER_GROUP_ORDER . '_invoice',
    //             'group' => self::SELLER_GROUP_ORDER,
    //             'menu_group' => self::SELLER_MENU_GROUP_ORDER,
    //         ],
    //         [
    //             'name' => 'Invoice Download',
    //             'slug' => self::SELLER_GROUP_ORDER . '_invoice_download',
    //             'group' => self::SELLER_GROUP_ORDER,
    //             'menu_group' => self::SELLER_MENU_GROUP_ORDER,
    //         ],
    //         [
    //             'name' => 'Status Update',
    //             'slug' => self::SELLER_GROUP_ORDER . '_change_status',
    //             'group' => self::SELLER_GROUP_ORDER,
    //             'menu_group' => self::SELLER_MENU_GROUP_ORDER,
    //         ],

    //         // Product
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_PRODUCT . '_index',
    //             'group' => self::SELLER_GROUP_PRODUCT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_PRODUCT . '_create',
    //             'group' => self::SELLER_GROUP_PRODUCT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_PRODUCT . '_update',
    //             'group' => self::SELLER_GROUP_PRODUCT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_PRODUCT . '_delete',
    //             'group' => self::SELLER_GROUP_PRODUCT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],
    //         [
    //             'name' => 'Status Update',
    //             'slug' => self::SELLER_GROUP_PRODUCT . '_change_status',
    //             'group' => self::SELLER_GROUP_PRODUCT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],
    //         [
    //             'name' => 'View',
    //             'slug' => self::SELLER_GROUP_PRODUCT . '_show',
    //             'group' => self::SELLER_GROUP_PRODUCT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],
    //         // [
    //         //     'name'       => 'Clone',
    //         //     'slug'       => self::SELLER_GROUP_PRODUCT . '_create_clone',
    //         //     'group'      => self::SELLER_GROUP_PRODUCT,
    //         //     'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         // ],
    //         [
    //             'name' => 'Refundable',
    //             'slug' => self::SELLER_GROUP_PRODUCT . '_refundable',
    //             'group' => self::SELLER_GROUP_PRODUCT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],
    //         [
    //             'name' => 'ShowHomePage',
    //             'slug' => self::SELLER_GROUP_PRODUCT . '_showHomePage',
    //             'group' => self::SELLER_GROUP_PRODUCT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],

    //         // Review
    //         [
    //             'name' => 'All Product Review',
    //             'slug' => self::SELLER_GROUP_REVIEW . '_all_index',
    //             'group' => self::SELLER_GROUP_REVIEW,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],

    //         [
    //             'name' => 'Single Product Review',
    //             'slug' => self::SELLER_GROUP_REVIEW . '_index',
    //             'group' => self::SELLER_GROUP_REVIEW,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],

    //         // Return
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_REFUND . '_index',
    //             'group' => self::SELLER_GROUP_REFUND,
    //             'menu_group' => self::SELLER_MENU_GROUP_RETURN,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_REFUND . '_create',
    //             'group' => self::SELLER_GROUP_REFUND,
    //             'menu_group' => self::SELLER_MENU_GROUP_RETURN,
    //         ],
    //         [
    //             'name' => 'View',
    //             'slug' => self::SELLER_GROUP_REFUND . '_show',
    //             'group' => self::SELLER_GROUP_REFUND,
    //             'menu_group' => self::SELLER_MENU_GROUP_RETURN,
    //         ],
    //         [
    //             'name' => 'Approve',
    //             'slug' => self::SELLER_GROUP_REFUND . '_approved',
    //             'group' => self::SELLER_GROUP_REFUND,
    //             'menu_group' => self::SELLER_MENU_GROUP_RETURN,
    //         ],

    //         // Moderator ---------------------------------------
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_MODERATOR . '_index',
    //             'group' => self::SELLER_GROUP_MODERATOR,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_MODERATOR . '_create',
    //             'group' => self::SELLER_GROUP_MODERATOR,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_MODERATOR . '_update',
    //             'group' => self::SELLER_GROUP_MODERATOR,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'View',
    //             'slug' => self::SELLER_GROUP_MODERATOR . '_show',
    //             'group' => self::SELLER_GROUP_MODERATOR,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_MODERATOR . '_delete',
    //             'group' => self::SELLER_GROUP_MODERATOR,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_MODERATOR . '_restore',
    //             'group' => self::SELLER_GROUP_MODERATOR,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Status Update',
    //             'slug' => self::SELLER_GROUP_MODERATOR . 'change_status',
    //             'group' => self::SELLER_GROUP_MODERATOR,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Update Password',
    //             'slug' => self::SELLER_GROUP_MODERATOR . 'change_password',
    //             'group' => self::SELLER_GROUP_MODERATOR,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],

    //         //Emergency Contact
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_EMERGENCY_CONTACT . '_index',
    //             'group' => self::SELLER_GROUP_EMERGENCY_CONTACT,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_EMERGENCY_CONTACT . '_create',
    //             'group' => self::SELLER_GROUP_EMERGENCY_CONTACT,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_EMERGENCY_CONTACT . '_update',
    //             'group' => self::SELLER_GROUP_EMERGENCY_CONTACT,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'View',
    //             'slug' => self::SELLER_GROUP_EMERGENCY_CONTACT . '_show',
    //             'group' => self::SELLER_GROUP_EMERGENCY_CONTACT,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_EMERGENCY_CONTACT . '_delete',
    //             'group' => self::SELLER_GROUP_EMERGENCY_CONTACT,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],

    //         //Address
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_ADDRESS . '_index',
    //             'group' => self::SELLER_GROUP_ADDRESS,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_ADDRESS . '_create',
    //             'group' => self::SELLER_GROUP_ADDRESS,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_ADDRESS . '_update',
    //             'group' => self::SELLER_GROUP_ADDRESS,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'View',
    //             'slug' => self::SELLER_GROUP_ADDRESS . '_show',
    //             'group' => self::SELLER_GROUP_ADDRESS,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_ADDRESS . '_delete',
    //             'group' => self::SELLER_GROUP_ADDRESS,
    //             'menu_group' => self::SELLER_MENU_GROUP_MODERATOR,
    //         ],

    //         //Ticket
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_TICKET . '_index',
    //             'group' => self::SELLER_GROUP_TICKET,
    //             'menu_group' => self::SELLER_MENU_GROUP_TICKET,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_TICKET . '_create',
    //             'group' => self::SELLER_GROUP_TICKET,
    //             'menu_group' => self::SELLER_MENU_GROUP_TICKET,
    //         ],
    //         [
    //             'name' => 'View',
    //             'slug' => self::SELLER_GROUP_TICKET . '_show',
    //             'group' => self::SELLER_GROUP_TICKET,
    //             'menu_group' => self::SELLER_MENU_GROUP_TICKET,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_TICKET . '_update',
    //             'group' => self::SELLER_GROUP_TICKET,
    //             'menu_group' => self::SELLER_MENU_GROUP_TICKET,
    //         ],
    //         [
    //             'name' => 'Reply',
    //             'slug' => self::SELLER_GROUP_TICKET . '_reply',
    //             'group' => self::SELLER_GROUP_TICKET,
    //             'menu_group' => self::SELLER_MENU_GROUP_TICKET,
    //         ],
    //         [
    //             'name' => 'Change Status',
    //             'slug' => self::SELLER_GROUP_TICKET . '_change_status',
    //             'group' => self::SELLER_GROUP_TICKET,
    //             'menu_group' => self::SELLER_MENU_GROUP_TICKET,
    //         ],
    //         [
    //             'name' => 'Re-Open',
    //             'slug' => self::SELLER_GROUP_TICKET . '_reopen',
    //             'group' => self::SELLER_GROUP_TICKET,
    //             'menu_group' => self::SELLER_MENU_GROUP_TICKET,
    //         ],

    //         // Ad request
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_AD_REQUEST . '_index',
    //             'group' => self::SELLER_GROUP_AD_REQUEST,
    //             'menu_group' => self::SELLER_MENU_GROUP_AD,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_AD_REQUEST . '_create',
    //             'group' => self::SELLER_GROUP_AD_REQUEST,
    //             'menu_group' => self::SELLER_MENU_GROUP_AD,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_AD_REQUEST . '_update',
    //             'group' => self::SELLER_GROUP_AD_REQUEST,
    //             'menu_group' => self::SELLER_MENU_GROUP_AD,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_AD_REQUEST . '_delete',
    //             'group' => self::SELLER_GROUP_AD_REQUEST,
    //             'menu_group' => self::SELLER_MENU_GROUP_AD,
    //         ],

    //         // Bank account
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_BANK_ACCOUNT . '_index',
    //             'group' => self::SELLER_GROUP_BANK_ACCOUNT,
    //             'menu_group' => self::SELLER_MENU_GROUP_BANK_ACCOUNT,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_BANK_ACCOUNT . '_create',
    //             'group' => self::SELLER_GROUP_BANK_ACCOUNT,
    //             'menu_group' => self::SELLER_MENU_GROUP_BANK_ACCOUNT,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_BANK_ACCOUNT . '_update',
    //             'group' => self::SELLER_GROUP_BANK_ACCOUNT,
    //             'menu_group' => self::SELLER_MENU_GROUP_BANK_ACCOUNT,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_BANK_ACCOUNT . '_delete',
    //             'group' => self::SELLER_GROUP_BANK_ACCOUNT,
    //             'menu_group' => self::SELLER_MENU_GROUP_BANK_ACCOUNT,
    //         ],
    //         [
    //             'name' => 'Status Update',
    //             'slug' => self::SELLER_GROUP_BANK_ACCOUNT . '_status',
    //             'group' => self::SELLER_GROUP_BANK_ACCOUNT,
    //             'menu_group' => self::SELLER_MENU_GROUP_BANK_ACCOUNT,
    //         ],

    //         // Role Permissions
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_ROLE . '_index',
    //             'group' => self::SELLER_GROUP_ROLE,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_ROLE . '_create',
    //             'group' => self::SELLER_GROUP_ROLE,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],
    //         [
    //             'name' => 'View',
    //             'slug' => self::SELLER_GROUP_ROLE . '_show',
    //             'group' => self::SELLER_GROUP_ROLE,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_ROLE . '_update',
    //             'group' => self::SELLER_GROUP_ROLE,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_ROLE . '_delete',
    //             'group' => self::SELLER_GROUP_ROLE,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],
    //         [
    //             'name' => 'Permission',
    //             'slug' => self::SELLER_GROUP_ROLE . '_show_permission',
    //             'group' => self::SELLER_GROUP_ROLE,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],
    //         [
    //             'name' => 'Permission Update',
    //             'slug' => self::SELLER_GROUP_ROLE . '_update_permission',
    //             'group' => self::SELLER_GROUP_ROLE,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],

    //         // Report
    //         [
    //             'name' => 'Stock Report',
    //             'slug' => self::SELLER_GROUP_REPORT . '_stock',
    //             'group' => self::SELLER_GROUP_REPORT,
    //             'menu_group' => self::SELLER_MENU_GROUP_REPORT,
    //         ],
    //         [
    //             'name' => 'Purchase/Sale Report',
    //             'slug' => self::SELLER_GROUP_REPORT . '_order',
    //             'group' => self::SELLER_GROUP_REPORT,
    //             'menu_group' => self::SELLER_MENU_GROUP_REPORT,
    //         ],
    //         [
    //             'name' => 'Expense Report',
    //             'slug' => self::SELLER_GROUP_REPORT . '_expense',
    //             'group' => self::SELLER_GROUP_REPORT,
    //             'menu_group' => self::SELLER_MENU_GROUP_REPORT,
    //         ],
    //         [
    //             'name' => 'Withdraw Report',
    //             'slug' => self::SELLER_GROUP_REPORT . '_withdraw',
    //             'group' => self::SELLER_GROUP_REPORT,
    //             'menu_group' => self::SELLER_MENU_GROUP_REPORT,
    //         ],
    //         [
    //             'name' => 'User Report',
    //             'slug' => self::SELLER_GROUP_REPORT . '_user',
    //             'group' => self::SELLER_GROUP_REPORT,
    //             'menu_group' => self::SELLER_MENU_GROUP_REPORT,
    //         ],

    //         // Payout
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_PAYOUT . '_index',
    //             'group' => self::SELLER_GROUP_PAYOUT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PAYOUT,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_PAYOUT . '_create',
    //             'group' => self::SELLER_GROUP_PAYOUT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PAYOUT,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_PAYOUT . '_update',
    //             'group' => self::SELLER_GROUP_PAYOUT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PAYOUT,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_PAYOUT . '_delete',
    //             'group' => self::SELLER_GROUP_PAYOUT,
    //             'menu_group' => self::SELLER_MENU_GROUP_PAYOUT,
    //         ],

    //         //notification
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_NOTIFICATION . '_index',
    //             'group' => self::SELLER_GROUP_NOTIFICATION,
    //             'menu_group' => self::SELLER_MENU_GROUP_NOTIFICATION,
    //         ],

    //         // Pickup Hub
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_PICKUP_HUB . '_index',
    //             'group' => self::SELLER_GROUP_PICKUP_HUB,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_PICKUP_HUB . '_create',
    //             'group' => self::SELLER_GROUP_PICKUP_HUB,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_PICKUP_HUB . '_update',
    //             'group' => self::SELLER_GROUP_PICKUP_HUB,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_PICKUP_HUB . '_delete',
    //             'group' => self::SELLER_GROUP_PICKUP_HUB,
    //             'menu_group' => self::SELLER_MENU_GROUP_SETTINGS,
    //         ],

    //         // Product Question & Answer
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_PRODUCT_QUESTION . '_index',
    //             'group' => self::SELLER_GROUP_PRODUCT_QUESTION,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],
    //         [
    //             'name' => 'Answer',
    //             'slug' => self::SELLER_GROUP_PRODUCT_QUESTION . '_answer',
    //             'group' => self::SELLER_GROUP_PRODUCT_QUESTION,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],
    //         [
    //             'name' => 'Change Status',
    //             'slug' => self::SELLER_GROUP_PRODUCT_QUESTION . '_change_status',
    //             'group' => self::SELLER_GROUP_PRODUCT_QUESTION,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_PRODUCT_QUESTION . '_delete',
    //             'group' => self::SELLER_GROUP_PRODUCT_QUESTION,
    //             'menu_group' => self::SELLER_MENU_GROUP_PRODUCT,
    //         ],

    //         // Coupon
    //         [
    //             'name' => 'List',
    //             'slug' => self::SELLER_GROUP_COUPON . '_index',
    //             'group' => self::SELLER_GROUP_COUPON,
    //             'menu_group' => self::SELLER_MENU_GROUP_COUPON,
    //         ],
    //         [
    //             'name' => 'Create',
    //             'slug' => self::SELLER_GROUP_COUPON . '_create',
    //             'group' => self::SELLER_GROUP_COUPON,
    //             'menu_group' => self::SELLER_MENU_GROUP_COUPON,
    //         ],
    //         [
    //             'name' => 'Update',
    //             'slug' => self::SELLER_GROUP_COUPON . '_update',
    //             'group' => self::SELLER_GROUP_COUPON,
    //             'menu_group' => self::SELLER_MENU_GROUP_COUPON,
    //         ],
    //         [
    //             'name' => 'Delete',
    //             'slug' => self::SELLER_GROUP_COUPON . '_delete',
    //             'group' => self::SELLER_GROUP_COUPON,
    //             'menu_group' => self::SELLER_MENU_GROUP_COUPON,
    //         ],
    //     ];
    // }
}
