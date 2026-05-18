<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OnboardingController extends Controller
{
    public function index()
    {
        return view('owner.onboarding');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'address' => 'nullable|string|max:255',
            'phone'   => 'nullable|string|max:20',
            'logo'    => 'nullable|image|mimes:png,jpg,jpeg,webp|max:2048',
        ], [
            'name.required' => 'Nama toko wajib diisi.',
            'logo.image'    => 'File logo harus berupa gambar.',
            'logo.max'      => 'Ukuran logo maksimal 2MB.',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        Store::create([
            'user_id' => auth()->id(),
            'name'    => $request->name,
            'address' => $request->address,
            'phone'   => $request->phone,
            'logo'    => $logoPath,
        ]);

        return redirect()->route('owner.dashboard')
            ->with('success', 'Selamat datang! Toko kamu sudah siap. Mulai tambahkan menu pertamamu! 🎉');
    }
}
