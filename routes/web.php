<?php
use Illuminate\Support\Facades\Route; use App\Http\Controllers\PublicController; use App\Http\Controllers\Admin\{AuthController,DashboardController,CarController,OfferController,VideoController,LeadController,MaintenanceController,SliderController,SettingController};
Route::get('/',[PublicController::class,'home'])->name('home'); Route::redirect('/leads', '/'); Route::post('/leads',[PublicController::class,'lead'])->middleware('throttle:10,1')->name('leads.store');
Route::get('/crm-check', function (\Illuminate\Http\Request $request) {
    if ($request->query('key') !== 'brhyundai2026') {
        return response()->json(['error' => 'Unauthorized. Open ?key=brhyundai2026 to run live CRM test.'], 403);
    }
    $crm = app(\App\Services\InfomanCrmService::class);
    $result = $crm->sendLead([
        'name' => 'Direct Live CRM Test (' . now()->format('d M H:i:s') . ')',
        'city' => 'Lucknow',
        'mobile' => '9899363534',
        'email' => 'test@hyundailucknow.com',
        'model' => 'CRETA'
    ]);
    return response()->json([
        'message' => 'Infoman eCRM LeadCreation API Test',
        'timestamp' => now()->toDateTimeString(),
        'result' => $result
    ]);
});
Route::prefix('admin')->name('admin.')->group(function(){ Route::middleware('guest')->group(function(){Route::get('/login',[AuthController::class,'showLogin'])->name('login');Route::post('/login',[AuthController::class,'login'])->name('login.store');}); Route::middleware('admin')->group(function(){Route::post('/logout',[AuthController::class,'logout'])->name('logout');Route::get('/',[DashboardController::class,'index'])->name('dashboard');Route::get('maintenance/clear-cache',[MaintenanceController::class,'clearCacheAndLinkStorage'])->name('maintenance.clear-cache');Route::get('settings',[SettingController::class,'edit'])->name('settings.edit');Route::put('settings',[SettingController::class,'update'])->name('settings.update');Route::patch('cars/{car}/toggle',[CarController::class,'toggle'])->name('cars.toggle');Route::resource('cars',CarController::class)->except(['show']);Route::patch('sliders/{slider}/toggle',[SliderController::class,'toggle'])->name('sliders.toggle');Route::resource('sliders',SliderController::class)->except(['show']);Route::patch('offers/{offer}/toggle',[OfferController::class,'toggle'])->name('offers.toggle');Route::resource('offers',OfferController::class)->except(['show']);Route::resource('videos',VideoController::class)->except(['show']);Route::get('leads/export',[LeadController::class,'export'])->name('leads.export');Route::post('leads/test-crm',[LeadController::class,'testCrm'])->name('leads.test-crm');Route::get('leads/test-crm-quick',[LeadController::class,'testCrm'])->name('leads.test-crm-quick');Route::post('leads/{lead}/sync-crm',[LeadController::class,'syncCrm'])->name('leads.sync-crm');Route::get('leads',[LeadController::class,'index'])->name('leads.index');Route::patch('leads/{lead}',[LeadController::class,'update'])->name('leads.update');Route::patch('leads/{lead}/spam',[LeadController::class,'toggleSpam'])->name('leads.spam');Route::delete('leads/{lead}',[LeadController::class,'destroy'])->name('leads.destroy');});});

// Shared hosting fallback route: serves files from storage when symlinks or terminal commands are not available
Route::get('/storage/{path}', function (string $path) {
    $cleanPath = str_replace(['..', "\0"], '', $path);
    $fullPath = storage_path('app/public/' . $cleanPath);
    if (! file_exists($fullPath) || is_dir($fullPath)) {
        $fullPath = base_path('storage/' . $cleanPath);
    }
    if (! file_exists($fullPath) || is_dir($fullPath)) {
        abort(404);
    }
    return response()->file($fullPath, [
        'Cache-Control' => 'public, max-age=31536000',
    ]);
})->where('path', '.*')->name('storage.fallback');

