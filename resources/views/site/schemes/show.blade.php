<x-main-layout title="Scheme Details">

    @push('style')
    <link rel="stylesheet" href="{{ asset('site/lib/lightbox/lightbox.min.css') }}" />
    <style>
        table,
        td,
        th {
            vertical-align: middle;
        }

        .scheme-table th {
            background-color: #f7f7f7;
            color: #333;
            font-weight: 600;
            text-align: left;
            padding: 12px 15px;
        }

        .scheme-table td {
            background-color: #fff;
            color: #555;
            padding: 12px 15px;
        }

        .card-body {
            padding: 20px;
            background-color: #fff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .mb-4 {
            margin-bottom: 1.5rem;
        }

        .table-responsive {
            margin-top: 20px;
        }

        .img-fluid {
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .comment-body {
            min-height: 60px;
            resize: none;
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            width: 100%;
        }

        .cw-btn {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }

        .cw-btn:hover {
            background-color: #0056b3;
        }

        .comments-section {
            margin-top: 30px;
        }

        .comment-card {
            background-color: #f7f7f7;
            border-radius: 8px;
            margin-bottom: 15px;
        }

    </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        {{ $scheme->scheme_name }}
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item"><a href="{{ route('schemes.index') }}">Schemes</a></li>
    </x-slot>

    <div class="container mt-3">

        <div class="d-flex justify-content-between">
            <p><strong>Scheme Code</strong> {{ $scheme->scheme_code }}</p>
            <p><strong>Views:</strong> {{ $scheme->views_count }}</p>
        </div>

        <div class="table-responsive mt-4">
            <table class="table scheme-table">
                <tbody>
                    @if(!empty($scheme->adp_number))
                    <tr>
                        <th>ADP Number</th>
                        <td>{{ $scheme->adp_number }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->year))
                    <tr>
                        <th>Year</th>
                        <td>{{ $scheme->year }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->scheme_name))
                    <tr>
                        <th>Scheme Name</th>
                        <td>{{ $scheme->scheme_name }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->sector_name))
                    <tr>
                        <th>Sector Name</th>
                        <td>{{ $scheme->sector_name }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->sub_sector_name))
                    <tr>
                        <th>Sub-Sector Name</th>
                        <td>{{ $scheme->sub_sector_name }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->local_cost))
                    <tr>
                        <th>Local Cost</th>
                        <td>&#8360; {{ number_format($scheme->local_cost, 3) }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->foreign_cost))
                    <tr>
                        <th>Foreign Cost</th>
                        <td>&#8360; {{ number_format($scheme->foreign_cost, 3) }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->capital_allocation))
                    <tr>
                        <th>Capital Allocation</th>
                        <td>&#8360; {{ number_format($scheme->capital_allocation, 3) }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->revenue_allocation))
                    <tr>
                        <th>Revenue Allocation</th>
                        <td>&#8360; {{ number_format($scheme->revenue_allocation, 3) }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->total_allocation))
                    <tr>
                        <th>Total Allocation</th>
                        <td>&#8360; {{ number_format($scheme->total_allocation, 3) }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->f_allocation))
                    <tr>
                        <th>Foreign Allocation</th>
                        <td>&#8360; {{ number_format($scheme->f_allocation, 3) }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->revised_allocation))
                    <tr>
                        <th>Revised Allocation</th>
                        <td>&#8360; {{ number_format($scheme->revised_allocation, 3) }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->prog_releases))
                    <tr>
                        <th>Program Releases</th>
                        <td>&#8360; {{ number_format($scheme->prog_releases, 3) }}</td>
                    </tr>
                    @endif
                    @if(!empty($scheme->progressive_exp))
                    <tr>
                        <th>Progressive Expenditure</th>
                        <td>&#8360; {{ number_format($scheme->progressive_exp, 3) }}</td>
                    </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>

    <div class="container mt-4">
        <h5 class="sharer-title">Share this scheme</h5>
        @php
            $title = $scheme->scheme_name . ' - ' . config('app.name');
        @endphp
        <div class="sharer-container">
            <div class="sharer-button" data-sharer="email" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-envelope-fill"></i>
                <span>Email</span>
            </div>
            <div class="sharer-button" data-sharer="whatsapp" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-whatsapp"></i>
                <span>WhatsApp</span>
            </div>
            <div class="sharer-button" data-sharer="facebook" data-url="{{ url()->current() }}">
                <i class="bi bi-facebook"></i>
                <span>Facebook</span>
            </div>
            <div class="sharer-button" data-sharer="twitter" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-twitter-x"></i>
                <span>X</span>
            </div>
            <div class="sharer-button" data-sharer="threads" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-threads"></i>
                <span>Threads</span>
            </div>
            <div class="sharer-button" data-sharer="linkedin" data-url="{{ url()->current() }}">
                <i class="bi bi-linkedin"></i>
                <span>LinkedIn</span>
            </div>
            <div class="sharer-button" data-sharer="telegram" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-telegram"></i>
                <span>Telegram</span>
            </div>
            <div class="sharer-button" data-sharer="reddit" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-reddit"></i>
                <span>Reddit</span>
            </div>
            <div class="sharer-button" data-sharer="pinterest" data-title="{{ $title }}" data-url="{{ url()->current() }}">
                <i class="bi bi-pinterest"></i>
                <span>Pinterest</span>
            </div>
        </div>
    </div>

    @push('script')
    <script src="{{ asset('site/lib/sharer/sharer.min.js') }}"></script>
    @endpush

</x-main-layout>
