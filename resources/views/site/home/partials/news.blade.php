<style>
    .news-list-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 20px;
    }
    
    .news-list {
        display: flex;
        flex-direction: column;
        gap: 30px;
    }
    
    .news-list-item {
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        overflow: hidden;
        background-color: white;
        display: flex;
        flex-direction: row;
        width: 100%;
    }
    
    .news-list-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    }
    
    .news-list-img {
        position: relative;
        overflow: hidden;
        min-width: 220px;
        max-width: 220px;
        height: 120px;
    }
    
    .news-list-img img {
        transition: transform 0.5s ease;
        object-fit: cover;
        height: 100%;
        width: 100%;
    }
    
    .news-list-item:hover .news-list-img img {
        transform: scale(1.1);
    }
    
    .news-list-content-wrapper {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
        padding: 20px;
        position: relative;
    }
    
    .news-list-title-container {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 12px;
    }
    
    .news-list-title {
        font-weight: 700;
        font-size: 22px;
        color: #333;
        text-decoration: none;
        flex: 1;
        padding-right: 15px;
    }
    
    .news-list-title:hover {
        color: var(--cw-primary);
        text-decoration: underline
    }
    
    .news-list-meta {
        display: flex;
        gap: 20px;
        font-size: 14px;
        color: #6c757d;
    }
    
    .news-list-meta i {
        margin-right: 5px;
    }
    
    @media (max-width: 768px) {
        .news-list-item {
            flex-direction: column;
        }
        
        .news-list-img {
            min-width: 100%;
            max-width: 100%;
        }
        
        .news-list-title-container {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }
        
        .news-list-title {
            padding-right: 0;
        }
    }
</style>

<div class="news-list-container">
    <div class="news-list">
        @foreach ($allNews as $news)
        <div class="news-list-item">
            <div class="news-list-img">
                @if (str_starts_with($news['file_type'], 'image'))
                <img src="{{ $news['image'] }}" alt="{{ $news['title'] }}">
                @else
                <img src="{{ asset('site/images/no-image.jpg') }}" alt="File Placeholder">
                @endif
            </div>
            <div class="news-list-content-wrapper">
                <div class="news-list-title-container">
                    <a href="{{ route('news.show', $news['slug']) }}" class="news-list-title">{{ $news['title'] }}</a>
                    <div>
                        <a href="{{ route('news.show', $news['slug']) }}" class="cw-btn">
                            View Detail
                        </a>
                    </div>
                </div>
                <div class="news-list-meta">
                    <span><i class="bi bi-eye"></i>{{ $news['views_count'] }}</span>
                    <span><i class="bi bi-calendar-date"></i>{{ $news['published_at'] }}</span>
                    <span><i class="bi bi-person"></i>{{ $news['author'] }}</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <div class="text-center mt-4">
        <a href="{{ route('news.index') }}" class="cw-btn">See All News</a>
    </div>
</div>