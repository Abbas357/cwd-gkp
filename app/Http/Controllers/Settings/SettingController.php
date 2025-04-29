<?php

namespace App\Http\Controllers\Settings;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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

        return redirect()->route('admin.settings.index')
            ->with('success', 'Website settings updated successfully.');
    }
    
    public function init()
    {
        Setting::set('app_name', 'Communication & Works Department, KP', $this->module);
        Setting::set('description', 'Communications & Works Department was established in 1979. Since establishment the Department is working to promote safe, sustainable, cost effective and environment friendly road infrastructure leading to socio-economic development.', $this->module);
        Setting::set('meta_description', 'Communications & Works Department was established in 1979. Since establishment the Department is working to promote safe, sustainable, cost effective and environment friendly road infrastructure leading to socio-economic development.', $this->module);
        Setting::set('commentable_tables', '["News"]', $this->module);
        Setting::set('contact_address', 'Civil Secretariat, Peshawar', $this->module);
        Setting::set('contact_phone', '091-9214039', $this->module);
        Setting::set('email', 'cwd.gkp@gmail.com', $this->module);
        Setting::set('whatsapp', '4534543534', $this->module);
        Setting::set('facebook', 'CWDKPGovt', $this->module);
        Setting::set('twitter', 'CWDKPGovt', $this->module);
        Setting::set('youtube', 'CWDKPGovt', $this->module);
        Setting::set('secret_key', 'abbas', $this->module);
        Setting::set('maintenance_routes', '{"contractors.*":"1"}', $this->module);

        Setting::set('page_type', [
            'about_us', 'introduction', 'vision', 'functions', 'announcement', 'organogram', 'achievements', 'e_standardization', 'e_registration', 'noc_for_pumps', 'procurement'
        ], $this->module, 'category', 'Page types for the website');

        $categorized = [
            'page_type' => [
                'about_us',
                'introduction',
                'vision',
                'functions',
                'Announcement',
                'organogram',
                'achievements',
                'E-Standardization',
                'E-Registration',
                'NOC for Pumps',
                'Procurement',
            ],
            'file_type' => [
                'pdf',
                'Image',
                'docs',
                'pptx',
                'xlsx',
            ],
            'download_category' => [
                'Pakistan Citizen Portal',
                'others',
                'PWMIS',
                'Engineering Materials',
                'Extension Certificate',
                'MRS',
                'Consultant',
                'Enrolment Of Contractor',
                'Planning Commission Proforma',
                'B&R CODES',
                'Building Codes',
                'Minutes of Promotional Meetings',
                'Service Rules',
                'Solar Panels And Allied Equipment',
                'Annual Procurement Plan Guidelines',
                'Bidding',
                'KIPRA Notification',
                'E-Billing',
                'Tech Evaluation Applications',
                'Policies & Procedure Internal Audit',
                'Internship Program',
            ],
            'gallery_type' => [
                'Visits',
                'PKHA',
                'Inauguration Ceremony',
                'General',
            ],
            'news_category' => [
                'Occasions',
                'Tender',
                'General',
                'Consultants',
            ],
            'receipt_type' => [
                'tender',
            ],
        ];

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
