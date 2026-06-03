<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'org_id',
        'user_id',
        'full_name',
        'subject',
        'message',
        'attachment',
        'department',
        'status',
        'priority',
        'assign_to_id',
        'created_by',
        'assign_id',
        'ip',
        'location',
    ];

    public $afterCommit = true;

    /*=====================Eloquent Relations======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'assign_to_id');
    }

    public function replies()
    {
        return $this->hasMany(TicketReply::class, 'ticket_id', 'id')->latest();
    }

    public function assigns()
    {
        return $this->hasMany(TicketAssign::class, 'ticket_id', 'id')->latest();
    }

    public function assign()
    {
        return $this->hasOne(TicketAssign::class, 'id', 'assign_id');
    }

    public function createBy()
    {
        return $this->hasOne(User::class, 'id', 'created_by');
    }

    /**
     * Fetch only the status change log for a ticket
     */
    public function statusLogs()
    {
        return $this->hasMany(ActivityLog::class, 'record_id')->where('subject', 'Ticket')->whereNotNull('status');
    }

    public static function getTicketCounts($user_id = '', $from, $to)
    {
        $query = self::select('status', DB::raw('count(*) as total'))
                    ->whereBetween('created_at', [$from, $to])
                    ->groupBy('status');

        if ($user_id) {
            $query->whereUserId($user_id);
        }

        return $query->pluck('total', 'status')->toArray();
    }
}
