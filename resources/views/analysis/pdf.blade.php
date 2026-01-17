<!DOCTYPE html>
<html>

<head>
    <title>Profit First Analysis Report</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
        }

        .summary {
            margin-top: 20px;
            border: 1px solid #eee;
            padding: 10px;
            background-color: #f9fafb;
        }

        .red {
            color: red;
            font-weight: bold;
        }

        .green {
            color: green;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Profit First Analysis</h1>
        <p>Report Date: {{ now()->format('M d, Y') }}</p>
        <p>Real Revenue: ${{ number_format($analysis->real_revenue, 2) }}</p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Actual</th>
                <th>Target (TAPS)</th>
                <th>PF $ (Target)</th>
                <th>The Bleed</th>
                <th>The Fix</th>
            </tr>
        </thead>
        <tbody>
            @foreach($analysis->rows as $row)
                <tr>
                    <td>{{ $row->category }}</td>
                    <td>${{ number_format($row->actual_amount, 2) }}</td>
                    <td>{{ $row->taps_percentage }}%</td>
                    <td>${{ number_format($row->pf_amount, 2) }}</td>
                    <td class="{{ $row->bleed < 0 ? 'red' : 'green' }}">${{ number_format($row->bleed, 2) }}</td>
                    <td>
                        <b>{{ $row->fix }}</b>
                        {{ $row->fix == 'Increase' ? 'Allocation' : 'Spending' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <h3>Money Moves (Action Plan)</h3>
        <ul>
            @foreach($analysis->rows as $row)
                @if($row->bleed != 0)
                    <li>
                        {{ $row->category }}:
                        <span class="{{ $row->fix == 'Increase' ? 'green' : 'red' }}">{{ $row->fix }}</span>
                        by ${{ number_format(abs($row->bleed), 2) }}
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</body>

</html>