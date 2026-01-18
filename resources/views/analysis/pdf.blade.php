<!DOCTYPE html>
<html>

<head>
    <title>Allocore Financial Analysis Report</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: left;
        }

        .table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        .summary {
            margin-top: 20px;
            border: 1px solid #eee;
            padding: 10px;
            background-color: #f9fafb;
        }

        .red {
            color: red;
        }

        .green {
            color: green;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="header">
        <h1>Allocore Financial Analysis</h1>
        @if($analysis->client_name)
            <h2 style="margin-top: 5px; color: #555;">{{ $analysis->client_name }}</h2>
        @endif
        <p>Report Date: {{ now()->format('M d, Y') }} | Real Revenue: ${{ number_format($analysis->real_revenue, 2) }}
        </p>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>Category</th>
                <th>Actual</th>
                <th>TAPS %</th>
                <th>PF $ (Target)</th>
                <th>The Bleed</th>
                <th>The Fix</th>
                <th>HAPS %</th>
                <th>Q1 CAPS</th>
                <th>Q2 CAPS</th>
                <th>Q3 CAPS</th>
                <th>Q4 CAPS</th>
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
                    </td>
                    <td>{{ number_format($row->haps, 1) }}%</td>
                    <td>{{ $row->q1_caps }}%</td>
                    <td>{{ $row->q2_caps }}%</td>
                    <td>{{ $row->q3_caps }}%</td>
                    <td>{{ $row->q4_caps }}%</td>
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
                        <span class="{{ $row->fix == 'Increase' ? 'green' : 'red' }} font-bold">{{ $row->fix }}</span>
                        by ${{ number_format(abs($row->bleed), 2) }}
                        @if($row->fix == 'Increase')
                            (Allocated too little)
                        @else
                            (Spent too much / Allocated too much)
                        @endif
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</body>

</html>