<?php 

use App\Models\Setting;

function getProfilePic($user): string
{
    if (!$user instanceof App\Models\User) {
        $defaultLogoPath = public_path('admin/images/no-profile.png');
        $defaultLogoData = file_get_contents($defaultLogoPath);
        return 'data:image/png;base64,' . base64_encode($defaultLogoData);
    }

    $url = asset($user->getFirstMediaUrl('profile_pictures', 'thumb'));

    $extension = pathinfo($url, PATHINFO_EXTENSION);
    if (!$extension || !in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif'])) {
        $defaultLogoPath = public_path('admin/images/no-profile.png');
        $defaultLogoData = file_get_contents($defaultLogoPath);
        return 'data:image/png;base64,' . base64_encode($defaultLogoData);
    }

    return $url;
}

function categoryType()
{
    return [
        'designation', 'office', 'file_type', 'download_category', 'contractor_category',
        'provincial_entity', 'gallery_type', 'news_category', 'page_type', 'tender_domain',
        'vehicle_type', 'vehicle_functional_status', 'vehicle_color', 'fuel_type', 'vehicle_registration_status', 'vehicle_brand', 'receipt_type',
        'machinery_type', 'machinery_operational_status', 'machinery_power_source',
        'machinery_location', 'machinery_manufacturer', 'machinery_certification_status',
    ];
}

function getYears() {
    $currentYear = (int)date('Y');
    $years = [];

    for ($year = $currentYear; $year >= 2000; $year--) {
        $years[] = $year;
    }

    return $years;
}

function getDocumentIcon($mimeType)
{
    switch (strtolower($mimeType)) {
        case 'application/pdf':
            return 'bi bi-file-earmark-pdf';
        case 'application/msword':
        case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
            return 'bi bi-file-earmark-word';
        case 'application/vnd.ms-excel':
        case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
            return 'bi bi-file-earmark-excel';
        case 'application/zip':
            return 'bi bi-file-earmark-zip';
        case 'text/plain':
            return 'bi bi-file-earmark-text';
        case 'image/jpeg':
        case 'image/png':
            return 'bi bi-file-earmark-image';
        case 'video/mp4':
            return 'bi bi-file-earmark-play';
        default:
            return 'bi bi-file-earmark';
    }
}

function formatRouteName(string $routeName): string
{
    $formattedName = explode('.', $routeName)[0];
        $formattedName = str_replace('_', ' ', $formattedName);
        $formattedName = ucwords($formattedName);
        $words = explode(' ', $formattedName);
        $words[count($words) - 1] = \Illuminate\Support\Str::singular($words[count($words) - 1]);
        return implode(' ', $words);
}

function formatDuration($startDate, $endDate = null) {
    if (empty($startDate)) {
        return 'Not Available';
    }
    
    try {
        if (!($startDate instanceof \Carbon\Carbon)) {
            $startDate = \Carbon\Carbon::parse($startDate);
        }
        
        if (empty($endDate)) {
            $endDate = now();
            $isOngoing = true;
        } else {
            if (!($endDate instanceof \Carbon\Carbon)) {
                $endDate = \Carbon\Carbon::parse($endDate);
            }
            $isOngoing = false;
        }
        
        if ($startDate->gt($endDate)) {
            return 'Invalid date range';
        }
        
        $interval = $startDate->diff($endDate);
        $years = (int)$interval->format('%y');
        $months = (int)$interval->format('%m');
        $days = (int)$interval->format('%d');
        
        $parts = [];
        
       if ($years >= 1) {
            $parts[] = $years . ' ' . ($years > 1 ? 'years' : 'year');
            
            if ($months > 0) {
                $parts[] = $months . ' ' . ($months > 1 ? 'months' : 'month');
            }
            
            if ($days > 0) {
                $parts[] = $days . ' ' . ($days > 1 ? 'days' : 'day');
            }
        }
        elseif ($months >= 1) {
            $parts[] = $months . ' ' . ($months > 1 ? 'months' : 'month');
            
            if ($days > 0) {
                $parts[] = $days . ' ' . ($days > 1 ? 'days' : 'day');
            }
        }
        elseif ($days >= 1) {
            $parts[] = $days . ' ' . ($days > 1 ? 'days' : 'day');
        }
        else {
            $parts[] = '1 day';
        }
        
        $duration = implode(', ', $parts);
        
        if ($isOngoing) {
            $duration .= ' (ongoing)';
        }
        
        return $duration;
    } catch (\Exception $e) {
        return 'Calculation Error: ' . $e->getMessage();
    }
}

function setting($key, $module = 'main', $default = null)
{
    return Setting::get($key, $module, $default);
}

function category($key, $module = 'main', $default = [])
{
    return Setting::getCategory($key, $module, $default);
}

function categories($module = 'main')
{
    return Setting::getAllCategories($module);
}