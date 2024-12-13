<?php
namespace App\Notifications\Site;

class SeniorityPublished
{
    public function __construct(
        public string $title,
        public string $description,
        public string $url
    ) {}

    public function toArray()
    {
        return [
            'type' => 'Seniority',
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
        ];
    }
}