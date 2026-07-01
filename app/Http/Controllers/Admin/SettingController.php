<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = [
            'app_name' => Setting::getValue('app_name', 'OpenMosque'),
            'maintenance_mode' => Setting::getValue('maintenance_mode', false),
            'api_key' => Setting::getValue('api_key', ''),
            'api_endpoint' => Setting::getValue('api_endpoint', ''),
            'app_logo' => Setting::getValue('app_logo', null),
            'app_favicon' => Setting::getValue('app_favicon', null),
            'seo_meta_title' => Setting::getValue('seo_meta_title', 'OpenMosque — Your Community Mosque'),
            'seo_meta_description' => Setting::getValue('seo_meta_description', 'A welcoming place of worship serving the community.'),
            'google_analytics_id' => Setting::getValue('google_analytics_id', ''),
            'google_site_verification' => Setting::getValue('google_site_verification', ''),
            'og_image' => Setting::getValue('og_image', null),
            'active_languages' => Setting::getValue('active_languages', ['en', 'id', 'ar']),
            'default_language' => Setting::getValue('default_language', 'en'),
        ];

        $available_languages = [
            'en' => 'English',
            'id' => 'Indonesia',
            'ar' => 'العربية (Arabic)'
        ];

        return view('admin.settings.index', compact('settings', 'available_languages'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'app_name' => 'required|string|max:255',
            'maintenance_mode' => 'nullable|boolean',
            'api_key' => 'nullable|string|max:255',
            'api_endpoint' => 'nullable|url|max:255',
            'app_logo' => 'nullable|image|max:2048',
            'app_favicon' => 'nullable|image|max:1024',
            'seo_meta_title' => 'nullable|string|max:255',
            'seo_meta_description' => 'nullable|string|max:500',
            'google_analytics_id' => 'nullable|string|max:50',
            'google_site_verification' => 'nullable|string|max:150',
            'og_image' => 'nullable|image|max:2048',
            'active_languages' => 'required|array|min:1',
            'default_language' => 'required|string',
        ]);

        Setting::setValue('app_name', $request->input('app_name'), 'general');
        Setting::setValue('maintenance_mode', $request->boolean('maintenance_mode'), 'system');
        Setting::setValue('api_key', $request->input('api_key'), 'api');
        Setting::setValue('api_endpoint', $request->input('api_endpoint'), 'api');
        Setting::setValue('seo_meta_title', $request->input('seo_meta_title'), 'seo');
        Setting::setValue('seo_meta_description', $request->input('seo_meta_description'), 'seo');
        Setting::setValue('google_analytics_id', $request->input('google_analytics_id'), 'seo');
        Setting::setValue('google_site_verification', $request->input('google_site_verification'), 'seo');
        Setting::setValue('active_languages', $request->input('active_languages'), 'localization');
        Setting::setValue('default_language', $request->input('default_language'), 'localization');

        if ($request->hasFile('app_logo')) {
            $path = $request->file('app_logo')->store('settings', 'public');
            Setting::setValue('app_logo', $path, 'general');
        }

        if ($request->hasFile('app_favicon')) {
            $path = $request->file('app_favicon')->store('settings', 'public');
            Setting::setValue('app_favicon', $path, 'general');
        }

        if ($request->hasFile('og_image')) {
            $path = $request->file('og_image')->store('settings', 'public');
            Setting::setValue('og_image', $path, 'seo');
        }

        return redirect()->route('admin.settings.index')->with('success', __('Settings updated successfully.'));
    }
}
