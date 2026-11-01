<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Katalog Produk' }} — {{ \App\Models\Setting::get('store_name', 'Katalog Bisdi') }}</title>
    
    <!-- Typography: Space Grotesk (Headings) & DM Sans (Body) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400..700;1,9..40,400..700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#0E0A08] text-[#F5EDE6] antialiased min-h-screen flex flex-col relative selection:bg-[#F97316] selection:text-white" x-data="{ mobileMenuOpen: false }">
    
    <!-- 1 Static Grain Noise Texture Across Whole Page (No animation) -->
    <div class="fixed inset-0 pointer-events-none z-50 bg-grain"></div>

    <!-- 1 Single Static Orange Glow Behind Hero (No pulsing, no movement) -->
    <div class="absolute top-0 right-[5%] w-[580px] h-[580px] rounded-full bg-[#F97316]/12 blur-[170px] pointer-events-none -z-10"></div>

    <!-- Floating Glass Island Navbar (Selective Glass) -->
    <header class="sticky top-4 z-40 px-4 sm:px-6 lg:px-8">
        <nav class="max-w-7xl mx-auto glass-surface rounded-2xl px-6 py-3.5 transition-all">
            <div class="flex justify-between items-center">
                
                <!-- Logo & Brand Name -->
                <a href="{{ route('catalog.index') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-[8px] bg-[#201A16] border border-white/10 text-white flex items-center justify-center font-bold text-xs tracking-wider">
                        BD
                    </div>
                    <div>
                        <span class="font-heading font-bold text-base sm:text-lg tracking-tight block text-[#F5EDE6]">
                            {{ \App\Models\Setting::get('store_name', 'Katalog Bisdi') }}
                        </span>
                        <span class="text-[10px] text-[#A39A92] font-medium tracking-wider block -mt-1 uppercase">
                            Fasilkom UPNVJT
                        </span>
                    </div>
                </a>

                <!-- Desktop Navigation Links -->
                <nav class="hidden md:flex items-center gap-6 text-xs font-semibold uppercase tracking-wider">
                    <a href="{{ route('catalog.index') }}" class="py-1 transition-colors duration-150 {{ request()->routeIs('catalog.index') ? 'text-[#F97316]' : 'text-[#A39A92] hover:text-[#F5EDE6]' }}">
                        Katalog
                    </a>
                    <a href="{{ route('pages.contact') }}" class="py-1 transition-colors duration-150 {{ request()->routeIs('pages.contact') ? 'text-[#F97316]' : 'text-[#A39A92] hover:text-[#F5EDE6]' }}">
                        Kontak
                    </a>
                </nav>

                <!-- Right Actions: Cart & Admin -->
                <div class="flex items-center gap-3">
                    <!-- Cart Indicator Button -->
                    <a href="{{ route('cart.index') }}" class="relative inline-flex items-center gap-2 px-3.5 py-2 rounded-[12px] bg-white/[0.04] hover:bg-white/[0.08] border border-white/10 text-[#F5EDE6] text-xs font-medium transition-colors duration-150">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                            <path d="M3 6h18"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                        <span class="hidden sm:inline">Keranjang</span>
                        <span x-show="$store.cart.totalItems > 0" x-text="$store.cart.totalItems" x-cloak class="px-1.5 py-0.2 rounded-full text-[10px] font-bold text-white bg-[#F97316]"></span>
                    </a>

                    <a href="/admin" target="_blank" class="hidden sm:inline-flex text-xs text-[#A39A92] hover:text-[#F5EDE6] transition-colors py-1">
                        Admin
                    </a>

                    <!-- Mobile Toggle -->
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 text-[#A39A92] hover:text-[#F5EDE6]">
                        <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
                        </svg>
                        <svg x-show="mobileMenuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Menu Dropdown -->
            <div x-show="mobileMenuOpen" x-cloak class="md:hidden pt-4 pb-2 border-t border-white/10 mt-3 space-y-2 text-sm font-medium">
                <a href="{{ route('catalog.index') }}" class="block px-3 py-2 rounded-[8px] {{ request()->routeIs('catalog.index') ? 'text-[#F97316]' : 'text-[#F5EDE6] hover:bg-white/[0.04]' }}">
                    Katalog
                </a>
                <a href="{{ route('pages.contact') }}" class="block px-3 py-2 rounded-[8px] {{ request()->routeIs('pages.contact') ? 'text-[#F97316]' : 'text-[#F5EDE6] hover:bg-white/[0.04]' }}">
                    Kontak
                </a>
                <a href="/admin" target="_blank" class="block px-3 py-2 rounded-[8px] text-[#A39A92]">
                    Admin Login
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content Container -->
    <main class="flex-grow z-10">
        @yield('content')
    </main>

    <!-- Solid Warm Surface Footer (No glass, clean architectural border) -->
    <footer class="mt-32 border-t border-white/5 bg-[#17120F]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-white/5">
                
                <div class="md:col-span-6 space-y-3">
                    <span class="font-heading text-xl font-bold text-[#F5EDE6]">
                        {{ \App\Models\Setting::get('store_name', 'Katalog Bisnis Digital') }}
                    </span>
                    <p class="text-xs text-[#A39A92] max-w-sm leading-relaxed">
                        Etalase resmi publikasi dan pemesanan produk digital karya mahasiswa Program Studi Bisnis Digital, Fakultas Ilmu Komputer, UPN "Veteran" Jawa Timur.
                    </p>
                </div>

                <div class="md:col-span-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-[#F5EDE6] mb-3">Tautan</h4>
                    <ul class="space-y-2 text-xs text-[#A39A92]">
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-[#F97316] transition-colors">Semua Produk</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-[#F97316] transition-colors">Keranjang Belanja</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-[#F97316] transition-colors">Kontak Kami</a></li>
                        <li><a href="/admin" target="_blank" class="hover:text-[#F97316] transition-colors">Panel Admin</a></li>
                    </ul>
                </div>

                <div class="md:col-span-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-[#F5EDE6] mb-3">Pemesanan</h4>
                    <p class="text-xs text-[#A39A92] leading-relaxed mb-3">
                        Transaksi dan pengiriman file digital dikoordinasikan langsung melalui WhatsApp resmi.
                    </p>
                    <span class="inline-block px-2.5 py-1 text-[11px] font-semibold text-[#F5EDE6] bg-[#201A16] border border-white/10 rounded-[6px]">
                        WhatsApp Direct
                    </span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center pt-8 text-xs text-[#A39A92] gap-4">
                <p>&copy; {{ date('Y') }} Bisnis Digital UPN "Veteran" Jawa Timur.</p>
                <p>Karya Mahasiswa Fasilkom</p>
            </div>
        </div>
    </footer>

    <!-- Toast Modal Alert (Selective Glass) -->
    <div x-data="{ show: false, message: '' }" 
         @notify.window="message = $event.detail.message; show = true; setTimeout(() => show = false, 3500)"
         x-show="show" 
         x-transition:enter="transition ease-out duration-200 transform"
         x-transition:enter-start="translate-y-4 opacity-0"
         x-transition:enter-end="translate-y-0 opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak
         class="fixed bottom-6 right-6 z-50">
        <div class="glass-surface px-4 py-3 rounded-[12px] flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#F97316" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span class="text-xs font-medium text-[#F5EDE6]" x-text="message"></span>
        </div>
    </div>
</body>
</html>