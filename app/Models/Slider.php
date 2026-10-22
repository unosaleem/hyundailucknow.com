<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\CarbonImmutable;

class Slider extends Model
{
    protected $fillable = [
        'title',
        'badge',
        'link',
        'image',
        'mobile_image',
        'sort_order',
        'is_active',
        'starts_at',
        'ends_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'starts_at' => 'date',
        'ends_at' => 'date',
    ];

    public function getScheduleStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        $today = CarbonImmutable::now(config('app.timezone'))->toDateString();
        if ($this->starts_at && $this->starts_at->toDateString() > $today) {
            return 'upcoming';
        }
        if ($this->ends_at && $this->ends_at->toDateString() < $today) {
            return 'expired';
        }

        return 'active';
    }

    public function getScheduleStatusLabelAttribute(): string
    {
        return ucfirst($this->schedule_status);
    }

    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return Str::startsWith($this->image, ['http://', 'https://'])
            ? $this->image
            : Storage::disk('public')->url($this->image);
    }

    public function getMobileImageUrlAttribute(): ?string
    {
        if (!$this->mobile_image) {
            return $this->image_url;
        }

        return Str::startsWith($this->mobile_image, ['http://', 'https://'])
            ? $this->mobile_image
            : Storage::disk('public')->url($this->mobile_image);
    }
}
