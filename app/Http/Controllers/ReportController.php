<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // Gunakan facade PDF

class ReportController extends Controller
{
    public function downloadTransactionsPdf(int $year, int $month)
    {
        // Logika pengambilan data, sama seperti di widget Anda
        $transactions = Transaction::with('category')
                                   ->whereYear('date', $year)
                                   ->whereMonth('date', $month)
                                   ->get();

        $income = $transactions->where('category.is_expense', false)->sum('amount');
        $expense = $transactions->where('category.is_expense', true)->sum('amount');
        $difference = $income - $expense;

        // Siapkan data untuk dikirim ke view
        $data = [
            'year' => $year,
            'month' => $month,
            'transactions' => $transactions,
            'income' => $income,
            'expense' => $expense,
            'difference' => $difference,
        ];

        // Buat PDF dari view 'reports.transactions-pdf' dengan data di atas
        $pdf = Pdf::loadView('reports.transactions-pdf', $data);

        // Download PDF tersebut dengan nama file yang dinamis
        $fileName = 'Laporan_Keuangan_' . $month . '_' . $year . '.pdf';
        return $pdf->download($fileName);
    }
}