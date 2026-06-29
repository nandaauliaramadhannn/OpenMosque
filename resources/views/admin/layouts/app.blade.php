<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $isRtl ?? false ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Admin') — OpenMosque</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&family=Amiri:wght@400;700&family=Noto+Sans+Arabic:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-900 text-gray-100 custom-scrollbar" x-data="{ sidebarOpen: false }">

    <div class="flex min-h-screen">
        {{-- Sidebar Overlay (Mobile) --}}
        <div
            x-show="sidebarOpen"
            x-transition:enter="transition-opacity ease-out duration-300"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-in duration-200"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0"
            @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/60 z-40 md:hidden"
        ></div>

        {{-- Sidebar --}}
        <aside
            class="admin-sidebar fixed md:sticky top-0 h-screen w-[260px] flex flex-col z-50 transition-transform duration-300 md:translate-x-0"
            :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full md:translate-x-0'"
        >
            {{-- Logo --}}
            <div class="p-5 border-b border-white/5">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl gradient-mosque flex items-center justify-center">
                        <span class="text-xl">🕌</span>
                    </div>
                    <div>
                        <h1 class="text-lg font-bold font-heading text-gradient-mosque">OpenMosque</h1>
                        <p class="text-[10px] text-gray-500 uppercase tracking-widest">Admin Panel</p>
                    </div>
                </a>
            </div>

            {{-- Navigation --}}
            <nav class="flex-1 p-4 space-y-1 overflow-y-auto custom-scrollbar">
                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-3 px-3">{{ __('Main') }}</p>

                <a href="{{ route('admin.dashboard') }}"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Dashboard') }}</span>
                </a>

                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-3 mt-6 px-3">{{ __('Content') }}</p>

                <a href="#"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                    <i data-lucide="megaphone" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Announcements') }}</span>
                </a>

                <a href="#"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
                    <i data-lucide="calendar-days" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Events') }}</span>
                </a>

                <a href="#"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <i data-lucide="file-text" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Pages') }}</span>
                </a>

                <a href="#"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.media.*') ? 'active' : '' }}">
                    <i data-lucide="image" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Media Library') }}</span>
                </a>

                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-3 mt-6 px-3">{{ __('Mosque') }}</p>

                <a href="#"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.prayer-times.*') ? 'active' : '' }}">
                    <i data-lucide="clock" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Prayer Times') }}</span>
                </a>

                <a href="#"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.donations.*') ? 'active' : '' }}">
                    <i data-lucide="heart-handshake" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Donations') }}</span>
                </a>

                <a href="#"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.services.*') ? 'active' : '' }}">
                    <i data-lucide="hand-helping" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Services') }}</span>
                </a>

                <a href="#"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                    <i data-lucide="users" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Staff') }}</span>
                </a>

                <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-3 mt-6 px-3">{{ __('System') }}</p>

                <a href="#"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <i data-lucide="settings" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Settings') }}</span>
                </a>

                <a href="#"
                   class="nav-link flex items-center gap-3 px-3 py-2.5 text-sm text-gray-400 {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                    <i data-lucide="shield" class="w-[18px] h-[18px]"></i>
                    <span>{{ __('Users & Roles') }}</span>
                </a>
            </nav>

            {{-- Sidebar Footer --}}
            <div class="p-4 border-t border-white/5">
                <a href="{{ route('home') }}" target="_blank"
                   class="flex items-center gap-2 px-3 py-2 text-sm text-gray-500 hover:text-emerald-400 transition-colors rounded-lg hover:bg-white/5">
                    <i data-lucide="external-link" class="w-4 h-4"></i>
                    <span>{{ __('View Website') }}</span>
                </a>
            </div>
        </aside>

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col min-w-0">
            {{-- Top Header --}}
            <header class="sticky top-0 z-30 glass-dark px-4 md:px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        {{-- Mobile Menu Toggle --}}
                        <button @click="sidebarOpen = !sidebarOpen" class="md:hidden p-2 text-gray-400 hover:text-white rounded-lg hover:bg-white/5">
                            <i data-lucide="menu" class="w-5 h-5"></i>
                        </button>

                        {{-- Breadcrumb --}}
                        <div class="hidden md:flex items-center gap-2 text-sm text-gray-500">
                            <span>{{ __('Admin') }}</span>
                            <i data-lucide="chevron-right" class="w-3 h-3"></i>
                            <span class="text-gray-300">@yield('breadcrumb', __('Dashboard'))</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-3">
                        {{-- Language Switcher --}}
                        <div x-data="{ langOpen: false }" class="relative">
                            <button @click="langOpen = !langOpen" class="flex items-center gap-2 px-3 py-1.5 text-sm text-gray-400 hover:text-white rounded-lg hover:bg-white/5 transition-colors">
                                <i data-lucide="globe" class="w-4 h-4"></i>
                                <span class="uppercase">{{ app()->getLocale() }}</span>
                            </button>
                            <div x-show="langOpen" @click.outside="langOpen = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-36 glass-dark rounded-xl shadow-xl border border-white/10 py-1 z-50">
                                @foreach(['en' => 'English', 'ar' => 'العربية', 'id' => 'Indonesia', 'ms' => 'Melayu', 'tr' => 'Türkçe', 'fr' => 'Français'] as $code => $lang)
                                <a href="?lang={{ $code }}"
                                   class="block px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5 {{ app()->getLocale() === $code ? 'text-emerald-400' : '' }}">
                                    {{ $lang }}
                                </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- User Menu --}}
                        <div x-data="{ userOpen: false }" class="relative">
                            <button @click="userOpen = !userOpen" class="flex items-center gap-2 px-3 py-1.5 rounded-lg hover:bg-white/5 transition-colors">
                                <div class="w-8 h-8 rounded-full gradient-mosque flex items-center justify-center text-sm font-semibold text-white">
                                    {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
                                </div>
                                <span class="hidden md:block text-sm text-gray-300">{{ auth()->user()->name ?? 'Admin' }}</span>
                                <i data-lucide="chevron-down" class="w-3 h-3 text-gray-500"></i>
                            </button>
                            <div x-show="userOpen" @click.outside="userOpen = false"
                                 x-transition
                                 class="absolute right-0 mt-2 w-48 glass-dark rounded-xl shadow-xl border border-white/10 py-1 z-50">
                                <div class="px-4 py-3 border-b border-white/5">
                                    <p class="text-sm font-medium text-white">{{ auth()->user()->name ?? 'Admin' }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email ?? '' }}</p>
                                </div>
                                <a href="#" class="flex items-center gap-2 px-4 py-2 text-sm text-gray-400 hover:text-white hover:bg-white/5">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                    {{ __('Profile') }}
                                </a>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2 w-full px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-white/5">
                                        <i data-lucide="log-out" class="w-4 h-4"></i>
                                        {{ __('Logout') }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-4 md:p-6 lg:p-8">
                {{-- Flash Messages --}}
                @if(session('success'))
                <div class="mb-6 p-4 rounded-xl bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 text-sm animate-fade-in flex items-center gap-3">
                    <i data-lucide="check-circle" class="w-5 h-5 shrink-0"></i>
                    <span>{{ session('success') }}</span>
                </div>
                @endif

                @if(session('error'))
                <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm animate-fade-in flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0"></i>
                    <span>{{ session('error') }}</span>
                </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    {{-- Initialize Lucide Icons --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>

    @stack('scripts')
</body>
</html>
