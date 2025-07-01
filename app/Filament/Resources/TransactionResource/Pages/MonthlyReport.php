<?php

namespace App\Filament\Resources\TransactionResource\Pages;

// BAGIAN 1: 'USE' STATEMENTS
// Pastikan semua ini ada di bagian atas
use App\Exports\TransactionsExport;
use App\Models\Transaction;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Resources\Pages\Page;
use Maatwebsite\Excel\Facades\Excel; // Jika Anda masih ingin mencoba Excel
use Barryvdh\DomPDF\Facade\Pdf; // Untuk PDF

class MonthlyReport extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = \App\Filament\Resources\TransactionResource::class;

    protected static string $view = 'filament.resources.transaction-resource.pages.monthly-report';

    // BAGIAN 2: PROPERTI KELAS
    public ?int $month;
    public ?int $year;

    // BAGIAN 3: METHOD 'MOUNT' (Untuk nilai default)
    public function mount(): void
    {
        $this->month = now()->month;
        $this->year = now()->year;

        $this->form->fill([
            'month' => $this->month,
            'year' => $this->year,
        ]);
    }

    // BAGIAN 4: METHOD 'GETFORMSCHEMA' (Untuk filter)
    protected function getFormSchema(): array
    {
        return [
            Select::make('month')
                ->label('Pilih Bulan')
                ->options(collect(range(1, 12))->mapWithKeys(function ($month) {
                    return [$month => date('F', mktime(0, 0, 0, $month, 1))];
                })->toArray())
                ->live()
                ->afterStateUpdated(fn ($state) => $this->month = $state),

            Select::make('year')
                ->label('Pilih Tahun')
                ->options(collect(range(now()->year, 2020))->mapWithKeys(function ($year) {
                    return [$year => $year];
                })->toArray())
                ->live()
                ->afterStateUpdated(fn ($state) => $this->year = $state),
        ];
    }

    // BAGIAN 5: METHOD 'GETHEADERACTIONS' (Untuk tombol ekspor)
    protected function getHeaderActions(): array
    {
        return [
            Action::make('export_pdf')
                ->label('Ekspor ke PDF')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn () => route('report.transactions.pdf', [
                    'year' => $this->year,
                    'month' => $this->month
                ]))
                ->openUrlInNewTab(),
        ];
    }

    // BAGIAN 6: METHOD 'GETTRANSACTIONSDATA' (Untuk mengambil data)
    public function getTransactionsData()
    {
        $transactions = Transaction::with('category')
                                   ->whereYear('date', $this->year)
                                   ->whereMonth('date', $this->month)
                                   ->get();

        $income = $transactions->where('category.is_expense', false)->sum('amount');
        $expense = $transactions->where('category.is_expense', true)->sum('amount');

        return [
            'transactions' => $transactions,
            'income' => $income,
            'expense' => $expense,
            'difference' => $income - $expense,
        ];
    }
}