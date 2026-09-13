@extends('layouts.admin')

@section('title', 'Pengaturan Web')

@section('content')
<div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden p-8">
    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <h3 class="font-bold text-gray-800 text-lg border-b pb-2 mb-6">Informasi Kontak</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nomor Telepon (WhatsApp)</label>
                <input type="text" name="contact_phone" value="{{ \App\Helpers\SiteSettings::get('contact_phone', '+6281234567890') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Alamat Email</label>
                <input type="email" name="contact_email" value="{{ \App\Helpers\SiteSettings::get('contact_email', 'hello@cakeluv.com') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition">
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Alamat Lengkap</label>
                <textarea name="contact_address" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition">{{ \App\Helpers\SiteSettings::get('contact_address', 'Jl. Kebon Agung No. 123, Yogyakarta') }}</textarea>
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Google Maps Embed (Iframe src URL / HTML)</label>
                <textarea name="map_iframe" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition">{{ \App\Helpers\SiteSettings::get('map_iframe', 'https://www.google.com/maps/embed?pb=...') }}</textarea>
                <p class="text-xs text-gray-400 mt-2">Salin & tempel URL <code>src</code> iframe dari Google Maps (atau paste seluruh tag iframe-nya, sistem di halaman utama akan menampilkannya).</p>
            </div>
        </div>

        <h3 class="font-bold text-gray-800 text-lg border-b pb-2 mb-6">Gambar & Profil</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Gambar Hero (Header Depan)</label>
                <input type="file" name="hero_image" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition mb-2">
                @if(\App\Helpers\SiteSettings::get('hero_image'))
                    <img src="{{ \App\Helpers\SiteSettings::get('hero_image') }}" class="h-24 rounded-lg object-cover">
                @endif
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Gambar Tentang Kami</label>
                <input type="file" name="about_image" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition mb-2">
                @if(\App\Helpers\SiteSettings::get('about_image'))
                    <img src="{{ \App\Helpers\SiteSettings::get('about_image') }}" class="h-24 rounded-lg object-cover">
                @endif
            </div>
            <div class="md:col-span-2">
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Teks Tentang Kami (Singkat)</label>
                <textarea name="about_text" rows="3" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition">{{ \App\Helpers\SiteSettings::get('about_text', 'Setiap kue yang kami buat...') }}</textarea>
            </div>
        </div>

        <h3 class="font-bold text-gray-800 text-lg border-b pb-2 mb-6">Profil Koki (Patissier)</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Nama Koki</label>
                <input type="text" name="chef_name" value="{{ \App\Helpers\SiteSettings::get('chef_name', 'Chef Antonio') }}" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition">
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Deskripsi Koki</label>
                <textarea name="chef_desc" rows="2" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition">{{ \App\Helpers\SiteSettings::get('chef_desc', 'Berpengalaman 15 tahun...') }}</textarea>
            </div>
            <div>
                <label class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Foto Koki</label>
                <input type="file" name="chef_image" accept="image/*" class="w-full px-4 py-3 rounded-xl border border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition mb-2">
                @if(\App\Helpers\SiteSettings::get('chef_image'))
                    <img src="{{ \App\Helpers\SiteSettings::get('chef_image') }}" class="h-24 rounded-lg object-cover">
                @endif
            </div>
        </div>

        <div class="flex justify-end pt-6 border-t border-gray-100">
            <button type="submit" class="px-8 py-3 rounded-xl bg-primary hover:bg-primary_hover text-white font-bold transition shadow-lg">Simpan Pengaturan</button>
        </div>
    </form>
</div>
@endsection
