<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'order_id',
        'return_id',
        'payment_method',
        'amount',
        'transaction_id',
        'note',
        'payment_status',
        'operator_id',
    ];

    /*===================== Start Eloquent Relations ======================*/
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function orderReturn(): BelongsTo
    {
        return $this->belongsTo(OrderReturn::class);
    }

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /*===================== End Eloquent Relations ======================*/

    // Get Auth User Branch Wise Collection
    public static function getAuthUserBranchWiseCollection($user, $from, $to)
    {
        $query = self::whereBetween('created_at', [$from, $to]);

        if ($user->isSuperAdmin() || $user->isAdmin()) {
            $query;
        } elseif ($user->isEmployee()) {
            $query->where('branch_id', $user->employeeBranch->id);
        } else {
            return null;
        }

        return $query;
    }

    // Get Total Collection
    public static function getTotalCollection($user, $from, $to)
    {
        $query = self::getAuthUserBranchWiseCollection($user, $from, $to);

        return $query->sum('amount');
    }
}
