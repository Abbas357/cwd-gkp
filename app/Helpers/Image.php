<?php

namespace App\Helpers;

class Image
{
    public static function generateBackgroundColor($id): string
    {
        $baseId = strlen((string)$id) > 2 
            ? intval(substr((string)$id, -2)) 
            : $id;

        $r = ($baseId * 17) % 256;
        $g = ($baseId * 23) % 256;
        $b = ($baseId * 29) % 256;

        return sprintf('%02x%02x%02x', $r, $g, $b);
    }

    public static function getAvatar($name, $id, $options = []): string
    {
        $defaultOptions = [
            'name' => $name,
            'size' => 50,
            'background' => self::generateBackgroundColor($id),
            'color' => 'ffffff',
            'rounded' => true,
            'bold' => true,
        ];

        $queryParams = array_merge($defaultOptions, $options);
        
        return 'https://ui-avatars.com/api/?' . http_build_query($queryParams);
    }
}