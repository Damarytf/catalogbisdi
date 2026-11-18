@extends('layouts.app')

@section('content')
<div class="py-12 sm:py-16 min-h-[75vh]" x-data="{ 
    waNumber: '{{ $whatsappNumber }}',
    greeting: '{{ $checkoutGreeting }}',
    closing: '{{ $checkoutClosing }}',
    buyerName: '',
    buyerAddress: '',
    buyerNotes: '',
    
    checkout() {
        if (!this.buyerName || !this.buyerAddress) {
            window.dispatchEvent(new CustomEvent('notify', {
                detail: { message: 'Nama dan Alamat Pengiriman wajib diisi!' }
            }));
            return;
        }

        let message = `${this.greeting}\n\n`;
        
        $store.cart.items.forEach((item, index) => {
            const subtotal = item.effective_price * item.qty;
            message += `${index + 1}. ${item.name} - Qty: ${item.qty} - ${$store.cart.formatPrice(item.effective_price)} = ${$store.cart.formatPrice(subtotal)}\n`;
        });
        
        message += `\nTotal Pesanan: ${$store.cart.formatPrice($store.cart.subtotal)}\n\n`;
        message += `Nama: ${this.buyerName}\n`;
        message += `Alamat / Email: ${this.buyerAddress}\n`;
        if (this.buyerNotes) {
            message += `Catatan: ${this.buyerNotes}\n`;
        }
        message += `\n${this.closing}`;
        
        const encodedMessage = encodeURIComponent(message);
        window.open(`https://wa.me/${this.waNumber}?text=${encodedMessage}`, '_blank');
    }
}">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Judul -->
        <div class="mb-10 pb-6" style="border-bottom: 1px solid var(--c-divider);">
            <h1 class="font-heading text-3xl sm:text-4xl font-bold text-main">Keranjang Belanja</h1>
            <p class="text-xs text-muted mt-1">Konfirmasi pesanan produk digital Anda langsung dengan admin toko.</p>
        </div>

        <div class="flex flex-col lg:flex-row gap-10" x-cloak>
            
            <!-- Keadaan Kosong -->
            <div x-show="$store.cart.items.length === 0"
                 class="w-full rounded-[20px] p-16 text-center card">
                <h2 class="font-heading text-2xl font-bold text-main mb-2">Keranjang Masih Kosong</h2>
                <p class="text-muted text-xs mb-6 max-w-sm mx-auto leading-relaxed">
                    Belum ada produk yang ditambahkan. Silakan telusuri katalog untuk mencari karya yang Anda inginkan.
                </p>
                <a href="{{ route('catalog.index') }}" class="inline-block px-6 py-3 rounded-[12px] bg-[#F97316] hover:bg-[#EA580C] text-white text-xs font-bold uppercase tracking-wider transition-colors duration-150">
                    Kembali ke Katalog
                </a>
            </div>

            <!-- Daftar Item -->
            <div x-show="$store.cart.items.length > 0" class="w-full lg:w-7/12 space-y-4">
                <template x-for="item in $store.cart.items" :key="item.id">
                    <div class="rounded-[16px] p-5 flex items-center gap-4 card">
                        <img :src="item.image" :alt="item.name"
                             class="w-16 h-16 object-cover rounded-[10px] shrink-0"
                             style="background-color: var(--c-elevated); border: 1px solid var(--c-border);">
                        
                        <div class="flex-grow min-w-0">
                            <h3 class="font-heading font-bold text-sm text-main truncate" x-text="item.name"></h3>
                            <div class="text-xs text-[#F97316] font-semibold mt-0.5 tabular-nums"
                                 x-text="$store.cart.formatPrice(item.effective_price)"></div>
                            
                            <!-- Qty Control -->
                            <div class="flex items-center gap-2 mt-3">
                                <button @click="$store.cart.updateQty(item.id, item.qty - 1)"
                                        class="w-6 h-6 rounded-[6px] flex items-center justify-center text-xs font-bold transition-colors btn-qty">−</button>
                                <span class="text-xs font-semibold text-main w-6 text-center tabular-nums" x-text="item.qty"></span>
                                <button @click="$store.cart.updateQty(item.id, item.qty + 1)"
                                        class="w-6 h-6 rounded-[6px] flex items-center justify-center text-xs font-bold transition-colors btn-qty">+</button>
                            </div>
                        </div>

                        <div class="text-right shrink-0">
                            <div class="font-bold text-sm text-main tabular-nums"
                                 x-text="$store.cart.formatPrice(item.effective_price * item.qty)"></div>
                            <button @click="$store.cart.remove(item.id)"
                                    class="text-xs text-muted hover:text-rose-500 mt-2 block ml-auto transition-colors">
                                Hapus
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <!-- Form Pemesan -->
            <div x-show="$store.cart.items.length > 0" class="w-full lg:w-5/12">
                <div class="glass-surface rounded-[20px] p-7 sticky top-24 space-y-5">
                    <h2 class="font-heading text-lg font-bold text-main">Detail Pemesan</h2>
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-main mb-1">Nama Lengkap *</label>
                            <input type="text" x-model="buyerName" placeholder="Contoh: Budi Santoso"
                                   class="input-field w-full px-3.5 py-2.5 rounded-[10px] text-xs">
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-main mb-1">Email / Kontak Aktif *</label>
                            <textarea x-model="buyerAddress" rows="2"
                                      placeholder="Email aktif untuk pengiriman berkas digital"
                                      class="input-field w-full px-3.5 py-2.5 rounded-[10px] text-xs"></textarea>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-main mb-1">Catatan (Opsional)</label>
                            <input type="text" x-model="buyerNotes" placeholder="Pesan untuk admin toko"
                                   class="input-field w-full px-3.5 py-2.5 rounded-[10px] text-xs">
                        </div>
                    </div>

                    <!-- Rincian Harga -->
                    <div class="pt-4 space-y-2" style="border-top: 1px solid var(--c-divider);">
                        <div class="flex justify-between text-xs text-muted">
                            <span>Subtotal</span>
                            <span class="font-semibold text-main tabular-nums" x-text="$store.cart.formatPrice($store.cart.subtotal)"></span>
                        </div>
                        <div class="flex justify-between items-baseline pt-2" style="border-top: 1px solid var(--c-border);">
                            <span class="text-sm font-bold text-main">Total Bayar</span>
                            <span class="text-xl font-bold text-[#F97316] tabular-nums" x-text="$store.cart.formatPrice($store.cart.subtotal)"></span>
                        </div>
                    </div>

                    <!-- WhatsApp CTA -->
                    <button @click="checkout()"
                            class="w-full py-3.5 rounded-[12px] bg-[#F97316] hover:bg-[#EA580C] text-white font-bold text-xs uppercase tracking-wider transition-colors duration-150 flex items-center justify-center gap-2">
                        <span>Pesan Langsung via WhatsApp</span>
                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="5" y1="12" x2="19" y2="12"></line>
                            <polyline points="12 5 19 12 12 19"></polyline>
                        </svg>
                    </button>
                    <p class="text-[10px] text-muted text-center">Format pesan terisi otomatis ke WhatsApp admin toko.</p>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
