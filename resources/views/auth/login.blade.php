<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if(\App\Models\Setting::getValue('app_favicon'))
        <link rel="icon" href="{{ Storage::url(\App\Models\Setting::getValue('app_favicon')) }}">
    @endif
    <title>{{ __('Login') }} — {{ \App\Models\Setting::getValue('app_name', 'OpenMosque') }} Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center relative">
    {{-- Minimal Background Pattern --}}
    <div class="fixed inset-0 islamic-pattern opacity-[0.02] pointer-events-none z-0"></div>

    <div class="relative z-10 w-full max-w-md mx-4">
        {{-- Logo --}}
        <div class="text-center mb-8">
            @if(\App\Models\Setting::getValue('app_logo'))
                <img src="{{ Storage::url(\App\Models\Setting::getValue('app_logo')) }}" alt="Logo" class="w-16 h-16 object-contain mx-auto mb-4">
            @else
                <div class="w-16 h-16 rounded-2xl bg-emerald-600 flex items-center justify-center mx-auto mb-4">
                    <span class="text-3xl">🕌</span>
                </div>
            @endif
            <h1 class="text-3xl font-bold font-heading text-emerald-800">{{ \App\Models\Setting::getValue('app_name', 'OpenMosque') }}</h1>
            <p class="text-sm text-gray-500 mt-2">{{ __('Admin Panel') }}</p>
        </div>

        {{-- Login Form --}}
        <div class="bg-white border border-gray-200 shadow-sm rounded-2xl p-8">
            <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ __('Welcome back') }}</h2>
            <p class="text-sm text-gray-500 mb-6">{{ __('Sign in to manage your mosque') }}</p>

            @if(session('error'))
            <div class="mb-4 p-3 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400 text-sm flex items-center gap-2">
                <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i>
                {{ session('error') }}
            </div>
            @endif

            <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Email Address') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="admin@mosque.com"
                            class="form-input w-full pl-10 pr-4 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-gray-900 text-sm placeholder:text-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 focus:bg-white"
                        >
                    </div>
                    @error('email')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Password') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-4 h-4 text-gray-400"></i>
                        </div>
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            name="password"
                            required
                            placeholder="••••••••"
                            class="form-input w-full pl-10 pr-12 py-3 bg-gray-50/50 border border-gray-200 rounded-xl text-gray-900 text-sm placeholder:text-gray-400 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 focus:bg-white"
                        >
                        <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 pr-3.5 flex items-center text-gray-600 hover:text-gray-400 transition-colors">
                            <i x-show="!showPassword" data-lucide="eye" class="w-4 h-4"></i>
                            <i x-show="showPassword" data-lucide="eye-off" class="w-4 h-4"></i>
                        </button>
                    </div>
                    @error('password')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Remember Me --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <input type="checkbox" name="remember"
                               class="w-4 h-4 rounded border-gray-300 bg-white text-emerald-600 focus:ring-emerald-500/20 focus:ring-offset-0">
                        <span class="text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full py-3 px-4 rounded-xl gradient-mosque text-white font-semibold text-sm hover:opacity-90 transition-all hover:shadow-lg hover:shadow-emerald-500/20 active:scale-[0.98]">
                    {{ __('Sign In') }}
                </button>
            </form>
        </div>

        {{-- Footer --}}
        <p class="text-center text-xs text-gray-600 mt-6">
            {{ __('Powered by') }} <a href="https://github.com/openmosque" class="text-emerald-600 hover:text-emerald-500 transition-colors">{{ \App\Models\Setting::getValue('app_name', 'OpenMosque') }}</a> — {{ __('Open Source') }}
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>
