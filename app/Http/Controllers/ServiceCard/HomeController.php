<?php

namespace App\Http\Controllers\ServiceCard;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $module = 'service_card';

    public function index() {
        return view('modules.service_card.home.index');
    }
    
    public function dashboard(Request $request)
    {

    }
    
    public function settings()
    {
        $this->initIfNeeded();
        return view('modules.service_cards.home.settings');
    }

    public function update(Request $request)
    {
        if ($request->has('settings')) {
            foreach ($request->settings as $key => $data) {
                if (!isset($data['value']) && $data['type'] !== 'boolean') {
                    continue;
                }

                Setting::set(
                    $key,
                    $data['value'],
                    $this->module,
                    'string',
                    $key . ' for ' . $this->module
                );
            }
        }

        return redirect()->route('admin.apps.service_cards.settings.index')
            ->with('success', 'Service Card settings updated successfully.');
    }

    public function init()
    {
        Setting::set('appName', 'Service Identity Card', $this->module);
        return redirect()->route('admin.apps.service_cards.settings.index')
            ->with('success', 'Service Card module initiated with default settings.');
    }

    private function initIfNeeded()
    {
        $appName = setting('appName', $this->module, null);
        if ($appName === null) {
            $this->init();
        }
    }
}
