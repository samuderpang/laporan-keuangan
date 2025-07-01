<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>
    <style>
        body { font-family: sans-serif; margin: 40px; }
        h1 { text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #dddddd; text-align: left; padding: 8px; font-size: 14px; }
        thead { background-color: #f2f2f2; }
        .income { color: green; }
        .expense { color: red; }
        .summary { margin-top: 20px; padding: 15px; border: 1px solid #ddd; }
    </style>
</head>
<body>
    <h1>Laporan Transaksi - {{ date('F', mktime(0, 0, 0, $month, 1)) }} {{ $year }}</h1>

    <div class="summary">
        <p><strong>Total Pemasukan:</strong> Rp {{ number_format($income, 0, ',', '.') }}</p>
        <p><strong>Total Pengeluaran:</strong> Rp {{ number_format($expense, 0, ',', '.') }}</p>
        <p><strong>Selisih (Laba/Rugi):</strong> Rp {{ number_format($difference, 0, ',', '.') }}</p>
    </div>

    <h2 style="margin-top: 30px;">Detail Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($transactions as $transaction)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</td>
                    <td>{{ $transaction->name }}</td>
                    <td>{{ $transaction->category->name }}</td>
                    <td class="{{ $transaction->category->is_expense ? 'expense' : 'income' }}">
                        Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align: center;">Tidak ada data untuk periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>