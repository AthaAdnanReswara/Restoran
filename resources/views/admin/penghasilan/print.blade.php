
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Laporan Penghasilan</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            margin: 30px;
            color: #333;
        }

        h2 {
            margin: 0;
            text-align: center;
        }

        p {
            text-align: center;
            margin-top: 5px;
        }

        .info {
            margin: 20px 0;
            font-size: 14px;
        }

        .total {
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: bold;
            color: green;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            border: 1px solid #000;
            padding: 8px;
            font-size: 13px;
        }

        table th {
            background: #f3f4f6;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        @media print {
            button {
                display: none;
            }
        }
    </style>
</head>

<body>

    <button onclick="window.print()">
        🖨 Print
    </button>

    <h2>LAPORAN PENGHASILAN</h2>

    <p>
        Dicetak pada :
        {{ now()->format('d-m-Y H:i') }}
    </p>

    <div class="info">

        @if(request('from') || request('to'))
            <strong>Periode :</strong>

            {{ request('from') ?: '-' }}
            s/d
            {{ request('to') ?: '-' }}

            <br>
        @endif

        @if(request('payment_method'))
            <strong>Pembayaran :</strong>
            {{ ucfirst(request('payment_method')) }}
        @endif

    </div>

    <div class="total">
        Total Penghasilan :
        Rp {{ number_format($totalIncome,0,',','.') }}
    </div>

    <table>

        <thead>

            <tr>

                <th>No</th>
                <th>Tanggal</th>
                <th>Customer</th>
                <th>Meja</th>
                <th>Menu</th>
                <th>Qty</th>
                <th>Pembayaran</th>
                <th>Total</th>

            </tr>

        </thead>

        <tbody>

            @forelse($transactions as $transaction)

                <tr>

                    <td class="text-center">
                        {{ $loop->iteration }}
                    </td>

                    <td>
                        {{ $transaction->created_at->format('d-m-Y') }}
                    </td>

                    <td>
                        {{ $transaction->customer_name }}
                    </td>

                    <td class="text-center">
                        {{ $transaction->table->table_number }}
                    </td>

                    <td>
                        {{ $transaction->menu->name }}
                    </td>

                    <td class="text-center">
                        {{ $transaction->quantity }}
                    </td>

                    <td class="text-center">
                        {{ ucfirst($transaction->payment_method) }}
                    </td>

                    <td class="text-right">
                        Rp {{ number_format($transaction->total_price,0,',','.') }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="text-center">

                        Tidak ada data.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

    <script>
        window.onload = function () {
            window.print();
        }
    </script>

</body>

</html>
