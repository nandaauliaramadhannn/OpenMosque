@extends('frontend.layouts.app')

@section('title', $mosque ? $mosque->getTranslation('name') : 'OpenMosque')

@section('content')
{{-- Hero Section --}}
<section class="relative min-h-screen flex items-center gradient-hero overflow-hidden">
    <div class="absolute inset-0 islamic-pattern opacity-30"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-transparent via-transparent to-black/40"></div>
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-32 text-center">
        <div class="animate-fade-in-up">
            <p class="text-emerald-300/80 text-sm font-medium uppercase tracking-[0.2em] mb-4">بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ</p>
            <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold font-heading text-white leading-tight mb-6">
                {{ $mosque ? $mosque->getTranslation('name') : 'OpenMosque' }}
            </h1>
            <p class="text-lg md:text-xl text-emerald-100/70 max-w-2xl mx-auto mb-10">
                {{ $mosque ? $mosque->getTranslation('description') : __('A place of worship, community, and learning for all.') }}
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="#prayer-times" class="px-8 py-4 rounded-2xl gradient-mosque text-white font-semibold hover:shadow-xl hover:shadow-emerald-500/25 transition-all active:scale-[0.98]">
                    <span class="flex items-center gap-2"><i data-lucide="clock" class="w-5 h-5"></i> {{ __('Prayer Times') }}</span>
                </a>
                <a href="#donate" class="px-8 py-4 rounded-2xl bg-white/10 backdrop-blur text-white font-semibold border border-white/20 hover:bg-white/20 transition-all">
                    <span class="flex items-center gap-2"><i data-lucide="heart" class="w-5 h-5"></i> {{ __('Donate Now') }}</span>
                </a>
            </div>
        </div>
    </div>
    {{-- Decorative bottom wave --}}
    <div class="absolute bottom-0 left-0 right-0">
        <svg viewBox="0 0 1440 100" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0 50L48 45C96 40 192 30 288 28C384 26 480 32 576 40C672 48 768 58 864 55C960 52 1056 36 1152 30C1248 24 1344 28 1392 30L1440 32V100H1392C1344 100 1248 100 1152 100C1056 100 960 100 864 100C768 100 672 100 576 100C480 100 384 100 288 100C192 100 96 100 48 100H0V50Z" fill="white"/></svg>
    </div>
</section>

{{-- Prayer Times Section --}}
<section id="prayer-times" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-emerald-600 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('Daily Schedule') }}</p>
            <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900">{{ __('Prayer Times') }}</h2>
            <p class="text-gray-500 mt-3 max-w-lg mx-auto">{{ __('Stay connected with your daily prayers') }}</p>
        </div>

        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
            @php
                $prayers = [
                    ['name' => 'Fajr', 'icon' => '🌅', 'key' => 'fajr', 'iqamah_key' => 'iqamah_fajr'],
                    ['name' => 'Sunrise', 'icon' => '☀️', 'key' => 'sunrise', 'iqamah_key' => null],
                    ['name' => 'Dhuhr', 'icon' => '🌤️', 'key' => 'dhuhr', 'iqamah_key' => 'iqamah_dhuhr'],
                    ['name' => 'Asr', 'icon' => '🌇', 'key' => 'asr', 'iqamah_key' => 'iqamah_asr'],
                    ['name' => 'Maghrib', 'icon' => '🌆', 'key' => 'maghrib', 'iqamah_key' => 'iqamah_maghrib'],
                    ['name' => 'Isha', 'icon' => '🌙', 'key' => 'isha', 'iqamah_key' => 'iqamah_isha'],
                ];
            @endphp
            @foreach($prayers as $prayer)
            <div class="prayer-card bg-gradient-to-b from-emerald-50 to-white rounded-2xl p-5 text-center border border-emerald-100 card-hover">
                <span class="text-3xl mb-3 block">{{ $prayer['icon'] }}</span>
                <h3 class="font-semibold text-gray-900 text-sm">{{ __($prayer['name']) }}</h3>
                <p class="text-2xl font-bold text-emerald-700 mt-2">
                    {{ $prayerTimes && $prayerTimes->{$prayer['key']} ? \Carbon\Carbon::parse($prayerTimes->{$prayer['key']})->format('h:i A') : '--:--' }}
                </p>
                @if($prayer['iqamah_key'] && $prayerTimes && $prayerTimes->{$prayer['iqamah_key']})
                <p class="text-xs text-gray-400 mt-1">{{ __('Iqamah') }}: {{ \Carbon\Carbon::parse($prayerTimes->{$prayer['iqamah_key']})->format('h:i A') }}</p>
                @endif
            </div>
            @endforeach
        </div>

        <p class="text-center text-xs text-gray-400 mt-6">
            {{ __('Date') }}: {{ now()->format('l, F d, Y') }} · {{ __('Times are approximate') }}
        </p>
    </div>
</section>

{{-- Announcements Section --}}
@if(isset($announcements) && $announcements->count())
<section class="py-20 bg-gray-50 islamic-pattern">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-emerald-600 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('Latest News') }}</p>
            <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900">{{ __('Announcements') }}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($announcements as $announcement)
            <article class="bg-white rounded-2xl overflow-hidden shadow-sm border border-gray-100 card-hover">
                @if($announcement->featured_image)
                <img src="{{ asset('storage/' . $announcement->featured_image) }}" alt="" class="w-full h-48 object-cover">
                @else
                <div class="w-full h-48 gradient-mosque flex items-center justify-center"><span class="text-5xl opacity-30">🕌</span></div>
                @endif
                <div class="p-6">
                    @if($announcement->is_pinned)
                    <span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 bg-gold-100 text-gold-700 rounded-full mb-3 font-medium">📌 {{ __('Pinned') }}</span>
                    @endif
                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2">{{ $announcement->getTranslation('title') }}</h3>
                    <p class="text-sm text-gray-500 line-clamp-3">{{ $announcement->getTranslation('excerpt') }}</p>
                    <div class="flex items-center justify-between mt-4 pt-4 border-t border-gray-100">
                        <span class="text-xs text-gray-400">{{ $announcement->published_at?->diffForHumans() }}</span>
                        <a href="#" class="text-xs text-emerald-600 font-medium hover:text-emerald-700">{{ __('Read More') }} →</a>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Events Section --}}
@if(isset($upcomingEvents) && $upcomingEvents->count())
<section id="events" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-emerald-600 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('What\'s Happening') }}</p>
            <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900">{{ __('Upcoming Events') }}</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($upcomingEvents as $event)
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm card-hover">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-14 h-14 rounded-xl gradient-mosque flex flex-col items-center justify-center text-white shrink-0">
                        <span class="text-lg font-bold leading-none">{{ $event->start_date->format('d') }}</span>
                        <span class="text-[10px] uppercase">{{ $event->start_date->format('M') }}</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-900">{{ $event->getTranslation('title') }}</h3>
                        <p class="text-xs text-gray-400">{{ $event->start_date->format('l, h:i A') }}</p>
                    </div>
                </div>
                <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $event->getTranslation('description') }}</p>
                @if($event->getTranslation('location'))
                <p class="flex items-center gap-1 text-xs text-gray-400"><i data-lucide="map-pin" class="w-3 h-3"></i> {{ $event->getTranslation('location') }}</p>
                @endif
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Donation Section --}}
<section id="donate" class="py-20 gradient-hero relative overflow-hidden">
    <div class="absolute inset-0 islamic-pattern-gold opacity-20"></div>
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <span class="text-4xl mb-4 block">🤲</span>
        <h2 class="text-3xl md:text-4xl font-bold font-heading text-white mb-4">{{ __('Support Your Mosque') }}</h2>
        <p class="text-emerald-100/70 max-w-2xl mx-auto mb-10">{{ __('Your generous contributions help maintain our mosque and serve the community. Every donation makes a difference.') }}</p>

        @if(isset($activeCampaigns) && $activeCampaigns->count())
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            @foreach($activeCampaigns as $campaign)
            <div class="glass rounded-2xl p-6 text-left">
                <h3 class="font-semibold text-white mb-2">{{ $campaign->getTranslation('title') }}</h3>
                <p class="text-sm text-emerald-200/60 mb-4">{{ $campaign->getTranslation('description') }}</p>
                <div class="w-full bg-white/10 rounded-full h-2 mb-2">
                    <div class="gradient-gold h-2 rounded-full transition-all" style="width: {{ $campaign->getProgressPercentage() }}%"></div>
                </div>
                <div class="flex justify-between text-xs">
                    <span class="text-emerald-200/80">${{ number_format($campaign->current_amount) }} {{ __('raised') }}</span>
                    <span class="text-gold-300">${{ number_format($campaign->goal_amount) }} {{ __('goal') }}</span>
                </div>
            </div>
            @endforeach
        </div>
        @endif

        <a href="#" class="inline-flex items-center gap-2 px-8 py-4 rounded-2xl bg-white text-emerald-800 font-bold hover:bg-emerald-50 transition-all hover:shadow-xl active:scale-[0.98]">
            <i data-lucide="heart" class="w-5 h-5"></i> {{ __('Donate Now') }}
        </a>
    </div>
</section>

{{-- Services Section --}}
@if(isset($services) && $services->count())
<section id="services" class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-12">
            <p class="text-emerald-600 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('How We Help') }}</p>
            <h2 class="text-3xl md:text-4xl font-bold font-heading text-gray-900">{{ __('Our Services') }}</h2>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($services as $service)
            <div class="p-6 rounded-2xl border border-gray-100 hover:border-emerald-200 bg-gradient-to-b from-white to-emerald-50/30 card-hover text-center">
                <span class="text-3xl block mb-3">{{ $service->icon ?? '🤝' }}</span>
                <h3 class="font-semibold text-gray-900 mb-2">{{ $service->getTranslation('name') }}</h3>
                <p class="text-sm text-gray-500">{{ $service->getTranslation('description') }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Contact Section --}}
<section id="contact" class="py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div>
                <p class="text-emerald-600 text-sm font-semibold uppercase tracking-wider mb-2">{{ __('Get In Touch') }}</p>
                <h2 class="text-3xl font-bold font-heading text-gray-900 mb-6">{{ __('Contact Us') }}</h2>
                <div class="space-y-4 mb-8">
                    @if($mosque && $mosque->address)
                    <div class="flex items-start gap-3"><div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0"><i data-lucide="map-pin" class="w-5 h-5 text-emerald-600"></i></div><div><p class="font-medium text-gray-900 text-sm">{{ __('Address') }}</p><p class="text-sm text-gray-500">{{ $mosque->address }}</p></div></div>
                    @endif
                    @if($mosque && $mosque->phone)
                    <div class="flex items-start gap-3"><div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0"><i data-lucide="phone" class="w-5 h-5 text-emerald-600"></i></div><div><p class="font-medium text-gray-900 text-sm">{{ __('Phone') }}</p><p class="text-sm text-gray-500">{{ $mosque->phone }}</p></div></div>
                    @endif
                    @if($mosque && $mosque->email)
                    <div class="flex items-start gap-3"><div class="w-10 h-10 rounded-xl bg-emerald-50 flex items-center justify-center shrink-0"><i data-lucide="mail" class="w-5 h-5 text-emerald-600"></i></div><div><p class="font-medium text-gray-900 text-sm">{{ __('Email') }}</p><p class="text-sm text-gray-500">{{ $mosque->email }}</p></div></div>
                    @endif
                </div>
            </div>
            <div>
                <form class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    @csrf
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Name') }}</label><input type="text" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20"></div>
                        <div><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Email') }}</label><input type="email" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20"></div>
                    </div>
                    <div class="mb-4"><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Subject') }}</label><input type="text" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20"></div>
                    <div class="mb-6"><label class="block text-sm font-medium text-gray-700 mb-1">{{ __('Message') }}</label><textarea rows="4" class="w-full px-4 py-3 rounded-xl border border-gray-200 text-sm focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20 resize-none"></textarea></div>
                    <button type="submit" class="w-full py-3 rounded-xl gradient-mosque text-white font-semibold hover:opacity-90 transition-all">{{ __('Send Message') }}</button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
