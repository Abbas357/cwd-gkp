<?php

namespace App\Helpers;

use Spatie\MediaLibrary\Support\PathGenerator\PathGenerator;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

use Illuminate\Support\Str;

class CustomPathGenerator implements PathGenerator
{

    public function getPath(Media $media): string
    {
        return $media->collection_name . '/'; 
    }

    public function getPathForConversions(Media $media): string
    {
        return $this->getPath($media) . 'conversions/';
    }

    public function getPathForResponsiveImages(Media $media): string
    {
        return $this->getPath($media) . 'responsive-images/';
    }

    public function getCustomFileName(Media $media): string
    {
        $extension = $media->getExtensionAttribute();
        $uniqueId = substr(uniqid(), -6);
        $date = now()->format('d-m-Y');
        $singularCollection = Str::singular($media->collection_name);
        return $singularCollection . '_' . $uniqueId . '_' . $date . '.' . $extension;
    }
}

