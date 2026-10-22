<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Artisan;

class MaintenanceController extends Controller
{
    public function clearCacheAndLinkStorage(): RedirectResponse
    {
        Artisan::call('optimize:clear');
        $cacheOutput = trim(Artisan::output());

        Artisan::call('storage:link');
        $storageOutput = trim(Artisan::output());

        return back()->with('success', 'Application cache cleared and public storage link verified.')
            ->with('maintenance_output', [
                'cache' => $cacheOutput,
                'storage' => $storageOutput,
            ]);
    }
}
