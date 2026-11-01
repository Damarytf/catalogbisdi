@extends('layouts.app')

@section('content')

<!-- ======================================================= -->
<!-- 1. ASYMMETRIC HERO SECTION (WARM MIDNIGHT OVERLAP)      -->
<!-- ======================================================= -->
<section class="relative pt-12 pb-20 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16 items-center">
            
            <!-- Kolom Kiri: Judul Masif & Intensi (7 Cols) -->
            <div class="lg:col-span-7 space-y-6">
                
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full glass-pill text-xs font-medium text-[#A39A92]">
                    <span class="w-2 h-2 rounded-full bg-[#F97316]"></span>
                    <span>Prodi Bisnis Digital • Fasilkom UPNVJT</span>
                </div>

                <h1 class="font-heading text-4xl sm:text-6xl lg:text-7xl font-bold tracking-tight text-[#F5EDE6] leading-[1.05]">
                    Katalog karya digital yang siap pakai.
                </h1>

                <p class="text-base sm:text-lg text-[#A39A92] max-w-xl font-light leading-relaxed">
                    {{ \App\Models\Setting::get('store_tagline', 'Kumpulan modul belajar, aset visual, dan template siap pakai hasil proyek praktikum dan wirausaha mahasiswa.') }}
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-4">
                    <a href="#katalog-produk" class="px-6 py-3.5 rounded-[12px] bg-[#F97316] hover:bg-[#EA580C] text-white text-xs font-bold uppercase tracking-wider transition-colors duration-150">
                        Buka Katalog
                    </a>
                    <a href="{{ route('pages.contact') }}" class="px-6 py-3.5 rounded-[12px] bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 text-[#F5EDE6] text-xs font-semibold uppercase tracking-wider transition-colors duration-150">
                        Konsultasi
                    </a>
                </div>
            </div>

            <!-- Kolom Kanan: Featured Overlap Showcase (5 Cols) -->
            <div class="lg:col-span-5 relative">
                @if(isset($featuredProducts) && $featuredProducts->count() > 0)
                    @php $lead = $featuredProducts->first(); @endphp
                    
                    <!-- Decorative Underlay Box (Sengaja overlap asimetris) -->
                    <div class="absolute -top-4 -right-4 w-full h-full rounded-[24px] border border-white/[0.04] bg-[#17120F]/60 -z-10 translate-x-3 translate-y-3 hidden sm:block"></div>

                    <!-- Main Highlight Card (Solid surface, rounded 20px) -->
                    <div class="bg-[#17120F] rounded-[20px] border border-white/[0.08] p-6 shadow-2xl relative">
                        <div class="flex items-center justify-between pb-3 mb-4 border-b border-white/[0.06]">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-[#F97316]">Produk Pilihan</span>
                            <span class="text-xs text-[#A39A92]">{{ $lead->category->name ?? 'Digital Asset' }}</span>
                        </div>

                        <!-- Gambar -->
                        <div class="relative aspect-[16/10] rounded-[14px] overflow-hidden bg-[#201A16] mb-5 border border-white/[0.06]">
                            <img src="{{ $lead->image_url }}" alt="{{ $lead->name }}" class="w-full h-full object-cover">
                            <span class="absolute top-3 left-3 glass-pill px-2.5 py-1 rounded-full text-[10px] font-bold text-white uppercase tracking-wider">
                                Rekomendasi
                            </span>
                        </div>

                        <!-- Info -->
                        <h2 class="font-heading text-xl font-bold text-[#F5EDE6] mb-2 leading-snug">
                            <a href="{{ route('catalog.show', $lead->slug) }}" class="hover:text-[#F97316] transition-colors">
                                {{ $lead->name }}
                            </a>
                        </h2>

                        <p class="text-xs text-[#A39A92] line-clamp-2 leading-relaxed mb-5">
                            {{ strip_tags($lead->description) }}
                        </p>

                        <!-- Price & CTA -->
                        <div class="flex items-center justify-between pt-4 border-t border-white/[0.06]">
                            <div class="tabular-nums">
                                @if($lead->isOnSale())
                                    <span class="text-xs text-[#A39A92] line-through mr-1">{{ $lead->formatted_price }}</span>
                                    <span class="text-lg font-bold text-[#F97316]">{{ $lead->formatted_effective_price }}</span>
                                @else
                                    <span class="text-lg font-bold text-[#F5EDE6]">{{ $lead->formatted_price }}</span>
                                @endif
                            </div>

                            <a href="{{ route('catalog.show', $lead->slug) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#F5EDE6] hover:text-[#F97316] transition-colors">
                                <span>Lihat detail</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                    <polyline points="12 5 19 12 12 19"></polyline>
                                </svg>
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>
    </div>
</section>

<!-- ======================================================= -->
<!-- 2. VALUE PROPOSITION: BENTO GRID (1 BESAR + 3 KECIL)    -->
<!-- ======================================================= -->
<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        <!-- Bento 1: Kotak Besar (Span 2 Kolom) -->
        <div class="md:col-span-2 bg-[#17120F] rounded-[20px] border border-white/[0.07] p-8 flex flex-col justify-between relative overflow-hidden group">
            <div class="max-w-md space-y-3 z-10">
                <div class="w-10 h-10 rounded-[10px] bg-[#201A16] border border-white/10 flex items-center justify-center text-[#F97316]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 10v6M2 10l10-5 10 5-10 5z"></path>
                        <path d="M6 12v5c3 3 9 3 12 0v-5"></path>
                    </svg>
                </div>
                <h3 class="font-heading text-2xl font-bold text-[#F5EDE6]">Kurasi Asli Mahasiswa Bisnis Digital</h3>
                <p class="text-xs text-[#A39A92] leading-relaxed">
                    Setiap produk yang terdaftar diuji kelayakannya melalui tugas akhir, praktikum, dan inkubasi wirausaha di lingkungan Fasilkom UPN "Veteran" Jawa Timur.
                </p>
            </div>
            <div class="pt-6 z-10">
                <span class="text-[11px] font-semibold text-[#F97316] uppercase tracking-wider">Terverifikasi Akademik & Bisnis</span>
            </div>
        </div>

        <!-- Bento 2: Kotak Kecil (1 Kolom) -->
        <div class="bg-[#17120F] rounded-[20px] border border-white/[0.07] p-7 flex flex-col justify-between">
            <div class="w-10 h-10 rounded-[10px] bg-[#201A16] border border-white/10 flex items-center justify-center text-[#F97316] mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon>
                </svg>
            </div>
            <div>
                <h4 class="font-heading text-lg font-bold text-[#F5EDE6] mb-1">Akses Instan</h4>
                <p class="text-xs text-[#A39A92] leading-relaxed">
                    Tautan berkas Google Drive / ZIP dikirim langsung setelah konfirmasi WhatsApp.
                </p>
            </div>
        </div>

        <!-- Bento 3: Kotak Kecil (1 Kolom) -->
        <div class="bg-[#17120F] rounded-[20px] border border-white/[0.07] p-7 flex flex-col justify-between">
            <div class="w-10 h-10 rounded-[10px] bg-[#201A16] border border-white/10 flex items-center justify-center text-[#F97316] mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="12" cy="12" r="10"></circle>
                    <path d="m9 12 2 2 4-4"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-heading text-lg font-bold text-[#F5EDE6] mb-1">Lisensi Fleksibel</h4>
                <p class="text-xs text-[#A39A92] leading-relaxed">
                    Bebas dipakai untuk proyek pribadi, kuliah, hingga operasional bisnis nyata.
                </p>
            </div>
        </div>

        <!-- Bento 4: Kotak Kecil Lebar (Span 2 Kolom) -->
        <div class="md:col-span-2 bg-[#17120F] rounded-[20px] border border-white/[0.07] p-7 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-[10px] bg-[#201A16] border border-white/10 flex items-center justify-center text-[#F97316] shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-heading text-base font-bold text-[#F5EDE6]">Tanya Langsung Pembuatnya</h4>
                    <p class="text-xs text-[#A39A92]">Ada kendala saat memakai template? Mahasiswa kami siap bantu pandu.</p>
                </div>
            </div>
            <a href="{{ route('pages.contact') }}" class="text-xs font-bold text-[#F97316] hover:underline whitespace-nowrap">
                Hubungi Kami &rarr;
            </a>
        </div>

    </div>
</section>

<!-- ======================================================= -->
<!-- 3. KATALOG & FILTER SECTION                             -->
<!-- ======================================================= -->
<section id="katalog-produk" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16 scroll-mt-24">
    
    <!-- Filter Bar Header -->
    <div class="flex flex-col md:flex-row gap-6 justify-between items-start md:items-center pb-8 mb-10 border-b border-white/[0.07]">
        
        <!-- Filter Chips: Pill shape, aktif = oranye solid, nonaktif = outline tipis -->
        <div class="flex items-center gap-2 overflow-x-auto w-full md:w-auto pb-2 md:pb-0 scrollbar-none">
            <a href="{{ route('catalog.index') }}#katalog-produk" 
               class="px-4 py-2 rounded-full text-xs font-bold tracking-wider uppercase whitespace-nowrap transition-colors duration-150 {{ !request('category') ? 'bg-[#F97316] text-white' : 'border border-white/10 text-[#A39A92] hover:text-[#F5EDE6] hover:border-white/20' }}">
                Semua Kategori
            </a>

            @foreach($categories as $cat)
                <a href="{{ route('catalog.index', ['category' => $cat->slug]) }}#katalog-produk" 
                   class="px-4 py-2 rounded-full text-xs font-bold tracking-wider uppercase whitespace-nowrap transition-colors duration-150 {{ request('category') === $cat->slug ? 'bg-[#F97316] text-white' : 'border border-white/10 text-[#A39A92] hover:text-[#F5EDE6] hover:border-white/20' }}">
                    {{ $cat->name }}
                </a>
            @endforeach
        </div>

        <!-- Search Bar Selective Glass (Tanpa glow, border oranye saat focus) -->
        <div class="w-full md:w-72">
            <form action="{{ route('catalog.index') }}#katalog-produk" method="GET" class="relative">
                @if(request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                <input type="text" name="search" value="{{ request('search') }}" 
                       placeholder="Cari karya digital..." 
                       class="w-full pl-9 pr-16 py-2.5 glass-surface rounded-[12px] text-xs text-[#F5EDE6] placeholder-[#A39A92] focus:outline-none focus:border-[#F97316] transition-colors duration-150">
                
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#A39A92]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="11" cy="11" r="8"></circle>
                        <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                    </svg>
                </div>

                <button type="submit" class="absolute right-1.5 top-1.5 bottom-1.5 px-3 bg-[#201A16] hover:bg-[#F97316] text-[#F5EDE6] hover:text-white text-[11px] font-bold rounded-[8px] transition-colors duration-150">
                    Cari
                </button>
            </form>
        </div>
    </div>

    <!-- Grid Produk (4 Kolom Responsif) -->
    @if($products->isEmpty())
        <div class="bg-[#17120F] rounded-[20px] border border-white/[0.07] p-16 text-center max-w-md mx-auto">
            <h3 class="font-heading text-xl font-bold text-[#F5EDE6] mb-2">Produk Tidak Ditemukan</h3>
            <p class="text-xs text-[#A39A92] leading-relaxed mb-6">
                Tidak ada produk yang cocok dengan pencarian Anda saat ini.
            </p>
            <a href="{{ route('catalog.index') }}#katalog-produk" class="inline-block px-5 py-2.5 bg-[#F97316] hover:bg-[#EA580C] text-white text-xs font-bold rounded-[10px] transition-colors">
                Bersihkan Filter
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($products as $product)
                <x-product-card :product="$product" />
            @endforeach
        </div>
        
        <div class="mt-14 pt-8 border-t border-white/[0.06]">
            {{ $products->links() }}
        </div>
    @endif

</section>

@endsection