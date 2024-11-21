@if(
    (isset($newsResults) && !$newsResults->isEmpty()) ||
    (isset($projectResults) && !$projectResults->isEmpty()) ||
    (isset($downloadResults) && !$downloadResults->isEmpty()) ||
    (isset($eventResults) && !$eventResults->isEmpty()) ||
    (isset($seniorityResults) && !$seniorityResults->isEmpty()) ||
    (isset($userResults) && !$userResults->isEmpty())
)
    @if(isset($newsResults) && !$newsResults->isEmpty())
        <h4 class="text-dark fs-4 px-3 py-1 border border-bottom bg-light">News</h4>
        <ul class="cw-search-results">
            @foreach($newsResults as $news)
                <li class="cw-search-item">
                    <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="cw-search-item-image" />
                    <a href="{{ route('news.show', $news->slug) }}" class="cw-search-item-content">
                        <h3 class="fs-5 cw-search-item-title">{{ $news->title }}</h3>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    @if(isset($projectResults) && !$projectResults->isEmpty())
        <h4 class="text-dark fs-4 px-3 py-1 border border-bottom bg-light">Projects</h4>
        <ul class="cw-search-results">
            @foreach($projectResults as $project)
                <li class="cw-search-item">
                    <a href="{{ route('development_projects.show', $project->slug) }}" class="cw-search-item-content">
                        <h3 class="fs-5 cw-search-item-title">{{ $project->name }}</h3>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    @if(isset($downloadResults) && !$downloadResults->isEmpty())
        <h4 class="text-dark fs-4 px-3 py-1 border border-bottom bg-light">Downloads</h4>
        <ul class="cw-search-results">
            @foreach($downloadResults as $download)
                <li class="cw-search-item d-flex justify-content-between align-items-center">
                    <p>{{ $download->file_name }}</p>
                    <a href="{{ $download->getFirstMediaUrl('downloads') }}" class="btn btn-light" style="white-space: nowrap">
                        <i class="bi-cloud-arrow-down"></i> Download
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    @if(isset($eventResults) && !$eventResults->isEmpty())
        <h4 class="text-dark fs-4 px-3 py-1 border border-bottom bg-light">Events</h4>
        <ul class="cw-search-results">
            @foreach($eventResults as $event)
                <li class="cw-search-item">
                    <a href="{{ route('events.show', $event->slug) }}" class="cw-search-item-content">
                        <h3 class="fs-5 cw-search-item-title">{{ $event->title }}</h3>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    @if(isset($seniorityResults) && !$seniorityResults->isEmpty())
        <h4 class="text-dark fs-4 px-3 py-1 border border-bottom bg-light">Seniority</h4>
        <ul class="cw-search-results">
            @foreach($seniorityResults as $seniority)
                <li class="cw-search-item">
                    <a href="{{ route('seniority.show', $seniority->slug) }}" class="cw-search-item-content">
                        <h3 class="fs-5 cw-search-item-title">{{ $seniority->title }}</h3>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

    @if(isset($userResults) && !$userResults->isEmpty())
        <h4 class="text-dark fs-4 px-3 py-1 border border-bottom bg-light">Team</h4>
        <ul class="cw-search-results">
            @foreach($userResults as $user)
                <li class="cw-search-item">
                    <a href="{{ url('/positions/' . $user->position . '/?id=' . $user->id . '&type=details') }}" class="cw-search-item-content">
                        <h3 class="fs-5 cw-search-item-title">
                            {{ $user->name }} 
                            ({{ $user->position ? $user->position : $user->designation }})
                        </h3>
                    </a>
                </li>
            @endforeach
        </ul>
    @endif

@else
    <p class="cw-no-results">No results found.</p>
@endif
