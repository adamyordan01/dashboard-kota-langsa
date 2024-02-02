<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiData extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_category_id',
        'name',
        'url',
        'method',
        'is_active',
    ];

    public function category()
    {
        return $this->belongsTo(ApiCategory::class, 'api_category_id');
    }
}
