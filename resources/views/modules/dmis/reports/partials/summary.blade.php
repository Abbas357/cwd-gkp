<table id="generated-report" class="table table-bordered generated-report">
    <caption class="report-metadata">
        <div>
            <h5>
                <strong>{{ $type ?? "Road" }}s Summary</strong> Report
                @if(isset($startDate) && isset($endDate) && $startDate && $endDate)
                    @if($startDate->format('Y-m-d') === $endDate->format('Y-m-d'))
                        <span class="text-muted"> Date: <strong>{{ $startDate->format('F d, Y (l)') }}</strong></span>
                    @else
                        <span class="text-muted"> from <strong>{{ $startDate->format('F d, Y') }} </strong> to <strong> {{ $endDate->format('F d, Y') }} </strong></span>
                    @endif
                @else
                    <span class="text-muted"> (Dated: <strong>{{ now()->format('F d, Y') . ' - ' . now()->format('l') }}</strong>)</span>
                @endif
            </h5>
        </div>
        
        <div><h6><strong>Office:</strong> {{ $selectedUser->currentOffice->name ?? '-' }}</h6></div>
    </caption>
    <thead>
        <tr class="bg-success text-white text-uppercase fw-bold">
            <th scope="col" class="text-center align-middle" rowspan="2">S#</th>
            <th scope="col" class="text-center align-middle" rowspan="2">Officer</th>
            <th scope="col" class="text-center align-middle" rowspan="2">District</th>
            <th scope="colgroup" class="text-center align-middle bg-light" colspan="4">
                Damaged {{ $type ?? 'Road' }}s {{ $type == 'Road' || !request()->has('type') ? '(KM)' : '(Meter)' }}
            </th>
            <th scope="colgroup" class="text-center align-middle bg-light" colspan="3">
                {{ $type ?? 'Road' }} Status
            </th>
            @if($costInfo)
            <th scope="colgroup" class="text-center align-middle bg-light" colspan="2">
                Approximate Cost (Millions)
            </th>
            @endif
        </tr>
        <tr class="bg-success bg-opacity-75 text-white text-uppercase fw-bold">
            <th scope="col" class="text-center align-middle">
                Effected {{ $type ?? 'Road' }}s
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
                Fully Restored<br>
                <small class="help-text">(Open to all traffic)</small>
            </th>
            <th scope="col" class="text-center align-middle">
                Partially Restored<br>
                <small class="help-text">(Open to light traffic)</small>
            </th>
            <th scope="col" class="text-center align-middle">
                Not Restored<br>
                <small class="help-text">(Closed for traffic)</small>
            </th>
            @if($costInfo)
            <th scope="col" class="text-center align-middle">
                Restoration
            </th>
            <th scope="col" class="text-center align-middle">
                Rehabilitation
            </th>
            @endif
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
                                <div class="officer-office">{{ $subordinate?->currentOffice?->name ?? 'No Office' }}
                                </div>
                                <div class="officer-name" style="font-size:.7rem">({{ $subordinate->name }})</div>
                            </td>
                        @endif
                    @endif
                    <td class="text-center fw-medium">{{ $district->name }}</td>
                    <td class="text-center fw-medium"><a
                            href="{{ route('admin.apps.dmis.reports.district-details', ['district' => $district->id, 'type' => $type ?? 'Road', 'user' => $subordinate->id]) }}">{{ $district->damaged_infrastructure_count }}</a>
                    </td>
                    <td class="text-center fw-medium">{{ $district->damage_count }}</td>
                    <td class="text-center fw-medium">{{ number_format($district->damaged_infrastructure_total_count, 2) }}</td>
                    <td class="text-center fw-medium">{{ number_format($district->damaged_infrastructure_sum, 2) }}</td>
                    <td class="text-center fw-medium">{{ $district->fully_restored }}</td>
                    <td class="text-center fw-medium">{{ $district->partially_restored }}</td>
                    <td class="text-center fw-medium">{{ $district->not_restored }}</td>
                    @if($costInfo)
                    <td class="text-center fw-medium">{{ number_format($district->restoration, 2) }}</td>
                    <td class="text-center fw-medium">{{ number_format($district->rehabilitation, 2) }}</td>
                    @endif
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
                <th class="bg-light text-center">{{ number_format($total['totalDamagedInfrastructureTotalCount'], 2) }}
                </th>
                <th class="bg-light text-center">{{ number_format($total['totalDamagedInfrastructureSum'], 2) }}</th>
                <th class="bg-light text-center">{{ $total['totalFullyRestored'] }}</th>
                <th class="bg-light text-center">{{ $total['totalPartiallyRestored'] }}</th>
                <th class="bg-light text-center">{{ $total['totalNotRestored'] }}</th>
                @if($costInfo)
                <th class="bg-light text-center">{{ number_format($total['totalRestorationCost'], 2) }}</th>
                <th class="bg-light text-center">{{ number_format($total['totalRehabilitationCost'], 2) }}</th>
                @endif
            </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <td colspan="12">
                <span style="display: block; margin-top: 5px; font-size: 10px; text-align: center; color: #777;">
                    This is a system-generated report from Damage Management Information System (DMIS), C&W Department. All efforts have been made to ensure accuracy; however, errors and omissions are excepted.
                </span>
            </td>
        </tr>
    </tfoot>
</table>

@if (count($subordinatesWithDistricts) == 0)
    <div class="alert alert-info text-center">
        <i class="bi-info-circle me-2"></i>
        No damages found for the selected criteria. Try changing your filters or select a different officer.
    </div>
@endif
