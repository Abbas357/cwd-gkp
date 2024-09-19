<?php

namespace App;

use Spatie\MediaLibrary\Support\FileNamer\DefaultFileNamer;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\MediaLibrary\Conversions\Conversion;
use Illuminate\Support\Str;

class CustomFileNamer extends DefaultFileNamer
{
    public function originalFileName(string $fileName): string
    {
        $baseName = pathinfo($fileName, PATHINFO_FILENAME);
        $uniqueId = substr(uniqid(), -6);
        $date = now()->format('d-m-Y');
        $newFileName = Str::lower(Str::limit($baseName, 10, ''));
        $newFileName = str_replace('-', '_', $newFileName);
        return "{$newFileName}_{$uniqueId}_{$date}";
    }

    public function conversionFileName(string $fileName, Conversion $conversion): string
    {
        $strippedFileName = pathinfo($fileName, PATHINFO_FILENAME);
        return "{$strippedFileName}-{$conversion->getName()}";
    }

    public function responsiveFileName(string $fileName): string
    {
        return pathinfo($fileName, PATHINFO_FILENAME);
    }
}
