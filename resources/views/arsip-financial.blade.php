@extends('arsip')

@section('arsip-content')
    <!-- Filter Section -->
    <div class="bg-gray-800 rounded-xl p-6 mb-8">
        <form method="GET" action="{{ url('/arsip/laporan-keuangan') }}" class="flex flex-col sm:flex-row gap-4">
            <div class="flex-1">
                <select name="year" 
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Tahun</option>
                    @foreach($years as $year)
                        <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>
                            {{ $year }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="flex-1">
                <select name="type" 
                        class="w-full bg-gray-700 text-white rounded-lg px-4 py-3 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Tipe</option>
                    <option value="monthly" {{ request('type') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    <option value="quarterly" {{ request('type') === 'quarterly' ? 'selected' : '' }}>Kuartalan</option>
                    <option value="yearly" {{ request('type') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                </select>
            </div>
            <button type="submit" 
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-8 py-3 rounded-lg font-medium transition whitespace-nowrap">
                Filter
            </button>
            @if(request()->has('year') || request()->has('type'))
                <a href="{{ url('/arsip/laporan-keuangan') }}" 
                   class="bg-gray-700 hover:bg-gray-600 text-white px-8 py-3 rounded-lg font-medium transition whitespace-nowrap text-center">
                    Clear
                </a>
            @endif
        </form>
    </div>

    @if($reports->count() > 0)
        <!-- Reports List -->
        <div class="space-y-6">
            @foreach($reports as $report)
                <div class="bg-gray-800 rounded-xl overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-700 hover:border-indigo-500">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6">
                            <!-- Left: Info -->
                            <div class="flex-1">
                                <div class="flex items-start gap-4 mb-4">
                                    <div class="w-16 h-16 bg-gradient-to-br from-indigo-600 to-purple-600 rounded-xl flex items-center mt-5 justify-center flex-shrink-0">
                                        <svg class="w-8 h-8  text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4z"/>
                                            <path fill-rule="evenodd" d="M18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                    
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="px-3 py-1 text-xs font-semibold bg-indigo-500/20 text-indigo-400 rounded-full capitalize">
                                                {{ $report->report_type === 'monthly' ? 'Bulanan' : ($report->report_type === 'quarterly' ? 'Kuartalan' : 'Tahunan') }}
                                            </span>
                                            <span class="text-gray-400 text-sm">{{ $report->period }}</span>
                                        </div>
                                        <h3 class="text-white font-bold text-xl mb-2">{{ $report->title }}</h3>
                                        @if($report->description)
                                            <p class="text-gray-400 text-sm">{{ Str::limit($report->description, 150) }}</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Financial Summary -->
                                <div class="grid grid-cols-3 gap-4 mt-4 p-4 bg-gray-700/50 rounded-lg">
                                    <div>
                                        <p class="text-xs text-gray-400 mb-1">Pemasukan</p>
                                        <p class="text-green-400 font-bold">{{ $report->formatted_income }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 mb-1">Pengeluaran</p>
                                        <p class="text-red-400 font-bold">{{ $report->formatted_expense }}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs text-gray-400 mb-1">Saldo</p>
                                        <p class="font-bold {{ $report->balance >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                            {{ $report->formatted_balance }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Action -->
                            @if($report->file_path)
                                <div class="lg:text-right self-end mb-4">
                                    <a href="{{ Storage::url($report->file_path) }}" 
                                       target="_blank"
                                       class="inline-flex items-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg transition-all hover:scale-105 shadow-lg">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        <span>Download PDF</span>
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Results Count -->
        <div class="mt-8 text-center text-gray-400">
            Menampilkan {{ $reports->count() }} laporan
        </div>
    @else
        <!-- Empty State -->
        <div class="text-center py-16 bg-gray-800 rounded-xl">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-gray-700 rounded-full mb-6">
                <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h3 class="text-2xl font-bold text-white mb-2">
                Belum Ada Laporan Tersedia
            </h3>
            <p class="text-gray-400">
                @if(request()->has('year') || request()->has('type'))
                    Tidak ada laporan yang sesuai dengan filter Anda.
                @else
                    Laporan keuangan akan segera dipublikasikan.
                @endif
            </p>
        </div>
    @endif
@endsection