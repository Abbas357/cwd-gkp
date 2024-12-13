<?php
namespace App\Notifications\Site;

class EventPublished
{
    public function __construct(
        public string $title,
        public string $description,
        public string $url
    ) {}

    public function toArray()
    {
        return [
            'type' => 'Event',
            'title' => $this->title,
            'description' => $this->description,
            'url' => $this->url,
        ];
    }
}