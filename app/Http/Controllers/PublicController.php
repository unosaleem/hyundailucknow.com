<?php
namespace App\Http\Controllers;
use App\Models\{Car,Offer,Video,Lead,Slider,Setting}; use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Schema;
use Carbon\CarbonImmutable;
class PublicController extends Controller {
 public function home(){
  $data=[
   'setting'=>Schema::hasTable('settings') ? Setting::current() : new Setting(),
   'sliders'=>collect(),
   'cars'=>collect(),
   'offers'=>collect(),
   'videos'=>collect(),
  ];
  $today=CarbonImmutable::now(config('app.timezone'))->toDateString();
  if(Schema::hasTable('sliders')){
   $data['sliders']=Slider::where('is_active',true)
    ->where(function($query) use ($today){$query->whereNull('starts_at')->orWhereDate('starts_at','<=',$today);})
    ->where(function($query) use ($today){$query->whereNull('ends_at')->orWhereDate('ends_at','>=',$today);})
    ->orderBy('sort_order')
    ->latest()
    ->get();
  }
  if(Schema::hasTable('cars'))$data['cars']=Car::where('is_active',true)->orderBy('sort_order')->latest()->get();
  if(Schema::hasTable('offers')){
   $data['offers']=Offer::where('is_active',true)
    ->where(function($query) use ($today){$query->whereNull('starts_at')->orWhereDate('starts_at','<=',$today);})
    ->where(function($query) use ($today){$query->whereNull('ends_at')->orWhereDate('ends_at','>=',$today);})
    ->latest()->get();
  }
  if(Schema::hasTable('videos'))$data['videos']=Video::where('is_active',true)->get()->filter(fn (Video $video) => $video->video_id)->values();
  return view('welcome',$data);
 }
 public function lead(Request $r){
  $data=$r->validate([
   'model'=>'nullable|string|max:80',
   'selected_offer_id'=>'nullable|integer|exists:offers,id',
   'name'=>'required|string|max:120',
   'city'=>'required|string|max:100',
   'mobile'=>'required|string|max:20',
   'email'=>'nullable|email|max:150',
   'enquiry_type'=>'nullable|string|max:40',
   'website'=>'nullable|max:0',
   'form_started_at'=>'nullable'
  ]);
  if($r->filled('website')) return response()->json(['success'=>false,'message'=>'Thanks!'],422);
  try {
   $offerId = !empty($data['selected_offer_id']) ? (int)$data['selected_offer_id'] : null;
   $offer = $offerId ? Offer::whereKey($offerId)->where('is_active',true)->first() : null;
   if ($offer && $offer->schedule_status !== 'active') $offer = null;
   if ($offerId && !$offer) {
    return response()->json(['success'=>false,'message'=>'That offer is no longer available. Please choose another offer.'],422);
   }
   $model = !empty($data['model']) ? trim((string)$data['model']) : null;
   if (!$model && !$offer) {
    return response()->json(['success'=>false,'message'=>'Please choose a Hyundai model or offer.'],422);
   }
   Lead::create([
    'model'=>$model,
    'selected_offer_id'=>$offer?->id,
    'name'=>$data['name'],
    'city'=>$data['city'],
    'mobile'=>$data['mobile'],
    'email'=>$data['email']??null,
    'enquiry_type'=>$data['enquiry_type']??'Best Offer',
    'source'=>'Website'
   ]);
   return response()->json(['success'=>true,'message'=>'Thanks! Our team will contact you shortly.']);
  } catch (\Throwable $e) {
   report($e);
   return response()->json(['success'=>false,'message'=>'We could not save your enquiry right now. Please call us or try again shortly.'], 500);
  }
 }
}
