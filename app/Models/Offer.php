<?php
namespace App\Models;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Carbon\CarbonImmutable;
class Offer extends Model {
    protected $fillable=['title','description','image','badge','is_active','starts_at','ends_at'];
    protected $casts=['is_active'=>'boolean','starts_at'=>'date','ends_at'=>'date'];
    public function getScheduleStatusAttribute(): string
    {
        if (!$this->is_active) return 'inactive';

        $today = CarbonImmutable::now(config('app.timezone'))->toDateString();
        if ($this->starts_at && $this->starts_at->toDateString() > $today) return 'upcoming';
        if ($this->ends_at && $this->ends_at->toDateString() < $today) return 'expired';

        return 'active';
    }

    public function getScheduleStatusLabelAttribute(): string
    {
        return ucfirst($this->schedule_status);
    }
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) return null;
        return Str::startsWith($this->image, ['http://', 'https://'])
            ? $this->image : asset('storage/' . ltrim($this->image, '/'));
    }
}
