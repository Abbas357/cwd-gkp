<x-main-layout title="The card is {{ $service_card->status === 'Verified' ? 'Verified' : 'Not Verified' }}">
    @push('style')
        <style>
            .avatar {
                width: 150px;
                border-radius: 50%;               
            }
        </style>
    @endpush
    <div class="container mt-2">
        <x-slot name="breadcrumbTitle">
            Card Details
        </x-slot>
    
        <x-slot name="breadcrumbItems">
            <li class="breadcrumb-item active">Service Card</li>
        </x-slot>

        <div class="row card-details">
            <div class="d-flex justify-content-between align-items-center no-print">
                <h2 class="mb-4"></h2>
                <button type="button" id="print-card" class="btn btn-light text-gray-900 border border-gray-300 float-end me-2 mb-2">
                    <span class="d-flex align-items-center">
                        <i class="bi-print"></i>
                        Print
                    </span>
                </button>
            </div>

            <div class="d-flex justify-content-center align-items-center">
                <img src="{{ $service_card->getFirstMediaUrl('service_card_pictures') }}"alt="avatar" class="avatar">
            </div>
            <h3 class="display-3 fs-3 text-center"> {{ $service_card->name }}</h3>
            <h3 class="fs-6 text-center"> {{ $service_card->designation }} ({{ $service_card->bps }})</h3>
            <hr />

            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th>Status</th>
                        <td>{!! $service_card->status === 'Verified' ? '<span class="badge fs-6 bg-success">Verified</span>' : '<span class="badge fs-6 bg-danger">Not Verified</span>' !!}</td>
                    </tr>
                    @if($service_card->status === 'Verified')
                    <tr>
                        <th>Issue Date</th>
                        <td>{{ $service_card->updated_at->format('d-M-Y') }} ({{ $service_card->updated_at->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Expiration Date</th>
                        <td>{{ $service_card->updated_at ->copy()->modify('+3 years')->format('d-M-Y') }} ({{ $service_card->updated_at->copy()->modify('+3 years')->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $service_card->name }}</td>
                    </tr>
                    <tr>
                        <th>Designation</th>
                        <td>{{ $service_card->designation }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $service_card->present_address }}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{ $service_card->mobile_number }}</td>
                    </tr>
                    <tr>
                        <th>Landline Number</th>
                        <td>{{ $service_card->landline_number }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $service_card->email }}</td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        @push('script')
        <script src="{{ asset('admin/plugins/printThis/printThis.js') }}"></script>
        <script>
            $('#print-card').on('click', () => {
                $(".card-details").printThis({
                    pageTitle: "Card details of {{ $service_card->name }}"
                });
            });

        </script>
        @endpush
</x-main-layout>
