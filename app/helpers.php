<?php 

function getProfilePic(App\Models\User $user): string
{
    $url = asset($user->getFirstMediaUrl('profile_pictures', 'thumb'));
    if (!isset(pathinfo($url)['extension']) || !in_array(strtolower(pathinfo($url)['extension']), ['jpg', 'jpeg', 'png', 'gif'])) {
        $defaultLogoPath = public_path('/images/no-profile.png');
        $defaultLogoData = file_get_contents($defaultLogoPath);
        $base64 = 'data:image/png;base64,' . base64_encode($defaultLogoData);
        return $base64;
    }
    return $url;
}