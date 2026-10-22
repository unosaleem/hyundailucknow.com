<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller; use App\Models\{Car,Offer,Video,Lead,Slider};
class DashboardController extends Controller { public function index(){ return view('admin.dashboard',['stats'=>['sliders'=>Slider::where('is_active',true)->count(),'cars'=>Car::count(),'offers'=>Offer::where('is_active',true)->count(),'videos'=>Video::where('is_active',true)->count(),'leads'=>Lead::count(),'newLeads'=>Lead::where('status','new')->count(),'spamLeads'=>Lead::where('status','spam')->count()],'recentLeads'=>Lead::latest()->limit(8)->get()]); } }
