<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarModel extends Model
{
    protected $fillable = ['car_make_id', 'name', 'is_active'];

    protected $casts = ['is_active' => 'boolean'];

    public function carMake(): BelongsTo
    {
        return $this->belongsTo(CarMake::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
