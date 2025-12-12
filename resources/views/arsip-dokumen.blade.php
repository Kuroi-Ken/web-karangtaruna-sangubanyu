@extends('arsip')

@section('arsip-content')
    <!-- Info Section -->
    <div class="bg-blue-500/10 border border-blue-500 rounded-xl p-6 mb-8">
        <div class="flex items-start gap-4">
            <svg class="w-6 h-6 text-blue-400 flex-shrink-0 mt-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div>
                <h3 class="text-white font-semibold mb-1">Informasi</h3>
                <p class="text-gray-300 text-sm">
                    Kumpulan dokumen resmi dan surat-surat Karang Taruna Desa Sangubanyu. 
                    Klik pada dokumen untuk mengunduh.
                </p>
            </div>
        </div>
    </div>

    @if($documents->count() > 0)
        <!-- Documents List -->
        <div class="space-y-4">
            @foreach($documents as $document)
                <div class="bg-gray-800 rounded-xl overflow-hidden hover:shadow-2xl transition-all duration-300 border border-gray-700 hover:border-indigo-500">
                    <div class="p-6">
                        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                            <!-- Left: File Info -->
                            <div class="flex items-start gap-4 flex-1 min-w-0">
                                <!-- File Icon -->
                                <div class="w-14 h-14 bg-gradient-to-br 
                                    @if(strtolower($document->file_type) === 'pdf') from-red-600 to-red-700
                                    @elseif(in_array(strtolower($document->file_type), ['doc', 'docx'])) from-blue-600 to-blue-700
                                    @elseif(in_array(strtolower($document->file_type), ['xls', 'xlsx'])) from-green-600 to-green-700
                                    @elseif(in_array(strtolower($document->file_type), ['ppt', 'pptx'])) from-orange-600 to-orange-700
                                    @else from-gray-600 to-gray-700
                                    @endif
                                    rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                    
                                    @if(strtolower($document->file_type) === 'pdf')
                                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                        </svg>
                                    @elseif(in_array(strtolower($document->file_type), ['doc', 'docx']))
                                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/>
                                        </svg>
                                    @else
                                        <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/>
                                        </svg>
                                    @endif
                                </div>
                                
                                <div class="flex-1 min-w-0">
                                    <!-- Category Badge -->
                                    @if($document->category)
                                        <span class="inline-block px-2.5 py-1 text-xs font-semibold text-indigo-400 bg-indigo-500/10 rounded-full mb-2">
                                            {{ $document->category }}
                                        </span>
                                    @endif

                                    <!-- Document Title -->
                                    <h3 class="text-white font-bold text-lg mb-2 break-words">
                                        {{ $document->title }}
                                    </h3>

                                    <!-- Description -->
                                    @if($document->description)
                                        <p class="text-gray-400 text-sm mb-3">
                                            {{ Str::limit($document->description, 150) }}
                                        </p>
                                    @endif
                                    
                                    <!-- File Meta -->
                                    <div class="flex flex-wrap gap-3 text-sm text-gray-400">
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v8a2 2 0 002 2h12a2 2 0 002-2V8a2 2 0 00-2-2h-5L9 4H4zm7 5a1 1 0 00-2 0v1H8a1 1 0 000 2h1v1a1 1 0 002 0v-1h1a1 1 0 000-2h-1V9z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ strtoupper($document->file_type) }}
                                        </span>
                                        
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M3 17a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm3.293-7.707a1 1 0 011.414 0L9 10.586V3a1 1 0 112 0v7.586l1.293-1.293a1 1 0 111.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $document->formatted_file_size }}
                                        </span>
                                        
                                        <span class="flex items-center gap-1">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                            </svg>
                                            {{ $document->created_at->format('d M Y') }}
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Download Button -->
                            <div class="w-full sm:w-auto">
                                <a href="{{ Storage::url($document->file_path) }}" 
                                   download="{{ $document->file_name }}"
                                   target="_blank"
                                   class="inline-flex items-center justify-center gap-2 w-full sm:w-auto bg-indigo-600 hover:bg-indigo-700 text-white font-semibold px-6 py-3 rounded-lg transition-all hover:scale-105 shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    <span>Download</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Results Count -->
        <div class="mt-8 text-center text-gray-400">
            Menampilkan {{ $documents->count() }} dokumen
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
                Belum Ada Dokumen Tersedia
            </h3>
            <p class="text-gray-400">
                Dokumen dan arsip surat akan segera dipublikasikan.
            </p>
        </div>
    @endif
@endsection