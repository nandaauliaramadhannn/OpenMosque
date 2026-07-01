@extends('admin.layouts.app')

@section('title', __('Dashboard'))
@section('breadcrumb', __('Dashboard'))

@section('content')
<div class="space-y-6">
    {{-- Page Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold font-heading text-gray-900">{{ __('Dashboard') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Welcome back') }}, {{ auth()->user()->name ?? 'Admin' }} 👋</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}" target="_blank"
               class="flex items-center gap-2 px-4 py-2 text-sm bg-gray-50 hover:bg-gray-100 text-gray-300 rounded-xl border border-gray-200 transition-all">
                <i data-lucide="external-link" class="w-4 h-4"></i>
                {{ __('View Website') }}
            </a>
        </div>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Announcements --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 card-hover relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ __('Announcements') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['announcements'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Total published') }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-500/10 flex items-center justify-center">
                    <i data-lucide="megaphone" class="w-5 h-5 text-emerald-400"></i>
                </div>
            </div>
        </div>

        {{-- Upcoming Events --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 card-hover relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ __('Upcoming Events') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['events'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Scheduled') }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-500/10 flex items-center justify-center">
                    <i data-lucide="calendar-days" class="w-5 h-5 text-blue-400"></i>
                </div>
            </div>
        </div>

        {{-- Donations This Month --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 card-hover relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ __('Donations') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">${{ number_format($stats['donations_this_month'] ?? 0, 0) }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ __('This month') }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-yellow-500/10 flex items-center justify-center">
                    <i data-lucide="heart-handshake" class="w-5 h-5 text-yellow-400"></i>
                </div>
            </div>
        </div>

        {{-- Pending Requests --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-5 card-hover relative overflow-hidden">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-xs text-gray-500 uppercase tracking-wider">{{ __('Pending Requests') }}</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">{{ $stats['pending_requests'] ?? 0 }}</p>
                    <p class="text-xs text-gray-500 mt-1">{{ __('Needs attention') }}</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-purple-500/10 flex items-center justify-center">
                    <i data-lucide="inbox" class="w-5 h-5 text-purple-400"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Two Column Layout --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Upcoming Events List --}}
        <div class="lg:col-span-2 bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="calendar-days" class="w-5 h-5 text-emerald-400"></i>
                    {{ __('Upcoming Events') }}
                </h2>
                <a href="#" class="text-xs text-emerald-400 hover:text-emerald-300 transition-colors">{{ __('View All') }} →</a>
            </div>

            @if(isset($upcomingEvents) && $upcomingEvents->count())
                <div class="space-y-3">
                    @foreach($upcomingEvents as $event)
                    <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="w-12 h-12 rounded-xl gradient-mosque flex flex-col items-center justify-center text-gray-900 shrink-0">
                            <span class="text-xs font-bold leading-none">{{ $event->start_date->format('d') }}</span>
                            <span class="text-[9px] uppercase">{{ $event->start_date->format('M') }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 truncate">{{ $event->getTranslation('title') }}</p>
                            <p class="text-xs text-gray-500">{{ $event->start_date->format('h:i A') }} · {{ $event->getTranslation('location') }}</p>
                        </div>
                        @if($event->is_featured)
                        <span class="px-2 py-0.5 text-[10px] bg-gold-500/10 text-gold-400 rounded-full border border-gold-500/20">{{ __('Featured') }}</span>
                        @endif
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i data-lucide="calendar-x" class="w-12 h-12 text-gray-300 mx-auto mb-3"></i>
                    <p class="text-sm text-gray-500">{{ __('No upcoming events') }}</p>
                </div>
            @endif
        </div>

        {{-- Recent Activity --}}
        <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                    <i data-lucide="activity" class="w-5 h-5 text-emerald-400"></i>
                    {{ __('Recent Activity') }}
                </h2>
            </div>

            @if(isset($recentActivities) && $recentActivities->count())
                <div class="space-y-4">
                    @foreach($recentActivities->take(6) as $activity)
                    <div class="flex items-start gap-3">
                        <div class="w-2 h-2 rounded-full mt-1.5 shrink-0
                            {{ $activity->action === 'login' ? 'bg-emerald-400' : '' }}
                            {{ $activity->action === 'logout' ? 'bg-gray-400' : '' }}
                            {{ $activity->action === 'created' ? 'bg-blue-400' : '' }}
                            {{ $activity->action === 'updated' ? 'bg-yellow-400' : '' }}
                            {{ $activity->action === 'deleted' ? 'bg-red-400' : '' }}
                        "></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-xs text-gray-300 truncate">{{ $activity->description }}</p>
                            <p class="text-[10px] text-gray-600 mt-0.5">
                                {{ $activity->user->name ?? __('System') }} · {{ $activity->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <i data-lucide="activity" class="w-10 h-10 text-gray-300 mx-auto mb-3"></i>
                    <p class="text-sm text-gray-500">{{ __('No recent activity') }}</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Recent Donations --}}
    <div class="bg-white border border-gray-100 shadow-sm rounded-2xl p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="text-lg font-semibold text-gray-900 flex items-center gap-2">
                <i data-lucide="heart-handshake" class="w-5 h-5 text-gold-400"></i>
                {{ __('Recent Donations') }}
            </h2>
            <a href="#" class="text-xs text-emerald-400 hover:text-emerald-300 transition-colors">{{ __('View All') }} →</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-xs text-gray-500 uppercase tracking-wider border-b border-white/5">
                        <th class="pb-3 px-3">{{ __('Donor') }}</th>
                        <th class="pb-3 px-3">{{ __('Type') }}</th>
                        <th class="pb-3 px-3">{{ __('Amount') }}</th>
                        <th class="pb-3 px-3">{{ __('Status') }}</th>
                        <th class="pb-3 px-3">{{ __('Date') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentDonations ?? [] as $donation)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="py-3 px-3">
                            <span class="text-gray-300">{{ $donation->is_anonymous ? __('Anonymous') : ($donation->donor_name ?? __('N/A')) }}</span>
                        </td>
                        <td class="py-3 px-3">
                            <span class="px-2 py-0.5 text-[10px] rounded-full bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 capitalize">
                                {{ $donation->type }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-gray-900 font-medium">${{ number_format($donation->amount, 2) }}</td>
                        <td class="py-3 px-3">
                            <span class="inline-flex items-center gap-1 text-xs
                                {{ $donation->status === 'completed' ? 'text-emerald-400' : '' }}
                                {{ $donation->status === 'pending' ? 'text-yellow-400' : '' }}
                                {{ $donation->status === 'failed' ? 'text-red-400' : '' }}
                            ">
                                <span class="w-1.5 h-1.5 rounded-full
                                    {{ $donation->status === 'completed' ? 'bg-emerald-400' : '' }}
                                    {{ $donation->status === 'pending' ? 'bg-yellow-400' : '' }}
                                    {{ $donation->status === 'failed' ? 'bg-red-400' : '' }}
                                "></span>
                                {{ ucfirst($donation->status) }}
                            </span>
                        </td>
                        <td class="py-3 px-3 text-gray-500 text-xs">{{ $donation->created_at->diffForHumans() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">{{ __('No donations yet') }}</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
