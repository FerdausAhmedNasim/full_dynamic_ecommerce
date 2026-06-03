<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * App\Models\Account
 *
 * @property int $id
 * @property int $operator_id
 * @property float $amount
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Account newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Account query()
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Account whereUpdatedAt($value)
 */
	class Account extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ActivityLog
 *
 * @property int $id
 * @property int|null $action_by
 * @property string $action Create, Update, Delete
 * @property string $subject Model name
 * @property string $log_time
 * @property string $ip
 * @property string $browser
 * @property string $changes
 * @property string|null $note
 * @property string|null $status
 * @property int $record_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereAction($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereActionBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereBrowser($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereChanges($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereLogTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereRecordId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ActivityLog whereUpdatedAt($value)
 */
	class ActivityLog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Address
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $street_address
 * @property int|null $area_id
 * @property int|null $thana_id
 * @property string|null $area_text
 * @property string|null $note
 * @property string|null $latitude
 * @property string|null $longitude
 * @property int $primary
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\Area|null $area
 * @property-read mixed $full_address
 * @property-read mixed $seller_pickup_hub
 * @property-read \App\Models\Thana|null $thana
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Address newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Address onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Address primary()
 * @method static \Illuminate\Database\Eloquent\Builder|Address query()
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAreaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereAreaText($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLatitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereLongitude($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address wherePrimary($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereStreetAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereThanaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Address withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Address withoutTrashed()
 */
	class Address extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Advertise
 *
 * @property int $id
 * @property string|null $link
 * @property mixed|null $product_ids
 * @property string $status
 * @property string $payment_status
 * @property string $start_date
 * @property string $end_date
 * @property int $seller_id
 * @property int $advertise_location_id
 * @property float $amount
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\AdvertiseLocation $adLocation
 * @property-read \App\Models\Attachment|null $attachment
 * @property-read mixed $image
 * @property-read \App\Models\User $seller
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise query()
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereAdvertiseLocationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereProductIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Advertise whereUpdatedAt($value)
 */
	class Advertise extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AdvertiseLocation
 *
 * @property int $id
 * @property int $active
 * @property string $location
 * @property float $amount amount per day
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read mixed $location_name
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation active()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation query()
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AdvertiseLocation whereUpdatedAt($value)
 */
	class AdvertiseLocation extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Area
 *
 * @property int $id
 * @property string $en_name
 * @property string|null $bn_name
 * @property int $active
 * @property int $division_id
 * @property int $district_id
 * @property int $thana_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\District|null $district
 * @property-read \App\Models\Division|null $division
 * @property-read \App\Models\Thana|null $thana
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Area active()
 * @method static \Illuminate\Database\Eloquent\Builder|Area newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Area query()
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereBnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereEnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereThanaId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Area whereUpdatedBy($value)
 */
	class Area extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Attachment
 *
 * @property int $id
 * @property string $attachment
 * @property int $attachable_id
 * @property string $attachable_type
 * @property string $mime_type
 * @property string $for
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $attachable
 * @property-read \App\Models\User|null $operator
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereAttachableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereAttachableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereMimeType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attachment whereUpdatedAt($value)
 */
	class Attachment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Attribute
 *
 * @property int $id
 * @property string|null $name
 * @property int $active
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\AttributeValue> $attributeValues
 * @property-read int|null $attribute_values_count
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute active()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute query()
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Attribute whereUpdatedAt($value)
 */
	class Attribute extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\AttributeValue
 *
 * @property int $id
 * @property int $attribute_id
 * @property string $value
 * @property int $active
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attribute $attribute
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue query()
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereAttributeId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|AttributeValue whereValue($value)
 */
	class AttributeValue extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BalanceHistory
 *
 * @property int $id
 * @property int $seller_id
 * @property int|null $settlement_id
 * @property int|null $operator_id
 * @property string $type
 * @property float $amount
 * @property string $dr_cr
 * @property string|null $transaction_id
 * @property string|null $payment_method
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $operator
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereDrCr($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereSettlementId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BalanceHistory whereUpdatedAt($value)
 */
	class BalanceHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BankAccount
 *
 * @property int $id
 * @property string|null $bank_name
 * @property string|null $branch_name
 * @property string $account_name
 * @property string $account_number
 * @property string|null $swift_code
 * @property string|null $routing_number
 * @property string|null $verified_at
 * @property int $seller_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount query()
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereAccountName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereAccountNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereBankName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereBranchName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereRoutingNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereSwiftCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BankAccount whereVerifiedAt($value)
 */
	class BankAccount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Banner
 *
 * @property int $id
 * @property string $link
 * @property string $location
 * @property int $active
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner query()
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Banner whereUpdatedAt($value)
 */
	class Banner extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Benefit
 *
 * @property int $id
 * @property string $title
 * @property string $sub_title
 * @property int $order
 * @property int $active
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read mixed $image
 * @property-read \App\Models\User|null $operator
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit active()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit query()
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Benefit whereUpdatedAt($value)
 */
	class Benefit extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BlackUser
 *
 * @property int $id
 * @property int $user_id
 * @property int $seller_order_id
 * @property float $shipping_cost
 * @property int $active
 * @property string|null $penalty_payment_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $product
 * @property-read \App\Models\SellerOrder|null $sellerOrder
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser active()
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser wherePenaltyPaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser whereSellerOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlackUser whereUserId($value)
 */
	class BlackUser extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Blog
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog query()
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Blog whereUpdatedAt($value)
 */
	class Blog extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\BlogLanguage
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|BlogLanguage whereUpdatedAt($value)
 */
	class BlogLanguage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Branch
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Account> $balance
 * @property-read int|null $balance_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeBranch> $branchEmployee
 * @property-read int|null $branch_employee_count
 * @property-read \App\Models\Location|null $location
 * @property-read \App\Models\User|null $manager
 * @property-read \App\Models\User|null $operator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Withdraw> $withdraws
 * @property-read int|null $withdraws_count
 * @method static \Illuminate\Database\Eloquent\Builder|Branch active()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Branch query()
 */
	class Branch extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Brand
 *
 * @property int $id
 * @property string $slug
 * @property int $active
 * @property int $featured
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read mixed $thumbnail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CommonLanguage> $languages
 * @property-read int|null $languages_count
 * @property-read \App\Models\User $operator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Brand active()
 * @method static \Database\Factories\BrandFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Brand featured()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand query()
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Brand whereUpdatedAt($value)
 */
	class Brand extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Campaign
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $active
 * @property int $featured
 * @property string $start_date
 * @property string $end_date
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign query()
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Campaign whereUpdatedAt($value)
 */
	class Campaign extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CampaignRequest
 *
 * @property int $id
 * @property string $status
 * @property int $seller_id
 * @property int $campaign_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequest newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequest newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequest query()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequest whereCampaignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequest whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequest whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequest whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequest whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequest whereUpdatedAt($value)
 */
	class CampaignRequest extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CampaignRequestProduct
 *
 * @property int $id
 * @property int $campaign_request_id
 * @property int $product_id
 * @property string $discount_type
 * @property int $discount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequestProduct newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequestProduct newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequestProduct query()
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequestProduct whereCampaignRequestId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequestProduct whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequestProduct whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequestProduct whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequestProduct whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequestProduct whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CampaignRequestProduct whereUpdatedAt($value)
 */
	class CampaignRequestProduct extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Cart
 *
 * @property int $id
 * @property string $cart_identifier
 * @property int $product_id
 * @property string|null $variant
 * @property int $quantity
 * @property float $price
 * @property float $ezzico_discount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart query()
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCartIdentifier($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereEzzicoDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Cart whereVariant($value)
 */
	class Cart extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Category
 *
 * @property int $id
 * @property string $slug
 * @property int|null $parent_id
 * @property int $order
 * @property int $active
 * @property int $featured
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $children
 * @property-read int|null $children_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, Category> $childrenCategories
 * @property-read int|null $children_categories_count
 * @property-read mixed $icon
 * @property-read mixed $thumbnail
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CommonLanguage> $languages
 * @property-read int|null $languages_count
 * @property-read \App\Models\User $operator
 * @property-read Category|null $parent
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $products
 * @property-read int|null $products_count
 * @method static \Illuminate\Database\Eloquent\Builder|Category active()
 * @method static \Database\Factories\CategoryFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Category featured()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Category onlyParent()
 * @method static \Illuminate\Database\Eloquent\Builder|Category query()
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Category whereUpdatedAt($value)
 */
	class Category extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Color
 *
 * @property int $id
 * @property string $name
 * @property string $color_code
 * @property int $active
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|Color active()
 * @method static \Illuminate\Database\Eloquent\Builder|Color newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Color query()
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereColorCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Color whereUpdatedAt($value)
 */
	class Color extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CommonLanguage
 *
 * @property int $id
 * @property string $title
 * @property string $local
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property int $languageable_id
 * @property string $languageable_type
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $languageable
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage whereLanguageableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage whereLanguageableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage whereLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CommonLanguage whereUpdatedAt($value)
 */
	class CommonLanguage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Config
 *
 * @property int $id
 * @property string $key
 * @property string|null $value
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Config newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Config query()
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Config whereValue($value)
 */
	class Config extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ContactMessage
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string|null $phone
 * @property string|null $subject
 * @property string|null $message
 * @property int $is_replied
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereIsReplied($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ContactMessage whereUpdatedAt($value)
 */
	class ContactMessage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Coupon
 *
 * @property int $id
 * @property string $code
 * @property string|null $minimum_shopping
 * @property string $maximum_discount
 * @property string $discount_type
 * @property int $discount
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $active
 * @property int $seller_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon active()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon query()
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereMaximumDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereMinimumShopping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Coupon whereUpdatedAt($value)
 */
	class Coupon extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CouponComment
 *
 * @method static \Illuminate\Database\Eloquent\Builder|CouponComment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponComment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CouponComment query()
 */
	class CouponComment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\CourierPricingPlan
 *
 * @property int $id
 * @property string $pickup_location
 * @property string $delivery_location
 * @property int $min_weight
 * @property int $max_weight
 * @property float $price
 * @property int $active
 * @property string|null $delivery_time
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan active()
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan query()
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan whereDeliveryLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan whereDeliveryTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan whereMaxWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan whereMinWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan wherePickupLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan wherePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|CourierPricingPlan whereUpdatedAt($value)
 */
	class CourierPricingPlan extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Discount
 *
 * @property int $id
 * @property string $title
 * @property float $amount
 * @property int $is_active
 * @property string|null $start_date
 * @property string|null $end_date
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount query()
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereIsActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Discount whereUpdatedAt($value)
 */
	class Discount extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\District
 *
 * @property int $id
 * @property string $en_name
 * @property string|null $bn_name
 * @property int $active
 * @property int $suburb
 * @property int $division_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\Division|null $division
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|District active()
 * @method static \Illuminate\Database\Eloquent\Builder|District newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|District query()
 * @method static \Illuminate\Database\Eloquent\Builder|District whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereBnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereDivisionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereEnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereSuburb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|District whereUpdatedBy($value)
 */
	class District extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Division
 *
 * @property int $id
 * @property string $en_name
 * @property string|null $bn_name
 * @property int $active
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Division active()
 * @method static \Illuminate\Database\Eloquent\Builder|Division newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Division newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Division query()
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereBnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereEnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Division whereUpdatedBy($value)
 */
	class Division extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailHistory
 *
 * @property int $id
 * @property int $user_id receiver user id
 * @property string $subject
 * @property string $email
 * @property string $message
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistory whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistory whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistory whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailHistory whereUserId($value)
 */
	class EmailHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailSignature
 *
 * @property int $id
 * @property string $name
 * @property string $signature
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSignature newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSignature newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSignature query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSignature whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSignature whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSignature whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSignature whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSignature whereSignature($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailSignature whereUpdatedAt($value)
 */
	class EmailSignature extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmailTemplate
 *
 * @property int $id
 * @property string $name
 * @property string $key
 * @property string $subject
 * @property string $message
 * @property string|null $shortcodes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereKey($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereShortcodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmailTemplate whereUpdatedAt($value)
 */
	class EmailTemplate extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmergencyContact
 *
 * @property int $id
 * @property int $user_id
 * @property string|null $name
 * @property string|null $address
 * @property string|null $email
 * @property string|null $mobile_number
 * @property string|null $relationship
 * @property string|null $note
 * @property string|null $image
 * @property int $created_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact query()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereMobileNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereRelationship($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|EmergencyContact withoutTrashed()
 */
	class EmergencyContact extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Employee
 *
 * @property int $id
 * @property int $user_id
 * @property int $operator_id
 * @property string $job_title Comes from config
 * @property string|null $employment_type Part time/Full time & comes from config
 * @property string|null $entitlement_to_work Comes from config
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read string $full_address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee query()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEmploymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereEntitlementToWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Employee withoutTrashed()
 */
	class Employee extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EmployeeBranch
 *
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User|null $employee
 * @property-read \App\Models\User|null $operator
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeBranch newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeBranch newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EmployeeBranch query()
 */
	class EmployeeBranch extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Expense
 *
 * @property int $id
 * @property string $category
 * @property string $title
 * @property string|null $note
 * @property float $amount
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense query()
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCategory($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Expense whereUpdatedAt($value)
 */
	class Expense extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\EzzicoSale
 *
 * @property int $id
 * @property int $product_id
 * @property string $start_date
 * @property string $end_date
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|EzzicoSale newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EzzicoSale newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|EzzicoSale query()
 * @method static \Illuminate\Database\Eloquent\Builder|EzzicoSale whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EzzicoSale whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EzzicoSale whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EzzicoSale whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EzzicoSale whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EzzicoSale whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|EzzicoSale whereUpdatedAt($value)
 */
	class EzzicoSale extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Language
 *
 * @property int $id
 * @property string $name
 * @property string $locale
 * @property int $active
 * @property string $text_direction
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Language newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Language query()
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereLocale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereTextDirection($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Language whereUpdatedAt($value)
 */
	class Language extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Location
 *
 * @property int $id
 * @property int $operator_id
 * @property string $name
 * @property string|null $ip
 * @property string|null $details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|Location newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Location query()
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Location whereUpdatedAt($value)
 */
	class Location extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\LoginHistory
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $email
 * @property string|null $password
 * @property string $status
 * @property string|null $ip
 * @property string|null $country
 * @property string|null $region
 * @property string|null $city
 * @property mixed|null $geo_details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereCity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereCountry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereGeoDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereRegion($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|LoginHistory whereUserId($value)
 */
	class LoginHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Member
 *
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read string $full_address
 * @property-read \App\Models\User|null $nominated
 * @property-read \App\Models\User|null $seconded
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Member active()
 * @method static \Illuminate\Database\Eloquent\Builder|Member isNominated()
 * @method static \Illuminate\Database\Eloquent\Builder|Member isSeconded()
 * @method static \Illuminate\Database\Eloquent\Builder|Member newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Member nominatedAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Member onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Member query()
 * @method static \Illuminate\Database\Eloquent\Builder|Member secondedAt()
 * @method static \Illuminate\Database\Eloquent\Builder|Member withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Member withoutTrashed()
 */
	class Member extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Moderator
 *
 * @property int $id
 * @property int $user_id
 * @property int $operator_id
 * @property string $job_title Comes from config
 * @property string|null $employment_type Part time/Full time & comes from config
 * @property string|null $entitlement_to_work Comes from config
 * @property string|null $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator query()
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator whereEmploymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator whereEntitlementToWork($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Moderator whereUserId($value)
 */
	class Moderator extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Note
 *
 * @property int $id
 * @property int $user_id
 * @property int $operator_id
 * @property string $title
 * @property string $description
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $operator
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|Note newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Note query()
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Note whereUserId($value)
 */
	class Note extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Notification
 *
 * @property int $id
 * @property int|null $user_id
 * @property string $subject
 * @property string $message
 * @property string|null $send_date
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\NotificationRecipient> $recipients
 * @property-read int|null $recipients_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification query()
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSendDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Notification whereUserId($value)
 */
	class Notification extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\NotificationRecipient
 *
 * @property int $id
 * @property int $notification_id
 * @property int $user_id
 * @property int $is_sent
 * @property int $is_try
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Notification $notification
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRecipient newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRecipient newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRecipient query()
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRecipient whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRecipient whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRecipient whereIsSent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRecipient whereIsTry($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRecipient whereNotificationId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRecipient whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|NotificationRecipient whereUserId($value)
 */
	class NotificationRecipient extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Order
 *
 * @property int $id
 * @property string|null $transaction_id
 * @property string $invoice_id
 * @property int $customer_id
 * @property int $operator_id
 * @property int|null $address_id
 * @property string|null $note
 * @property int $quantity
 * @property float $sub_total_amount
 * @property float $total_amount
 * @property float $discount_amount
 * @property float $ezzico_discount
 * @property float $return_amount
 * @property float $shipping_cost
 * @property float $penalty_amount
 * @property float $collected_amount
 * @property float $amount_to_be_collect
 * @property string $order_status Pending, Canceled, Processing, Shipped, Delivered, Not Received, Returned, Incomplete
 * @property string $payment_status Unpaid, Partial, Paid, Refunded
 * @property string $payment_type cod, digital
 * @property string|null $payment_details
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Address|null $address
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \App\Models\User $customer
 * @property-read mixed $invoice
 * @property-read \App\Models\User $operator
 * @property-read \App\Models\Payment|null $paymentDetails
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payment> $payments
 * @property-read int|null $payments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderReturn> $returns
 * @property-read int|null $returns_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SellerOrder> $sellerOrders
 * @property-read int|null $seller_orders_count
 * @method static \Illuminate\Database\Eloquent\Builder|Order newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Order query()
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAddressId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereAmountToBeCollect($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCollectedAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereEzzicoDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentDetails($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order wherePenaltyAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereReturnAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereSubTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Order whereUpdatedAt($value)
 */
	class Order extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderReturn
 *
 * @property int $id
 * @property string $invoice_id
 * @property int $seller_order_id
 * @property int $operator_id
 * @property string|null $payment_method
 * @property float $payment_amount
 * @property float $shipping_cost
 * @property float $sub_total_amount
 * @property float $total_amount
 * @property string|null $payment_transaction_id
 * @property string|null $note
 * @property string $status Pending, Approved, Rejected, Processed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \App\Models\User $operator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ReturnDetails> $returnDetails
 * @property-read int|null $return_details_count
 * @property-read \App\Models\SellerOrder $sellerOrder
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereInvoiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn wherePaymentAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn wherePaymentTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereSellerOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereSubTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderReturn whereUpdatedAt($value)
 */
	class OrderReturn extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\OrderStatusHistory
 *
 * @property int $id
 * @property int $order_id
 * @property int $operator_id
 * @property string $previous_status Pending, Canceled, Processing, Shipped, Delivered, Not Received, Returned, Incomplete
 * @property string $current_status Pending, Canceled, Processing, Shipped, Delivered, Not Received, Returned, Incomplete
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory query()
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereCurrentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory wherePreviousStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|OrderStatusHistory whereUpdatedAt($value)
 */
	class OrderStatusHistory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Page
 *
 * @property int $id
 * @property string $link
 * @property int $active
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\PageLanguage> $languages
 * @property-read int|null $languages_count
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|Page active()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Page query()
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Page whereUpdatedAt($value)
 */
	class Page extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\PageLanguage
 *
 * @property int $id
 * @property string $local
 * @property string $title
 * @property string $content
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keyword
 * @property int $page_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $page
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage whereLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage whereMetaKeyword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage wherePageId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|PageLanguage whereUpdatedAt($value)
 */
	class PageLanguage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payment
 *
 * @property int $id
 * @property string $type Sale, Purchase, Sale Return, Purchase Return
 * @property int|null $order_id
 * @property int|null $return_id
 * @property int $operator_id
 * @property string|null $payment_method
 * @property float $amount
 * @property string|null $transaction_id
 * @property string|null $note
 * @property string $payment_status Success, Failed
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $operator
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\OrderReturn|null $orderReturn
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentMethod($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereReturnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereTransactionId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payment whereUpdatedAt($value)
 */
	class Payment extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Payout
 *
 * @property int $id
 * @property int $seller_id
 * @property float $amount
 * @property string|null $note
 * @property string $status
 * @property int|null $approved_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $approvedBy
 * @property-read \App\Models\User $seller
 * @method static \Illuminate\Database\Eloquent\Builder|Payout newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout query()
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereApprovedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Payout whereUpdatedAt($value)
 */
	class Payout extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Permission
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $group
 * @property string $menu_group
 * @property string $for employee panel, seller panel
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission query()
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereMenuGroup($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Permission whereUpdatedAt($value)
 */
	class Permission extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Product
 *
 * @property int $id
 * @property int $category_id
 * @property int|null $brand_id
 * @property string $slug
 * @property string $type Simple, Variant, combo
 * @property string|null $unit
 * @property float|null $weight
 * @property string|null $barcode
 * @property int|null $has_variant
 * @property string|null $attribute_sets
 * @property string|null $selected_variants
 * @property string|null $selected_variants_ids
 * @property int $current_stock
 * @property int $minimum_order_quantity
 * @property int $stock_notification
 * @property int|null $low_stock_to_notify
 * @property string $stock_visibility hide_stock, visible_with_text, visible_with_quantity
 * @property int $total_sale
 * @property string $status trash, published, unpublished
 * @property int $approved use for seller product approval purpose
 * @property int $featured
 * @property int $refundable
 * @property int $show_home_page
 * @property float $rating
 * @property int $has_product_base_shipping
 * @property int $has_discount
 * @property int $seller_id
 * @property int $cash_on_delivery 0 not available, 1 available
 * @property float $unit_price
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\EzzicoSale|null $activeEzzicoDiscount
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \App\Models\Brand|null $brand
 * @property-read \App\Models\Category $category
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Color> $colors
 * @property-read int|null $colors_count
 * @property-read \App\Models\EzzicoSale|null $ezzicoDiscount
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EzzicoSale> $ezzicoDiscounts
 * @property-read int|null $ezzico_discounts_count
 * @property-read mixed $description
 * @property-read mixed $gallery_images
 * @property-read mixed $meta_image
 * @property-read mixed $product_meta_image
 * @property-read mixed $thumbnail
 * @property-read \App\Models\User $operator
 * @property-read \App\Models\ProductDetails|null $productDetails
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductLanguage> $productLanguages
 * @property-read int|null $product_languages_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductService> $productServices
 * @property-read int|null $product_services_count
 * @property-read \App\Models\ProductStock|null $productStock
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductStock> $productStocks
 * @property-read int|null $product_stocks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductQuestion> $question
 * @property-read int|null $question_count
 * @property-read \App\Models\User|null $seller
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SellerOrderDetails> $sellerOrderDetails
 * @property-read int|null $seller_order_details_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Wishlist> $wishlist
 * @property-read int|null $wishlist_count
 * @method static \Illuminate\Database\Eloquent\Builder|Product approved()
 * @method static \Database\Factories\ProductFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Product featured()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Product onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product published()
 * @method static \Illuminate\Database\Eloquent\Builder|Product query()
 * @method static \Illuminate\Database\Eloquent\Builder|Product refundable()
 * @method static \Illuminate\Database\Eloquent\Builder|Product showHomePage()
 * @method static \Illuminate\Database\Eloquent\Builder|Product today()
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereApproved($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereAttributeSets($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBarcode($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereBrandId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCashOnDelivery($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereCurrentStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereFeatured($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasProductBaseShipping($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereHasVariant($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereLowStockToNotify($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereMinimumOrderQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereRefundable($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSelectedVariants($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSelectedVariantsIds($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereShowHomePage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockNotification($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereStockVisibility($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereTotalSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnit($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product whereWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Product withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Product withoutTrashed()
 */
	class Product extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductDetails
 *
 * @property int $id
 * @property int $product_id
 * @property string|null $shipping_type flat rate, free shipping
 * @property float $shipping_fee
 * @property int $shipping_fee_depend_on_quantity
 * @property int $shipping_fee_depend_on_weight
 * @property string|null $estimated_shipping_days estimated time of delivering the product
 * @property int $viewed total views of the product
 * @property float|null $discount
 * @property string|null $discount_type percentage, flat
 * @property string|null $discount_start
 * @property string|null $discount_end
 * @property mixed|null $dimension
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereDimension($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereDiscountEnd($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereDiscountStart($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereEstimatedShippingDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereShippingFee($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereShippingFeeDependOnQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereShippingFeeDependOnWeight($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereShippingType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductDetails whereViewed($value)
 */
	class ProductDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductInvoice
 *
 * @property-read \App\Models\Product|null $product
 * @property-read \App\Models\User|null $seller
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInvoice newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInvoice newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductInvoice query()
 */
	class ProductInvoice extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductLanguage
 *
 * @property int $id
 * @property int $product_id
 * @property string $local
 * @property string $title
 * @property string|null $short_description
 * @property string|null $description
 * @property string|null $shipping_note
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $meta_keywords
 * @property string|null $tags
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $deleted_at
 * @property-read mixed $short_title
 * @property-read mixed $short_title_for_dashboard
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereMetaKeywords($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereShippingNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereShortDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereTags($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductLanguage whereUpdatedAt($value)
 */
	class ProductLanguage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductQuestion
 *
 * @property int $id
 * @property string $comment
 * @property int $active
 * @property int|null $customer_id
 * @property int|null $seller_id
 * @property int $product_id
 * @property int|null $parent_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read ProductQuestion|null $childrenQuestion
 * @property-read \App\Models\User|null $customer
 * @property-read ProductQuestion|null $parent
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\User|null $seller
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion active()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductQuestion whereUpdatedAt($value)
 */
	class ProductQuestion extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductReview
 *
 * @property int $id
 * @property int $customer_id
 * @property int $product_id
 * @property int $active
 * @property int $rating
 * @property string|null $comment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \App\Models\User $customer
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview active()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereCustomerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductReview whereUpdatedAt($value)
 */
	class ProductReview extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductService
 *
 * @property int $id
 * @property int $order
 * @property int $active
 * @property int $product_id
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductServiceLanguage> $productServiceLanguages
 * @property-read int|null $product_service_languages_count
 * @property-read \App\Models\Product|null $productStock
 * @method static \Illuminate\Database\Eloquent\Builder|ProductService newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductService newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductService query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductService whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductService whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductService whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductService whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductService whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductService whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductService whereUpdatedAt($value)
 */
	class ProductService extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductServiceLanguage
 *
 * @property int $id
 * @property int $product_service_id
 * @property string $local
 * @property string $title
 * @property string $sub_title
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\ProductService|null $productService
 * @method static \Illuminate\Database\Eloquent\Builder|ProductServiceLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductServiceLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductServiceLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductServiceLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductServiceLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductServiceLanguage whereLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductServiceLanguage whereProductServiceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductServiceLanguage whereSubTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductServiceLanguage whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductServiceLanguage whereUpdatedAt($value)
 */
	class ProductServiceLanguage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ProductStock
 *
 * @property int $id
 * @property string|null $variant_ids first one is color,rest is attribute values
 * @property int $product_id
 * @property string|null $name auto generated by attributes and colors
 * @property string|null $sku
 * @property int $current_stock
 * @property float|null $unit_price
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Attachment|null $attachment
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read mixed $variant_image
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock query()
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock whereCurrentStock($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock whereSku($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock whereUnitPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ProductStock whereVariantIds($value)
 */
	class ProductStock extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\ReturnDetails
 *
 * @property int $id
 * @property int $return_id
 * @property int $product_id
 * @property int $seller_order_details_id
 * @property int $quantity
 * @property float $sale_price
 * @property float $discount
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\OrderReturn $return
 * @property-read \App\Models\SellerOrderDetails $sellerOrderDetails
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails whereReturnId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails whereSellerOrderDetailsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|ReturnDetails whereUpdatedAt($value)
 */
	class ReturnDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Returns
 *
 * @method static \Illuminate\Database\Eloquent\Builder|Returns newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Returns newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Returns query()
 */
	class Returns extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Role
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property string $for employee, seller, moderator
 * @property int|null $seller_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\User> $users
 * @property-read int|null $users_count
 * @method static \Illuminate\Database\Eloquent\Builder|Role newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Role query()
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereFor($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Role whereUpdatedAt($value)
 */
	class Role extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SellerCategory
 *
 * @property int $id
 * @property int $seller_id
 * @property int $category_id
 * @property int $operator_id
 * @property float $commission_rate
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Category|null $category
 * @property-read \App\Models\User|null $operator
 * @property-read \App\Models\User|null $seller
 * @method static \Illuminate\Database\Eloquent\Builder|SellerCategory newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerCategory newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerCategory query()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerCategory whereCategoryId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerCategory whereCommissionRate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerCategory whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerCategory whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerCategory whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerCategory whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerCategory whereUpdatedAt($value)
 */
	class SellerCategory extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SellerOrder
 *
 * @property int $id
 * @property int $order_id
 * @property int $seller_id
 * @property int $operator_id
 * @property int|null $coupon_id
 * @property int $quantity
 * @property string|null $payment_date
 * @property float $commission_amount
 * @property float $sub_total_amount
 * @property float $total_amount
 * @property float $discount_amount
 * @property float $ezzico_discount
 * @property float $return_amount
 * @property float $shipping_cost
 * @property string $order_status Pending, Canceled, Processing, Shipped, Delivered, Not Received, Returned, Incomplete
 * @property string $payment_status Unpaid, Paid, Refunded
 * @property string $payment_type cod, digital
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\BlackUser|null $blackUser
 * @property-read \App\Models\User $operator
 * @property-read \App\Models\Order $order
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\OrderReturn> $returns
 * @property-read int|null $returns_count
 * @property-read \App\Models\User|null $seller
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SellerOrderDetails> $sellerOrderDetails
 * @property-read int|null $seller_order_details_count
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder query()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereCommissionAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereCouponId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereDiscountAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereEzzicoDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereOrderStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder wherePaymentDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder wherePaymentStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder wherePaymentType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereReturnAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereSubTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereTotalAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrder whereUpdatedAt($value)
 */
	class SellerOrder extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SellerOrderDetails
 *
 * @property int $id
 * @property int $seller_order_id
 * @property int $product_id
 * @property int|null $stock_variant_id
 * @property int $quantity
 * @property int|null $return_quantity
 * @property float $product_price
 * @property float $sale_price
 * @property string|null $discount_type percentage, flat
 * @property float $discount
 * @property float $ezzico_discount
 * @property float $shipping_cost
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Order|null $order
 * @property-read \App\Models\Product $product
 * @property-read \App\Models\ProductLanguage|null $productLanguage
 * @property-read \App\Models\ProductStock|null $productStock
 * @property-read \App\Models\SellerOrder $sellerOrder
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails query()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereDiscountType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereEzzicoDiscount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereProductPrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereReturnQuantity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereSalePrice($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereSellerOrderId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereShippingCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereStockVariantId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SellerOrderDetails whereUpdatedAt($value)
 */
	class SellerOrderDetails extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\SellerStore
 *
 * @method static \Illuminate\Database\Eloquent\Builder|SellerStore newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerStore newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SellerStore query()
 */
	class SellerStore extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Settlement
 *
 * @property int $id
 * @property int $money_sent
 * @property int $seller_id
 * @property float $total_sale
 * @property float $commission
 * @property float $ad_cost
 * @property float $amount
 * @property string $date
 * @property string $start_date Settlement period start
 * @property string $end_date Settlement period end
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $paidBy
 * @property-read \App\Models\User|null $seller
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement query()
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereAdCost($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereCommission($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereEndDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereMoneySent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereStartDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereTotalSale($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Settlement whereUpdatedAt($value)
 */
	class Settlement extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Slider
 *
 * @property int $id
 * @property int $order
 * @property string $link
 * @property int $active
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read mixed $background
 * @property-read \App\Models\User|null $operator
 * @method static \Illuminate\Database\Eloquent\Builder|Slider active()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider query()
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereLink($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereOrder($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Slider whereUpdatedAt($value)
 */
	class Slider extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Store
 *
 * @property int $id
 * @property string|null $facebook
 * @property string|null $google
 * @property string|null $twitter
 * @property string|null $instagram
 * @property string|null $youtube
 * @property string $slug
 * @property string|null $license_no
 * @property int $rating_count
 * @property int $reviews_count
 * @property int $active
 * @property int $seller_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read mixed $banner
 * @property-read mixed $thumbnail
 * @property-read \App\Models\User|null $seller
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreLanguage> $storeLanguage
 * @property-read int|null $store_language_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\StoreLanguage> $storeLanguages
 * @property-read int|null $store_languages_count
 * @method static \Illuminate\Database\Eloquent\Builder|Store newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Store onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Store query()
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereFacebook($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereGoogle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereInstagram($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereLicenseNo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereRatingCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereReviewsCount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereSellerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereTwitter($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store whereYoutube($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Store withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|Store withoutTrashed()
 */
	class Store extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\StoreLanguage
 *
 * @property int $id
 * @property string $local
 * @property string $store_name
 * @property string|null $store_tagline
 * @property string|null $meta_title
 * @property string|null $meta_description
 * @property string|null $address
 * @property int $store_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Store|null $store
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage query()
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage whereLocal($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage whereMetaDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage whereMetaTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage whereStoreId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage whereStoreName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage whereStoreTagline($value)
 * @method static \Illuminate\Database\Eloquent\Builder|StoreLanguage whereUpdatedAt($value)
 */
	class StoreLanguage extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Subscriber
 *
 * @property int $id
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber query()
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Subscriber whereUpdatedAt($value)
 */
	class Subscriber extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Tag
 *
 * @property int $id
 * @property string $name
 * @property int $active
 * @property int $operator_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|Tag active()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag query()
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Tag whereUpdatedAt($value)
 */
	class Tag extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Thana
 *
 * @property int $id
 * @property string $en_name
 * @property string|null $bn_name
 * @property int $active
 * @property int $suburb
 * @property int $district_id
 * @property int|null $created_by
 * @property int|null $updated_by
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $createdBy
 * @property-read \App\Models\District|null $district
 * @property-read \App\Models\User|null $updatedBy
 * @method static \Illuminate\Database\Eloquent\Builder|Thana active()
 * @method static \Illuminate\Database\Eloquent\Builder|Thana newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Thana newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Thana query()
 * @method static \Illuminate\Database\Eloquent\Builder|Thana whereActive($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thana whereBnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thana whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thana whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thana whereDistrictId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thana whereEnName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thana whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thana whereSuburb($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thana whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Thana whereUpdatedBy($value)
 */
	class Thana extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Ticket
 *
 * @property int $id
 * @property int|null $org_id
 * @property int $user_id
 * @property string $full_name
 * @property int|null $assign_to_id
 * @property int|null $assign_id
 * @property string $subject
 * @property string $message
 * @property string|null $attachment
 * @property string $department
 * @property string $status
 * @property string $priority
 * @property int $created_by
 * @property string|null $ip
 * @property string|null $location
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\TicketAssign|null $assign
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TicketAssign> $assigns
 * @property-read int|null $assigns_count
 * @property-read \App\Models\User|null $createBy
 * @property-read \App\Models\User|null $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TicketReply> $replies
 * @property-read int|null $replies_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ActivityLog> $statusLogs
 * @property-read int|null $status_logs_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket query()
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereAssignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereAssignToId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereCreatedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereDepartment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereFullName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereLocation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereMessage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereOrgId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket wherePriority($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereSubject($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Ticket whereUserId($value)
 */
	class Ticket extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TicketAssign
 *
 * @property int $id
 * @property int $ticket_id
 * @property int $assigned_by
 * @property string $assigned_by_name
 * @property int $assigned_to
 * @property string $assign_to_name
 * @property string $notes
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Employee|null $employee
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\TicketReply> $replies
 * @property-read int|null $replies_count
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign whereAssignToName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign whereAssignedBy($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign whereAssignedByName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign whereAssignedTo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign whereNotes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketAssign whereUpdatedAt($value)
 */
	class TicketAssign extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\TicketReply
 *
 * @property int $id
 * @property int $ticket_id
 * @property int $user_id
 * @property int $ticket_assign_id
 * @property string $user_name
 * @property int $is_admin_reply 0 = Others, 1 = Admin reply
 * @property string $comment
 * @property int|null $solution_time
 * @property string|null $attachment
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Ticket|null $ticket
 * @property-read \App\Models\User|null $user
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply query()
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereAttachment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereComment($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereIsAdminReply($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereSolutionTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereTicketAssignId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereTicketId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereUserId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|TicketReply whereUserName($value)
 */
	class TicketReply extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\User
 *
 * @property int $id
 * @property string $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property string $phone
 * @property string $password
 * @property string|null $google_id
 * @property string $user_type
 * @property string|null $gender Comes from config
 * @property string|null $dob
 * @property string $customer_type Individual, Business
 * @property string $status 1 = PENDING, 2 = ACTIVE, 3 = SUSPENDED
 * @property string|null $avatar
 * @property int|null $operator_id
 * @property string|null $description
 * @property string|null $address
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $last_login_at
 * @property int|null $parent_id
 * @property float $balance
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\BankAccount> $Banks
 * @property-read int|null $banks_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Product> $Products
 * @property-read int|null $products_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Attachment> $attachments
 * @property-read int|null $attachments_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Branch> $branchManager
 * @property-read int|null $branch_manager_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SellerCategory> $categories
 * @property-read int|null $categories_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Coupon> $coupons
 * @property-read int|null $coupons_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ProductReview> $customer
 * @property-read int|null $customer_count
 * @property-read \App\Models\EmergencyContact|null $emergency
 * @property-read \App\Models\Employee|null $employee
 * @property-read \App\Models\EmployeeBranch|null $employeeBranch
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\EmployeeBranch> $employeeBranches
 * @property-read int|null $employee_branches_count
 * @property-read mixed $age
 * @property-read mixed $full_address
 * @property-read mixed $full_name
 * @property-read mixed $is_adult
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read User|null $operator
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Order> $orders
 * @property-read int|null $orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Payout> $payout
 * @property-read int|null $payout_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Permission> $permissions
 * @property-read int|null $permissions_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Role> $roles
 * @property-read int|null $roles_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\SellerOrder> $sellerOrders
 * @property-read int|null $seller_orders_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \Laravel\Sanctum\PersonalAccessToken> $tokens
 * @property-read int|null $tokens_count
 * @property-read \App\Models\Address|null $userAddress
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Wishlist> $wishlist
 * @property-read int|null $wishlist_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|User hasAdminPanelAccess()
 * @method static \Illuminate\Database\Eloquent\Builder|User isMember()
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereAvatar($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBalance($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCustomerType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDob($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGender($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereGoogleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastLoginAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUserType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User withTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutDatabaseUser()
 * @method static \Illuminate\Database\Eloquent\Builder|User withoutTrashed()
 */
	class User extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Wishlist
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User|null $customer
 * @property-read \App\Models\Product $product
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist query()
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereProductId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Wishlist whereUserId($value)
 */
	class Wishlist extends \Eloquent {}
}

namespace App\Models{
/**
 * App\Models\Withdraw
 *
 * @property int $id
 * @property int $operator_id
 * @property float $amount
 * @property string|null $note
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Branch|null $branch
 * @property-read \App\Models\User $operator
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw query()
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereAmount($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereNote($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereOperatorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Withdraw whereUpdatedAt($value)
 */
	class Withdraw extends \Eloquent {}
}

