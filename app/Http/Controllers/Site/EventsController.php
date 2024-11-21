<?php

namespace App\Http\Controllers\Site;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventsController extends Controller
{
    public function index(Request $request)
    {
        $newsItems = Event::with(['media', 'user'])
            ->orderBy('published_at', 'desc')
            ->paginate(10);

        return view('site.events.index', compact('newsItems'));
    }

    public function showEvent($slug)
    {
        $event = Event::where('slug', $slug)
            ->with(['media', 'user'])
            ->firstOrFail();

        $mediaUrls = $event->getMedia('events_pictures')->map(function ($media) {
            return $media->getUrl();
        });

        $eventData = [
            'id' => $event->id,
            'title' => $event->title,
            'slug' => $event->slug,
            'start_datetime' => $event->start_datetime->format('M d, Y h:i A'),
            'end_datetime' => $event->end_datetime->format('M d, Y h:i A'),
            'location' => $event->location,
            'organizer' => $event->organizer,
            'chairperson' => $event->chairperson,
            'participants_type' => $event->participants_type,
            'no_of_participants' => $event->no_of_participants,
            'event_type' => $event->event_type,
            'published_by' => $event->user->designation,
            'published_at' => $event->published_at->format('M d, Y'),
            'description' => $event->description,
            'images' => $mediaUrls,
        ];

        return view('site.events.show', compact('eventData'));
    }
}
