@extends('admin.layouts.app')

@section('title', __('System Settings'))
@section('breadcrumb', __('Settings'))

@section('content')
<div class="max-w-4xl">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-2xl font-bold font-heading text-gray-900">{{ __('System Settings') }}</h1>
            <p class="text-sm text-gray-500 mt-1">{{ __('Manage your mosque application configuration.') }}</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 shadow-sm rounded-2xl overflow-hidden">
        <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="divide-y divide-gray-100">
            @csrf
            
            {{-- General Settings --}}
            <div class="p-6 md:p-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                    <i data-lucide="layout" class="w-5 h-5 text-emerald-500"></i>
                    {{ __('General Information') }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="app_name" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Application Name') }}</label>
                        <input type="text" id="app_name" name="app_name" value="{{ old('app_name', $settings['app_name']) }}" required
                               class="form-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20">
                        @error('app_name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ preview: '{{ $settings['app_logo'] ? Storage::url($settings['app_logo']) : '' }}' }">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Application Logo') }}</label>
                        <div x-show="preview" class="mb-3" style="display: none;">
                            <img :src="preview" alt="Logo Preview" class="h-16 rounded border border-gray-200 p-1 object-contain">
                        </div>
                        <input type="file" name="app_logo" accept="image/*"
                               @change="if($event.target.files.length) preview = URL.createObjectURL($event.target.files[0])"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="text-xs text-gray-500 mt-2">{{ __('Recommended: 512x512px, transparent PNG.') }}</p>
                        @error('app_logo') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ preview: '{{ $settings['app_favicon'] ? Storage::url($settings['app_favicon']) : '' }}' }">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Favicon') }}</label>
                        <div x-show="preview" class="mb-3" style="display: none;">
                            <img :src="preview" alt="Favicon Preview" class="h-10 w-10 rounded border border-gray-200 p-1 object-contain">
                        </div>
                        <input type="file" name="app_favicon" accept="image/x-icon,image/png"
                               @change="if($event.target.files.length) preview = URL.createObjectURL($event.target.files[0])"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="text-xs text-gray-500 mt-2">{{ __('Must be a valid .ico or .png file (max 1MB).') }}</p>
                        @error('app_favicon') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- System Settings --}}
            <div class="p-6 md:p-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                    <i data-lucide="sliders" class="w-5 h-5 text-emerald-500"></i>
                    {{ __('System Control') }}
                </h2>
                
                <div>
                    <label class="flex items-center gap-3 cursor-pointer">
                        <div class="relative">
                            <input type="checkbox" name="maintenance_mode" value="1" class="sr-only peer" {{ old('maintenance_mode', $settings['maintenance_mode']) ? 'checked' : '' }}>
                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                        </div>
                        <div>
                            <span class="block text-sm font-medium text-gray-900">{{ __('Maintenance Mode') }}</span>
                            <span class="block text-xs text-gray-500">{{ __('When enabled, public visitors will see a maintenance page.') }}</span>
                        </div>
                    </label>
                    @error('maintenance_mode') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            {{-- API Settings --}}
            <div class="p-6 md:p-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                    <i data-lucide="webhook" class="w-5 h-5 text-emerald-500"></i>
                    {{ __('API Configuration') }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="api_key" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Prayer Times API Token (IslamicAPI)') }}</label>
                        <input type="password" id="api_key" name="api_key" value="{{ old('api_key', $settings['api_key']) }}" placeholder="Enter your API token..."
                               class="form-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20">
                        <p class="text-xs text-gray-500 mt-1">
                            {!! __('Get your API Token from <a href="https://islamicapi.com/doc/prayer-time/" target="_blank" class="text-emerald-600 hover:underline">IslamicAPI Documentation</a>.') !!}
                        </p>
                        @error('api_key') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- SEO & Analytics Settings --}}
            <div class="p-6 md:p-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                    <i data-lucide="search" class="w-5 h-5 text-emerald-500"></i>
                    {{ __('SEO & Analytics') }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div class="md:col-span-2">
                        <label for="seo_meta_title" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Meta Title') }}</label>
                        <input type="text" id="seo_meta_title" name="seo_meta_title" value="{{ old('seo_meta_title', $settings['seo_meta_title']) }}" placeholder="OpenMosque - Your Community Mosque"
                               class="form-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20">
                        <p class="text-xs text-gray-500 mt-1">{{ __('Default title for search engines. Recommended: 50-60 characters.') }}</p>
                        @error('seo_meta_title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="md:col-span-2">
                        <label for="seo_meta_description" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Meta Description') }}</label>
                        <textarea id="seo_meta_description" name="seo_meta_description" rows="3"
                                  class="form-textarea w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20">{{ old('seo_meta_description', $settings['seo_meta_description']) }}</textarea>
                        <p class="text-xs text-gray-500 mt-1">{{ __('Brief description for search engines. Recommended: 150-160 characters.') }}</p>
                        @error('seo_meta_description') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div x-data="{ preview: '{{ $settings['og_image'] ? Storage::url($settings['og_image']) : '' }}' }">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Open Graph Image (Social Share)') }}</label>
                        <div x-show="preview" class="mb-3" style="display: none;">
                            <img :src="preview" alt="OG Image Preview" class="h-24 w-auto rounded border border-gray-200 object-cover">
                        </div>
                        <input type="file" name="og_image" accept="image/*"
                               @change="if($event.target.files.length) preview = URL.createObjectURL($event.target.files[0])"
                               class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-emerald-50 file:text-emerald-700 hover:file:bg-emerald-100">
                        <p class="text-xs text-gray-500 mt-2">{{ __('Shown when shared on WhatsApp, Facebook, etc. Recommended: 1200x630px.') }}</p>
                        @error('og_image') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="google_site_verification" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Google Site Verification') }}</label>
                        <input type="text" id="google_site_verification" name="google_site_verification" value="{{ old('google_site_verification', $settings['google_site_verification']) }}" placeholder="e.g. jB_8xxxxxxxx"
                               class="form-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20">
                        <p class="text-xs text-gray-500 mt-1">{{ __('For Google Search Console verification code.') }}</p>
                        @error('google_site_verification') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="google_analytics_id" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Google Analytics ID') }}</label>
                        <input type="text" id="google_analytics_id" name="google_analytics_id" value="{{ old('google_analytics_id', $settings['google_analytics_id']) }}" placeholder="G-XXXXXXXXXX"
                               class="form-input w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20">
                        <p class="text-xs text-gray-500 mt-1">{{ __('Measurement ID (GA4). Leave blank to disable.') }}</p>
                        @error('google_analytics_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- Localization Settings --}}
            <div class="p-6 md:p-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-6 flex items-center gap-2">
                    <i data-lucide="languages" class="w-5 h-5 text-emerald-500"></i>
                    {{ __('Translation & Language') }}
                </h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">{{ __('Active Languages') }}</label>
                        <div class="space-y-3">
                            @foreach($available_languages as $code => $label)
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="checkbox" name="active_languages[]" value="{{ $code }}" 
                                       {{ in_array($code, old('active_languages', $settings['active_languages'])) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded border-gray-300 text-emerald-600 focus:ring-emerald-500/20">
                                <span class="text-sm text-gray-700">{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                        <p class="text-xs text-gray-500 mt-2">{{ __('Select which languages are available in the language switcher.') }}</p>
                        @error('active_languages') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="default_language" class="block text-sm font-medium text-gray-700 mb-1.5">{{ __('Default Language') }}</label>
                        <select id="default_language" name="default_language" 
                                class="form-select w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl text-gray-900 text-sm focus:bg-white focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500/20">
                            @foreach($available_languages as $code => $label)
                                <option value="{{ $code }}" {{ old('default_language', $settings['default_language']) === $code ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        <p class="text-xs text-gray-500 mt-1">{{ __('The primary language when visitors first open the site.') }}</p>
                        @error('default_language') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-8 bg-gray-50 flex items-center justify-end gap-3 rounded-b-2xl">
                <button type="reset" class="px-5 py-2.5 text-sm font-medium text-gray-700 hover:text-gray-900 bg-white border border-gray-300 rounded-xl shadow-sm hover:bg-gray-50 transition-colors">
                    {{ __('Cancel') }}
                </button>
                <button type="submit" class="px-5 py-2.5 text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 rounded-xl shadow-sm shadow-emerald-600/20 transition-all flex items-center gap-2">
                    <i data-lucide="save" class="w-4 h-4"></i>
                    {{ __('Save Settings') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
