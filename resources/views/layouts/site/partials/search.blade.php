@if($newsResults->isEmpty())
    <p class="cw-no-results">No results found.</p>
@else
    <ul class="cw-search-results">
        @foreach($newsResults as $news)
            <li class="cw-search-item">
                <img src="{{ $news->image_url }}" alt="{{ $news->title }}" class="cw-search-item-image" />
                <a href="{{ route('news.show', $news->slug) }}" class="cw-search-item-content">
                    <h3 class="fs-5 cw-search-item-title">{{ $news->title }}</h3>
                    <p class="cw-search-item-summary">{{ $news->summary }}</p>
                </a>
            </li>
        @endforeach
    </ul>
@endif