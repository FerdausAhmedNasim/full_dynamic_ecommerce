<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'link',
        'status',
        'operator_id'
    ];

    public function operator()
    {
        return $this->belongsTo(User::class);
    }
}
