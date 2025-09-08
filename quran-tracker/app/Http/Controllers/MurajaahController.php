<?php

namespace App\Http\Controllers;

use App\Models\Murajaah;
use App\Models\Group;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MurajaahController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        $murajaahs = collect();
        if ($santri) {
            $murajaahs = Murajaah::where('santri_id', $santri->id)
                ->with(['group'])
                ->orderBy('target_date', 'desc')
                ->get();
        }
        
        return view('murajaahs.index', compact('murajaahs'));
    }

    public function create()
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri) {
            return redirect()->route('santris.create')->with('error', 'Buat profil santri terlebih dahulu!');
        }
        
        $groups = Group::where('admin_id', $user->id)->get();
        
        return view('murajaahs.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'surah_name' => 'required|string|max:255',
            'start_ayah' => 'required|integer|min:1',
            'end_ayah' => 'required|integer|min:1|gte:start_ayah',
            'target_date' => 'required|date|after_or_equal:today',
            'notes' => 'nullable|string',
        ]);

        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri) {
            return redirect()->route('santris.create')->with('error', 'Buat profil santri terlebih dahulu!');
        }

        Murajaah::create([
            'santri_id' => $santri->id,
            'group_id' => $request->group_id,
            'surah_name' => $request->surah_name,
            'start_ayah' => $request->start_ayah,
            'end_ayah' => $request->end_ayah,
            'target_date' => $request->target_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('murajaahs.index')->with('success', 'Murajaah baru berhasil ditambahkan!');
    }

    public function show(Murajaah $murajaah)
    {
        $murajaah->load(['santri', 'group']);
        
        return view('murajaahs.show', compact('murajaah'));
    }

    public function edit(Murajaah $murajaah)
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri || $murajaah->santri_id !== $santri->id) {
            abort(403);
        }
        
        $groups = Group::where('admin_id', $user->id)->get();
        
        return view('murajaahs.edit', compact('murajaah', 'groups'));
    }

    public function update(Request $request, Murajaah $murajaah)
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri || $murajaah->santri_id !== $santri->id) {
            abort(403);
        }

        $request->validate([
            'group_id' => 'required|exists:groups,id',
            'surah_name' => 'required|string|max:255',
            'start_ayah' => 'required|integer|min:1',
            'end_ayah' => 'required|integer|min:1|gte:start_ayah',
            'target_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $murajaah->update($request->only([
            'group_id', 'surah_name', 'start_ayah', 'end_ayah', 'target_date', 'notes'
        ]));

        return redirect()->route('murajaahs.index')->with('success', 'Murajaah berhasil diperbarui!');
    }

    public function destroy(Murajaah $murajaah)
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri || $murajaah->santri_id !== $santri->id) {
            abort(403);
        }

        $murajaah->delete();

        return redirect()->route('murajaahs.index')->with('success', 'Murajaah berhasil dihapus!');
    }

    public function complete(Murajaah $murajaah)
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri || $murajaah->santri_id !== $santri->id) {
            abort(403);
        }

        $murajaah->update([
            'status' => 'completed',
            'completed_date' => now(),
        ]);

        return back()->with('success', 'Murajaah berhasil diselesaikan!');
    }
}
