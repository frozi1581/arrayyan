<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SantriController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        return view('santris.index', compact('santri'));
    }

    public function create()
    {
        $user = Auth::user();
        $existingSantri = Santri::where('user_id', $user->id)->first();
        
        if ($existingSantri) {
            return redirect()->route('santris.index')->with('info', 'Profil santri sudah ada.');
        }
        
        return view('santris.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:santris,email',
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'birth_date', 'gender', 'address']);
        $data['user_id'] = Auth::id();

        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        Santri::create($data);

        return redirect()->route('santris.index')->with('success', 'Profil santri berhasil dibuat!');
    }

    public function show(Santri $santri)
    {
        $santri->load(['groupMembers.group', 'hafalans.group', 'murajaahs.group']);
        
        return view('santris.show', compact('santri'));
    }

    public function edit(Santri $santri)
    {
        // Ensure user can only edit their own profile
        if ($santri->user_id !== Auth::id()) {
            abort(403);
        }
        
        return view('santris.edit', compact('santri'));
    }

    public function update(Request $request, Santri $santri)
    {
        // Ensure user can only edit their own profile
        if ($santri->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:santris,email,' . $santri->id,
            'phone' => 'nullable|string|max:20',
            'birth_date' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'address' => 'nullable|string',
            'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only(['name', 'email', 'phone', 'birth_date', 'gender', 'address']);

        if ($request->hasFile('profile_photo')) {
            // Delete old photo
            if ($santri->profile_photo) {
                Storage::disk('public')->delete($santri->profile_photo);
            }
            $data['profile_photo'] = $request->file('profile_photo')->store('profile-photos', 'public');
        }

        $santri->update($data);

        return redirect()->route('santris.index')->with('success', 'Profil santri berhasil diperbarui!');
    }

    public function destroy(Santri $santri)
    {
        // Ensure user can only delete their own profile
        if ($santri->user_id !== Auth::id()) {
            abort(403);
        }

        // Delete profile photo
        if ($santri->profile_photo) {
            Storage::disk('public')->delete($santri->profile_photo);
        }

        $santri->delete();

        return redirect()->route('santris.index')->with('success', 'Profil santri berhasil dihapus!');
    }
}
