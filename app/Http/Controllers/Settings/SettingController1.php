<?php

namespace App\Http\Controllers\Settings;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $module = 'main';

    public function settings()
    {
        $this->initIfNeeded();
        return view('modules.vehicles.settings');
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

        return redirect()->route('admin.apps.vehicles.settings.index')
            ->with('success', 'Vehicle settings updated successfully.');
    }
    
    public function init()
    {
        Setting::set('appName', 'Vehicle Management System', $this->module);

        Setting::set('vehicle_type', [
            'Vigo', 'Single Cabin', 'Pick up', 'Motorcycle', 'Jeep', 'Double Cabin', 'Car'
            ], $this->module, 'category', 'Vehicle Type');

        Setting::set('vehicle_functional_status', [
            'Non-Functional', 'Functional', 'Condemned'
            ], $this->module, 'category', 'Vehicle Functional Status');

        Setting::set('vehicle_color', [
            'Yellow', 'White', 'Silver', 'Red', 'Orange', 'Metallic', 'Green', 'Green', 'Gray', 'Brown', 'Blue', 'Black', 'N/A'
            ], $this->module, 'category', 'Vehicle Color');

        Setting::set('fuel_type', [
            'Petrol + CNG', 'Petrol', 'Diesel', 'CNG', 'N/A'
            ], $this->module, 'category', 'Vehicle Fuel Type');

        Setting::set('vehicle_registration_status', [
            'Un-Registered', 'Registered', 'In-Progress'
            ], $this->module, 'category', 'Vehicle Registration Status');

        Setting::set('vehicle_brand', [
            'Yamaha', 'Toyota', 'Suzuki', 'Nissan', 'Mitsubishi', 'Mercedes-Benz', 'Mazda', 'Kia', 'Jeep', 'Indus Car', 'Hyundai', 'Honda', 'Ford', 'Chevrolet', 'BMW', 'Audi'
            ], $this->module, 'category', 'Vehicle Brand');

        return redirect()->route('admin.apps.vehicles.settings.index')
            ->with('success', 'Vehicle Management System module initiated with default settings and categories.');
    }

    private function initIfNeeded()
    {
        $appName = setting('appName', $this->module, null);
        if ($appName === null) {
            $this->init();
        }
    }
}
