<?php
namespace App\Notifications\Site;

class ProjectPublished
{
    public function __construct(
        public string $title,
        public string $description,
        public string $url
    ) {}

    public function toArray()
    {
        return [
            'type' => 'Project',
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
        ];
    }
}