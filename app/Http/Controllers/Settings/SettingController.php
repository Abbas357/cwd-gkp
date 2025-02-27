<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\UpdateSettingRequest;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        $tables = ['Slider', 'Gallery', 'News', 'Seniority', 'DevelopmentProject', 'Tender', 'Event'];
        return view('admin.settings.index', compact('settings', 'tables'));
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

        if ($request->has('commentable_tables')) {
            $validatedData['commentable_tables'] = json_encode($request->commentable_tables);
        } else {
            $validatedData['commentable_tables'] = json_encode([]);
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
