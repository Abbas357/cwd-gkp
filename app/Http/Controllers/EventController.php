<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\SiteNotification;
use Yajra\DataTables\DataTables;
use App\Http\Requests\StoreEventRequest;

class EventController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', null);

        $events = Event::query()->withoutGlobalScope('published');

        $events->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        });

        if ($request->ajax()) {
            $dataTable = Datatables::of($events)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return view('admin.events.partials.buttons', compact('row'))->render();
                })
                ->editColumn('status', function ($row) {
                    return view('admin.events.partials.status', compact('row'))->render();
                })
                ->editColumn('start_datetime', function ($row) {
                    return \Carbon\Carbon::parse($row->start_datetime)->format('d, M Y (h:i A)');
                })
                ->editColumn('end_datetime', function ($row) {
                    return \Carbon\Carbon::parse($row->end_datetime)->format('d, M Y (h:i A)');
                })                
                ->addColumn('uploaded_by', function ($row) {
                    return $row->user?->position 
                    ? '<a href="'.route('admin.users.show', $row->user->id).'" target="_blank">'.$row->user->position.'</a>' 
                    : ($row->user?->designation ?? 'N/A');
                })
                ->editColumn('created_at', function ($row) {
                    return $row->created_at->format('j, F Y');
                })
                ->editColumn('updated_at', function ($row) {
                    return $row->updated_at->diffForHumans();
                })
                ->rawColumns(['action', 'status', 'uploaded_by']);

            if (!$request->input('search.value') && $request->has('searchBuilder')) {
                $dataTable->filter(function ($query) use ($request) {
                    $sb = new \App\Helpers\SearchBuilder($request, $query);
                    $sb->build();
                });
            }

            return $dataTable->toJson();
        }

        return view('admin.events.index');
    }

    public function create()
    {
        $stats = [
            'totalCount' => Event::withoutGlobalScope('published')->count(),
            'publishedCount' => Event::withoutGlobalScope('published')->where('status', 'published')->whereNotNull('published_at')->count(),
            'archivedCount' => Event::withoutGlobalScope('published')->where('status', 'archived')->count(),
            'unPublishedCount' => Event::withoutGlobalScope('published')->where('status', 'draft')->count(),
        ];
        $cat = [
            'participants_type' => ['Contractors', 'Internal Officers', 'Consultants', 'Secretaries', 'Engineers', 'Public'],
            'event_type' => ['review_meeting', 'conference', 'workshop', 'seminar', 'webinar', 'training'],
        ];
        return view('admin.events.create', compact('stats', 'cat'));
    }

    public function store(StoreEventRequest $request)
    {
        $event = new Event();
        $event->title = $request->title;
        $event->slug = Str::uuid();
        $event->description = $request->description;
        $event->start_datetime = $request->start_datetime;
        $event->end_datetime = $request->end_datetime;
        $event->location = $request->location;
        $event->organizer = $request->organizer;
        $event->chairperson = $request->chairperson;
        $event->participants_type = $request->participants_type;
        $event->no_of_participants = $request->no_of_participants;
        $event->event_type = $request->event_type;
        $event->status = 'draft';

        $images = $request->file('images');

        if ($images) {
            foreach ($images as $image) {
                $event->addMedia($image)->toMediaCollection('events_pictures');
            }
        }

        if ($request->user()->events()->save($event)) {
            return redirect()->route('admin.events.create')->with('success', 'Event Added successfully');
        }
        return redirect()->route('admin.events.create')->with('error', 'There is an error adding the event');
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function publishEvent(Request $request, Event $event)
    {
        if ($event->status === 'draft') {
            $event->published_at = now();
            $event->status = 'published';
            $message = 'Event has been published successfully.';            
        } else {
            $event->status = 'draft';
            $message = 'Event has been unpublished.';
        }
        $event->published_by = $request->user()->id;
        $event->save();
        return response()->json(['success' => $message], 200);
    }

    public function archiveEvent(Request $request, Event $event)
    {
        if (!is_null($event->published_at)) {
            $event->status = 'archived';
            $event->save();
            return response()->json(['success' => 'Event has been archived successfully.'], 200);
        }
        return response()->json(['success' => 'Event cannot be archived.'], 403);
    }

    public function showDetail(Event $event)
    {
        if (!$event) {
            return response()->json([
                'success' => false,
                'data' => [
                    'result' => 'Unable to load Event Detail',
                ],
            ]);
        }

        $cat = [
            'participants_type' => ['Contractors', 'Internal Officers', 'Consultants', 'Secretaries', 'Engineers', 'Public'],
            'event_type' => ['review_meeting', 'conference', 'workshop', 'seminar', 'webinar', 'training'],
        ];

        $html = view('admin.events.partials.detail', compact('event', 'cat'))->render();
        return response()->json([
            'success' => true,
            'data' => [
                'result' => $html,
            ],
        ]);
    }

    public function updateField(Request $request, Event $event)
    {
        $request->validate([
            'field' => 'required|string',
            'value' => 'required|string',
        ]);

        if (in_array($event->status, ['published', 'archived'])) {
            return response()->json(['error' => 'Published or Archived events cannot be updated'], 403);
        }

        $event->{$request->field} = $request->value;

        if ($event->isDirty($request->field)) {
            $event->save();
            return response()->json(['success' => 'Field updated successfully'], 200);
        }

        return response()->json(['error' => 'No changes were made to the field'], 200);
    }
    
    public function destroy(Event $event)
    {
        if (request()->user()->isAdmin() || ($event->status === 'draft' && is_null($event->published_at))) {
            if ($event->delete()) {
                return response()->json(['success' => 'Event has been deleted successfully.']);
            }
        }
        return response()->json(['error' => 'Published, Archived, or Draft events that were once published cannot be deleted.']);
    }

    public function updateComments(Request $request, Event $Event)
    {
        $validated = $request->validate([
            'comments_allowed' => 'required|boolean',
        ]);

        $Event->update($validated);

        return response()->json([
            'success' => 'Comments visibility updated',
        ]);
    }
}
