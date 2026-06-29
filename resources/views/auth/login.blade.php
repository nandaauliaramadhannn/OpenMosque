<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('Login') }} — OpenMosque Admin</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-surface-900 min-h-screen flex items-center justify-center islamic-pattern">

    {{-- Ambient Glow --}}
    <div class="fixed inset-0 pointer-events-none">
        <div class="absolute top-1/4 left-1/4 w-96 h-96 bg-emerald-500/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-1/4 right-1/4 w-80 h-80 bg-mosque-500/10 rounded-full blur-3xl"></div>
    </div>

    <div class="relative z-10 w-full max-w-md mx-4">
        {{-- Logo --}}
        <div class="text-center mb-8 animate-fade-in">
            <div class="w-16 h-16 rounded-2xl gradient-mosque flex items-center justify-center mx-auto mb-4 animate-float">
                <span class="text-3xl">🕌</span>
            </div>
            <h1 class="text-3xl font-bold font-heading text-gradient-mosque">OpenMosque</h1>
            <p class="text-sm text-gray-500 mt-2">{{ __('Admin Panel') }}</p>
        </div>

        {{-- Login Form --}}
        <div class="glass-dark rounded-2xl p-8 animate-fade-in-up">
            <h2 class="text-xl font-semibold text-white mb-1">{{ __('Welcome back') }}</h2>
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
                    <label for="email" class="block text-sm font-medium text-gray-400 mb-1.5">{{ __('Email Address') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="w-4 h-4 text-gray-600"></i>
                        </div>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                            placeholder="admin@mosque.com"
                            class="form-input w-full pl-10 pr-4 py-3 bg-white/5 border border-white/10 rounded-xl text-white text-sm placeholder:text-gray-600 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20"
                        >
                    </div>
                    @error('email')
                    <p class="mt-1 text-xs text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div x-data="{ showPassword: false }">
                    <label for="password" class="block text-sm font-medium text-gray-400 mb-1.5">{{ __('Password') }}</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="w-4 h-4 text-gray-600"></i>
                        </div>
                        <input
                            :type="showPassword ? 'text' : 'password'"
                            id="password"
                            name="password"
                            required
                            placeholder="••••••••"
                            class="form-input w-full pl-10 pr-12 py-3 bg-white/5 border border-white/10 rounded-xl text-white text-sm placeholder:text-gray-600 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20"
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
                               class="w-4 h-4 rounded border-white/20 bg-white/5 text-emerald-500 focus:ring-emerald-500/20 focus:ring-offset-0">
                        <span class="text-sm text-gray-500">{{ __('Remember me') }}</span>
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
            {{ __('Powered by') }} <a href="https://github.com/openmosque" class="text-emerald-500/70 hover:text-emerald-400 transition-colors">OpenMosque</a> — {{ __('Open Source') }}
        </p>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            lucide.createIcons();
        });
    </script>
</body>
</html>
