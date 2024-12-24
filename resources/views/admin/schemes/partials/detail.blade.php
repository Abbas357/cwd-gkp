<style>
    .table-cell {
        padding: 0.5rem 1rem;
        vertical-align: middle;
    }
    .table th {
        background-color: #f4f4f4;
        font-weight: bold;
    }
    .table td {
        text-align: center;
    }
</style>

<div class="row events-details">
    <div class="col-md-12">
        <table class="table table-bordered mt-3">
            <!-- File Name -->
            <tr>
                <th class="table-cell">ADP Number</th>
                <td class="table-cell">{{ $scheme->adp_number ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Scheme Code</th>
                <td class="table-cell">{{ $scheme->scheme_code ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Year</th>
                <td class="table-cell">{{ $scheme->year ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Scheme Name</th>
                <td class="table-cell">{{ $scheme->scheme_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Sector Name</th>
                <td class="table-cell">{{ $scheme->sector_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Sub Sector Name</th>
                <td class="table-cell">{{ $scheme->sub_sector_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Local Cost</th>
                <td class="table-cell">{{ number_format($scheme->local_cost, 3) ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Foreign Cost</th>
                <td class="table-cell">{{ number_format($scheme->foreign_cost, 3) ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Previous Expenditure</th>
                <td class="table-cell">{{ number_format($scheme->previous_expenditure, 3) ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Capital Allocation</th>
                <td class="table-cell">{{ number_format($scheme->capital_allocation, 3) ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Revenue Allocation</th>
                <td class="table-cell">{{ number_format($scheme->revenue_allocation, 3) ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Total Allocation</th>
                <td class="table-cell">{{ number_format($scheme->total_allocation, 3) ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">F Allocation</th>
                <td class="table-cell">{{ number_format($scheme->f_allocation, 3) ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">TF</th>
                <td class="table-cell">{{ number_format($scheme->tf, 3) ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Revised Allocation</th>
                <td class="table-cell">{{ number_format($scheme->revised_allocation, 3) ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Prog Releases</th>
                <td class="table-cell">{{ number_format($scheme->prog_releases, 3) ?? 'N/A' }}</td>
            </tr>
            <tr>
                <th class="table-cell">Progressive Expenditure</th>
                <td class="table-cell">{{ number_format($scheme->progressive_exp, 3) ?? 'N/A' }}</td>
            </tr>
        </table>
    </div>
</div>
