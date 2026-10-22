<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'meta_title',
        'meta_description',
        'meta_keywords',
        'phone',
        'whatsapp_number',
        'email',
        'address',
        'working_hours',
    ];

    /**
     * Singleton instance helper with established dealership defaults
     */
    public static function current(): self
    {
        return static::firstOrCreate([], [
            'meta_title' => 'BR Hyundai | Find Your Hyundai - Best Deals & Offers in Lucknow',
            'meta_description' => 'Find your Hyundai at BR Hyundai and get your best available offer. Explore Hyundai SUVs, sedans, hatchbacks and electric cars.',
            'meta_keywords' => 'BR Hyundai, Hyundai Lucknow, Hyundai Showroom Lucknow, Hyundai Cars, Creta, Venue, Verna, Exter, i20, Alcazar, Aura, Best Hyundai Offers',
            'phone' => '+91 9724 777 048',
            'whatsapp_number' => '919724777048',
            'email' => 'sales@hyundailucknow.com',
            'address' => 'Authorized BR Hyundai Dealership, Lucknow, Uttar Pradesh',
            'working_hours' => 'Mon – Sun · 9am – 7pm',
        ]);
    }

    /**
     * Clean phone number for tel: links
     */
    public function getCleanPhoneAttribute(): string
    {
        $phone = preg_replace('/[^0-9+]/', '', $this->phone ?? '');
        return $phone ?: '+919724777048';
    }

    /**
     * Clean WhatsApp number for wa.me/ links
     */
    public function getCleanWhatsappAttribute(): string
    {
        $wa = preg_replace('/[^0-9]/', '', $this->whatsapp_number ?? '');
        return $wa ?: '919724777048';
    }
}
