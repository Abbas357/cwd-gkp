<x-main-layout title="Tenders">
    @push('style')
    <style>
        table tbody tr {
            box-shadow: 2px 3px 5px #00000011, -2px -3px 5px #00000011;
        }

        table tr th, table tr td {
            vertical-align: middle
        }

        .tender-documents {
            width: 170px;
            height: 110px;
        }
    </style>
    @endpush

    <x-slot name="breadcrumbTitle">
        Tender
    </x-slot>

    <x-slot name="breadcrumbItems">
        <li class="breadcrumb-item active">Tender</li>
    </x-slot>

    <div class="container my-4">

        <div class="mb-4">
            <form method="GET" action="{{ route('tenders.index') }}">
                <div class="d-flex align-items-center">
                    <label for="category" class="me-2">Filter by Domain:</label>
                    <select name="category" id="category" class="form-select w-auto" onchange="this.form.submit()">
                        <option value="">All</option>
                        @foreach ($categories as $category)
                        <option value="{{ $category->name }}" {{ request('category') === $category->name ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>

        <!-- Tender Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-light">
                    <tr>
                        <th>Title</th>
                        <th>Procurement Entity</th>
                        <th>Office</th>
                        <th>Tender Domain</th>
                        <th>Published Date</th>
                        <th>Tender Documents</th>
                        <th>EOI Documents</th>
                        <th>Bidding Documents</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($tenders as $tender)
                    <tr>
                        <td> {{ $tender->title }} </td>
                        <td> {{ $tender->procurement_entity }} </td>
                        <td> {{ $tender->user->position }} </td>
                        <td> {{ $tender->domain }} </td>
                        <td> {{ $tender->published_at->format('j, F Y') }}
                        </td>
                        <td>
                            {{ $tender->getMedia('tender_documents')->isNotEmpty() ? 'Yes' : 'Not Available' }}
                        </td>
                        <td>
                            {{ $tender->getMedia('tender_eoi_documents')->isNotEmpty() ? 'Yes' : 'Not Available' }}
                        </td>
                        <td>
                            {{ $tender->getMedia('bidding_documents')->isNotEmpty() ? 'Yes' : 'Not Available' }}
                        </td>
                        <td>
                            <a href="{{ route('tenders.show', $tender->slug) }}" class="cw-btn" data-icon="bi-eye">View Detail</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $tenders->links() }}
        </div>
    </div>
</x-main-layout>
