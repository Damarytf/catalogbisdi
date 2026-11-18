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
                    @if($product->isAvailable())
                        <div class="pt-6 flex flex-wrap items-center gap-4" style="border-top: 1px solid var(--c-divider);">
                            <button 
                                @click.prevent="$store.cart.add({{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => (float)$product->price, 'sale_price' => (float)$product->sale_price, 'image_url' => $product->image_url]) }})"
                                class="px-6 py-3.5 rounded-[12px] bg-[#F97316] hover:bg-[#EA580C] text-white font-bold text-xs uppercase tracking-wider transition-colors duration-150 flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Tambah ke Keranjang
                            </button>

                            <a href="{{ route('cart.index') }}" class="px-6 py-3.5 rounded-[12px] text-main text-xs font-semibold uppercase tracking-wider transition-colors duration-150 btn-ghost">
                                Buka Keranjang
                            </a>
                        </div>
                    @endif

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
