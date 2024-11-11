<x-main-layout title="The card is {{ $user->card_status === 'verified' ? 'Verified' : 'Not Verified' }}">
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
                <img src="{{ getProfilePic($user) }}"alt="avatar" class="avatar">
            </div>
            <h3 class="display-3 fs-3 text-center"> {{ $user->name }}</h3>
            <h3 class="fs-6 text-center"> {{ $user->designation }} ({{ $user->bps }})</h3>
            <hr />

            <div class="col-md-12">
                <table class="table table-bordered">
                    <tr>
                        <th>Status</th>
                        <td>{!! $user->card_status === 'verified' ? '<span class="badge fs-6 bg-success">Verified</span>' : '<span class="badge fs-6 bg-danger">Not Verified</span>' !!}</td>
                    </tr>
                    @if($user->card_status === 'verified')
                    <tr>
                        <th>Issue Date</th>
                        <td>{{ $user->updated_at->format('d-M-Y') }} ({{ $user->updated_at->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Expiration Date</th>
                        <td>{{ $user->updated_at ->copy()->modify('+3 years')->format('d-M-Y') }} ({{ $user->updated_at->copy()->modify('+3 years')->diffForHumans() }})</td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td>{{ $user->name }}</td>
                    </tr>
                    <tr>
                        <th>Designation</th>
                        <td>{{ $user->designation }}</td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td>{{ $user->present_address }}</td>
                    </tr>
                    <tr>
                        <th>Mobile Number</th>
                        <td>{{ $user->mobile_number }}</td>
                    </tr>
                    <tr>
                        <th>Landline Number</th>
                        <td>{{ $user->landline_number }}</td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td>{{ $user->email }}</td>
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
                    pageTitle: "Card details of {{ $user->name }}"
                });
            });

        </script>
        @endpush
</x-main-layout>
