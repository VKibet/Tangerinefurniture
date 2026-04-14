<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $contactSettings = Setting::getGroup('contact');
        $socialSettings = Setting::getGroup('social');
        
        return view('admin.settings.index', compact('contactSettings', 'socialSettings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*' => 'nullable|string|max:500'
        ]);

        foreach ($request->settings as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Settings updated successfully.');
    }

    public function contact()
    {
        $contactSettings = Setting::getGroup('contact');
        return view('admin.settings.contact', compact('contactSettings'));
    }

    public function social()
    {
        $socialSettings = Setting::getGroup('social');
        return view('admin.settings.social', compact('socialSettings'));
    }
}
