@extends('layouts.admin')

@php
use App\Models\Setting;
@endphp

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Site Settings</h1>
        <p class="text-gray-600 mt-2">Manage your website settings and contact information</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <!-- Contact Settings -->
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Contact Information</h2>
                <a href="{{ route('admin.settings.contact') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Edit →
                </a>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Phone</label>
                    <p class="text-gray-900">{{ Setting::get('contact_phone', 'Not set') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Email</label>
                    <p class="text-gray-900">{{ Setting::get('contact_email', 'Not set') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Address</label>
                    <p class="text-gray-900">{{ Setting::get('contact_address', 'Not set') }}, {{ Setting::get('contact_city', 'Not set') }}</p>
                </div>
            </div>
        </div>

        <!-- Social Media Settings -->
        <div class="bg-white border border-gray-200 rounded-lg p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-semibold text-gray-900">Social Media</h2>
                <a href="{{ route('admin.settings.social') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                    Edit →
                </a>
            </div>
            <div class="space-y-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Facebook</label>
                    <p class="text-gray-900">{{ Setting::get('social_facebook', 'Not set') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Twitter</label>
                    <p class="text-gray-900">{{ Setting::get('social_twitter', 'Not set') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">Instagram</label>
                    <p class="text-gray-900">{{ Setting::get('social_instagram', 'Not set') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-600">LinkedIn</label>
                    <p class="text-gray-900">{{ Setting::get('social_linkedin', 'Not set') }}</p>
                </div>
            </div>
        </div>
    </div>
    <!-- Order Notification Settings -->
    <div class="bg-white border border-gray-200 rounded-lg p-6 mt-8">
        <div class="mb-6">
            <h2 class="text-xl font-semibold text-gray-900">Order Notifications</h2>
            <p class="text-gray-600 text-sm mt-1">These addresses receive a copy of every new order email. Enter one email per line (or separate with commas).</p>
        </div>

        <form action="{{ route('admin.settings.notifications.update') }}" method="POST">
            @csrf
            <textarea name="order_notification_emails" rows="5"
                      class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                      placeholder="sales@example.com&#10;manager@example.com">{{ old('order_notification_emails', Setting::get('order_notification_emails', '')) }}</textarea>
            @error('order_notification_emails')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
            <div class="mt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg">
                    Save Recipients
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
