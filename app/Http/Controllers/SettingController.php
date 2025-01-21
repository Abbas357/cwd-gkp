<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(UpdateSettingRequest $request)
    {
        $validatedData = $request->validated();
        $message = '';

        if ($request->has('maintenance_routes')) {
            $maintenanceRoutes = [];
            foreach ($request->maintenance_routes as $route => $status) {
                $maintenanceRoutes[$route] = (bool) $status;
            }
            $validatedData['maintenance_routes'] = $maintenanceRoutes;
        } else {
            $validatedData['maintenance_routes'] = [];
        }

        Setting::updateOrCreate(
            ['id' => 1],
            $validatedData
        );

        $message = 'Settings saved successfully.';
        Cache::forget('settings');

        if ($request->has('cache')) {
            $cacheAction = $request->input('cache');
            if ($cacheAction === 'create') {
                $message = 'All caches have been created (route, config, view).';
                session()->flash('success', $message);
                Artisan::call('route:cache');
                Artisan::call('config:cache');
                Artisan::call('view:cache');
            } elseif ($cacheAction === 'clear') {
                $message = 'All caches have been cleared (route, config, view).';
                session()->flash('success', $message);
                Artisan::call('route:clear');
                Artisan::call('config:clear');
                Artisan::call('view:clear');
            }
        }

        session()->flash('success', $message);
        return redirect()->route('admin.settings.index');
    }
}
