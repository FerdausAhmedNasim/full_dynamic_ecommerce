<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject',
        'send_date',
        'message',
    ];
    /*=====================Eloquent======================*/
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function recipients()
    {
        return $this->hasMany(NotificationRecipient::class, 'notification_id', 'id');
    }
    /*=====================End======================*/

    public function setSendDateAttribute($value)
    {
        $this->attributes['send_date'] = Carbon::parse($value)->format('Y-m-d');
    }
}
