@props(['product'])

<div class="bg-[#17120F] rounded-[20px] border border-white/[0.07] hover:border-[#F97316]/50 overflow-hidden flex flex-col h-full transition-all duration-200 group">
    
    <!-- Image Area with Selective Glass Badges -->
    <a href="{{ route('catalog.show', $product->slug) }}" class="block relative aspect-[4/3] overflow-hidden bg-[#201A16]">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="object-cover w-full h-full group-hover:scale-[1.03] transition-transform duration-250 ease-out">
        
        <!-- Selective Glass Badges on Top of Image -->
        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 z-10">
            @if($product->isOnSale())
                <span class="glass-pill px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-white bg-black/40">
                    <span class="text-[#F97316] mr-0.5">•</span> Diskon
                </span>
            @endif
            @if($product->is_featured)
                <span class="glass-pill px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-[#F5EDE6] bg-black/40">
                    Unggulan
                </span>
            @endif
        </div>

        @if(!$product->isAvailable())
            <div class="absolute inset-0 bg-[#0E0A08]/75 backdrop-blur-[2px] flex items-center justify-center z-20">
                <span class="text-[11px] font-bold text-[#A39A92] uppercase tracking-wider px-3 py-1 border border-white/10 rounded-full">Stok Habis</span>
            </div>
        @endif
    </a>
    
    <!-- Content Body (Solid Surface) -->
    <div class="p-5 flex flex-col flex-grow">
        <!-- Category -->
        <span class="text-[11px] font-semibold tracking-wider uppercase text-[#A39A92] mb-1.5 block">
            {{ $product->category->name ?? 'Produk Digital' }}
        </span>
        
        <!-- Product Name -->
        <a href="{{ route('catalog.show', $product->slug) }}" class="block mb-2">
            <h3 class="font-heading font-bold text-base text-[#F5EDE6] group-hover:text-[#F97316] transition-colors duration-150 line-clamp-2 leading-snug">
                {{ $product->name }}
            </h3>
        </a>

        <!-- Description Snippet -->
        @if($product->description)
            <p class="text-xs text-[#A39A92] line-clamp-2 mb-4 leading-relaxed font-light">
                {{ strip_tags($product->description) }}
            </p>
        @endif
        
        <!-- Price & Action (Tabular Numbers) -->
        <div class="mt-auto pt-4 border-t border-white/[0.06] flex items-center justify-between">
            <div class="tabular-nums">
                @if($product->isOnSale())
                    <div class="text-[11px] text-[#A39A92] line-through mb-0.5">{{ $product->formatted_price }}</div>
                    <div class="text-base font-bold text-[#F97316]">{{ $product->formatted_effective_price }}</div>
                @else
                    <div class="text-base font-bold text-[#F5EDE6]">{{ $product->formatted_price }}</div>
                @endif
            </div>
            
            @if($product->isAvailable())
                <button 
                    @click.prevent="$store.cart.add({{ json_encode(['id' => $product->id, 'name' => $product->name, 'price' => (float)$product->price, 'sale_price' => (float)$product->sale_price, 'image_url' => $product->image_url]) }})"
                    class="w-9 h-9 rounded-[10px] bg-white/[0.04] hover:bg-[#F97316] border border-white/10 hover:border-[#F97316] text-[#F5EDE6] hover:text-white flex items-center justify-center transition-colors duration-150 active:scale-95"
                    title="Tambah ke Keranjang"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="12" y1="5" x2="12" y2="19"></line>
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                </button>
            @endif
        </div>
    </div>
</div>