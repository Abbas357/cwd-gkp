<x-main-layout title="Contacts">
    <div class="container-fluid bg-breadcrumb">
        <div class="container text-center py-1" style="max-width: 900px;">
            <h3 class="text-secondary display-6 fw-bold mb-4">Contact List</h3>
            <ol class="breadcrumb justify-content-center mb-0">
                <li class="breadcrumb-item"><a href="{{ route('site') }}" class="text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active">Contacts</li>
            </ol>
        </div>
    </div>

    <div class="container my-3">
        <div class="row">
            <div class="col-md-3">
                <ul class="nav nav-pills flex-column bg-light rounded p-3 shadow-sm" id="officeTabs" role="tablist">
                    @foreach ($contactsByOffice as $office => $contacts)
                        <li class="nav-item mb-2" role="presentation">
                            <a class="nav-link @if($loop->first) active @endif text-center p-2 fw-bold" 
                               id="tab-{{ Str::slug($office) }}" 
                               data-bs-toggle="tab" 
                               href="#{{ Str::slug($office) }}" 
                               role="tab" 
                               aria-controls="{{ Str::slug($office) }}" 
                               aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                {{ $office }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="col-md-9">
                <div class="tab-content" id="officeTabContent">
                    @foreach ($contactsByOffice as $office => $contacts)
                        <div class="tab-pane fade @if($loop->first) show active @endif" 
                             id="{{ Str::slug($office) }}" 
                             role="tabpanel" 
                             aria-labelledby="tab-{{ Str::slug($office) }}">

                            <h4 class="mt-3 mb-3 text-primary">{{ $office }} Contacts</h4>

                            <div class="table-responsive">
                                <table class="table table-striped table-bordered shadow-sm">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>S#</th>
                                            <th>Name</th>
                                            <th>Designation</th>
                                            <th>Mobile Number</th>
                                            <th>Landline Number</th>
                                            <th>Social Media</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($contacts as $contact)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $contact->name }}</td>
                                                <td>{{ $contact->designation }}</td>
                                                <td>{{ $contact->mobile_number }}</td>
                                                <td>{{ $contact->landline_number }}</td>
                                                <td>
                                                    <div>
                                                    <a href="https://facebook.com/{{ $contact->facebook ?? '#'}}"><i class="bi bi-facebook fs-4 me-2"></i></a>
                                                    <a href="https://twitter.com/{{ $contact->twitter ?? '#'}}"><i class="bi bi-twitter fs-4 me-2"></i></a>
                                                    <a href="https://youtube.com/{{ $contact->whatsapp ?? '#'}}"><i class="bi bi-whatsapp fs-4 me-2"></i> </a>
                                                </div></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-main-layout>