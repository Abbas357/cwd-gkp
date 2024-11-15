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
        'designation', 'office', 'file_type', 'file_category', 'contractor_category',
        'provincial_entity', 'gallery_type', 'news_category', 'page_type',
    ];
}