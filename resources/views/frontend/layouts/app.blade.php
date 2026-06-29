<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $isRtl ?? false ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Home') — OpenMosque</title>
    <meta name="description" content="@yield('meta_description', 'Welcome to our mosque — a place of worship, community, and learning.')">

    <!-- Open Graph -->
    <meta property="og:title" content="@yield('title', 'OpenMosque')">
    <meta property="og:description" content="@yield('meta_description', 'Welcome to our mosque')">
    <meta property="og:type" content="website">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&family=Amiri:wght@400;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('head')
</head>
<body class="bg-white text-gray-800 font-sans antialiased" x-data="{ mobileMenuOpen: false }">

    {{-- Navigation --}}
    <nav class="fixed top-0 left-0 right-0 z-50 transition-all duration-300"
         x-data="{ scrolled: false }"
         x-init="window.addEventListener('scroll', () => { scrolled = window.scrollY > 50 })"
         :class="scrolled ? 'bg-white/95 backdrop-blur-lg shadow-lg shadow-black/5' : 'bg-transparent'">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 md:h-20">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3 shrink-0">
                    <div class="w-10 h-10 rounded-xl gradient-mosque flex items-center justify-center">
                        <span class="text-xl">🕌</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold font-heading" :class="scrolled ? 'text-emerald-800' : 'text-white'">
                            {{ $mosque->getTranslation('name') ?? 'OpenMosque' }}
                        </h1>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <div class="hidden md:flex items-center gap-1">
                    @php
                        $navLinks = [
                            ['route' => 'home', 'label' => __('Home')],
                            ['url' => '#prayer-times', 'label' => __('Prayer Times')],
                            ['url' => '#events', 'label' => __('Events')],
                            ['url' => '#about', 'label' => __('About')],
                            ['url' => '#services', 'label' => __('Services')],
                            ['url' => '#contact', 'label' => __('Contact')],
                        ];
                    @endphp

                    @foreach($navLinks as $link)
                    <a href="{{ $link['url'] ?? route($link['route']) }}"
                       class="px-4 py-2 text-sm font-medium rounded-lg transition-colors"
                       :class="scrolled ? 'text-gray-600 hover:text-emerald-700 hover:bg-emerald-50' : 'text-white/80 hover:text-white hover:bg-white/10'">
                        {{ $link['label'] }}
                    </a>
                    @endforeach

                    {{-- Donate CTA --}}
                    <a href="#donate"
                       class="ml-2 px-5 py-2.5 text-sm font-semibold rounded-xl gradient-mosque text-white hover:opacity-90 transition-all hover:shadow-lg hover:shadow-emerald-500/25 active:scale-[0.98]">
                        {{ __('Donate') }}
                    </a>

                    {{-- Language Switcher --}}
                    <div x-data="{ langOpen: false }" class="relative ml-2">
                        <button @click="langOpen = !langOpen"
                                class="p-2 rounded-lg transition-colors"
                                :class="scrolled ? 'text-gray-500 hover:text-emerald-700 hover:bg-emerald-50' : 'text-white/60 hover:text-white hover:bg-white/10'">
                            <i data-lucide="globe" class="w-4 h-4"></i>
                        </button>
                        <div x-show="langOpen" @click.outside="langOpen = false" x-transition
                             class="absolute right-0 mt-2 w-36 bg-white rounded-xl shadow-xl border border-gray-100 py-1 z-50">
                            @foreach(['en' => 'English', 'ar' => 'العربية', 'id' => 'Indonesia'] as $code => $lang)
                            <a href="?lang={{ $code }}"
                               class="block px-4 py-2 text-sm text-gray-600 hover:text-emerald-700 hover:bg-emerald-50 {{ app()->getLocale() === $code ? 'text-emerald-600 font-medium' : '' }}">
                                {{ $lang }}
                            </a>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- Mobile Menu Toggle --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen" class="md:hidden p-2 rounded-lg"
                        :class="scrolled ? 'text-gray-600' : 'text-white'">
                    <i x-show="!mobileMenuOpen" data-lucide="menu" class="w-6 h-6"></i>
                    <i x-show="mobileMenuOpen" data-lucide="x" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        {{-- Mobile Menu --}}
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 -translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="opacity-100 translate-y-0"
             x-transition:leave-end="opacity-0 -translate-y-2"
             class="md:hidden bg-white border-t border-gray-100 shadow-xl">
            <div class="px-4 py-3 space-y-1">
                <a href="{{ route('home') }}" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg">{{ __('Home') }}</a>
                <a href="#prayer-times" @click="mobileMenuOpen = false" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg">{{ __('Prayer Times') }}</a>
                <a href="#events" @click="mobileMenuOpen = false" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg">{{ __('Events') }}</a>
                <a href="#about" @click="mobileMenuOpen = false" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg">{{ __('About') }}</a>
                <a href="#contact" @click="mobileMenuOpen = false" class="block px-4 py-2.5 text-sm text-gray-700 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg">{{ __('Contact') }}</a>
                <div class="pt-2">
                    <a href="#donate" class="block px-4 py-2.5 text-sm text-center font-semibold rounded-xl gradient-mosque text-white">{{ __('Donate') }}</a>
                </div>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-surface-900 text-gray-400 islamic-pattern-gold">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
                {{-- Mosque Info --}}
                <div class="lg:col-span-1">
                    <a href="{{ route('home') }}" class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 rounded-xl gradient-mosque flex items-center justify-center">
                            <span class="text-xl">🕌</span>
                        </div>
                        <h3 class="text-lg font-bold text-gradient-mosque font-heading">OpenMosque</h3>
                    </a>
                    <p class="text-sm text-gray-500 leading-relaxed mb-4">
                        {{ $mosque->getTranslation('description') ?? __('A place of worship, community, and learning for all.') }}
                    </p>
                    @if($mosque && $mosque->social_links)
                    <div class="flex items-center gap-3">
                        @foreach($mosque->social_links as $platform => $url)
                        @if($url)
                        <a href="{{ $url }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-emerald-500/20 flex items-center justify-center text-gray-500 hover:text-emerald-400 transition-all">
                            <i data-lucide="{{ $platform }}" class="w-4 h-4"></i>
                        </a>
                        @endif
                        @endforeach
                    </div>
                    @endif
                </div>

                {{-- Quick Links --}}
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">{{ __('Quick Links') }}</h4>
                    <ul class="space-y-2">
                        <li><a href="#prayer-times" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors">{{ __('Prayer Times') }}</a></li>
                        <li><a href="#events" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors">{{ __('Events') }}</a></li>
                        <li><a href="#about" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors">{{ __('About Us') }}</a></li>
                        <li><a href="#services" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors">{{ __('Services') }}</a></li>
                        <li><a href="#donate" class="text-sm text-gray-500 hover:text-emerald-400 transition-colors">{{ __('Donate') }}</a></li>
                    </ul>
                </div>

                {{-- Contact Info --}}
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">{{ __('Contact') }}</h4>
                    <ul class="space-y-3">
                        @if($mosque && $mosque->address)
                        <li class="flex items-start gap-2 text-sm text-gray-500">
                            <i data-lucide="map-pin" class="w-4 h-4 shrink-0 mt-0.5 text-emerald-500/50"></i>
                            <span>{{ $mosque->address }}</span>
                        </li>
                        @endif
                        @if($mosque && $mosque->phone)
                        <li class="flex items-center gap-2 text-sm text-gray-500">
                            <i data-lucide="phone" class="w-4 h-4 shrink-0 text-emerald-500/50"></i>
                            <span>{{ $mosque->phone }}</span>
                        </li>
                        @endif
                        @if($mosque && $mosque->email)
                        <li class="flex items-center gap-2 text-sm text-gray-500">
                            <i data-lucide="mail" class="w-4 h-4 shrink-0 text-emerald-500/50"></i>
                            <span>{{ $mosque->email }}</span>
                        </li>
                        @endif
                    </ul>
                </div>

                {{-- Newsletter / Prayer Times Mini --}}
                <div>
                    <h4 class="text-sm font-semibold text-white uppercase tracking-wider mb-4">{{ __('Stay Connected') }}</h4>
                    <p class="text-sm text-gray-500 mb-3">{{ __('Get updates about our mosque activities.') }}</p>
                    <form class="flex gap-2">
                        <input type="email" placeholder="{{ __('Your email') }}"
                               class="flex-1 px-3 py-2 bg-white/5 border border-white/10 rounded-lg text-sm text-white placeholder:text-gray-600 focus:outline-none focus:border-emerald-500">
                        <button type="submit" class="px-4 py-2 gradient-mosque text-white text-sm rounded-lg hover:opacity-90 transition-all">
                            <i data-lucide="send" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bottom Bar --}}
        <div class="border-t border-white/5">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-5 flex flex-col md:flex-row items-center justify-between gap-3">
                <p class="text-xs text-gray-600">
                    © {{ date('Y') }} OpenMosque. {{ __('Open Source') }} — <a href="https://github.com/openmosque" class="text-emerald-500/60 hover:text-emerald-400 transition-colors">GitHub</a>
                </p>
                <p class="text-xs text-gray-600">
                    {{ __('Built with') }} ❤️ {{ __('for the Muslim community') }}
                </p>
            </div>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>

    @stack('scripts')
</body>
</html>
