@extends('layouts.app')

@section('content')
<div class="py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Breadcrumbs -->
        <nav class="flex text-xs text-[#A39A92] mb-8" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li>
                    <a href="{{ route('catalog.index') }}" class="hover:text-[#F97316] transition-colors">Katalog</a>
                </li>
                @if($product->category)
                <li class="flex items-center gap-2">
                    <span class="text-white/20">/</span>
                    <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}" class="hover:text-[#F97316] transition-colors">
                        {{ $product->category->name }}
                    </a>
                </li>
                @endif
                <li class="flex items-center gap-2">
                    <span class="text-white/20">/</span>
                    <span class="text-[#F5EDE6] font-medium line-clamp-1">{{ $product->name }}</span>
                </li>
            </ol>
        </nav>

        <!-- Main Product Card (Solid Surface #17120F, Rounded 20px) -->
        <div class="bg-[#17120F] rounded-[20px] border border-white/[0.08] p-8 sm:p-12 mb-16">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-start">
                
                <!-- Gambar Produk (5 Cols) -->
                <div class="lg:col-span-5">
                    <div class="relative aspect-square rounded-[16px] overflow-hidden bg-[#201A16] border border-white/[0.06]">
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
                
                <!-- Keterangan Produk (7 Cols) -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="flex flex-wrap items-center justify-between gap-3 pb-4 border-b border-white/[0.06]">
                        <span class="text-xs font-semibold uppercase tracking-wider text-[#A39A92]">
                            {{ $product->category->name ?? 'Produk Digital' }}
                        </span>

                        @if($product->isAvailable())
                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium text-emerald-300 bg-emerald-950/60 border border-emerald-500/20">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span>
                                Tersedia ({{ $product->stock }} item)
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium text-[#A39A92] bg-white/[0.04] border border-white/10">
                                Stok Habis
                            </span>
                        @endif
                    </div>
                    
                    <h1 class="font-heading text-3xl sm:text-4xl font-bold text-[#F5EDE6] leading-tight">
                        {{ $product->name }}
                    </h1>
                    
                    <!-- Harga Tabular -->
                    <div class="py-2 flex items-baseline gap-4 tabular-nums">
                        @if($product->isOnSale())
                            <span class="text-3xl sm:text-4xl font-bold text-[#F97316]">{{ $product->formatted_effective_price }}</span>
                            <span class="text-base text-[#A39A92] line-through">{{ $product->formatted_price }}</span>
                        @else
                            <span class="text-3xl sm:text-4xl font-bold text-[#F5EDE6]">{{ $product->formatted_price }}</span>
                        @endif
                    </div>

                    <!-- Deskripsi Detail -->
                    <div class="text-sm text-[#A39A92] leading-relaxed space-y-3 font-light pt-2">
                        {!! nl2br(e($product->description)) !!}
                    </div>

                    <!-- Tombol Aksi -->
                    @if($product->isAvailable())
                        <div class="pt-6 border-t border-white/[0.06] flex flex-wrap items-center gap-4">
                            <button 
                                @click.prevent="$store.cart.add({{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => (float)$product->price, 'sale_price' => (float)$product->sale_price, 'image_url' => $product->image_url]) }})"
                                class="px-6 py-3.5 rounded-[12px] bg-[#F97316] hover:bg-[#EA580C] text-white font-bold text-xs uppercase tracking-wider transition-colors duration-150 flex items-center gap-2"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                                Tambah ke Keranjang
                            </button>

                            <a href="{{ route('cart.index') }}" class="px-6 py-3.5 rounded-[12px] bg-white/[0.04] hover:bg-white/[0.08] text-[#F5EDE6] border border-white/10 text-xs font-semibold uppercase tracking-wider transition-colors duration-150">
                                Buka Keranjang
                            </a>
                        </div>
                    @endif

                </div>
            </div>
        </div>

        <!-- Produk Terkait -->
        @if($relatedProducts->count() > 0)
            <div class="mt-20 pt-10 border-t border-white/[0.06]">
                <h2 class="font-heading text-2xl font-bold text-[#F5EDE6] mb-6">Produk Terkait Lainnya</h2>

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
