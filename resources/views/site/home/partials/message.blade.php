<style>
    .message .card-row {
        display: flex;
        gap: 20px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .message .card {
        display: flex;
        flex-direction: column;
        border: 1px solid #ddd;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        background-color: #fff;
        padding: 15px;
        width: 48%;
        min-width: 300px;
    }

    .message .card-body {
        display: flex;
        gap: 1rem;
        width: 100%;
    }

    .message .card-text {
        flex: 1;
        order: 1;
        text-align: justify;
    }

    .message .card-image {
        flex-basis: 30%;
        order: 2;
    }

    .message .card-image img {
        width: 100%;
        height: auto;
        border: 2px solid #ddd;
        border-radius: 5px;
        box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.15);
    }

    .show-more-inline {
        background: none;
        border: none;
        color: #007bff;
        cursor: pointer;
        font-size: 1rem;
        display: inline;
        margin-left: 5px;
    }

    .message .card-footer-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
        width: 100%;
        padding-top: 15px;
        border-top: 1px solid #ddd;
    }

    .message .view-previous {
        background-color: #007bff;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 4px;
    }

    .message .person-name {
        font-weight: bold;
        font-size: 1rem;
        color: #333;
    }

    @media (max-width: 768px) {
        .message .card-body {
            flex-direction: column;
            align-items: center;
        }

        .message .card-text {
            order: 2;
            width: 100%;
            text-align: justify;
        }

        .message .card-image {
            order: 1;
            width: 100%;
            margin-bottom: 10px;
        }

        .message .card-footer-row {
            flex-direction: column;
            align-items: center;
            gap: 5px;
        }
    }

</style>


<div class="card-row row">
    @if($ministerData)
    <div class="col card">
        <div class="card-body">
            <div class="card-text">
                <h4 class="card-title">{{ $ministerData['title'] }}</h4>
                <p class="message-text-content" data-full-text="{{ $ministerData['message'] }}">
                    {{ Str::limit($ministerData['message'], 100) }}
                </p>
                <button class="show-more-inline">Show More</button>
            </div>
            <div class="card-image">
                <img src="{{ $ministerData['image'] }}" alt="Minister Image" />
            </div>
        </div>
        <div class="card-footer-row">
            <a href="{{ route('positions.details', ['id' => $ministerData['id'] ]) }}">View Detail</a>
            <span class="person-name">{{ $ministerData['name'] }}</span>
        </div>
    </div>
    @endif

    @if($secretaryData)
    <div class="card">
        <div class="card-body">
            <div class="card-text">
                <h4 class="card-title">{{ $secretaryData['title'] }}</h4>
                <p class="message-text-content" data-full-text="{{ $secretaryData['message'] }}">
                    {{ Str::limit($secretaryData['message'], 100) }}
                </p>
                <button class="show-more-inline">Show More</button>
            </div>
            <div class="card-image">
                <img src="{{ $secretaryData['image'] }}" alt="Secretary Image" />
            </div>
        </div>
        <div class="card-footer-row">
            <a href="{{ route('positions.details', ['id' => $secretaryData['id'] ]) }}">View Detail</a>
            <span class="person-name">{{ $secretaryData['name'] }}</span>
        </div>
    </div>
    @endif

</div>
<script>
    const maxCharacters = 300;

    $('.message-text-content').each(function() {
        const $textContent = $(this);
        const fullText = $textContent.data('full-text');
        const $showMoreButton = $textContent.next();

        if (fullText.length > maxCharacters) {
            $textContent.text(fullText.slice(0, maxCharacters) + '...');
            $showMoreButton.show();

            $showMoreButton.on('click', function() {
                if ($textContent.text().endsWith('...')) {
                    $textContent.text(fullText);
                    $showMoreButton.text('Show Less');
                } else {
                    $textContent.text(fullText.slice(0, maxCharacters) + '...');
                    $showMoreButton.text('Show More');
                }
            });
        } else {
            $textContent.text(fullText);
            $showMoreButton.hide();
        }
    });

</script>
