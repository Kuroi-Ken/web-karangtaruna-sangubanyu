<x-layout>
    <x-slot:title>Laporan Keuangan</x-slot:title>

    <div class="py-6">
        <x-admin-menu />
        
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-white">Manajemen Menu Laporan Keuangan</h2>
            <a href="{{ route('admin.financial-reports.create') }}"
                class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-md">
                + Tambah Laporan
            </a>
        </div>

        @if (session('success'))
            <div class="bg-green-500/10 border border-green-500 text-green-500 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Filter Section -->
        <div class="bg-gray-800 rounded-lg p-4 mb-6">
            <form method="GET" action="{{ route('admin.financial-reports.index') }}" class="flex gap-4 flex-wrap">
                <div class="flex-1 min-w-[150px]">
                    <select name="type" 
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Tipe</option>
                        <option value="monthly" {{ request('type') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                        <option value="quarterly" {{ request('type') === 'quarterly' ? 'selected' : '' }}>Kuartalan</option>
                        <option value="yearly" {{ request('type') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                    </select>
                </div>
                <div class="min-w-[150px]">
                    <select name="year" 
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Tahun</option>
                        @foreach($years as $year)
                            <option value="{{ $year }}" {{ request('year') == $year ? 'selected' : '' }}>{{ $year }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="min-w-[150px]">
                    <select name="status" 
                            class="w-full bg-gray-700 text-white rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Semua Status</option>
                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>Dipublikasi</option>
                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>Draf</option>
                    </select>
                </div>
                <button type="submit" 
                        class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    Filter
                </button>
                @if(request()->has('type') || request()->has('year') || request()->has('status'))
                    <a href="{{ route('admin.financial-reports.index') }}" 
                       class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-lg font-medium transition">
                        Clear
                    </a>
                @endif
            </form>
        </div>

        <!-- Reports Table -->
        <div class="bg-gray-800 rounded-lg overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-max">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Periode</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Judul</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Pemasukan</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Pengeluaran</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Saldo</th>
                            <th class="px-6 py-3 text-center text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase whitespace-nowrap">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-700">
                        @forelse ($reports as $report)
                            <tr class="hover:bg-gray-700/50">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-white font-medium">{{ $report->period }}</div>
                                    <span class="text-xs text-gray-400 capitalize">{{ $report->report_type }}</span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-white min-w-[200px]">{{ $report->title }}</div>
                                    @if($report->file_path)
                                        <a href="{{ Storage::url($report->file_path) }}" target="_blank" 
                                        class="text-xs text-indigo-400 hover:underline flex items-center gap-1 mt-1 whitespace-nowrap">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M8 4a3 3 0 00-3 3v4a5 5 0 0010 0V7a1 1 0 112 0v4a7 7 0 11-14 0V7a5 5 0 0110 0v4a3 3 0 11-6 0V7a1 1 0 012 0v4a1 1 0 102 0V7a3 3 0 00-3-3z" clip-rule="evenodd"/>
                                            </svg>
                                            Lihat PDF
                                        </a>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right text-green-400 font-medium whitespace-nowrap">
                                    {{ $report->formatted_income }}
                                </td>
                                <td class="px-6 py-4 text-right text-red-400 font-medium whitespace-nowrap">
                                    {{ $report->formatted_expense }}
                                </td>
                                <td class="px-6 py-4 text-right font-bold whitespace-nowrap {{ $report->balance >= 0 ? 'text-green-400' : 'text-red-400' }}">
                                    {{ $report->formatted_balance }}
                                </td>
                                <td class="px-6 py-4 text-center whitespace-nowrap">
                                    <span class="px-2 py-1 text-xs rounded {{ $report->is_published ? 'bg-green-500/10 text-green-500' : 'bg-yellow-500/10 text-yellow-500' }}">
                                        {{ $report->is_published ? 'Dipublikasi' : 'Draf' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex gap-3 justify-end">
                                        <a href="{{ route('admin.financial-reports.edit', $report) }}"
                                            class="text-blue-400 hover:text-blue-300">Edit</a>
                                        <form action="{{ route('admin.financial-reports.destroy', $report) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin menghapus laporan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-400">
                                    Belum ada laporan keuangan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($reports->isNotEmpty())
            <div class="mt-6 text-gray-400 text-sm">
                Menampilkan {{ $reports->count() }} Laporan
            </div>
        @endif
        @if($reports->hasPages())
            <div class="mt-6">
                {{ $reports->links() }}
            </div>
        @endif
    </div>
</x-layout>