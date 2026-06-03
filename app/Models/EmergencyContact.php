<?php

namespace App\Models;

use App\Library\Enum;
use Illuminate\Support\Facades\Vite;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmergencyContact extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'address',
        'email',
        'mobile_number',
        'relationship',
        'note',
        'image',
        'created_by',
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function getImage(): string
    {
        $path = public_path($this->image);

        if($this->image && is_file($path) && file_exists($path)) {
            return asset($this->image);
        }

        return Vite::asset(Enum::NO_AVATAR_PATH);
    }
}
