<?php
namespace App\Notifications\Site;

class DownloadPublished
{
    public function __construct(
        public string $title,
        public string $description,
        public string $url
    ) {}

    public function toArray()
    {
        return [
            'type' => 'Download',
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
        ];
    }
}