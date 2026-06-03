<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Expense extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'branch_id',
        'category',
        'title',
        'amount',
        'note',
        'operator_id',
    ];


    /*===================== Start Eloquent Relations ======================*/

    public function operator(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }

    /*===================== End Eloquent Relations ======================*/

    // Get Auth User Branch Wise Sales
    public static function getAuthUserBranchWiseExpense($user, $from, $to)
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

    // Get Total Expense
    public static function getTotalExpense($user, $from, $to)
    {
        $query = self::getAuthUserBranchWiseExpense($user, $from, $to);

        return $query->sum('amount');
    }
}
