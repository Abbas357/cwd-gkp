<div class="table-responsive">
    <table id="generated-report" class="table table-bordered generated-report">
        <caption class="report-metadata">
            <div>
                <h5><strong>Daily Situation Report </strong> on <strong
                        class="px-2 py-1 bg-light shadow-sm rounded border">{{ $type ?? 'Road' }}s</strong> dated
                    <strong>{{ \Carbon\Carbon::parse($reportDate)->format('F d, Y (l)') }}</strong></h5>
            </div>
            <div>
                <h6><strong>Office:</strong> {{ $selectedUser->currentOffice->name ?? '-' }}</h6>
            </div>
        </caption>
        <thead>
            <tr class="bg-danger text-white text-uppercase fw-bold">
                <th scope="col" class="text-center align-middle" rowspan="2">S#</th>
                <th scope="col" class="text-center align-middle" rowspan="2">Officer</th>
                <th scope="col" class="text-center align-middle" rowspan="2">District</th>
                <th scope="colgroup" class="text-center align-middle bg-light" colspan="4">
                    Daily Damages - {{ $type ?? 'Road' }}s
                    {{ $type == 'Road' || !request()->has('type') ? '(KM)' : '(Meter)' }}
                </th>
                <th scope="colgroup" class="text-center align-middle bg-light" colspan="3">
                    {{ $type ?? 'Road' }} Status (Today)
                </th>
                @if($costInfo)
                <th scope="colgroup" class="text-center align-middle bg-light" colspan="2">
                    Approximate Cost (Millions)
                </th>
                @endif
                <th scope="colgroup" class="text-center align-middle bg-warning text-dark" colspan="2">
                    Daily Activity
                </th>
            </tr>
            <tr class="bg-danger bg-opacity-75 text-white text-uppercase fw-bold">
                <th scope="col" class="text-center align-middle">
                    Affected {{ $type ?? 'Road' }}s
                </th>
                <th scope="col" class="text-center align-middle">
                    No. of Damages
                </th>
                <th scope="col" class="text-center align-middle">
                    Total Length
                </th>
                <th scope="col" class="text-center align-middle">
                    Damage Length
                </th>
                <th scope="col" class="text-center align-middle">
                    Fully Restored
                </th>
                <th scope="col" class="text-center align-middle">
                    Partially Restored
                </th>
                <th scope="col" class="text-center align-middle">
                    Not Restored
                </th>
                @if($costInfo)
                <th scope="col" class="text-center align-middle">
                    Restoration
                </th>
                <th scope="col" class="text-center align-middle">
                    Rehabilitation
                </th>
                @endif
                <th scope="col" class="text-center align-middle bg-warning text-dark">
                    New Today
                </th>
                <th scope="col" class="text-center align-middle bg-warning text-dark">
                    Updated Today
                </th>
            </tr>
        </thead>
        <tbody>
            @php $serial = 1; @endphp
            @foreach ($subordinatesWithDistricts as $index => $item)
                @php
                    $subordinate = $item['subordinate'];
                    $districts = $item['districts'];
                    $districtCount = $item['district_count'];
                @endphp

                @foreach ($districts as $districtIndex => $district)
                    <tr class="align-middle {{ $districtIndex % 2 == 0 ? 'bg-light' : '' }}">
                        @if ($districtIndex === 0)
                            <td class="text-center fw-medium" rowspan="{{ $districtCount }}">{{ $serial++ }}</td>
                            @if (isset($subordinateDesignation))
                                <td class="text-center fw-medium officer-cell" rowspan="{{ $districtCount }}">
                                    <div class="officer-office">
                                        {{ $subordinate?->currentOffice?->name ?? 'No Office' }}</div>
                                    <div class="officer-name">({{ $subordinate->name }})</div>
                                </td>
                            @endif
                        @endif
                        <td class="text-center fw-medium">{{ $district->name }}</td>
                        <td class="text-center fw-medium">
                            {{ $district->damaged_infrastructure_count }}
                        </td>
                        <td class="text-center fw-medium">{{ $district->damage_count }}</td>
                        <td class="text-center fw-medium">
                            {{ number_format($district->damaged_infrastructure_total_count, 2) }}</td>
                        <td class="text-center fw-medium">{{ number_format($district->damaged_infrastructure_sum, 2) }}
                        </td>
                        <td class="text-center fw-medium">{{ $district->fully_restored }}</td>
                        <td class="text-center fw-medium">{{ $district->partially_restored }}</td>
                        <td class="text-center fw-medium">{{ $district->not_restored }}</td>
                        @if($costInfo)
                        <td class="text-center fw-medium">{{ number_format($district->restoration, 2) }}</td>
                        <td class="text-center fw-medium">{{ number_format($district->rehabilitation, 2) }}</td>
                        @endif
                        <td class="text-center fw-medium">
                            <span class="badge bg-danger">{{ $district->new_damages_today ?? 0 }}</span>
                        </td>
                        <td class="text-center fw-medium">
                            <span class="badge bg-warning text-dark">{{ $district->updated_damages_today ?? 0 }}</span>
                        </td>
                    </tr>
                @endforeach
            @endforeach

            @if (count($subordinatesWithDistricts) > 0)
                <tr class="fw-bold">
                    <th class="bg-light text-center">Total</th>
                    @if (isset($subordinateDesignation))
                        <th class="bg-light text-center"></th>
                    @endif
                    <th class="bg-light text-center"></th>
                    <th class="bg-light text-center">{{ $total['totalDamagedInfrastructureCount'] }}</th>
                    <th class="bg-light text-center">{{ $total['totalDamageCount'] }}</th>
                    <th class="bg-light text-center">
                        {{ number_format($total['totalDamagedInfrastructureTotalCount'], 2) }}</th>
                    <th class="bg-light text-center">{{ number_format($total['totalDamagedInfrastructureSum'], 2) }}
                    </th>
                    <th class="bg-light text-center">{{ $total['totalFullyRestored'] }}</th>
                    <th class="bg-light text-center">{{ $total['totalPartiallyRestored'] }}</th>
                    <th class="bg-light text-center">{{ $total['totalNotRestored'] }}</th>
                    @if($costInfo)
                    <th class="bg-light text-center">{{ number_format($total['totalRestorationCost'], 2) }}</th>
                    <th class="bg-light text-center">{{ number_format($total['totalRehabilitationCost'], 2) }}</th>
                    @endif
                    <th class="bg-light text-center">
                        <span class="badge bg-danger">
                            {{ collect($subordinatesWithDistricts)->flatMap(fn($item) => $item['districts'])->sum('new_damages_today') }}
                        </span>
                    </th>
                    <th class="bg-light text-center">
                        <span class="badge bg-warning text-dark">
                            {{ collect($subordinatesWithDistricts)->flatMap(fn($item) => $item['districts'])->sum('updated_damages_today') }}
                        </span>
                    </th>
                </tr>
            @endif
        </tbody>
        <tfoot>
            <tr>
                <td colspan="14">
                    <span style="display: block; margin-top: 5px; font-size: 10px; text-align: center; color: #777;">
                        This is a system-generated report from Damage Management Information System (DMIS), C&W
                        Department. All efforts have been made to ensure accuracy; however, errors and omissions are
                        excepted.
                    </span>
                </td>
            </tr>
        </tfoot>
    </table>

    @if (count($subordinatesWithDistricts) == 0)
        <div class="alert alert-warning text-center">
            <i class="bi-calendar-x me-2"></i>
            No damage reports found for {{ \Carbon\Carbon::parse($reportDate)->format('F d, Y') }}.
            Try selecting a different date or officer.
        </div>
    @endif
</div>

@if (count($subordinatesWithDistricts) > 0)
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0"><i class="bi-info-circle me-2"></i>Daily Summary</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-md-3">
                            <div class="card border-danger">
                                <div class="card-body">
                                    <h6 class="text-danger">New Damages Today</h6>
                                    <h3 class="text-danger">
                                        {{ collect($subordinatesWithDistricts)->flatMap(fn($item) => $item['districts'])->sum('new_damages_today') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h6 class="text-warning">Updates Today</h6>
                                    <h3 class="text-warning">
                                        {{ collect($subordinatesWithDistricts)->flatMap(fn($item) => $item['districts'])->sum('updated_damages_today') }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h6 class="text-success">Total Restored</h6>
                                    <h3 class="text-success">{{ $total['totalFullyRestored'] }}</h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-primary">
                                <div class="card-body">
                                    <h6 class="text-primary">Cost (Millions)</h6>
                                    <h3 class="text-primary">
                                        {{ number_format($total['totalRestorationCost'] + $total['totalRehabilitationCost'], 2) }}
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
