@extends('layouts.app')

@section('content')
<div class="py-14 sm:py-20">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Header -->
        <div class="max-w-xl mb-12">
            <span class="text-xs font-semibold uppercase tracking-wider text-[#F97316] block mb-2">Informasi & Kontak</span>
            <h1 class="font-heading text-3xl sm:text-4xl font-bold text-main tracking-tight mb-3">
                Layanan Kontak Resmi
            </h1>
            <p class="text-xs text-muted leading-relaxed">
                Pertanyaan seputar produk atau kebutuhan kolaborasi dapat Anda tanyakan langsung kepada perwakilan pengelola katalog.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Kolom Info Kontak (6 Cols) -->
            <div class="lg:col-span-6 space-y-4">
                
                <!-- Alamat -->
                <div class="rounded-[16px] p-6 card">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-muted mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#F97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                            <circle cx="12" cy="10" r="3"></circle>
                        </svg>
                        Lokasi Kampus
                    </div>
                    <p class="text-xs text-main leading-relaxed">
                        {{ $settings['store_address'] ?? 'Program Studi Bisnis Digital, Fakultas Ilmu Komputer, UPN Veteran Jawa Timur, Jl. Rungkut Madya No.1, Surabaya' }}
                    </p>
                </div>

                <!-- WhatsApp -->
                <div class="rounded-[16px] p-6 card">
                    <div class="text-[11px] font-bold uppercase tracking-wider text-muted mb-2 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="#F97316" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        WhatsApp Resmi
                    </div>
                    <p class="text-sm font-bold text-main mb-3 tabular-nums">{{ $settings['whatsapp_number'] ?? '0812-3456-7890' }}</p>
                    @if(isset($settings['whatsapp_number']))
                    <a href="https://wa.me/{{ $settings['whatsapp_number'] }}" target="_blank"
                       class="inline-flex items-center gap-2 text-xs font-bold px-4 py-2 rounded-[8px] bg-[#F97316] text-white hover:bg-[#EA580C] transition-colors">
                        Kirim Pesan WhatsApp &rarr;
                    </a>
                    @endif
                </div>

                <!-- Email & Operasional -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="rounded-[16px] p-5 card">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-muted mb-1">Email</div>
                        <p class="text-xs text-main font-medium break-all">{{ $settings['store_email'] ?? 'bisnisdigital@upnjatim.ac.id' }}</p>
                    </div>

                    <div class="rounded-[16px] p-5 card">
                        <div class="text-[10px] font-bold uppercase tracking-wider text-muted mb-1">Waktu Respons</div>
                        <p class="text-xs text-main font-medium">{{ $settings['store_hours'] ?? 'Senin - Jumat: 08.00 - 16.00 WIB' }}</p>
                    </div>
                </div>

            </div>

            <!-- Kolom Peta (6 Cols) -->
            <div class="lg:col-span-6">
                <div class="rounded-[20px] p-2 card" style="min-height: 360px;">
                    @if(isset($settings['maps_embed_url']) && $settings['maps_embed_url'])
                        <iframe src="{{ $settings['maps_embed_url'] }}" width="100%" height="360"
                                class="rounded-[14px] w-full h-[360px]"
                                style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                    @else
                        <div class="w-full h-[360px] rounded-[14px] flex flex-col items-center justify-center p-6 text-center text-muted"
                             style="background-color: var(--c-elevated);">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none"
                                 stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                 class="mb-2 text-[#F97316]">
                                <path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"></path>
                                <circle cx="12" cy="10" r="3"></circle>
                            </svg>
                            <span class="text-xs font-bold text-main block mb-0.5">Lokasi Kampus UPNVJT</span>
                            <span class="text-[11px] max-w-xs">Fakultas Ilmu Komputer, UPN "Veteran" Jawa Timur, Surabaya.</span>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
