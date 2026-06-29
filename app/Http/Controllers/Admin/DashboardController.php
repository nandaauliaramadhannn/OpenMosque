<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Donation;
use App\Models\Event;
use App\Models\ServiceRequest;
use App\Models\ActivityLog;

class DashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $stats = [
            'announcements' => Announcement::count(),
            'events' => Event::where('start_date', '>=', now())->count(),
            'donations_this_month' => Donation::completed()->thisMonth()->sum('amount'),
            'pending_requests' => ServiceRequest::pending()->count(),
        ];

        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(10)
            ->get();

        $upcomingEvents = Event::published()
            ->upcoming()
            ->take(5)
            ->get();

        $recentDonations = Donation::completed()
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentActivities',
            'upcomingEvents',
            'recentDonations'
        ));
    }
}
