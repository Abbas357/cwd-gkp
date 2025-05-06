<h4 class="d-none">{{ $category ?? 'Category' }} Downloads</h4>
<table class="table table-striped table-hover mb-0">
    <thead class="table-secondary text-uppercase">
        <tr>
            <th>#</th>
            <th>File Name</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($downloads as $download)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>
                @php
                    $icons = [
                        'pdf' => 'bi-file-earmark-pdf text-danger',
                        'doc' => 'bi-file-earmark-word text-primary',
                        'docx' => 'bi-file-earmark-word text-primary',
                        'docs' => 'bi-file-earmark-word text-primary',
                        'image' => 'bi-file-earmark-image text-info',
                        'xlsx' => 'bi-file-earmark-excel text-success',
                        'xls' => 'bi-file-earmark-excel text-success',
                        'ppt' => 'bi-file-earmark-slides text-warning',
                        'pptx' => 'bi-file-earmark-slides text-warning',
                        'zip' => 'bi-file-earmark-zip text-secondary',
                        'txt' => 'bi-file-earmark-text text-dark',
                    ];
                    $fileType = strtolower($download->file_type ?? 'default');
                    $iconClass = $icons[$fileType] ?? 'bi-file-earmark';
                @endphp
                <span class="rounded bg-light p-1 me-3 border border-success shadow-sm">
                    <i class="bi {{ $iconClass }} file-icon"></i>
                    <span style="font-size:12px; color: #777"> .{{ $download->file_type ?? 'N/A' }} </span>
                </span>
                {{ $download->file_name }}
            </td>
            <td>
                @if ($media = $download->getFirstMediaUrl('downloads'))
                <a href="{{ $media }}" class="cw-btn bg-light text-dark" 
                   data-id="{{ $download->id }}" target="_blank">
                    <i class="bi-download me-1"></i> Download
                </a>
                @else
                <span class="text-muted">No file available</span>
                @endif
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center">No downloads available in this category.</td>
        </tr>
        @endforelse
    </tbody>
</table>