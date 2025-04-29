<?php

namespace App\Http\Controllers\Settings;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    protected $module = 'main';

    public function settings()
    {
        $this->initIfNeeded();
        return view('misc.settings');
    }

    public function update(Request $request)
    {
        if ($request->has('settings')) {
            foreach ($request->settings as $key => $data) {
                if (!isset($data['value']) && ($data['type'] ?? '') !== 'boolean') {
                    continue;
                }

                $type = $data['type'] ?? 'string';
                $description = $data['description'] ?? ($key . ' for ' . $this->module);
                
                if ($type === 'json' && is_array($data['value'])) {
                    $value = json_encode($data['value']);
                } else {
                    $value = $data['value'];
                }

                Setting::set(
                    $key,
                    $value,
                    $this->module,
                    $type,
                    $description
                );
            }
        }

        if ($request->has('categories')) {
            foreach ($request->categories as $key => $data) {
                if (!isset($data['value']) || !is_array($data['value'])) {
                    continue;
                }
                $items = array_values(array_filter($data['value']));
                Setting::set(
                    $key,
                    $items,
                    $this->module,
                    'category',
                    $data['description'] ?? null
                );
            }
        }

        $clearCache = true;
    
        session()->flash('success', 'Website settings updated successfully.');

        if ($request->has('cache')) {
            switch ($request->cache) {
                case 'create':
                    Artisan::call('route:cache');
                    Artisan::call('config:cache');
                    Artisan::call('view:cache');
                    $clearCache = false;
                    break;
                case 'clear':
                    Artisan::call('route:clear');
                    Artisan::call('config:clear');
                    Artisan::call('view:clear');
                    Artisan::call('cache:clear');
                    break;
            }
        }

        if ($clearCache) {
            Cache::flush();
        }
        
        return redirect()->route('admin.settings.index');
    }
    
    public function init()
    {
        Setting::set('app_name', 'Communication & Works Department, KP', $this->module);
        Setting::set('description', 'Communications & Works Department was established in 1979. Since establishment the Department is working to promote safe, sustainable, cost effective and environment friendly road infrastructure leading to socio-economic development.', $this->module);
        Setting::set('meta_description', 'Communications & Works Department was established in 1979. Since establishment the Department is working to promote safe, sustainable, cost effective and environment friendly road infrastructure leading to socio-economic development.', $this->module);
        Setting::set('contact_address', 'Civil Secretariat, Peshawar', $this->module);
        Setting::set('contact_phone', '091-9214039', $this->module);
        Setting::set('email', 'cwd.gkp@gmail.com', $this->module);
        Setting::set('whatsapp', '4534543534', $this->module);
        Setting::set('facebook', 'CWDKPGovt', $this->module);
        Setting::set('twitter', 'CWDKPGovt', $this->module);
        Setting::set('youtube', 'CWDKPGovt', $this->module);
        Setting::set('secret_key', 'abbas', $this->module);
        Setting::set('maintenance_routes', '{"contractors.*":"1"}', $this->module, 'json', 'Routes exempt from maintenance mode');
        Setting::set('maintenance_mode', false, $this->module, 'boolean', 'Website maintenance mode');

        Setting::set('page_type', [
            'about_us', 'introduction', 'vision', 'functions', 'announcement', 'organogram', 'achievements', 'e_standardization', 'e_registration', 'noc_for_pumps', 'procurement'
        ], $this->module, 'category', 'Page types for the website');

        Setting::set('download_category', [
            'Pakistan Citizen Portal', 'others', 'PWMIS', 'Engineering Materials', 'Extension Certificate', 'MRS', 'Consultant', 'Enrolment Of Contractor', 'Planning Commission Proforma', 'B&R CODES', 'Building Codes', 'Minutes of Promotional Meetings', 'Service Rules', 'Solar Panels And Allied Equipment', 'Annual Procurement Plan Guidelines', 'Bidding', 'KIPRA Notification', 'E-Billing', 'Tech Evaluation Applications', 'Policies & Procedure Internal Audit', 'Internship Program',
        ], $this->module, 'category', 'Download categories for the website');

        Setting::set('gallery_type', [
            'Visits', 'PKHA', 'Inauguration Ceremony', 'General',
        ], $this->module, 'category', 'Gallery types for the website');

        Setting::set('news_category', [
            'Occasions', 'Tender', 'General', 'Consultants',
        ], $this->module, 'category', 'News Category for the website');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Website is initiated with default settings and categories.');
    }

    private function initIfNeeded()
    {
        $appName = setting('app_name', $this->module, null);
        if ($appName === null) {
            $this->init();
        }
    }
}
