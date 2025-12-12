<x-layout>
    <x-slot:title>Tambah Laporan Keuangan</x-slot:title>

    <div class="max-w-4xl mx-auto py-6">
        <h2 class="text-2xl font-bold text-white mb-6">Tambah Laporan Keuangan Baru</h2>

        @if ($errors->any())
            <div class="bg-red-500/10 border border-red-500 text-red-500 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.financial-reports.store') }}" method="POST" enctype="multipart/form-data"
            class="bg-gray-800 rounded-lg p-6 space-y-6">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-white mb-2 font-medium">Judul Laporan *</label>
                <input type="text" name="title" value="{{ old('title') }}" required
                    placeholder="e.g., Laporan Keuangan Bulan Januari 2024"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
            </div>

            <!-- Report Type -->
            <div>
                <label class="block text-white mb-2 font-medium">Tipe Laporan *</label>
                <select name="report_type" id="report_type" required onchange="togglePeriodFields()"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Pilih Tipe</option>
                    <option value="monthly" {{ old('report_type') === 'monthly' ? 'selected' : '' }}>Bulanan</option>
                    <option value="quarterly" {{ old('report_type') === 'quarterly' ? 'selected' : '' }}>Kuartalan</option>
                    <option value="yearly" {{ old('report_type') === 'yearly' ? 'selected' : '' }}>Tahunan</option>
                </select>
            </div>

            <!-- Period Fields -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Year -->
                <div>
                    <label class="block text-white mb-2 font-medium">Tahun *</label>
                    <input type="number" name="year" value="{{ old('year', date('Y')) }}" required
                        min="2000" max="2100"
                        class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <!-- Month (for monthly reports) -->
                <div id="month_field" class="hidden">
                    <label class="block text-white mb-2 font-medium">Bulan</label>
                    <select name="month"
                        class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Pilih Bulan</option>
                        @foreach(range(1, 12) as $m)
                            <option value="{{ $m }}" {{ old('month') == $m ? 'selected' : '' }}>
                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Quarter (for quarterly reports) -->
                <div id="quarter_field" class="hidden">
                    <label class="block text-white mb-2 font-medium">Kuartal</label>
                    <select name="quarter"
                        class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="">Pilih Kuartal</option>
                        <option value="1" {{ old('quarter') == 1 ? 'selected' : '' }}>Q1 (Jan-Mar)</option>
                        <option value="2" {{ old('quarter') == 2 ? 'selected' : '' }}>Q2 (Apr-Jun)</option>
                        <option value="3" {{ old('quarter') == 3 ? 'selected' : '' }}>Q3 (Jul-Sep)</option>
                        <option value="4" {{ old('quarter') == 4 ? 'selected' : '' }}>Q4 (Oct-Dec)</option>
                    </select>
                </div>
            </div>

            <!-- Financial Data -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="block text-white mb-2 font-medium">Pemasukan (Rp) *</label>
                    <input type="number" name="income" value="{{ old('income', 0) }}" required
                        min="0" step="0.01"
                        class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-white mb-2 font-medium">Pengeluaran (Rp) *</label>
                    <input type="number" name="expense" value="{{ old('expense', 0) }}" required
                        min="0" step="0.01"
                        class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>

                <div>
                    <label class="block text-white mb-2 font-medium">Order</label>
                    <input type="number" name="order" value="{{ old('order', 0) }}"
                        class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                </div>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-white mb-2 font-medium">Deskripsi/Catatan</label>
                <textarea name="description" rows="4"
                    placeholder="Tambahkan catatan atau detail tentang laporan ini..."
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('description') }}</textarea>
            </div>

            <!-- File Upload -->
            <div>
                <label class="block text-white mb-2 font-medium">Upload File PDF</label>
                <input type="file" name="file" accept=".pdf"
                    class="w-full bg-gray-700 text-white rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="text-gray-400 text-sm mt-1">Max size: 5MB. Format: PDF only (Optional)</p>
            </div>

            <!-- Published Status -->
            <div class="p-4 bg-indigo-500/10 border border-indigo-500 rounded">
                <label class="flex items-center text-white">
                    <input type="checkbox" name="is_published" value="1" {{ old('is_published') ? 'checked' : '' }}
                        class="mr-2 rounded bg-gray-700 border-gray-600">
                    <div>
                        <span class="font-semibold">Publish Laporan</span>
                        <p class="text-sm text-gray-300 mt-1">Centang untuk menampilkan laporan di halaman publik</p>
                    </div>
                </label>
            </div>

            <!-- Submit Buttons -->
            <div class="flex gap-3">
                <button type="submit"
                    class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-md">
                    Simpan Laporan
                </button>
                <a href="{{ route('admin.financial-reports.index') }}"
                    class="bg-gray-700 hover:bg-gray-600 text-white px-6 py-2 rounded-md">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <script>
        function togglePeriodFields() {
            const reportType = document.getElementById('report_type').value;
            const monthField = document.getElementById('month_field');
            const quarterField = document.getElementById('quarter_field');
            const monthInput = monthField.querySelector('select');
            const quarterInput = quarterField.querySelector('select');

            monthField.classList.add('hidden');
            quarterField.classList.add('hidden');
            
            // Remove required attribute
            monthInput.removeAttribute('required');
            quarterInput.removeAttribute('required');

            if (reportType === 'monthly') {
                monthField.classList.remove('hidden');
                monthInput.setAttribute('required', 'required');
            } else if (reportType === 'quarterly') {
                quarterField.classList.remove('hidden');
                quarterInput.setAttribute('required', 'required');
            }
        }

        // Run on page load to handle old() values
        document.addEventListener('DOMContentLoaded', togglePeriodFields);
    </script>
</x-layout>