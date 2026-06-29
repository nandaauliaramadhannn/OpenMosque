<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Campaign;
use App\Models\Event;
use App\Models\Mosque;
use App\Models\PrayerTime;
use App\Models\Service;
use App\Models\Staff;

class HomeController extends Controller
{
    /**
     * Show the public homepage.
     */
    public function index()
    {
        $mosque = Mosque::first();

        $prayerTimes = PrayerTime::today();

        $announcements = Announcement::published()
            ->take(3)
            ->get();

        $upcomingEvents = Event::published()
            ->upcoming()
            ->take(3)
            ->get();

        $activeCampaigns = Campaign::active()
            ->take(2)
            ->get();

        $services = Service::active()
            ->take(6)
            ->get();

        $staff = Staff::active()
            ->take(4)
            ->get();

        return view('frontend.home', compact(
            'mosque',
            'prayerTimes',
            'announcements',
            'upcomingEvents',
            'activeCampaigns',
            'services',
            'staff'
        ));
    }
}
