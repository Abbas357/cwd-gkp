<?php

namespace App\Http\Controllers\Dts;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    protected $module = 'dts';

    public function index()
    {
        $this->initIfNeeded();
        $years = $this->years();
        $activityTypes = [
            'Monsoon',
            'Flood',
            'Earthquake',
            'Landslide',
            'Snowfall',
            'Avalanche',
        ];

        return view('modules.dts.home.settings', compact('activityTypes', 'years'));
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

        return redirect()->route('admin.apps.dts.settings.index')
            ->with('success', 'DTS settings updated successfully.');
    }

    public function init()
    {
        Setting::set('activity', 'Monsoon', $this->module);
        Setting::set('session', date('Y'), $this->module);

        Setting::set('road_status', [
            'Partially restored', 'Fully restored', 'Not restored'
        ], $this->module, 'category', 'Types of Road Status');
        Setting::set('infrastructure_type', [
            'Road', 'Bridge', 'Culvert'
        ], $this->module, 'category', 'Types of Infrastructures');
        Setting::set('damage_status', [
            'Partially Damaged', 'Fully Damaged'
        ], $this->module, 'category', 'Types of Damage Status');
        Setting::set('damage_nature', [
            'Culvert', 'Retaining Wall', 'Embankment Damages', 'Shoulders', 'WC',
            'Base Course', 'Sub Base', 'Culverts', 'Rigid Pavement', 'Kacha Road',
            'Structure work & Approach', 'Road washed away', 'Land Sliding',
            'Surface of road', 'Earth Work', 'PCC Work', 'Wing Wall', 'Debris Deposition',
            'Slips', 'Boulders', 'Debris', 'Road Crust', 'Bed damaged', 'Breast Wall',
            'Slush', 'Rock Fall', 'Planks', 'Beams', 'Mulbas', 'Erosion',
            'Accumulation of boulders', 'Piles', 'activityway', 'Drain', 'PCC Berms'
        ],
        $this->module, 'category', 'Types of Damage Nature');
        return redirect()->route('admin.apps.dts.settings.index')
            ->with('success', 'Damage Tracking System module initd with default settings and categories.');
    }

    private function initIfNeeded()
    {
        $activity = setting('activity', $this->module, null);
        if ($activity === null) {
            $this->init();
        }
    }
}
