<div class="table-responsive">
    <table id="generated-report" class="table table-bordered table-hover">
        <caption class="report-metadata">
            <div>
                <h5>
                    <strong>District Wise <span class="px-2 py-1 bg-light shadow-sm rounded border">{{ $type ?? "Road" }}s</span> Report</strong>
                    @if(isset($startDate) && isset($endDate))
                        @if($startDate->format('Y-m-d') === $endDate->format('Y-m-d'))
                            <span class="text-muted"> Date <strong>{{ $startDate->format('F d, Y (l)') }}</strong></span>
                        @else
                            <span class="text-muted"> from <strong>{{ $startDate->format('F d, Y') }} </strong> to <strong>{{ $endDate->format('F d, Y') }}</strong></span>
                        @endif
                    @else
                        <span class="text-muted">- Generated: <strong>{{ now()->format('F d, Y (l)') }}</strong></span>
                    @endif
                </h5>
            </div>
        </caption>
        <thead>`
            <tr class="bg-success text-white text-uppercase fw-bold">
                <th scope="col" class="text-center align-middle">Rank</th>
                <th scope="col" class="text-center align-middle">District</th>
                <th scope="col" class="text-center align-middle">Total {{ $type ?? 'Road' }}s</th>
                <th scope="col" class="text-center align-middle">Damaged {{ $type ?? 'Road' }}s</th>
                <th scope="col" class="text-center align-middle">Damage Reports</th>
                <th scope="col" class="text-center align-middle">Damaged Length</th>
                <th scope="col" class="text-center align-middle">Fully Restored</th>
                <th scope="col" class="text-center align-middle">Partially Restored</th>
                <th scope="col" class="text-center align-middle">Not Restored</th>
                <th scope="col" class="text-center align-middle">Restoration Cost(M)</th>
                <th scope="col" class="text-center align-middle">Rehabilitation Cost(M)</th>
                <th scope="col" class="text-center align-middle">Total Cost(M)</th>
                <th scope="col" class="text-center align-middle no-print">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($districtStats as $index => $stats)
                <tr class="align-middle">
                    <td class="text-center fw-bold">{{ $index + 1 }}</td>
                    <td class="district-cell">
                        <div class="district-name">{{ $stats['district']->name }}</div>
                    </td>
                    <td class="text-center">{{ $stats['infrastructure_count'] }}</td>
                    <td class="text-center">
                        @if ($stats['damaged_infrastructure_count'] > 0)
                            {{ $stats['damaged_infrastructure_count'] }}
                        @else
                            <span class="no-damage">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($stats['damage_count'] > 0)
                            {{ $stats['damage_count'] }}
                        @else
                            <span class="no-damage">-</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if ($stats['damaged_length'] > 0)
                            {{ number_format($stats['damaged_length'], 2) }}
                        @else
                            <span class="no-damage">0.00</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $stats['fully_restored'] }}</td>
                    <td class="text-center">{{ $stats['partially_restored'] }}</td>
                    <td class="text-center">{{ $stats['not_restored'] }}</td>
                    <td class="text-center">{{ number_format($stats['restoration_cost'], 2) }}</td>
                    <td class="text-center">{{ number_format($stats['rehabilitation_cost'], 2) }}</td>
                    <td class="text-center fw-bold">{{ number_format($stats['total_cost'], 2) }}</td>
                    <td class="text-center no-print">
                        <div class="action-buttons">
                            <a href="{{ route('admin.apps.dmis.reports.district-details', ['district' => $stats['district']->id, 'type' => $type]) }}"
                                class="btn btn-white border btn-detail" title="View Details">
                                <i class="bi-eye"></i>
                            </a>
                        </div>
                    </td>
                </tr>
            @endforeach

            <tr class="fw-bold total-row">
                <td colspan="2" class="text-end">Total:</td>
                <td class="text-center">{{ $total['total_infrastructure_count'] }}</td>
                <td class="text-center">{{ $total['total_damaged_infrastructure_count'] }}</td>
                <td class="text-center">{{ $total['total_damage_count'] }}</td>
                <td class="text-center">{{ number_format($total['total_damaged_length'], 2) }}</td>
                <td class="text-center">{{ $total['total_fully_restored'] }}</td>
                <td class="text-center">{{ $total['total_partially_restored'] }}</td>
                <td class="text-center">{{ $total['total_not_restored'] }}</td>
                <td class="text-center">{{ number_format($total['total_restoration_cost'], 2) }}</td>
                <td class="text-center">{{ number_format($total['total_rehabilitation_cost'], 2) }}</td>
                <td class="text-center">{{ number_format($total['total_cost'], 2) }}</td>
                <td class="text-center no-print">-</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="13">
                    <span style="display: block; margin-top: 5px; font-size: 10px; text-align: center; color: #777;">
                        This is a system-generated report from Damage Management Information System (DMIS), C&W
                        Department. All efforts have been made to ensure accuracy; however, errors and omissions are
                        excepted.
                    </span>
                </td>
            </tr>
        </tfoot>
    </table>

    @if ($districtStats->isEmpty())
        <div class="alert alert-info text-center">
            <i class="bi-info-circle me-2"></i>
            No data available for the selected criteria.
        </div>
    @endif
</div>
