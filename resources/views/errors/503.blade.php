<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $isRtl ?? false ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    @if(\App\Models\Setting::getValue('app_favicon'))
        <link rel="icon" href="{{ Storage::url(\App\Models\Setting::getValue('app_favicon')) }}">
    @endif
    
    <title>{{ __('Maintenance Mode') }} — {{ \App\Models\Setting::getValue('app_name', 'OpenMosque') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center relative">
    {{-- Minimal Background Pattern --}}
    <div class="fixed inset-0 islamic-pattern opacity-[0.02] pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-lg mx-4 text-center">
        {{-- Logo --}}
        <div class="mb-8">
            @if(\App\Models\Setting::getValue('app_logo'))
                <img src="{{ Storage::url(\App\Models\Setting::getValue('app_logo')) }}" alt="Logo" class="w-20 h-20 object-contain mx-auto mb-5 drop-shadow-sm">
            @else
                <div class="w-20 h-20 rounded-2xl bg-emerald-600 flex items-center justify-center mx-auto mb-5 shadow-lg shadow-emerald-600/20">
                    <span class="text-4xl">🕌</span>
                </div>
            @endif
            <h1 class="text-3xl md:text-4xl font-bold font-heading text-gray-900 mb-2">
                {{ __('We are under maintenance') }}
            </h1>
            <p class="text-gray-500 text-lg">
                {{ __('We are currently updating our systems to serve you better. Please check back later.') }}
            </p>
        </div>

        {{-- Return to admin if logged in (Optional) --}}
        @auth
            <div class="mt-8">
                <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl gradient-mosque text-white font-medium hover:opacity-90 transition-all shadow-md shadow-emerald-500/20">
                    <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                    {{ __('Go to Admin Dashboard') }}
                </a>
            </div>
        @endauth
        
        <div class="mt-12 text-sm text-gray-400">
            &copy; {{ date('Y') }} {{ \App\Models\Setting::getValue('app_name', 'OpenMosque') }}
        </div>
    </div>

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>
