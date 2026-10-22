<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Lead extends Model {
    protected $fillable=['model','selected_offer_id','name','city','mobile','email','enquiry_type','source','status','notes'];
    protected $casts=[];

    public function offer()
    {
        return $this->belongsTo(Offer::class, 'selected_offer_id');
    }
}
