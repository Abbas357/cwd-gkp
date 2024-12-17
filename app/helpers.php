<?php 

function getProfilePic(App\Models\User $user): string
{
    $url = asset($user->getFirstMediaUrl('profile_pictures', 'thumb'));
    if (!isset(pathinfo($url)['extension']) || !in_array(strtolower(pathinfo($url)['extension']), ['jpg', 'jpeg', 'png', 'gif'])) {
        $defaultLogoPath = public_path('admin/images/no-profile.png');
        $defaultLogoData = file_get_contents($defaultLogoPath);
        $base64 = 'data:image/png;base64,' . base64_encode($defaultLogoData);
        return $base64;
    }
    return $url;
}

function categoryType()
{
    return [
        'position', 'designation', 'office', 'file_type', 'download_category', 'contractor_category',
        'provincial_entity', 'gallery_type', 'news_category', 'page_type', 'tender_domain',
    ];
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