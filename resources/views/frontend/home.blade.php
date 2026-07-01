@extends('frontend.layouts.app')

@section('title', $mosque ? $mosque->getTranslation('name') : \App\Models\Setting::getValue('app_name', 'OpenMosque'))

@section('content')
<div x-data="prayerTimesData()" x-init="initData()">
{{-- Hero Section with Slider --}}
<section x-data="{ 
        currentSlide: 0, 
        slides: [
            {
                image: 'https://images.unsplash.com/photo-1565552643982-1ce829373bc0?q=80&w=2070&auto=format&fit=crop',
                title: '{{ $mosque ? $mosque->getTranslation('name') : \App\Models\Setting::getValue('app_name', 'OpenMosque') }}',
                subtitle: '{{ __('Welcome to our community, a place of peace, worship, and learning.') }}'
            },
            {
                image: 'https://images.unsplash.com/photo-1584551246679-0daf3d275d0f?q=80&w=2076&auto=format&fit=crop',
                title: '{{ __('Learn & Grow Together') }}',
                subtitle: '{{ __('Join our educational programs and weekend classes to strengthen your Deen.') }}'
            },
            {
                image: 'https://images.unsplash.com/photo-1542816417-0983c9c9ad53?q=80&w=2070&auto=format&fit=crop',
                title: '{{ __('Support The Community') }}',
                subtitle: '{{ __('Your generous donations help us maintain the mosque and support those in need.') }}'
            }
        ],
        next() { this.currentSlide = (this.currentSlide === this.slides.length - 1) ? 0 : this.currentSlide + 1; },
        prev() { this.currentSlide = (this.currentSlide === 0) ? this.slides.length - 1 : this.currentSlide - 1; },
        init() { setInterval(() => this.next(), 6000); }
    }" 
    class="relative min-h-screen lg:h-screen lg:min-h-[600px] flex items-center justify-center overflow-hidden group py-24 lg:py-0">
    
    {{-- Slider Images Backgrounds --}}
    <template x-for="(slide, index) in slides" :key="index">
        <div x-show="currentSlide === index" 
             x-transition:enter="transition ease-out duration-1000 transform"
             x-transition:enter-start="opacity-0 scale-105"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-1000 transform absolute inset-0"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-105"
             class="absolute inset-0 z-0">
             
            {{-- Image Background --}}
            <img :src="slide.image" class="absolute inset-0 w-full h-full object-cover" alt="Mosque Image">
            
            {{-- Overlays (Gradient + Islamic Pattern) --}}
            <div class="absolute inset-0 bg-gradient-to-r from-emerald-950/95 via-emerald-900/80 to-black/60 mix-blend-multiply"></div>
            <div class="absolute inset-0 islamic-pattern-gold opacity-20 mix-blend-overlay"></div>
        </div>
    </template>

    {{-- Content --}}
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full flex flex-col lg:flex-row items-center justify-between gap-12 pt-20">
        
        {{-- Text Content --}}
        <div class="w-full lg:w-3/5 space-y-6 text-center lg:text-left flex flex-col items-center lg:items-start">
            <div class="inline-flex items-center gap-3 px-5 py-2.5 rounded-full bg-emerald-950/80 border border-emerald-500/30 shadow-lg">
                <span class="text-gold-400 animate-pulse">✨</span>
                <p class="text-emerald-100 text-xs sm:text-sm font-semibold uppercase tracking-widest font-heading">
                    بِسْمِ اللَّهِ الرَّحْمَنِ الرَّحِيمِ
                </p>
                <span class="text-gold-400 animate-pulse">✨</span>
            </div>
            
            <div class="h-[280px] sm:h-[240px] lg:h-[220px] relative w-full"> {{-- Fixed height wrapper for transitions --}}
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="currentSlide === index"
                         x-transition:enter="transition ease-out duration-700 delay-300"
                         x-transition:enter-start="opacity-0 translate-y-8"
                         x-transition:enter-end="opacity-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-300 absolute inset-0"
                         x-transition:leave-start="opacity-100 translate-y-0"
                         x-transition:leave-end="opacity-0 -translate-y-8"
                         class="absolute inset-0 flex flex-col justify-center lg:justify-start">
                        <h1 class="text-4xl sm:text-5xl lg:text-6xl xl:text-7xl font-bold font-heading text-white leading-tight drop-shadow-lg mb-4" x-text="slide.title"></h1>
                        <p class="text-base sm:text-lg lg:text-xl text-emerald-50 max-w-2xl font-light leading-relaxed drop-shadow-md mx-auto lg:mx-0" x-text="slide.subtitle"></p>
                    </div>
                </template>
            </div>
        </div>

        {{-- Next Prayer Widget Overlay (Visible on all screens now) --}}
        <div class="w-full sm:max-w-sm lg:max-w-none lg:w-1/3 xl:w-1/4 mt-8 lg:mt-0 mb-12 lg:mb-0 relative z-20">
            <div class="bg-surface-900 rounded-3xl p-8 border border-emerald-900 shadow-2xl relative overflow-hidden group-hover:border-emerald-500/40 transition-colors duration-500">
                <div class="absolute -right-12 -top-12 w-48 h-48 bg-gold-500/10 rounded-full blur-3xl animate-pulse"></div>
                <div class="absolute -left-16 -bottom-16 w-64 h-64 opacity-[0.03] islamic-pattern-gold animate-spin-slow pointer-events-none"></div>
                
                <div class="flex items-center justify-between mb-2">
                    <p class="text-emerald-400 text-xs font-semibold uppercase tracking-wider">{{ __('Next Prayer') }}</p>
                    <i data-lucide="bell" class="w-4 h-4 text-emerald-500/60"></i>
                </div>
                <h3 class="text-4xl font-bold font-heading text-white mb-2" x-text="nextPrayerIndex !== -1 ? prayerNames[nextPrayerIndex] : '...'">...</h3>
                <p class="text-5xl font-bold text-gold-400 tracking-tight flex items-baseline gap-2">
                    <span x-text="nextPrayerIndex !== -1 ? formatTime(prayers[prayerKeys[nextPrayerIndex]]) : '--:--'"></span>
                    <span class="text-xl font-medium text-emerald-200/60 uppercase" x-text="nextPrayerIndex !== -1 ? getAmPm(prayers[prayerKeys[nextPrayerIndex]]) : ''"></span>
                </p>
                
                <div class="mt-8 pt-6 border-t border-white/10 flex flex-col gap-2">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-emerald-100/60">{{ __('Current Location') }}</span>
                        <span class="text-white font-medium" x-text="locationStr">...</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-emerald-100/60">{{ __('Time left') }}</span>
                        <span class="text-emerald-400 font-mono font-medium bg-emerald-500/10 px-2 py-1 rounded-md" x-text="timeLeft">--:--:--</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Slider Controls --}}
    <div class="absolute bottom-8 inset-x-0 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-center lg:justify-end gap-6">
        {{-- Indicators --}}
        <div class="flex gap-2">
            <template x-for="(slide, index) in slides" :key="index">
                <button @click="currentSlide = index" 
                        class="h-1.5 rounded-full transition-all duration-300"
                        :class="currentSlide === index ? 'bg-gold-500 w-12' : 'bg-white/30 hover:bg-white/50 w-6'">
                </button>
            </template>
        </div>
        
        {{-- Arrows --}}
        <div class="hidden sm:flex gap-2">
            <button @click="prev()" class="p-2.5 rounded-full bg-emerald-950/80 hover:bg-emerald-900 text-white border border-white/10 hover:border-white/30 transition-all shadow-md">
                <i data-lucide="chevron-left" class="w-5 h-5"></i>
            </button>
            <button @click="next()" class="p-2.5 rounded-full bg-emerald-950/80 hover:bg-emerald-900 text-white border border-white/10 hover:border-white/30 transition-all shadow-md">
                <i data-lucide="chevron-right" class="w-5 h-5"></i>
            </button>
        </div>
    </div>

    {{-- Decorative bottom transition --}}
    <div class="absolute bottom-0 left-0 right-0 z-10">
        <div class="h-24 bg-gradient-to-t from-white to-transparent"></div>
    </div>
</section>

{{-- Prayer Times Section --}}
<section id="prayer-times" class="py-24 bg-white relative overflow-hidden">
    {{-- Background Ornaments --}}
    <div class="absolute inset-0 islamic-pattern opacity-[0.03] animate-spin-slow pointer-events-none" style="background-size: 120px;"></div>
    <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-emerald-50 rounded-full blur-[100px] pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-[500px] h-[500px] bg-gold-50 rounded-full blur-[100px] pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="text-center mb-16">
            <div class="inline-flex items-center justify-center gap-2 mb-4">
                <div class="w-8 h-px bg-emerald-500/50"></div>
                <p class="text-emerald-600 text-sm font-semibold uppercase tracking-widest">{{ __('Daily Schedule') }}</p>
                <div class="w-8 h-px bg-emerald-500/50"></div>
            </div>
            <h2 class="text-3xl md:text-5xl font-bold font-heading text-emerald-950">{{ __('Prayer Times') }}</h2>
            <p class="text-emerald-700/70 mt-4 max-w-lg mx-auto text-sm md:text-base mb-8">{{ __('Stay connected with your daily prayers and strengthen your spiritual journey') }}</p>
            
            <div class="flex flex-col sm:flex-row flex-wrap items-center justify-center gap-3 text-xs">
                <div class="flex items-center gap-2 bg-emerald-50 px-4 py-2 rounded-full border border-emerald-100 shadow-sm" x-show="gregorianDate" style="display: none;">
                    <i data-lucide="calendar" class="w-4 h-4 text-emerald-600"></i>
                    <span class="font-medium text-emerald-800" x-text="gregorianDate"></span>
                </div>
                <div class="flex items-center gap-2 bg-emerald-50 px-4 py-2 rounded-full border border-emerald-100 shadow-sm" x-show="hijriDate" style="display: none;">
                    <i data-lucide="moon" class="w-4 h-4 text-emerald-600"></i>
                    <span class="font-medium text-emerald-800" x-text="hijriDate"></span>
                </div>
                <div class="flex items-center gap-2 bg-emerald-50 px-4 py-2 rounded-full border border-emerald-100 shadow-sm">
                    <i data-lucide="map-pin" class="w-4 h-4 text-emerald-600"></i>
                    <span class="font-medium text-emerald-800" x-text="locationStr">{{ __('Detecting location...') }}</span>
                </div>
                <div class="flex items-center gap-2 bg-white px-4 py-2 rounded-full border shadow-sm"
                     :class="statusMessage === '{{ __('Live Times') }}' ? 'border-emerald-200' : 'border-gold-200'">
                    <div class="w-2 h-2 rounded-full"
                         :class="statusMessage === '{{ __('Live Times') }}' ? 'bg-emerald-500 animate-pulse' : 'bg-gold-500 animate-pulse'"></div>
                    <span class="font-medium" 
                          :class="statusMessage === '{{ __('Live Times') }}' ? 'text-emerald-700' : 'text-gold-700'"
                          x-text="statusMessage">{{ __('Please allow location access for accurate prayer times.') }}</span>
                </div>
            </div>
        </div>

        <div class="relative">
            {{-- Location Denied Overlay --}}
            <div x-show="locationDenied" style="display: none;" class="absolute inset-0 z-30 flex items-center justify-center bg-white/60 backdrop-blur-sm rounded-3xl -mx-4 sm:mx-0">
                <div class="bg-white p-6 sm:p-8 rounded-2xl shadow-xl border border-red-100 max-w-md text-center mx-4 animate-fade-in-up">
                    <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center mx-auto mb-4 shadow-sm border border-red-100">
                        <i data-lucide="map-pin-off" class="w-8 h-8 text-red-500"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">{{ __('Location Access Required') }}</h3>
                    <p class="text-gray-600 text-sm mb-6">
                        {{ __('Untuk melihat waktu sholat, izinkan lokasi biar akurasi tepat.') }}
                    </p>
                    <button @click="window.location.reload()" class="bg-emerald-600 hover:bg-emerald-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-md shadow-emerald-500/20">
                        {{ __('Refresh Page') }}
                    </button>
                </div>
            </div>

            <div class="flex flex-nowrap overflow-x-auto overflow-y-hidden pb-8 -mx-4 px-4 lg:mx-0 lg:px-0 lg:grid lg:grid-cols-5 gap-3 sm:gap-4 lg:gap-6 snap-x snap-mandatory [&::-webkit-scrollbar]:hidden transition-all duration-500" 
                 style="scrollbar-width: none; -ms-overflow-style: none; -webkit-overflow-scrolling: touch;"
                 :class="{ 'opacity-20 pointer-events-none blur-sm': locationDenied }">
            @php
                $prayers = [
                    ['name' => 'Fajr', 'arabic' => 'الفجر', 'icon' => 'sunrise', 'key' => 'fajr', 'iqamah_key' => 'iqamah_fajr'],
                    ['name' => 'Dhuhr', 'arabic' => 'الظهر', 'icon' => 'sun-dim', 'key' => 'dhuhr', 'iqamah_key' => 'iqamah_dhuhr'],
                    ['name' => 'Asr', 'arabic' => 'العصر', 'icon' => 'cloud-sun', 'key' => 'asr', 'iqamah_key' => 'iqamah_asr'],
                    ['name' => 'Maghrib', 'arabic' => 'المغرب', 'icon' => 'sunset', 'key' => 'maghrib', 'iqamah_key' => 'iqamah_maghrib'],
                    ['name' => 'Isha', 'arabic' => 'العشاء', 'icon' => 'moon', 'key' => 'isha', 'iqamah_key' => 'iqamah_isha'],
                ];
            @endphp
            @foreach($prayers as $index => $prayer)
            <div class="rounded-2xl p-3 sm:p-4 text-center border transition-all duration-300 relative overflow-hidden group shadow-sm hover:shadow-lg bg-white min-w-[130px] sm:min-w-[150px] lg:min-w-0 snap-center shrink-0"
                 :class="{
                    'border-emerald-500 shadow-emerald-500/20 bg-emerald-50 scale-105 z-20': currentPrayerIndex === {{ $index }},
                    'border-gold-400 shadow-gold-500/20 bg-gold-50 scale-[1.02] z-10': nextPrayerIndex === {{ $index }},
                    'border-emerald-100 hover:border-emerald-300 hover:bg-emerald-50/50': currentPrayerIndex !== {{ $index }} && nextPrayerIndex !== {{ $index }}
                 }">
                <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-emerald-500 to-transparent opacity-0 transition-opacity duration-500"
                     :class="{ 'opacity-100': currentPrayerIndex === {{ $index }} || nextPrayerIndex === {{ $index }}, 'group-hover:opacity-100': currentPrayerIndex !== {{ $index }} && nextPrayerIndex !== {{ $index }} }"></div>
                
                <div class="relative z-10 flex flex-col items-center">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full border flex items-center justify-center mb-2 sm:mb-3 transition-all duration-300 shadow-sm"
                         :class="{
                            'bg-emerald-500 border-emerald-600 scale-110': currentPrayerIndex === {{ $index }},
                            'bg-gold-100 border-gold-300 scale-110': nextPrayerIndex === {{ $index }},
                            'bg-emerald-50 border-emerald-100 group-hover:border-emerald-300 group-hover:scale-110': currentPrayerIndex !== {{ $index }} && nextPrayerIndex !== {{ $index }}
                         }">
                        <i data-lucide="{{ $prayer['icon'] }}" class="w-5 h-5 transition-colors duration-300"
                           :class="{ 'text-white': currentPrayerIndex === {{ $index }}, 'text-gold-600': nextPrayerIndex === {{ $index }}, 'text-emerald-600 group-hover:text-emerald-700': currentPrayerIndex !== {{ $index }} && nextPrayerIndex !== {{ $index }} }"></i>
                    </div>
                    
                    <h3 class="font-bold text-emerald-950 text-sm sm:text-base tracking-wide flex items-center justify-center gap-1">
                        {{ __($prayer['name']) }}
                        <span x-show="nextPrayerIndex === {{ $index }}" class="text-[7px] sm:text-[8px] bg-gold-500 text-white border border-gold-600 px-1 py-0.5 rounded-full uppercase tracking-wider" style="display: none;">Next</span>
                    </h3>
                    <p class="text-[10px] sm:text-xs text-emerald-600/70 font-arabic mb-2 sm:mb-3">{{ $prayer['arabic'] }}</p>
                    
                    <div class="w-full h-px mb-2 sm:mb-3 transition-colors duration-300"
                         :class="{ 'bg-emerald-200': currentPrayerIndex === {{ $index }}, 'bg-emerald-100 group-hover:bg-emerald-200': currentPrayerIndex !== {{ $index }} }"></div>
                    
                    <p class="text-xl sm:text-2xl font-bold font-heading mb-0.5 transition-colors duration-300" 
                       :class="{ 'text-emerald-700': currentPrayerIndex === {{ $index }}, 'text-gold-600': nextPrayerIndex === {{ $index }}, 'text-emerald-900': currentPrayerIndex !== {{ $index }} && nextPrayerIndex !== {{ $index }} }"
                       x-text="formatTime(prayers.{{ $prayer['key'] }})">
                        --:--
                    </p>
                    <span class="text-[8px] sm:text-[9px] font-medium uppercase tracking-widest"
                          :class="{ 'text-emerald-600/70': currentPrayerIndex === {{ $index }}, 'text-gold-600/70': nextPrayerIndex === {{ $index }}, 'text-gray-400': currentPrayerIndex !== {{ $index }} && nextPrayerIndex !== {{ $index }} }"
                          x-text="getAmPm(prayers.{{ $prayer['key'] }})">
                        AM/PM
                    </span>
                    
                    {{-- Countdown for Next Prayer --}}
                    <div x-show="nextPrayerIndex === {{ $index }}" style="display: none;" class="mt-2 sm:mt-3 w-full">
                        <div class="bg-gold-50 border border-gold-200 rounded-md px-1 sm:px-1.5 py-1 sm:py-1.5 flex flex-col items-center justify-center">
                            <span class="text-[7px] sm:text-[8px] text-gold-600/80 uppercase tracking-widest mb-0.5">{{ __('Starts in') }}</span>
                            <span class="text-xs font-mono font-bold text-gold-600" x-text="timeLeft.replace('-', '')">--:--:--</span>
                        </div>
                    </div>

                    @if($prayer['iqamah_key'] && $prayerTimes && $prayerTimes->{$prayer['iqamah_key']})
                    <div x-show="nextPrayerIndex !== {{ $index }}" class="mt-2 sm:mt-3 inline-flex items-center gap-1 sm:gap-1.5 px-2 py-1 rounded-md bg-emerald-50 border border-emerald-100 group-hover:border-emerald-300 transition-colors duration-300">
                        <span class="text-[7px] sm:text-[8px] text-emerald-600/70 uppercase tracking-wider">{{ __('Iqamah') }}</span>
                        <span class="text-[9px] sm:text-[10px] font-bold text-emerald-700">{{ \Carbon\Carbon::parse($prayerTimes->{$prayer['iqamah_key']})->format('h:i A') }}</span>
                    </div>
                    @else
                    <div x-show="nextPrayerIndex !== {{ $index }}" class="mt-2 sm:mt-3 h-[20px] sm:h-[24px]"></div> {{-- Spacer for Sunrise --}}
                    @endif
                </div>
            </div>
            @endforeach
            </div>
        </div>

        {{-- API Source Credit --}}
        <div class="mt-6 text-center text-[10px] sm:text-xs text-gray-400/80 animate-fade-in-up" x-show="apiSource" style="display: none;">
            {{ __('Data provided by') }} 
            <a :href="apiSource === 'IslamicAPI.com' ? 'https://islamicapi.com' : 'https://aladhan.com'" target="_blank" rel="noopener noreferrer" class="text-emerald-600/70 hover:text-emerald-600 hover:underline font-medium transition-colors" x-text="apiSource"></a>
        </div>
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
            <article class="bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-100 relative group">
                <div class="absolute -right-20 -top-20 w-40 h-40 islamic-pattern-gold opacity-5 group-hover:animate-spin-slow pointer-events-none z-0"></div>
                
                @if($announcement->featured_image)
                <img src="{{ asset('storage/' . $announcement->featured_image) }}" alt="" class="w-full h-48 object-cover relative z-10">
                @else
                <div class="w-full h-48 bg-gray-50 flex items-center justify-center relative z-10 border-b border-gray-100"><span class="text-5xl opacity-30 group-hover:scale-110 transition-transform duration-500">🕌</span></div>
                @endif
                <div class="p-6 relative z-10">
                    @if($announcement->is_pinned)
                    <span class="inline-flex items-center gap-1 text-[10px] px-2 py-0.5 bg-gold-50 border border-gold-200 text-gold-700 rounded-full mb-3 font-medium shadow-sm">📌 {{ __('Pinned') }}</span>
                    @endif
                    <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 group-hover:text-emerald-700 transition-colors">{{ $announcement->getTranslation('title') }}</h3>
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
            <div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-sm hover:shadow-md transition-all duration-300 relative overflow-hidden group">
                <div class="absolute -right-8 -top-8 w-24 h-24 islamic-pattern opacity-5 group-hover:animate-spin-slow pointer-events-none"></div>
                <div class="relative z-10">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-14 h-14 rounded-xl bg-emerald-50 border border-emerald-100 flex flex-col items-center justify-center text-emerald-700 shrink-0 shadow-sm group-hover:bg-emerald-600 group-hover:text-white transition-colors duration-300">
                            <span class="text-lg font-bold leading-none">{{ $event->start_date->format('d') }}</span>
                            <span class="text-[10px] uppercase font-semibold">{{ $event->start_date->format('M') }}</span>
                        </div>
                        <div>
                            <h3 class="font-semibold text-gray-900 group-hover:text-emerald-700 transition-colors">{{ $event->getTranslation('title') }}</h3>
                            <p class="text-xs text-gray-500">{{ $event->start_date->format('l, h:i A') }}</p>
                        </div>
                    </div>
                    <p class="text-sm text-gray-500 line-clamp-2 mb-4">{{ $event->getTranslation('description') }}</p>
                    @if($event->getTranslation('location'))
                    <p class="flex items-center gap-1 text-xs text-gray-400"><i data-lucide="map-pin" class="w-3 h-3 text-emerald-500/50"></i> {{ $event->getTranslation('location') }}</p>
                    @endif
                </div>
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
</div>

@push('head')
<script>
    const PRAYER_API_KEY = "{{ \App\Models\Setting::getValue('api_key', '') }}";

    document.addEventListener('alpine:init', () => {
        Alpine.data('prayerTimesData', () => ({
            locationStr: '{{ __('Detecting location...') }}',
            statusMessage: '{{ __('Please allow location access for accurate prayer times.') }}',
            locationDenied: false,
            apiSource: '',
            hijriDate: '',
            gregorianDate: '',
            prayers: { fajr: '--:--', dhuhr: '--:--', asr: '--:--', maghrib: '--:--', isha: '--:--' },
            currentPrayerIndex: -1,
            nextPrayerIndex: -1,
            prayerKeys: ['fajr', 'dhuhr', 'asr', 'maghrib', 'isha'],
            prayerNames: ['Fajr', 'Dhuhr', 'Asr', 'Maghrib', 'Isha'],
            timeLeft: '--:--:--',
            
            initData() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => this.fetchByCoords(position.coords.latitude, position.coords.longitude),
                        (error) => {
                            if (error.code === 1) { // PERMISSION_DENIED
                                console.warn("Geolocation denied by user.");
                                this.locationDenied = true;
                                this.statusMessage = '{{ __('To see prayer times, please allow location access for accurate precision.') }}';
                                this.locationStr = '{{ __('Location Access Denied') }}';
                            } else {
                                console.warn("Geolocation failed, falling back to IP.", error);
                                this.fetchByIp();
                            }
                        },
                        { timeout: 10000 }
                    );
                } else {
                    this.fetchByIp();
                }
            },

            async fetchByCoords(lat, lon, fallbackCity = null, fallbackCountry = null) {
                try {
                    this.statusMessage = '{{ __('Calculating precise times...') }}';
                    
                    // Reverse geocoding for city name if not provided by fallback
                    if (fallbackCity) {
                        this.locationStr = fallbackCity + (fallbackCountry ? ', ' + fallbackCountry : '');
                    } else {
                        try {
                            const geoRes = await fetch(`https://api.bigdatacloud.net/data/reverse-geocode-client?latitude=${lat}&longitude=${lon}&localityLanguage=en`);
                            const geoData = await geoRes.json();
                            this.locationStr = (geoData.city || geoData.locality || 'Unknown') + ', ' + geoData.countryName;
                        } catch(e) {
                            console.warn("Reverse geocode failed", e);
                        }
                    }

                    const date = new Date();
                    const dd = String(date.getDate()).padStart(2, '0');
                    const mm = String(date.getMonth() + 1).padStart(2, '0');
                    const yyyy = date.getFullYear();
                    
                    // Determine which API to use
                    let url = '';
                    if (PRAYER_API_KEY) {
                        // Islamic API Logic
                        url = `https://islamicapi.com/api/v1/prayer-time/?lat=${lat}&lon=${lon}&date=${yyyy}-${mm}-${dd}&api_key=${PRAYER_API_KEY}`;
                        this.apiSource = 'IslamicAPI.com';
                    } else {
                        // Fallback to Aladhan API Logic
                        url = `https://api.aladhan.com/v1/timings/${dd}-${mm}-${yyyy}?latitude=${lat}&longitude=${lon}&method=2`;
                        this.apiSource = 'Aladhan.com';
                    }
                    
                    const ptRes = await fetch(url);
                    const ptData = await ptRes.json();
                    console.log("Prayer Times API Response:", ptData);
                    
                    if (ptData.status === "error" || ptData.code === 401) {
                        throw new Error(ptData.message || "API Error");
                    }
                    
                    this.processTimings(ptData);
                } catch (e) {
                    console.error('Coord fetch error:', e);
                    this.fetchByIp();
                }
            },

            async fetchByIp() {
                try {
                    this.statusMessage = '{{ __('Using IP location estimate...') }}';
                    const locRes = await fetch('https://get.geojs.io/v1/ip/geo.json');
                    const locData = await locRes.json();
                    
                    if (locData.latitude && locData.longitude) {
                        // Pass lat/lon to main function to unify API calling logic
                        await this.fetchByCoords(locData.latitude, locData.longitude, locData.city, locData.country);
                    } else {
                        throw new Error("No coordinates from IP");
                    }
                } catch (e) {
                    this.locationStr = '{{ __('Global Standard') }}';
                    this.statusMessage = '{{ __('Unable to detect location') }}';
                    console.error('IP fetch error:', e);
                }
            },

            processTimings(ptData) {
                // Determine API Response structure
                let timings = {};
                let dateData = null;
                
                if (ptData.data && ptData.data.timings) {
                    // Aladhan API Format
                    timings = ptData.data.timings;
                    dateData = ptData.data.date;
                } else if (ptData.data && ptData.data.times) {
                    // IslamicAPI Format
                    timings = ptData.data.times;
                    dateData = ptData.data.date;
                } else if (ptData.data || ptData.timings) {
                    // IslamicAPI Format or Generic
                    timings = ptData.data || ptData.timings || ptData;
                    dateData = ptData.date || ptData.data?.date || ptData;
                } else {
                    timings = ptData;
                }

                if (timings && (timings.Fajr || timings.fajr)) {
                    this.prayers = {
                        fajr: timings.Fajr || timings.fajr,
                        dhuhr: timings.Dhuhr || timings.dhuhr,
                        asr: timings.Asr || timings.asr,
                        maghrib: timings.Maghrib || timings.maghrib,
                        isha: timings.Isha || timings.isha
                    };
                    
                    if (dateData) {
                        // Extract Gregorian
                        if (dateData.readable) {
                            this.gregorianDate = dateData.readable;
                        } else if (dateData.gregorian) {
                            this.gregorianDate = typeof dateData.gregorian === 'string' ? dateData.gregorian : dateData.gregorian.date;
                        }

                        // Extract Hijri
                        if (dateData.hijri) {
                            const hijri = dateData.hijri;
                            if (typeof hijri === 'string') {
                                this.hijriDate = hijri;
                            } else if (hijri.day && hijri.month && hijri.year) {
                                this.hijriDate = `${hijri.day} ${hijri.month.en || hijri.month} ${hijri.year} H`;
                            }
                        }
                    }

                    this.statusMessage = '{{ __('Live Times') }}';
                    this.calculateCurrentAndNext();
                    setInterval(() => this.calculateCurrentAndNext(), 1000);
                } else {
                    this.statusMessage = '{{ __('Error connecting to API') }}';
                    console.error("Unknown API Response format", ptData);
                }
            },

            calculateCurrentAndNext() {
                if (this.prayers.fajr === '--:--') return;
                
                const now = new Date();
                const currentTime = now.getHours() * 60 + now.getMinutes();
                
                let foundNext = false;
                for (let i = 0; i < this.prayerKeys.length; i++) {
                    const timeStr = this.prayers[this.prayerKeys[i]];
                    const [h, m] = timeStr.split(':').map(Number);
                    const prayerTimeMins = h * 60 + m;
                    
                    if (currentTime < prayerTimeMins) {
                        this.nextPrayerIndex = i;
                        this.currentPrayerIndex = i === 0 ? this.prayerKeys.length - 1 : i - 1;
                        
                        // Calculate time left
                        let diff = prayerTimeMins * 60 - (currentTime * 60 + now.getSeconds());
                        let hrs = Math.floor(diff / 3600);
                        let mins = Math.floor((diff % 3600) / 60);
                        let secs = diff % 60;
                        
                        this.timeLeft = `-${String(hrs).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                        foundNext = true;
                        break;
                    }
                }
                
                // If all prayers today have passed, next prayer is Fajr tomorrow
                if (!foundNext) {
                    this.nextPrayerIndex = 0;
                    this.currentPrayerIndex = this.prayerKeys.length - 1; // Isha is current
                    
                    const timeStr = this.prayers.fajr;
                    const [h, m] = timeStr.split(':').map(Number);
                    const prayerTimeMins = h * 60 + m + (24 * 60); // add 24 hours
                    
                    let diff = prayerTimeMins * 60 - (currentTime * 60 + now.getSeconds());
                    let hrs = Math.floor(diff / 3600);
                    let mins = Math.floor((diff % 3600) / 60);
                    let secs = diff % 60;
                    
                    this.timeLeft = `-${String(hrs).padStart(2, '0')}:${String(mins).padStart(2, '0')}:${String(secs).padStart(2, '0')}`;
                }
            },
            
            formatTime(timeStr) {
                if (timeStr === '--:--' || !timeStr) return '--:--';
                let [h, m] = timeStr.split(':').map(Number);
                h = h % 12;
                h = h ? h : 12; // the hour '0' should be '12'
                return String(h).padStart(2, '0') + ':' + String(m).padStart(2, '0');
            },
            
            getAmPm(timeStr) {
                if (timeStr === '--:--' || !timeStr) return '';
                let [h, m] = timeStr.split(':').map(Number);
                return h >= 12 ? 'PM' : 'AM';
            }
        }));
    });
</script>
@endpush
@endsection
