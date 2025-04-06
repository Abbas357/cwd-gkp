<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use Illuminate\Support\Facades\Cache;

class Setting extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia, LogsActivity;

    protected $fillable = [
        'module',
        'key',
        'value',
        'type',
        'description'
    ];

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('logo')->singleFile();
        $this->addMediaCollection('favicon')->singleFile();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logExcept(['id', 'updated_at', 'created_at'])
            ->logOnlyDirty()
            ->useLogName('settings')
            ->dontSubmitEmptyLogs()
            ->setDescriptionForEvent(function (string $eventName) {
                return "Setting {$this->module}.{$this->key} {$eventName}";
            });
    }

    public static function get($key, $module = 'main', $default = null)
    {
        $setting = self::where('module', $module)
            ->where('key', $key)
            ->first();

        if (!$setting) {
            return $default;
        }

        return self::castValue($setting->value, $setting->type);
    }


    public static function getAll($module = 'main')
    {
        return self::where('module', $module)
            ->get()
            ->mapWithKeys(function ($setting) {
                return [
                    $setting->key => self::castValue($setting->value, $setting->type)
                ];
            })
            ->toArray();
    }

    public static function set($key, $value, $module = 'main', $type = null, $description = null)
    {
        if ($key === 'category') {
            Cache::forget("category_{$module}_{$key}");
        }

        if ($type === null) {
            $type = self::determineType($value);
        }

        $valueToStore = self::prepareForStorage($value, $type);

        // Update or create setting
        return self::updateOrCreate(
            ['module' => $module, 'key' => $key],
            [
                'value' => $valueToStore,
                'type' => $type,
                'description' => $description ?? '',
            ]
        );
    }

    protected static function determineType($value)
    {
        if (is_bool($value)) {
            return 'boolean';
        } elseif (is_int($value)) {
            return 'integer';
        } elseif (is_float($value)) {
            return 'float';
        } elseif (is_array($value) || is_object($value)) {
            return 'json';
        } else {
            return 'string';
        }
    }

    protected static function prepareForStorage($value, $type)
    {
        if ($type === 'json' || $type === 'category') {
            if (is_array($value) || is_object($value)) {
                return json_encode($value);
            }
        }

        if ($type === 'boolean') {
            return $value ? '1' : '0';
        }

        return (string) $value;
    }

    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return (bool) $value;
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'json':
            case 'category':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    public static function getCategory($key, $module = 'main', $default = [])
    {
        $setting = self::where('module', $module)
            ->where('key', $key)
            ->where('type', 'category')
            ->first();

        if (!$setting) {
            return $default;
        }

        return json_decode($setting->value, true);
    }

    public static function getAllCategories($module = 'main')
    {
        return self::where('module', $module)
            ->where('type', 'category')
            ->get()
            ->mapWithKeys(function ($setting) {
                return [
                    $setting->key => json_decode($setting->value, true)
                ];
            })
            ->toArray();
    }

    public static function addCategoryItem($categoryKey, $item, $module = 'main')
    {
        $currentItems = self::getCategory($categoryKey, $module, []);

        if (!in_array($item, $currentItems)) {
            $currentItems[] = $item;

            self::set($categoryKey, $currentItems, $module, 'category');

            Cache::forget("category_{$module}_{$categoryKey}");
            Cache::forget("categories_{$module}");
        }

        return $currentItems;
    }

    public static function removeCategoryItem($categoryKey, $item, $module = 'main')
    {
        $currentItems = self::getCategory($categoryKey, $module, []);

        $key = array_search($item, $currentItems);
        if ($key !== false) {
            unset($currentItems[$key]);
            $currentItems = array_values($currentItems); // Reindex array

            self::set($categoryKey, $currentItems, $module, 'category');

            Cache::forget("category_{$module}_{$categoryKey}");
            Cache::forget("categories_{$module}");
        }

        return $currentItems;
    }
}
