<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function submenus()
    {
        return $this->hasMany(Submenu::class)->orderBy('order', 'asc');
    }

    // function for save data with observer
    // public function saveQuietly(array $options = [])
    // {
    //     return static::withoutEvents(function () use ($options) {
    //         return $this->save($options);
    //     });
    // }

    public function saveQuietly(array $options = [])
    {
        return static::withoutEvents(function () {
            return $this->save();
        });
    }
}
