<x-filament-widgets::widget>
    <x-slot name="heading">
        Tautan Penting
    </x-slot>

    <div class="flex flex-col space-y-2">

        <a href="{{ route('filament.admin.resources.transactions.report') }}" 
           class="flex items-center p-2 space-x-2 text-sm text-gray-700 rounded-md hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-800">
            <x-filament::icon
                icon="heroicon-o-chart-bar-square"
                class="w-5 h-5 text-gray-500"
            />
            <span>Lihat Laporan Bulanan</span>
        </a>

        

        

    </div>
</x-filament-widgets::widget>