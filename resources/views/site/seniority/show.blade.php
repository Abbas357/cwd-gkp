<x-main-layout title="{{ $seniorityData['title'] }}">

    @push('style')
    <link rel="stylesheet" href="{{ asset('admin/plugins/lightbox/lightbox.min.css') }}" />
    @endpush

    <x-slot name="breadcrumbTitle">{{ $seniorityData['title'] }}</x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('seniority.index') }}">Seniority List</a></li>
        <li class="breadcrumb-item active">{{ $seniorityData['title'] }}</li>
    </x-slot>

    <div class="container mt-4">
        <p style="text-align: right"><strong>Views:</strong> {{ $seniorityData['views_count'] }}</p>
        <!-- Seniority Details Table -->
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <th>Title</th>
                        <td>{{ $seniorityData['title'] }}</td>
                    </tr>
                    <tr>
                        <th>Designation</th>
                        <td>{{ $seniorityData['designation'] }}</td>
                    </tr>
                    <tr>
                        <th>BPS</th>
                        <td>{{ $seniorityData['bps'] }}</td>
                    </tr>
                    <tr>
                        <th>Seniority Date</th>
                        <td>{{ $seniorityData['seniority_date'] }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Attachment (Media) Section with Lightbox -->
        @if ($seniorityData['attachment'])
        <div class="mt-4">
            <h5>Attachment</h5>
            <a href="{{ $seniorityData['attachment'] }}" download>
                Download Attachment
            </a>
        </div>
        @endif
    </div>

    @push('script')
    <script src="{{ asset('admin/plugins/lightbox/lightbox.min.js') }}"></script>
    <script>
        lightbox.option({
            'resizeDuration': 200,
            'wrapAround': true,
            'disableScrolling': true,
        });
    </script>
    @endpush

</x-main-layout>