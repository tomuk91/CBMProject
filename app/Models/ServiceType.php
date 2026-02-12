<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceType extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon',
        'estimated_duration',
        'price_from',
        'price_to',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price_from' => 'decimal:2',
        'price_to' => 'decimal:2',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    /**
     * Auto-generate slug from name.
     */
    protected static function booted(): void
    {
        static::creating(function (ServiceType $serviceType) {
            if (empty($serviceType->slug)) {
                $serviceType->slug = Str::slug($serviceType->name);
            }
        });
    }

    /**
     * Scope to active service types only.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order by sort_order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Get formatted price range string.
     */
    public function getPriceRangeAttribute(): ?string
    {
        if ($this->price_from && $this->price_to) {
            return number_format($this->price_from, 0) . ' - ' . number_format($this->price_to, 0) . ' Ft';
        }

        if ($this->price_from) {
            return number_format($this->price_from, 0) . ' Ft~';
        }

        return null;
    }
}
