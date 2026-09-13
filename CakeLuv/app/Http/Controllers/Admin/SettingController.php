<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Helpers\SiteSettings;

class SettingController extends Controller
{
    public function index()
    {
        return view('admin.settings');
    }

    public function update(Request $request)
    {
        $keys = [
            'contact_phone', 'contact_email', 'contact_address', 'map_iframe',
            'about_text', 'chef_name', 'chef_desc'
        ];

        foreach ($keys as $key) {
            if ($request->has($key)) {
                SiteSettings::set($key, $request->input($key));
            }
        }

        // Handle Images
        $imageKeys = ['hero_image', 'about_image', 'chef_image'];
        foreach ($imageKeys as $imgKey) {
            if ($request->hasFile($imgKey)) {
                $image = $request->file($imgKey);
                $imageName = $imgKey . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/settings'), $imageName);
                SiteSettings::set($imgKey, url('/uploads/settings/' . $imageName));
            }
        }

        return back()->with('success', 'Pengaturan situs berhasil diperbarui.');
    }
}
