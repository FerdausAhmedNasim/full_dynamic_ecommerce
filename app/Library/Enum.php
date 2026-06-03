<?php

namespace App\Library;

class Enum
{
    //Vite Resources Path
    public const LOGO_PATH = 'resources/images/logo.png';
    public const ICON_PATH = 'resources/images/favicon.png';
    public const BG_IMAGE_PATH = 'resources/images/bg-image.png';
    public const LOGO_WHITE_PATH = 'resources/images/logowhhite.png';
    public const NO_AVATAR_PATH = 'resources/images/no_avatar.png';
    public const NO_IMAGE_PATH = 'resources/images/noimage.jpg';
    public const LOGIN_BACKGROUND_PATH = 'resources/images/login-image.png';
    public const MARK_CHECK_IMAGE_PATH = 'resources/images/mark.jpg';
    public const PRODUCT_IMAGE = 'resources/images/product.jpg';
    public const FILE_ICON = 'resources/images/file-icon.png';
    public const DEFAULT_CATEGORY_IMAGE_PATH = 'resources/images/default_category.svg';
    public const DEFAULT_PRODUCT_IMAGE_PATH = 'resources/images/default_product.webp';
    public const OFFER_IMAGE1 = 'resources/images/offer_img.webp';
    public const OFFER_IMAGE2 = 'resources/images/offer_img2.png';
    public const ABOUT_IMAGE = 'resources/images/about.webp';
    public const QUESTION_IMAGE = 'resources/images/question.png';
    public const ANSWER_IMAGE = 'resources/images/answer.png';
    //================ frontend ========================//
    public const BANGLADESH_FLAG_PATH = 'resources/images/flags/bangladesh.png';
    public const USA_FLAG_PATH = 'resources/images/flags/united-states.png';

    public const ROLE_SUPER_ADMIN_SLUG = 'super-admin';
    public const QRCODE_DIR = 'storage/qrcode/';
    public const MEMBER_PROFILE_IMAGE_DIR = 'storage/member/profile';
    public const CONFIG_IMAGE_DIR = 'storage/config';
    public const MEMBER_NID_IMAGE_DIR = 'storage/member/nid';
    public const AMS_PRODUCT_IMAGE_DIR = 'storage/ams/product';
    public const EMPLOYEE_PROFILE_IMAGE = 'storage/user/employee/profile';
    public const TICKET_ATTACHMENT_DIR = 'storage/ticket';
    public const EMPLOYEE_CONTACT_PERSION_IMAGE = 'storage/user/employee/contact';
    public const ATTACHMENT_FILE_DIR = 'storage/attachment';
    public const EMPLOYEE_TRAINING_FILE_DIR = 'storage/user/employee/training';
    public const SPONSOR_IMAGE_DIR = 'storage/sponsor';
    public const BOAT_IMAGE_DIR = 'storage/boat';
    public const FISH_SPECIES_IMAGE_DIR = 'storage/fish_species';
    public const NEWS_FEATURE_IMAGE = 'storage/news';
    public const BLOG_FEATURE_IMAGE = 'storage/blog';
    public const SUBSCRIPTION_IMAGE_DIR = 'storage/subscription';

    public const TOURNAMENT_BANNER_IMAGE_DIR = 'storage/tournament/banner';
    public const TOURNAMENT_FEATURED_IMAGE_DIR = 'storage/tournament/featured';

    public const PROJECT_ID_TAG = 'Test';

    public const CATEGORY_THUMBNAIL_IMAGE_DIR = 'storage/category/thumbnail';
    public const BRAND_THUMBNAIL_IMAGE_DIR = 'storage/brand';
    public const CATEGORY_ICON_IMAGE_DIR = 'storage/category/icon';

    public const STORE_THUMBNAIL_IMAGE_DIR = 'storage/store/thumbnail';
    public const STORE_BANNER_IMAGE_DIR = 'storage/store/banner';
    public const STORE_ATTACHMENT_FILE_DIR = 'storage/store/attachment';

    public const USER_AVATAR_DIR = 'storage/user/avatar';
    public const USER_PHOTO_ID_DIR = 'storage/user/photo_id';
    public const TRAINING_DOCUMENTS = 'storage/training_documents';
    public const POST_DOCUMENT = 'storage/post_documents';

    public const GRID3_IMAGE = 'frontend/svg/grid-3.svg';
    public const GRID4_IMAGE = 'frontend/svg/grid-4.svg';
    public const GRID_IMAGE = 'frontend/svg/grid.svg';

    // Product File Path
    public const PRODUCT_THUMBNAIL_IMAGE_DIR = 'storage/product/thumbnail';
    public const PRODUCT_GALLERY_IMAGE_DIR = 'storage/product/gallery';
    public const PRODUCT_DESCRIPTION_IMAGE_DIR = 'storage/product/description';
    public const PRODUCT_VARIANT_IMAGE_DIR = 'storage/product/variant';
    public const PRODUCT_META_IMAGE_DIR = 'storage/product/meta';
    public const ADVERTISE_IMAGE_DIR = 'storage/attachment';

    // ==============  Website ==============//
    public const SLIDER_BACKGROUND_IMAGE_DIR = 'storage/website/slider';
    public const BENEFIT_ICON_IMAGE_DIR = 'storage/website/benefit';
    public const POPUP_IMAGE_DIR = 'storage/website/popup';
    public const POPUP_IMAGE_BANNER = 'storage/website/banners';
    public const LOGIN_IMAGE_PATH = 'resources/images/website/log-in.png';
    public const SIGNUP_IMAGE_PATH = 'resources/images/website/sign-up.png';
    public const FORGOT_PASSWORD_IMAGE_PATH = 'resources/images/website/forgot.png';
    public const GOOGLE_ICON_PATH = 'resources/images/website/google.png';
    public const FACEBOOK_ICON_PATH = 'resources/images/website/facebook.png';
    public const COOKIES_IMG_PATH = 'resources/images/website/cookie-bar.png';
    public const NO_DATA_IMAGE_PATH = 'resources/images/website/nodata.png';
    public const ABOUT_US_IMAGE_PATH = 'storage/website';

    //User dashboard
    public const USER_COVER_IMAGE_PATH = 'resources/images/website/cover-img.jpg';
    public const USER_ORDER_IMAGE_PATH = 'resources/images/website/svg/order.svg';
    public const USER_PENDING_IMAGE_PATH = 'resources/images/website/svg/pending.svg';
    public const USER_WISHLIST_IMAGE_PATH = 'resources/images/website/svg/wishlist.svg';
    public const PRODUCT_REVIEW_IMAGE_DIR = 'storage/product/review';
    public const PROFILE_IMAGE_DIR = 'resources/images/website/dashboard-profile.png';

    // ==============  End Website ==============//

    //===========------- Email Settings Start ----================//
    public const EMAIL_TICKET_CREATE = 'ticket_create';
    public const EMAIL_TICKET_ASSIGN = 'ticket_assign';
    public const EMAIL_TICKET_REPLY = 'ticket_reply';


    //STOCK
    public const EMAIL_STOCK_ASSIGN = 'stock_assign';

    // Page
    public const SELLER_POLICY = 'seller-policy';
    public const SUPPORT_POLICY = 'support-policy';
    public const TERM_CONDITION = 'terms-and-conditions';
    public const ABOUT_US = 'about-us';
    public const REFUND_POLICY = 'refund-policy';
    public const PRIVACY_POLICY = 'privacy-policy';
    public const CONTACT_US = 'contact-us';

    // Brand Page
    public const BRAND_FEATURED = 1;

    //orders
    public const EMAIL_ORDER_CREATE = 'order_create';
    public const EMAIL_ORDER_STATUS_CHANGE = 'order_status_change';
    public const EMAIL_PRODUCT_RETURN = 'product_return';
    public const EMAIL_RETURN_STATUS_CHANGE = 'return_status_change';
    public const EMAIL_SELLER_STATUS_CHANGE = 'seller_status_change';
    public const EMAIL_SHOP_STATUS_CHANGE = 'shop_status_change';
    public const EMAIL_CUSTOMER_STATUS_CHANGE = 'customer_status_change';
    public const EMAIL_SETTLEMENT_CREATE = 'settlement_create';

    public const EMAIL_PAYOUT_REQUEST = 'payout_request';

    //===========------- Email Settings End ----================//

    /* ============== USER MODULE ===================*/
    public const USER_TYPE_SUPER_ADMIN = 'super-admin';
    public const USER_TYPE_ADMIN = 'admin';
    public const USER_TYPE_EMPLOYEE = 'employee';
    public const USER_TYPE_CUSTOMER = 'customer';
    public const USER_TYPE_SELLER = 'seller';
    // public const USER_TYPE_MODERATOR = 'moderator';

    public static function getUserType(mixed $type = null)
    {
        $types = [
            self::USER_TYPE_SUPER_ADMIN => 'Database User',
            self::USER_TYPE_ADMIN       => 'Admin',
            self::USER_TYPE_EMPLOYEE    => 'Employee',
            self::USER_TYPE_CUSTOMER    => 'Customer',
            self::USER_TYPE_SELLER      => 'Seller',
            // self::USER_TYPE_MODERATOR   => 'Moderator',
        ];

        if (is_array($type) && !empty($type)) {
            foreach ($type as $value) {
                $result[$value] = $types[$value];
            }

            return $result;
        }

        return $type ? $types[$type] : $types;
    }

    public const USER_STATUS_PENDING = 1;
    public const USER_STATUS_ACTIVE = 2;
    public const USER_STATUS_SUSPENDED = 3;

    public static function getUserStatus(int $type = null)
    {
        $types = [
            self::USER_STATUS_PENDING   => "Pending",
            self::USER_STATUS_ACTIVE    => "Active",
            self::USER_STATUS_SUSPENDED => "Suspended",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }

    public const IMMUNIZATION_STATUS_PENDING = 1;
    public const IMMUNIZATION_STATUS_COMPLETE = 2;
    public const IMMUNIZATION_STATUS_CANCELED = 3;

    public static function getImmunizationStatus(int $type = null)
    {
        $types = [
            self::IMMUNIZATION_STATUS_PENDING  => "Pending",
            self::IMMUNIZATION_STATUS_COMPLETE => "Completed",
            self::IMMUNIZATION_STATUS_CANCELED => "Canceled",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }

    /* ============== END ===================*/

    /* ============== EMPLOYEE MODULE ===================*/


    public const CONTACT_TYPE_EMAIL = 'email';
    public const CONTACT_TYPE_PHONE = 'phone';
    public const CONTACT_TYPE_FACE_TO_FACE = 'face_to_face';

    public static function getContactType(string $type = null)
    {
        $types = [
            self::CONTACT_TYPE_EMAIL        => "Email",
            self::CONTACT_TYPE_PHONE        => "Phone Call",
            self::CONTACT_TYPE_FACE_TO_FACE => 'Face to Face'
        ];

        return $type ? $types[$type] : $types;
    }

    // public const AD_LOCATION_HOME_PAGE_BANNER = 'home_page_banner';
    public const AD_LOCATION_DEAL_YOU_CAN_NOT_MISS = 'deal_you_can_not_miss';
    public const AD_LOCATION_TOP_BRAND_OFFER = 'top_brand_offer';
    public const AD_LOCATION_FLASH_SALE = 'flash_sale';
    public const AD_LOCATION_TOP_SALE = 'top_sale';

    public static function getAdLocation(string $type = null)
    {
        $types = [
            // self::AD_LOCATION_HOME_PAGE_BANNER      => "Home page banner",
            self::AD_LOCATION_DEAL_YOU_CAN_NOT_MISS => 'Deal you can not miss',
            self::AD_LOCATION_TOP_BRAND_OFFER       => 'Top brand offer',
            self::AD_LOCATION_FLASH_SALE            => 'Flash sale',
            self::AD_LOCATION_TOP_SALE              => 'Top sale',
        ];

        return $type ? $types[$type] : $types;
    }

    public const EMPLOYMENT_STATUS_EMPLOYED = 'employed';
    public const EMPLOYMENT_STATUS_UNEMPLOYED = 'unemployed';

    public static function getEmploymentStatus(string $type = null)
    {
        $types = [
            self::EMPLOYMENT_STATUS_EMPLOYED   => "Employed",
            self::EMPLOYMENT_STATUS_UNEMPLOYED => "Unemployed",
        ];

        return $type ? $types[$type] : $types;
    }

    public const REFERRAL_STATUS_PENDING = 'pending';
    public const REFERRAL_STATUS_ENROLLED = 'enrolled';
    public const REFERRAL_STATUS_DISCHARGE = 'discharge';
    public const REFERRAL_STATUS_DECLINED = 'declined';
    // public const REFERRAL_STATUS_RE_REFER = 're-refer';

    public static function getReferralStatus(string $type = null)
    {
        $types = [
            self::REFERRAL_STATUS_PENDING   => "Pending",
            self::REFERRAL_STATUS_ENROLLED  => "Enrolled",
            self::REFERRAL_STATUS_DISCHARGE => "Discharge",
            self::REFERRAL_STATUS_DECLINED  => "Declined",
            // self::REFERRAL_STATUS_RE_REFER  => "Re-refer",
        ];

        return $type ? $types[$type] : $types;
    }

    public const REFERRAL_DECLINED_BY_KAIMAHI = 'kaimahi';
    public const REFERRAL_DECLINED_BY_CLIENT = 'client';

    public static function getReferralDeclinedBy(string $type = null)
    {
        $types = [
            self::REFERRAL_DECLINED_BY_KAIMAHI => "Kaimahi",
            self::REFERRAL_DECLINED_BY_CLIENT  => "Client",
        ];

        return $type ? $types[$type] : $types;
    }

    public const HAUORA_PLAN_TYPE_JOINT = 'joint';
    public const HAUORA_PLAN_TYPE_INDIVIDUAL = 'individual';

    public static function getHauoraPlanType(string $type = null)
    {
        $types = [
            self::HAUORA_PLAN_TYPE_JOINT      => "Joint",
            self::HAUORA_PLAN_TYPE_INDIVIDUAL => "Individual",
        ];

        return $type ? $types[$type] : $types;
    }

    public const HAUORA_PLAN_STATUS_ACTIVE = 'active';
    public const HAUORA_PLAN_STATUS_HOLD = 'hold';
    public const HAUORA_PLAN_STATUS_COMPLETED = 'completed';

    public static function getHauoraPlanStatus(string $type = null)
    {
        $types = [
            self::HAUORA_PLAN_STATUS_ACTIVE    => "Active",
            self::HAUORA_PLAN_STATUS_HOLD      => "Hold",
            self::HAUORA_PLAN_STATUS_COMPLETED => "Completed",
        ];

        return $type ? $types[$type] : $types;
    }

    public const ATTENDANCE_TYPE_EMPLOYEE = 'employee';
    public const ATTENDANCE_TYPE_VISITOR = 'visitor';

    public static function getAttendanceType(string $type = null)
    {
        $types = [
            self::ATTENDANCE_TYPE_EMPLOYEE => "Employee",
            self::ATTENDANCE_TYPE_VISITOR  => "Visitor",
        ];

        return $type ? $types[$type] : $types;
    }


    public const SIGN_OUT_TYPE_LEAVING = 'leaving';
    public const SIGN_OUT_TYPE_BREAK = 'break';
    public const SIGN_OUT_TYPE_HOME_VISIT = 'home_visit';
    public const SIGN_OUT_TYPE_HOSPITAL_VISIT = 'hospital_visit';
    public const SIGN_OUT_TYPE_TRAVELING_OTHER_OFFICE = 'traveling_other_office';

    public static function getSignOutType(string $type = null)
    {
        $types = [
            self::SIGN_OUT_TYPE_LEAVING                => "Leaving",
            self::SIGN_OUT_TYPE_BREAK                  => "Break",
            self::SIGN_OUT_TYPE_HOME_VISIT             => "Home Visit",
            self::SIGN_OUT_TYPE_HOSPITAL_VISIT         => "Hospital Visit",
            self::SIGN_OUT_TYPE_TRAVELING_OTHER_OFFICE => "Traveling to Other Office",
        ];

        return $type ? $types[$type] : $types;
    }

    /* ============== TICKET MODULE ===================*/
    public const TICKET_STATUS_OPEN = 1;
    public const TICKET_STATUS_HOLD = 2;
    public const TICKET_STATUS_CLOSED = 3;
    public const TICKET_STATUS_NEW = 4;

    public static function getTicketStatus(int $status = null)
    {
        $status_arr = [
            self::TICKET_STATUS_OPEN   => 'Open',
            self::TICKET_STATUS_HOLD   => 'Hold',
            self::TICKET_STATUS_CLOSED => 'Closed',
            self::TICKET_STATUS_NEW    => 'New',
        ];

        return $status ? $status_arr[$status] : $status_arr;
    }

    public const TICKET_PRIORITY_LOW = 1;
    public const TICKET_PRIORITY_MEDIUM = 2;
    public const TICKET_PRIORITY_HIGH = 3;

    public static function getTicketPriority(int $priority = 0)
    {
        $priority_arr = [
            self::TICKET_PRIORITY_LOW    => "Low",
            self::TICKET_PRIORITY_MEDIUM => "Medium",
            self::TICKET_PRIORITY_HIGH   => 'High'
        ];

        return $priority ? $priority_arr[$priority] : $priority_arr;
    }

    /* ============== CONFIG MODULE ===================*/
    // public const CONFIG_DROPDOWN_EMP_DESIGNATION = 'emp_designation';
    public const CONFIG_DROPDOWN_TICKET_DEPARTMENT = 'ticket_department';
    public const CONFIG_DROPDOWN_NOTIFICATION_TYPE = 'notification_type';
    public const CONFIG_DROPDOWN_AMS_BRAND = 'ams_brand';
    // public const CONFIG_DROPDOWN_AMS_LOCATION = 'location';
    public const CONFIG_DROPDOWN_GENDER = 'gender';
    // public const CONFIG_DROPDOWN_PRONOUN = 'pronoun';
    // public const CONFIG_DROPDOWN_ETHNICITY = 'ethnicity';
    // public const CONFIG_DROPDOWN_IWI = 'iwi';
    public const CONFIG_DROPDOWN_JOB_TITLE = 'job_title';
    public const CONFIG_DROPDOWN_EMPLOYMENT_STATUS = 'employment_status';
    // public const CONFIG_DROPDOWN_ENTITLEMENT_TO_WORK = 'entitlement_to_work';
    // public const CONFIG_DROPDOWN_LINE_WEIGHT = 'line_weight';
    // public const CONFIG_DROPDOWN_PRESCRIPTION_CATEGORY = 'prescription_category';
    // public const CONFIG_DROPDOWN_FISHING_METHOD = 'fishing_method';
    // public const CONFIG_DROPDOWN_BLOG_CATEGORY = 'blog_category';
    // public const CONFIG_DROPDOWN_NEWS_CATEGORY = 'news_category';
    // public const CONFIG_DROPDOWN_BLOG_TAG = 'blog_tag';
    public const CONFIG_DROPDOWN_UNIT = 'unit';
    public const CONFIG_DROPDOWN_PAYMENT_METHOD = 'payment_methods';
    public const CONFIG_DROPDOWN_CATEGORY = 'category';
    public const CONFIG_DROPDOWN_EXPENSE_CATEGORY = 'expense_category';

    public static function getConfigDropdown(string $key = null)
    {
        $dropdowns = [
            // self::CONFIG_DROPDOWN_EMP_DESIGNATION       => "Employee Designation",
            self::CONFIG_DROPDOWN_TICKET_DEPARTMENT => "Ticket Issue Type",
            self::CONFIG_DROPDOWN_NOTIFICATION_TYPE => "Notification Type",
            self::CONFIG_DROPDOWN_AMS_BRAND         => "Brand",
            self::CONFIG_DROPDOWN_GENDER            => "Gender",
            // self::CONFIG_DROPDOWN_PRONOUN               => "Pronoun",
            // self::CONFIG_DROPDOWN_ETHNICITY => "Ethnicity",
            // self::CONFIG_DROPDOWN_IWI                   => "Iwi",
            self::CONFIG_DROPDOWN_JOB_TITLE         => "Job Title",
            self::CONFIG_DROPDOWN_EMPLOYMENT_STATUS => "Employment Status",
            // self::CONFIG_DROPDOWN_ENTITLEMENT_TO_WORK => "Entitlement To Work",
            // self::CONFIG_DROPDOWN_LINE_WEIGHT           => "Line Weight (kg)",
            // self::CONFIG_DROPDOWN_PRESCRIPTION_CATEGORY => "Note Type",
            // self::CONFIG_DROPDOWN_FISHING_METHOD        => "Fishing Method",
            // self::CONFIG_DROPDOWN_BLOG_CATEGORY         => "Blog Category",
            // self::CONFIG_DROPDOWN_NEWS_CATEGORY         => "News Category",
            // self::CONFIG_DROPDOWN_BLOG_TAG              => "Blog Tags",
            self::CONFIG_DROPDOWN_UNIT             => "Unit",
            self::CONFIG_DROPDOWN_PAYMENT_METHOD   => "Payment Method",
            self::CONFIG_DROPDOWN_CATEGORY         => "Category",
            self::CONFIG_DROPDOWN_EXPENSE_CATEGORY => "Expense Category",
        ];

        return $key ? $dropdowns[$key] : $dropdowns;
    }

    /* ============== END ===================*/

    // Customer type
    public const CUSTOMER_TYPE_INDIVIDUAL = 'individual';
    public const CUSTOMER_TYPE_BUSINESS = 'business';

    public static function getCustomerTypes($type = null)
    {
        $types = [
            self::CUSTOMER_TYPE_INDIVIDUAL => "Individual",
            self::CUSTOMER_TYPE_BUSINESS   => "Business",
        ];

        return $type ? $types[$type] : $types;
    }

    public static function systemShortcodesWithValues()
    {
        return [
            'current_date'     => now()->format('Y-m-d'),
            'current_datetime' => '',
            'current_time'     => '',
            'system_url'       => '',
            'app_name'         => ''
        ];
    }

    // Address Default Shipping Status
    public const DEFAULT_SHIPPING_ACTIVE = 1;
    public const DEFAULT_SHIPPING = 0;

    // Categories entry type
    public const CATEGORY_BULK = 0;
    public const CATEGORY_INDIVIDUAL = 1;

    public static function getCategoryEntryType(int $type = null)
    {
        $types = [
            self::CATEGORY_BULK       => "Bulk",
            self::CATEGORY_INDIVIDUAL => "Individual",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }

    // Stock status
    public const PRODUCT_TYPE_SIMPLE = 'simple';
    public const PRODUCT_TYPE_VARIANT = 'variant';

    public static function getProductTypes(int $type = null)
    {
        $types = [
            self::PRODUCT_TYPE_SIMPLE  => "Simple",
            self::PRODUCT_TYPE_VARIANT => "Variant",
        ];

        return $type ? $types[$type] : $types;
    }

    // Stock status
    public const STOCK_AVAILABLE = 1;
    public const STOCK_ASSIGNED = 2;
    public const STOCK_WARRANTY = 3;
    public const STOCK_DAMAGED = 4;
    public const STOCK_MISSING = 5;
    public const STOCK_EXPIRED = 6;
    public const STOCK_RETURN = 7;
    public const STOCK_OUT = 8;

    public static function getStockStatus(int $type = null)
    {
        $types = [
            self::STOCK_AVAILABLE => "Available",
            self::STOCK_ASSIGNED  => "Assigned",
            self::STOCK_WARRANTY  => "Warranty",
            self::STOCK_DAMAGED   => "Damaged",
            self::STOCK_MISSING   => "Missing",
            self::STOCK_EXPIRED   => "Expired",
            self::STOCK_RETURN    => "Returned",
            self::STOCK_OUT       => "Stock Out",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }

    // Payment Status
    public const PAYMENT_STATUS_SUCCESS = 'success';
    public const PAYMENT_STATUS_FAILED = 'failed';

    public static function getPaymentStatus(string $type = null)
    {
        $types = [
            self::PAYMENT_STATUS_SUCCESS => "Success",
            self::PAYMENT_STATUS_FAILED  => "Failed",
        ];

        return $type ? $types[$type] : $types;
    }

    // Payment Type
    public const PAYMENT_TYPE_SALE = 'sale';
    public const PAYMENT_TYPE_PURCHASE = 'purchase';
    public const PAYMENT_TYPE_SALE_RETURN = 'sale_return';
    public const PAYMENT_TYPE_PURCHASE_RETURN = 'purchase_return';

    public static function getPaymentType(string $type = null)
    {
        $types = [
            self::PAYMENT_TYPE_SALE            => "Sale",
            self::PAYMENT_TYPE_PURCHASE        => "Purchase",
            self::PAYMENT_TYPE_SALE_RETURN     => "Sale Return",
            self::PAYMENT_TYPE_PURCHASE_RETURN => "Purchase Return",
        ];

        return $type ? $types[$type] : $types;
    }



    // Payment Methods
    public const PAYMENT_METHOD_MANUAL = 'manual';
    public const PAYMENT_METHOD_SSL_COMMERZ = 'sslcommerz';

    public static function getPaymentMethod(string $type = null)
    {
        $types = [
            self::PAYMENT_METHOD_MANUAL      => "Manual",
            self::PAYMENT_METHOD_SSL_COMMERZ => "SSLCommerz",
        ];

        return $type ? $types[$type] : $types;
    }

    // Fish Type
    public const FISH_TYPE_TAG = 'tagged';
    public const FISH_TYPE_LANDED = 'landed';

    public static function getFishType(string $type = null)
    {
        $types = [
            self::FISH_TYPE_TAG    => "Tag & Release",
            self::FISH_TYPE_LANDED => "Landed Fish",
        ];

        return $type ? $types[$type] : $types;
    }

    //Post Type
    public const POST_TYPE_BLOG = 'blog';
    public const POST_TYPE_NEWS = 'news';

    public static function getPostType(string $type = null)
    {
        $types = [
            self::POST_TYPE_BLOG => 'Blog',
            self::POST_TYPE_NEWS => 'News',
        ];

        return $type ? $types[$type] : $types;
    }

    // Blog Module Start
    public const BLOG_ACTIVE = 1;
    public const BLOG_INACTIVE = 0;

    public static function getBlogStatus(string $type = null)
    {
        $types = [
            self::BLOG_ACTIVE   => "Active",
            self::BLOG_INACTIVE => "Inactive",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }
    // Blog Module End

    // Start General Status
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;

    public static function getStatus(string $type = null)
    {
        $types = [
            self::STATUS_ACTIVE   => "Active",
            self::STATUS_INACTIVE => "Inactive",
        ];

        if (isset($type) && $type == 0) {
            return $types[$type];
        }

        return $type ? $types[$type] : $types;
    }
    // End General Status

    // Return Type
    public const RETURN_TYPE_SALE = 'sale';
    public const RETURN_TYPE_PURCHASE = 'purchase';

    public static function getReturnTypes(int $type = null)
    {
        $types = [
            self::RETURN_TYPE_SALE     => "Sale",
            self::RETURN_TYPE_PURCHASE => "Purchase",
        ];

        return $type ? $types[$type] : $types;
    }

    //Order  Type
    public const ORDER_TYPE_SALE = 'sale';
    public const ORDER_TYPE_PURCHASE = 'purchase';
    public const ORDER_TYPE_QUOTATION = 'quotation';

    public static function getOrderType(string $type = null)
    {
        $types = [
            self::ORDER_TYPE_SALE      => 'Sale',
            self::ORDER_TYPE_PURCHASE  => 'Purchase',
            self::ORDER_TYPE_QUOTATION => 'Quotation',
        ];

        return $type ? $types[$type] : $types;
    }

    //Order Status Type
    public const ORDER_STATUS_TYPE_PENDING = 'pending';
    public const ORDER_STATUS_TYPE_CANCELED = 'canceled';
    public const ORDER_STATUS_TYPE_PROCESSING = 'processing';
    public const ORDER_STATUS_TYPE_SHIPPED = 'shipped';
    public const ORDER_STATUS_TYPE_DELIVERED = 'delivered';
    public const ORDER_STATUS_TYPE_NOT_RECEIVED = 'not_received';
    public const ORDER_STATUS_TYPE_RETURNED = 'returned';
    public const ORDER_STATUS_TYPE_PARTIAL_RETURNED = 'partial_returned';

    public static function getOrderStatusType(string $type = null)
    {
        $types = [
            self::ORDER_STATUS_TYPE_PENDING      => 'Pending',
            self::ORDER_STATUS_TYPE_CANCELED     => 'Canceled',
            self::ORDER_STATUS_TYPE_PROCESSING   => 'Processing',
            self::ORDER_STATUS_TYPE_SHIPPED      => 'Shipped',
            self::ORDER_STATUS_TYPE_DELIVERED    => 'Delivered',
            self::ORDER_STATUS_TYPE_NOT_RECEIVED => 'Not Received',
            self::ORDER_STATUS_TYPE_RETURNED     => 'Returned',
            self::ORDER_STATUS_TYPE_PARTIAL_RETURNED => 'Partial Returned',
        ];

        return $type ? $types[$type] : $types;
    }

    // Ad Payment Status Type
    public const AD_PAYMENT_STATUS_UNPAID = 'unpaid';
    public const AD_PAYMENT_STATUS_PAID = 'paid';

    public static function getAdPaymentStatusType(string $type = null)
    {
        $types = [
            self::AD_PAYMENT_STATUS_UNPAID => 'Unpaid',
            self::AD_PAYMENT_STATUS_PAID   => 'Paid',
        ];

        return $type ? $types[$type] : $types;
    }

    // Ad Payment Status Type
    public const AD_STATUS_ACTIVE = 'active';
    public const AD_STATUS_INACTIVE = 'inactive';

    public static function getAdStatusType(string $type = null)
    {
        $types = [
            self::AD_STATUS_ACTIVE  => 'Active',
            self::AD_STATUS_INACTIVE => 'Inactive',
        ];

        return $type ? $types[$type] : $types;
    }

    // Ad Payment Status Type
    public const SETTLEMENT_STATUS_UNPAID = 'unpaid';
    public const SETTLEMENT_STATUS_PAID = 'paid';
    public const SETTLEMENT_STATUS_PARTIAL_PAID = 'partial_paid';

    public static function getSettlementStatusType(string $type = null)
    {
        $types = [
            self::SETTLEMENT_STATUS_UNPAID       => 'Unpaid',
            self::SETTLEMENT_STATUS_PAID         => 'Paid',
            self::SETTLEMENT_STATUS_PARTIAL_PAID => 'Partial Paid',
        ];

        return $type ? $types[$type] : $types;
    }

    // Payout Status Type
    public const PAYOUT_STATUS_PENDING = 'pending';
    public const PAYOUT_STATUS_APPROVED = 'approved';
    public const PAYOUT_STATUS_REJECTED = 'rejected';

    public static function getPayoutStatusType(string $type = null)
    {
        $types = [
            self::PAYOUT_STATUS_PENDING  => 'Pending',
            self::PAYOUT_STATUS_APPROVED => 'Approved',
            self::PAYOUT_STATUS_REJECTED => 'Rejected',
        ];

        return $type ? $types[$type] : $types;
    }

    // Payout Status Type
    public const BALANCE_HISTORY_STATUS_SETTLEMENT = 'settlement';
    public const BALANCE_HISTORY_STATUS_PAYOUT = 'payout';
    public const BALANCE_HISTORY_STATUS_SEND_MONEY = 'send_money';
    public const BALANCE_HISTORY_STATUS_TOP_UP = 'top_up';

    public static function getBalanceHistoryStatus(string $type = null)
    {
        $types = [
            self::BALANCE_HISTORY_STATUS_SETTLEMENT    => 'settlement',
            self::BALANCE_HISTORY_STATUS_PAYOUT        => 'payout',
            self::BALANCE_HISTORY_STATUS_SEND_MONEY    => 'send_money',
            self::BALANCE_HISTORY_STATUS_TOP_UP => 'top_up',
        ];

        return $type ? $types[$type] : $types;
    }

    //Order Payment Status Type
    public const ORDER_PAYMENT_STATUS_UNPAID = 'unpaid';
    public const ORDER_PAYMENT_STATUS_PARTIAL = 'partial';
    public const ORDER_PAYMENT_STATUS_PAID = 'paid';
    public const ORDER_PAYMENT_STATUS_REFUNDED = 'refunded';

    public static function getPaymentStatusType(string $type = null)
    {
        $types = [
            self::ORDER_PAYMENT_STATUS_UNPAID   => 'Unpaid',
            self::ORDER_PAYMENT_STATUS_PARTIAL  => 'Partial',
            self::ORDER_PAYMENT_STATUS_PAID     => 'Paid',
            self::ORDER_PAYMENT_STATUS_REFUNDED => 'Refunded',
        ];

        return $type ? $types[$type] : $types;
    }

    //Order Payment Status Type
    public const ORDER_PAYMENT_TYPE_COD = 'COD';
    public const ORDER_PAYMENT_TYPE_DIGITAL = 'Digital';

    public static function getOrderPaymentType(string $type = null)
    {
        $types = [
            self::ORDER_PAYMENT_TYPE_COD     => 'COD',
            self::ORDER_PAYMENT_TYPE_DIGITAL => 'Digital',
        ];

        return $type ? $types[$type] : $types;
    }

    // Stock Visibility Status
    public const VISIBILITY_STATUS_HIDE_STOCK = 'hide_stock';
    public const VISIBILITY_STATUS_VISIBLE_WITH_TEXT = 'visible_with_text';
    public const VISIBILITY_STATUS_VISIBLE_WITH_QUANTITY = 'visible_with_quantity';

    public static function getProductVisibilityStatus(string $type = null)
    {
        $types = [
            self::VISIBILITY_STATUS_HIDE_STOCK            => 'Hide Stock',
            self::VISIBILITY_STATUS_VISIBLE_WITH_TEXT     => 'Visible with text',
            self::VISIBILITY_STATUS_VISIBLE_WITH_QUANTITY => 'Visible with quantity',
        ];

        return $type ? $types[$type] : $types;
    }

    // Product Status
    public const PRODUCT_STATUS_TRASH = 'trash';
    public const PRODUCT_STATUS_PUBLISHED = 'published';
    public const PRODUCT_STATUS_UNPUBLISHED = 'unpublished';


    public const PRODUCT_SHOW_HOME_PAGE = 1;

    // Review Status
    public const REVIEW_STATUS = 0;

    public static function getProductStatus(string $type = null)
    {
        $types = [
            self::PRODUCT_STATUS_TRASH       => 'Trash',
            self::PRODUCT_STATUS_PUBLISHED   => 'Published',
            self::PRODUCT_STATUS_UNPUBLISHED => 'Unpublished',
        ];

        return $type ? $types[$type] : $types;
    }

    // Discount Type
    public const DISCOUNT_TYPE_FLAT = 'flat';
    public const DISCOUNT_TYPE_PERCENTAGE = 'percentage';

    public static function getDiscountType(string $type = null)
    {
        $types = [
            self::DISCOUNT_TYPE_FLAT       => 'Flat',
            self::DISCOUNT_TYPE_PERCENTAGE => 'Percentage',
        ];

        return $type ? $types[$type] : $types;
    }

    // Special Discount Type
    public const COUPON_TYPE_FLAT = 'flat';
    public const COUPON_TYPE_PERCENTAGE = 'percentage';

    public static function getCouponType(string $type = null)
    {
        $types = [
            self::COUPON_TYPE_FLAT       => 'Flat',
            self::COUPON_TYPE_PERCENTAGE => 'Percentage',
        ];

        return $type ? $types[$type] : $types;
    }

    // Shipping Type
    public const SHIPPING_TYPE_FLAT_RATE = 'flat_rate';
    public const SHIPPING_TYPE_FREE_SHIPPING = 'free_shipping';

    public static function getShippingType(string $type = null)
    {
        $types = [
            self::SHIPPING_TYPE_FLAT_RATE     => 'Flat Rate',
            self::SHIPPING_TYPE_FREE_SHIPPING => 'Free Shipping',
        ];

        return $type ? $types[$type] : $types;
    }

    // Attachment For Type
    public const ATTACHMENT_TYPE_THUMBNAIL = 'thumbnail';
    public const ATTACHMENT_TYPE_ICON = 'icon';
    public const ATTACHMENT_TYPE_GALLERY = 'gallery';
    public const ATTACHMENT_TYPE_DESCRIPTION = 'description';
    public const ATTACHMENT_TYPE_VARIANT = 'variant';
    public const ATTACHMENT_TYPE_META = 'meta';
    public const ATTACHMENT_TYPE_BANNER = 'banner';
    public const ATTACHMENT_TYPE_BACKGROUND = 'background';
    public const ATTACHMENT_TYPE_ATTACHMENT = 'attachment';

    public static function getAttachmentType(string $type = null)
    {
        $types = [
            self::ATTACHMENT_TYPE_THUMBNAIL   => "Thumbnail",
            self::ATTACHMENT_TYPE_ICON        => "Icon",
            self::ATTACHMENT_TYPE_GALLERY     => "Gallery",
            self::ATTACHMENT_TYPE_DESCRIPTION => "Description",
            self::ATTACHMENT_TYPE_VARIANT     => "Variant",
            self::ATTACHMENT_TYPE_META        => "Meta",
            self::ATTACHMENT_TYPE_BANNER      => "Banner",
            self::ATTACHMENT_TYPE_BACKGROUND  => "Background",
            self::ATTACHMENT_TYPE_ATTACHMENT  => "Attachment",
        ];

        return $type ? $types[$type] : $types;
    }

    // Language Type
    public const LANGUAGE_TYPE_ENGLISH = 'en';
    public const LANGUAGE_TYPE_BANGLA = 'bn';

    public static function getLanguageType(string $type = null)
    {
        $types = [
            self::LANGUAGE_TYPE_ENGLISH => "English",
            self::LANGUAGE_TYPE_BANGLA  => "Bangla",
        ];

        return $type ? $types[$type] : $types;
    }

    // Return Status Type
    public const RETURN_STATUS_PENDING = 'pending';
    public const RETURN_STATUS_APPROVED = 'approved';
    public const RETURN_STATUS_REJECTED = 'rejected';
    public const RETURN_STATUS_PROCESSED = 'processed';

    public static function getReturnStatusType(string $type = null)
    {
        $types = [
            self::RETURN_STATUS_PENDING   => 'Pending',
            self::RETURN_STATUS_APPROVED  => 'Approved',
            self::RETURN_STATUS_REJECTED  => 'Rejected',
            self::RETURN_STATUS_PROCESSED => 'Processed',
        ];

        return $type ? $types[$type] : $types;
    }

    // Ratting
    public const RATTING_TYPE_ONE = 1;
    public const RATTING_TYPE_TWO = 2;
    public const RATTING_TYPE_THREE = 3;
    public const RATTING_TYPE_FOUR = 4;
    public const RATTING_TYPE_FIVE = 5;

    public static function getRattingType(string $rating = null)
    {
        $rating_arr = [
            self::RATTING_TYPE_FIVE  => 5,
            self::RATTING_TYPE_FOUR  => 4,
            self::RATTING_TYPE_THREE => 3,
            self::RATTING_TYPE_TWO   => 2,
            self::RATTING_TYPE_ONE   => 1,
        ];

        return $rating ? $rating_arr[$rating] : $rating_arr;
    }

    // Courier Pickup Location && Delivery Location
    public const INSIDE_DHAKA = 'inside_dhaka';
    public const OUTSIDE_DHAKA = 'outside_dhaka';
    public const SUBURBS = 'suburbs';

    public static function getCourierPickupAndDeliveryLocation(string $rating = null)
    {
        $rating_arr = [
            self::INSIDE_DHAKA                 => 'Inside Dhaka',
            self::OUTSIDE_DHAKA                => 'Outside Dhaka',
            self::SUBURBS                      => 'Sub Dhaka',
        ];

        return $rating ? $rating_arr[$rating] : $rating_arr;
    }
}
