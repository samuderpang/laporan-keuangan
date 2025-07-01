<?php

namespace App\Filament\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use App\Models\Transaction;

class StatsOverview extends BaseWidget
{

   protected function getStats(): array
{
    // Ambil data dari database.
    $pemasukan = \App\Models\Transaction::incomes()->sum('amount');
    $pengeluaran = \App\Models\Transaction::expenses()->sum('amount');
    $selisih = $pemasukan - $pengeluaran;

    return [
        // Cukup gunakan Stat::make, bukan alamat lengkapnya
        Stat::make('Total Revenue', 'Rp ' . number_format($pemasukan, 0, ',', '.'))
            ->description('Total pendapatan yang diterima')
            ->color('success'),

        Stat::make('Total Expenses', 'Rp ' . number_format($pengeluaran, 0, ',', '.'))
            ->description('Total biaya yang dikeluarkan')
            ->color('danger'),

        Stat::make('Difference (Laba/Rugi)', 'Rp ' . number_format($selisih, 0, ',', '.'))
            ->description('Pemasukan dikurangi Pengeluaran')
            ->color($selisih >= 0 ? 'info' : 'danger'),
    ];

    }
}
