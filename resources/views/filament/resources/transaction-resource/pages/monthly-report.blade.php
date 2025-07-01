<x-filament-panels::page>
    {{-- Bagian ini akan menampilkan Form Filter yang kita buat di file PHP --}}
    <form wire:submit>
        {{ $this->form }}
    </form>

    {{-- Kita panggil method getTransactionsData() untuk mendapatkan data terbaru --}}
    @php
        $data = $this->getTransactionsData();
    @endphp

    {{-- Bagian ini menampilkan 3 Kartu Statistik Ringkasan --}}
    <div class="mt-8 grid grid-cols-1 gap-6 md:grid-cols-3">
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pemasukan</p>
            <p class="mt-1 text-3xl font-semibold text-green-600">
                Rp {{ number_format($data['income'], 0, ',', '.') }}
            </p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Pengeluaran</p>
            <p class="mt-1 text-3xl font-semibold text-red-600">
                Rp {{ number_format($data['expense'], 0, ',', '.') }}
            </p>
        </div>
        <div class="p-6 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Selisih (Laba/Rugi)</p>
            <p class="mt-1 text-3xl font-semibold {{ $data['difference'] >= 0 ? 'text-green-600' : 'text-red-600' }}">
                Rp {{ number_format($data['difference'], 0, ',', '.') }}
            </p>
        </div>
    </div>

    {{-- Bagian ini menampilkan Tabel Detail Transaksi --}}
    <div class="mt-8">
        <h2 class="text-xl font-semibold tracking-tight">Detail Transaksi</h2>
        <div class="mt-4 overflow-x-auto bg-white rounded-lg shadow-md dark:bg-gray-800">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Kategori</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider dark:text-gray-300">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse ($data['transactions'] as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $transaction->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">{{ $transaction->category->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-right font-mono {{ $transaction->category->is_expense ? 'text-red-600' : 'text-green-600' }}">
                                Rp {{ number_format($transaction->amount, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                Tidak ada data transaksi untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</x-filament-panels::page>