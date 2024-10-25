<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\UpdateSettingRequest;

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
        Setting::updateOrCreate(
            ['id' => 1],
            $validatedData
        );
        Cache::forget('settings');

        return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully.');
    }
}
