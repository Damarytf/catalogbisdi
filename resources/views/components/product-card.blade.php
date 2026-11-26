@props(['product'])

<div class="rounded-[20px] overflow-hidden flex flex-col h-full transition-all duration-200 group card hover:border-[#F97316]/50"
     style="border-color: var(--c-border);">
    
    <!-- Image Area -->
    <a href="{{ route('catalog.show', $product->slug) }}" class="block relative aspect-[4/3] overflow-hidden"
       style="background-color: var(--c-elevated);">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}"
             class="object-cover w-full h-full group-hover:scale-[1.03] transition-transform duration-250 ease-out">
        
        <!-- Badges -->
        <div class="absolute top-3 left-3 flex flex-wrap gap-1.5 z-10">
            @if($product->isOnSale())
                <span class="glass-pill px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-white bg-black/40">
                    <span class="text-[#F97316] mr-0.5">•</span> Diskon
                </span>
            @endif
            @if($product->is_featured)
                <span class="glass-pill px-2.5 py-1 rounded-full text-[10px] font-bold uppercase tracking-wider text-white bg-black/40">
                    Unggulan
                </span>
            @endif
        </div>

        @if(!$product->isAvailable())
            <div class="absolute inset-0 bg-black/60 backdrop-blur-[2px] flex items-center justify-center z-20">
                <span class="text-[11px] font-bold text-white/70 uppercase tracking-wider px-3 py-1 rounded-full"
                      style="border: 1px solid rgba(255,255,255,0.15);">Stok Habis</span>
            </div>
        @endif
    </a>
    
    <!-- Content Body -->
    <div class="p-5 flex flex-col flex-grow">
        <!-- Category -->
        <span class="text-[11px] font-semibold tracking-wider uppercase text-muted mb-1.5 block">
            {{ $product->category->name ?? 'Produk Digital' }}
        </span>
        
        <!-- Product Name -->
        <a href="{{ route('catalog.show', $product->slug) }}" class="block mb-2">
            <h3 class="font-heading font-bold text-base text-main group-hover:text-[#F97316] transition-colors duration-150 line-clamp-2 leading-snug">
                {{ $product->name }}
            </h3>
        </a>

        <!-- Description -->
        @if($product->description)
            <p class="text-xs text-muted line-clamp-2 mb-4 leading-relaxed font-light">
                {{ strip_tags($product->description) }}
            </p>
        @endif
        
        <!-- Price & Action -->
        <div class="mt-auto pt-4 flex items-center justify-between" style="border-top: 1px solid var(--c-divider);">
            <div class="tabular-nums">
                @if($product->isOnSale())
                    <div class="text-[11px] text-muted line-through mb-0.5">{{ $product->formatted_price }}</div>
                    <div class="text-base font-bold text-[#F97316]">{{ $product->formatted_effective_price }}</div>
                @else
                    <div class="text-base font-bold text-main">{{ $product->formatted_price }}</div>
                @endif
            </div>
            
            <a href="{{ route('catalog.show', $product->slug) }}"
               class="px-3 py-1.5 rounded-[8px] text-xs font-semibold text-[#F97316] transition-colors duration-150 hover:bg-[#F97316] hover:text-white btn-ghost"
               title="Lihat Detail">
                Detail →
            </a>
        </div>
    </div>
</div>
