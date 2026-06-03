<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'local',
        'store_name',
        'store_tagline',
        'meta_title',
        'meta_description',
        'address',
        'store_id',
    ];

    /*=====================Eloquent Relations======================*/

    public function store()
    {
        return $this->hasOne(Store::class, 'id', 'store_id');
    }

    /*=====================End Eloquent Relations======================*/
}
