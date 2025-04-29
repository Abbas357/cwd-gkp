<x-main-layout title="{{ $tenderData['title'] }}">

    <x-slot name="breadcrumbTitle">
        {{ $tenderData['title'] }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('tenders.index') }}">Tenders</a></li>
    </x-slot>

    <div class="container mt-3">
        <p style="text-align: right"><strong>Views:</strong> {{ $tenderData['views_count'] }}</p>
        <div class="card">
            <div class="card-body">
                <table class="table table-bordered table-striped mt-4">
                    <tbody>
                        @if (!empty($tenderData['published_by']) || !empty($tenderData['published_at']))
                        <tr>
                            <th>Date of Advertisement</th>
                            <td>{{ $tenderData['date_of_advertisement'] ?? 'Not Provided' }}</td>
                        </tr>
                        <tr>
                            <th>Closing Date</th>
                            <td>{{ $tenderData['closing_date'] ?? 'Not Provided' }}</td>
                        </tr>
                        <tr>
                            <th>Office</th>
                            <td>{{ $tenderData['user'] ?? 'Not Provided' }}</td>
                        </tr>
                        <tr>
                            <th>Published By</th>
                            <td>{{ $tenderData['published_by'] ?? 'Not Provided' }}</td>
                        </tr>
                        <tr>
                            <th>Published At</th>
                            <td>{{ $tenderData['published_at'] ?? 'Not Provided' }}</td>
                        </tr>
                        @endif

                        <tr>
                            <th>Description</th>
                            <td>{!! nl2br($tenderData['description']) !!}</td>
                        </tr>

                        {{-- Tender Documents --}}
                        <tr>
                            <th>Tender Documents</th>
                            <td>
                                <ul class="list-group">
                                    @forelse ($tenderData['tender_documents'] as $doc)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ $doc['url'] }}" target="_blank">
                                           <i class="{{ getDocumentIcon($doc['type']) }} text-danger"></i> {{ $doc['name'] }} 
                                        </a>
                                    </li>
                                    @empty
                                    No Tender Documents
                                    @endforelse
                                </ul>
                            </td>
                        </tr>

                        {{-- EOI Documents --}}
                        <tr>
                            <th>EOI Documents</th>
                            <td>
                                <ul class="list-group">
                                    @forelse ($tenderData['tender_eoi_documents'] as $doc)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ $doc['url'] }}" target="_blank">
                                            <i class="{{ getDocumentIcon($doc['type']) }} text-danger"></i> {{ $doc['name'] }}
                                        </a>
                                    </li>
                                    @empty
                                    No EOI Documents
                                    @endforelse
                                </ul>
                            </td>
                        </tr>

                        {{-- Bidding Documents --}}
                        <tr>
                            <th>Bidding Documents</th>
                            <td>
                                <ul class="list-group">
                                    @forelse ($tenderData['bidding_documents'] as $doc)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <a href="{{ $doc['url'] }}" target="_blank">
                                            <i class="{{ getDocumentIcon($doc['type']) }} text-danger"></i> {{ $doc['name'] }}
                                        </a>
                                    </li>
                                    @empty
                                    No Bidding Documents
                                    @endforelse
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>

                @if (empty($tenderData['tender_documents']) && empty($tenderData['tender_eoi_documents']) && empty($tenderData['bidding_documents']))
                <p>No documents available.</p>
                @endif
            </div>
        </div>
    </div>

    <x-sharer :title="$tenderData['title'].' - '.config('app.name')" :url="url()->current()" />

    {{-- <x-comments :comments="$tenderData['comments']" modelType="Tender" :modelId="$tenderData['id']" /> --}}

</x-main-layout>
