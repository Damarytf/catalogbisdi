@extends('layouts.app')

@section('content')
<div class="py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex text-xs text-muted mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li>
                    <a href="{{ route('catalog.index') }}" class="hover:text-[#F97316] transition-colors">Katalog</a>
                </li>
                @if($product->category)
                <li class="flex items-center gap-2">
                    <span class="text-muted opacity-40">/</span>
                    <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="hover:text-[#F97316] transition-colors">
                        {{ $product->category->name }}
                    </a>
                </li>
                @endif
                <li class="flex items-center gap-2">
                    <span class="text-muted opacity-40">/</span>
                    <span class="text-main font-medium line-clamp-1">{{ $product->name }}</span>
                </li>
            </ol>
        </nav>

        <!-- Main Product Card -->
        <div class="rounded-[20px] p-8 sm:p-12 mb-16 card">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Gambar (5 Cols) -->
                <div class="lg:col-span-5">
                    <div class="relative aspect-square rounded-[16px] overflow-hidden"
                         style="background-color: var(--c-elevated); border: 1px solid var(--c-border);">
                        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @if($product->isOnSale())
                            <div class="absolute top-3 left-3">
                                <span class="glass-pill px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-white bg-black/40">
                                    <span class="text-[#F97316] mr-1">•</span> Diskon
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <!-- Keterangan (7 Cols) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-4" style="border-bottom: 1px solid var(--c-divider);">
                        <span class="text-xs font-semibold uppercase tracking-wider text-muted">
                            {{ $product->category->name ?? 'Produk Digital' }}
                        </span>

                        @if($product->isAvailable())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium"
                                  style="color: var(--c-stock-text); background-color: var(--c-stock-bg); border: 1px solid var(--c-stock-border);">
                                <span class="w-1.5 h-1.5 rounded-full" style="background-color: var(--c-stock-text);"></span>
                                Tersedia ({{ $product->stock }} item)
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-muted btn-ghost">
                                Stok Habis
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="font-heading text-3xl sm:text-4xl font-bold text-main leading-tight">
                        {{ $product->name }}
                    </h1>
                    
                    <!-- Harga -->
                    <div class="py-2 flex items-baseline gap-4 tabular-nums">
                        @if($product->isOnSale())
                            <span class="text-3xl sm:text-4xl font-bold text-[#F97316]">{{ $product->formatted_effective_price }}</span>
                            <span class="text-base text-muted line-through">{{ $product->formatted_price }}</span>
                        @else
                            <span class="text-3xl sm:text-4xl font-bold text-main">{{ $product->formatted_price }}</span>
                        @endif
                    </div>

                    <!-- Deskripsi -->
                    <div class="text-sm text-muted leading-relaxed space-y-3 font-light pt-2">
                        {!! nl2br(e($product->description)) !!}
                    </div>

                    <!-- Tombol Aksi -->
                    <div class="pt-6 flex flex-wrap items-center gap-4" style="border-top: 1px solid var(--c-divider);">
                        @if($product->isAvailable())
                            @php
                                $waPhone = preg_replace('/^0/', '62', preg_replace('/[^\d]/', '', \App\Models\Setting::get('whatsapp_number', '6281234567890')));
                                $waText = rawurlencode("Halo Admin Bisdi, saya tertarik untuk bertanya/konsultasi mengenai produk: *" . $product->name . "*.\nLink: " . route('catalog.show', $product->slug));
                            @endphp
                            <a href="https://wa.me/{{ $waPhone }}?text={{ $waText }}" target="_blank"
                               class="px-6 py-3.5 rounded-[12px] bg-[#10B981] hover:bg-[#059669] text-white font-bold text-xs uppercase tracking-wider transition-colors duration-150 flex items-center gap-2 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                Tanya Admin via WhatsApp
                            </a>
                        @endif

                        <a href="{{ route('catalog.index') }}" class="px-6 py-3.5 rounded-[12px] text-main text-xs font-semibold uppercase tracking-wider transition-colors duration-150 btn-ghost">
                            ← Kembali ke Katalog
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- Produk Terkait -->
        @if($relatedProducts->count() > 0)
            <div class="mt-20 pt-10" style="border-top: 1px solid var(--c-divider);">
                <h2 class="font-heading text-2xl font-bold text-main mb-6">Produk Terkait Lainnya</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <x-product-card :product="$related" />
                    @endforeach
                </div>
            </div>
        @endif

    </div>
</div>
@endsection
