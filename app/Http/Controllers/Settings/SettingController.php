<?php

namespace App\Http\Controllers\Settings;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class SettingController extends Controller
{
    public function index()
    {        
        $tables = ['Slider', 'Gallery', 'News', 'Seniority', 'DevelopmentProject', 'Tender', 'Event'];
        return view('modules.settings.settings.index', compact('tables'));
    }

    public function update(Request $request, $module = 'main')
    {        
        if ($request->has('settings')) {
            foreach ($request->settings as $key => $data) {
                if (!isset($data['value']) && $data['type'] !== 'boolean') {
                    continue;
                }
                Setting::set(
                    $key, 
                    $data['value'], 
                    $module, 
                    $data['type'] ?? null, 
                    $data['description'] ?? null
                );
            }
        }
        
        $message = 'Settings saved successfully.';
        if ($request->has('cache')) {
            if ($request->input('cache') === 'create') {
                Artisan::call('route:cache');
                Artisan::call('config:cache');
                Artisan::call('view:cache');
                $message = 'Settings saved and caches created successfully.';
            } elseif ($request->input('cache') === 'clear') {
                Artisan::call('route:clear');
                Artisan::call('config:clear');
                Artisan::call('view:clear');
                $message = 'Settings saved and caches cleared successfully.';
            }
        }
        
        Cache::flush();
        
        return redirect()->route('admin.settings.index')
            ->with('success', $message);
    }

    public function categories()
    {        
        $categories = Setting::where('type', 'category')->get();
        return view('modules.settings.categories.index', compact('categories'));
    }
    
    public function showCategory($key, $module = 'main')
    {        
        $category = Setting::where('module', $module)
            ->where('key', $key)
            ->where('type', 'category')
            ->firstOrFail();
            
        $items = json_decode($category->value, true);
        
        return view('modules.settings.categories.show', compact('category', 'items'));
    }
    
    public function createCategory()
    {        
        return view('modules.settings.categories.create');
    }
    
    public function storeCategory(Request $request)
    {        
        $request->validate([
            'key' => 'required|string|max:255|unique:settings,key,NULL,id,module,' . $request->input('module', 'main') . ',type,category',
            'module' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'items' => 'nullable|array',
        ]);
        
        $module = $request->input('module', 'main');
        $key = $request->input('key');
        $description = $request->input('description');
        $items = $request->input('items', []);
        
        $categoryItems = [];
        foreach ($items as $item) {
            if (!empty($item)) {
                $categoryItems[] = $item;
            }
        }
        
        Setting::set($key, $categoryItems, $module, 'category', $description);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }
    
    public function editCategory($key, $module = 'main')
    {        
        $category = Setting::where('module', $module)
            ->where('key', $key)
            ->where('type', 'category')
            ->firstOrFail();
            
        $items = json_decode($category->value, true);
        
        return view('modules.settings.categories.edit', compact('category', 'items'));
    }
    
    public function updateCategory(Request $request, $key, $module = 'main')
    {        
        $request->validate([
            'description' => 'nullable|string',
            'items' => 'required|array',
        ]);
        
        $description = $request->input('description');
        $items = array_filter($request->input('items', [])); // Remove empty values
        
        Setting::set($key, array_values($items), $module, 'category', $description);
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }
    
    public function deleteCategory($key, $module = 'main')
    {        
        $category = Setting::where('module', $module)
            ->where('key', $key)
            ->where('type', 'category')
            ->firstOrFail();
            
        $category->delete();
        
        Cache::forget("category_{$module}_{$key}");
        Cache::forget("categories_{$module}");
        
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
        
    public function getCategoryItems($key, $module = 'main')
    {        
        $items = Setting::getCategory($key, $module, []);
        return response()->json(['items' => $items]);
    }
    
    public function addCategoryItem(Request $request, $key, $module = 'main')
    {        
        $request->validate([
            'item' => 'required|string|max:255',
        ]);
        
        $item = $request->input('item');
        
        $items = Setting::addCategoryItem($key, $item, $module);
        
        return response()->json([
            'success' => true,
            'items' => $items,
            'message' => 'Item added successfully.'
        ]);
    }
    
    public function removeCategoryItem(Request $request, $key, $module = 'main')
    {        
        $request->validate([
            'item' => 'required|string|max:255'
        ]);
        
        $item = $request->input('item');
        
        $items = Setting::removeCategoryItem($key, $item, $module);
        
        return response()->json([
            'success' => true,
            'items' => $items,
            'message' => 'Item removed successfully.'
        ]);
    }
}