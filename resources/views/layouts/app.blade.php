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

    {{-- Inline script: terapkan tema SEBELUM render untuk hindari flash --}}
    <script>
        (function() {
            const t = localStorage.getItem('theme');
            if (t === 'light') document.documentElement.classList.add('light');
        })();
    </script>
</head>
<body class="antialiased min-h-screen flex flex-col relative selection:bg-[#F97316] selection:text-white"
      style="background-color: var(--c-bg); color: var(--c-text);"
      x-data="{ mobileMenuOpen: false }"
      x-init="$store.theme.init()">
    
    <!-- Grain Noise Texture -->
    <div class="fixed inset-0 pointer-events-none z-50 bg-grain"></div>

    <!-- Orange Glow Behind Hero -->
    <div class="absolute top-0 right-[5%] w-[580px] h-[580px] rounded-full pointer-events-none -z-10"
         style="background: var(--c-glow); filter: blur(170px);"></div>

    <!-- ── Floating Glass Island Navbar ───────────────────────────── -->
    <header class="sticky top-4 z-40 px-4 sm:px-6 lg:px-8">
        <nav class="max-w-7xl mx-auto glass-surface rounded-2xl px-6 py-3.5 transition-all">
            <div class="flex justify-between items-center">
                
                <!-- Logo & Brand -->
                <a href="{{ route('catalog.index') }}" class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-[8px] flex items-center justify-center font-bold text-xs tracking-wider text-main"
                         style="background-color: var(--c-elevated); border: 1px solid var(--c-border);">
                        BD
                    </div>
                    <div>
                        <span class="font-heading font-bold text-base sm:text-lg tracking-tight block text-main">
                            {{ \App\Models\Setting::get('store_name', 'Katalog Bisdi') }}
                        </span>
                        <span class="text-[10px] font-medium tracking-wider block -mt-1 uppercase text-muted">
                            Fasilkom UPNVJT
                        </span>
                    </div>
                </a>

                <!-- Desktop Nav Links -->
                <nav class="hidden md:flex items-center gap-6 text-xs font-semibold uppercase tracking-wider">
                    <a href="{{ route('catalog.index') }}"
                       class="py-1 transition-colors duration-150 {{ request()->routeIs('catalog.index') ? 'text-[#F97316]' : 'text-muted hover:text-main' }}">
                        Katalog
                    </a>
                    <a href="{{ route('pages.contact') }}"
                       class="py-1 transition-colors duration-150 {{ request()->routeIs('pages.contact') ? 'text-[#F97316]' : 'text-muted hover:text-main' }}">
                        Kontak
                    </a>
                </nav>

                <!-- Right Actions -->
                <div class="flex items-center gap-3">

                    <!-- Cart -->
                    <a href="{{ route('cart.index') }}"
                       class="relative inline-flex items-center gap-2 px-3.5 py-2 rounded-[12px] text-xs font-medium transition-colors duration-150 btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z"/>
                            <path d="M3 6h18"/>
                            <path d="M16 10a4 4 0 0 1-8 0"/>
                        </svg>
                        <span class="hidden sm:inline text-main">Keranjang</span>
                        <span x-show="$store.cart.totalItems > 0" x-text="$store.cart.totalItems" x-cloak
                              class="px-1.5 py-0.2 rounded-full text-[10px] font-bold text-white bg-[#F97316]"></span>
                    </a>

                    <!-- Theme Toggle Button -->
                    <button
                        @click="$store.theme.toggle()"
                        class="w-9 h-9 rounded-[10px] flex items-center justify-center transition-colors duration-150 btn-ghost"
                        :title="$store.theme.dark ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                        aria-label="Toggle theme">
                        <!-- Moon icon (dark mode aktif) -->
                        <svg x-show="$store.theme.dark" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="text-muted">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
                        </svg>
                        <!-- Sun icon (light mode aktif) -->
                        <svg x-show="!$store.theme.dark" x-cloak xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round" class="text-[#F97316]">
                            <circle cx="12" cy="12" r="5"/>
                            <line x1="12" y1="1" x2="12" y2="3"/>
                            <line x1="12" y1="21" x2="12" y2="23"/>
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
                            <line x1="1" y1="12" x2="3" y2="12"/>
                            <line x1="21" y1="12" x2="23" y2="12"/>
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                        </svg>
                    </button>

                    <a href="/admin" target="_blank" class="hidden sm:inline-flex text-xs transition-colors py-1 text-muted hover:text-main">
                        Admin
                    </a>

                    <!-- Mobile Toggle -->
                    <button type="button" @click="mobileMenuOpen = !mobileMenuOpen"
                            class="md:hidden p-2 text-muted hover:text-main">
                        <svg x-show="!mobileMenuOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <line x1="4" x2="20" y1="12" y2="12"/><line x1="4" x2="20" y1="6" y2="6"/><line x1="4" x2="20" y1="18" y2="18"/>
                        </svg>
                        <svg x-show="mobileMenuOpen" x-cloak xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 6 6 18"/><path d="m6 6 12 12"/>
                        </svg>
                    </button>
                </div>

            </div>

            <!-- Mobile Menu -->
            <div x-show="mobileMenuOpen" x-cloak
                 class="md:hidden pt-4 pb-2 mt-3 space-y-2 text-sm font-medium"
                 style="border-top: 1px solid var(--c-border);">
                <a href="{{ route('catalog.index') }}"
                   class="block px-3 py-2 rounded-[8px] {{ request()->routeIs('catalog.index') ? 'text-[#F97316]' : 'text-main hover:bg-elevated' }}">
                    Katalog
                </a>
                <a href="{{ route('pages.contact') }}"
                   class="block px-3 py-2 rounded-[8px] {{ request()->routeIs('pages.contact') ? 'text-[#F97316]' : 'text-main hover:bg-elevated' }}">
                    Kontak
                </a>
                <a href="/admin" target="_blank" class="block px-3 py-2 rounded-[8px] text-muted">
                    Admin Login
                </a>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow z-10">
        @yield('content')
    </main>

    <!-- ── Footer ─────────────────────────────────────────────────── -->
    <footer class="mt-32" style="border-top: 1px solid var(--c-border); background-color: var(--c-surface);">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12" style="border-bottom: 1px solid var(--c-border);">
                
                <div class="md:col-span-6 space-y-3">
                    <span class="font-heading text-xl font-bold text-main">
                        {{ \App\Models\Setting::get('store_name', 'Katalog Bisnis Digital') }}
                    </span>
                    <p class="text-xs text-muted max-w-sm leading-relaxed">
                        Etalase resmi publikasi dan pemesanan produk digital karya mahasiswa Program Studi Bisnis Digital, Fakultas Ilmu Komputer, UPN "Veteran" Jawa Timur.
                    </p>
                </div>

                <div class="md:col-span-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-main mb-3">Tautan</h4>
                    <ul class="space-y-2 text-xs text-muted">
                        <li><a href="{{ route('catalog.index') }}" class="hover:text-[#F97316] transition-colors">Semua Produk</a></li>
                        <li><a href="{{ route('cart.index') }}" class="hover:text-[#F97316] transition-colors">Keranjang Belanja</a></li>
                        <li><a href="{{ route('pages.contact') }}" class="hover:text-[#F97316] transition-colors">Kontak Kami</a></li>
                        <li><a href="/admin" target="_blank" class="hover:text-[#F97316] transition-colors">Panel Admin</a></li>
                    </ul>
                </div>

                <div class="md:col-span-3">
                    <h4 class="text-xs font-bold uppercase tracking-wider text-main mb-3">Pemesanan</h4>
                    <p class="text-xs text-muted leading-relaxed mb-3">
                        Transaksi dan pengiriman file digital dikoordinasikan langsung melalui WhatsApp resmi.
                    </p>
                    <span class="inline-block px-2.5 py-1 text-[11px] font-semibold text-main rounded-[6px]"
                          style="background-color: var(--c-elevated); border: 1px solid var(--c-border);">
                        WhatsApp Direct
                    </span>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row justify-between items-center pt-8 text-xs text-muted gap-4">
                <p>&copy; {{ date('Y') }} Bisnis Digital UPN "Veteran" Jawa Timur.</p>
                <p>Karya Mahasiswa Fasilkom</p>
            </div>
        </div>
    </footer>

    <!-- Toast Notification -->
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
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none"
                 stroke="#F97316" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <polyline points="20 6 9 17 4 12"/>
            </svg>
            <span class="text-xs font-medium text-main" x-text="message"></span>
        </div>
    </div>
</body>
</html>
