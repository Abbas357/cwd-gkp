<?php
namespace App\Notifications\Site;

class GalleryPublished
{
    public function __construct(
        public string $title,
        public string $description,
        public string $url
    ) {}

    public function toArray()
    {
        return [
            'type' => 'Gallery',
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
        ];
    }
}