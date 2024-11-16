<h4>{{ $category ?? 'Category' }} Downloads</h4>
<table class="table table-striped">
    <thead>
        <tr>
            <th>#</th>
            <th>File Name</th>
            <th>File Type</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($downloads as $download)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $download->file_name }}</td>
            <td>
                @php
                    $icons = [
                        'pdf' => 'bi-file-earmark-pdf',
                        'doc' => 'bi-file-earmark-word',
                        'docx' => 'bi-file-earmark-word',
                        'docs' => 'bi-file-earmark-word',
                        'image' => 'bi-file-earmark-image',
                        'xlsx' => 'bi-file-earmark-excel',
                    ];

                    $fileType = strtolower($download->file_type ?? 'default');
                    $iconClass = $icons[$fileType] ?? 'bi-file-earmark';
                @endphp
                <i class="bi {{ $iconClass }}"></i> 
                {{ $download->file_type ?? 'N/A' }}
            </td>
            <td>
                @if ($media = $download->getFirstMediaUrl('downloads'))
                <a href="{{ $media }}" class="btn btn-primary btn-sm btn-animate" style="white-space: nowrap">
                    <i class="bi-cloud-arrow-down"></i> Download
                </a>
                @else
                <span class="text-muted">No file available</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" class="text-center">No downloads available in this category.</td>
        </tr>
        @endforelse
    </tbody>
</table>
