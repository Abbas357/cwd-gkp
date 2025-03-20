<?php 

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
        'position', 'designation', 'office', 'file_type', 'download_category', 'contractor_category',
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