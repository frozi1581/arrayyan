<?php

namespace App\Http\Controllers;

use App\Models\Hafalan;
use App\Models\Group;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HafalanController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        $hafalans = collect();
        if ($santri) {
            $hafalans = Hafalan::where('santri_id', $santri->id)
                ->with(['group'])
                ->orderBy('target_date', 'desc')
                ->get();
        }
        
        return view('hafalans.index', compact('hafalans'));
    }

    public function create()
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri) {
            return redirect()->route('santris.create')->with('error', 'Buat profil santri terlebih dahulu!');
        }
        
        $groups = Group::where('admin_id', $user->id)->get();
        
        return view('hafalans.create', compact('groups'));
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

        Hafalan::create([
            'santri_id' => $santri->id,
            'group_id' => $request->group_id,
            'surah_name' => $request->surah_name,
            'start_ayah' => $request->start_ayah,
            'end_ayah' => $request->end_ayah,
            'target_date' => $request->target_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('hafalans.index')->with('success', 'Hafalan baru berhasil ditambahkan!');
    }

    public function show(Hafalan $hafalan)
    {
        $hafalan->load(['santri', 'group']);
        
        return view('hafalans.show', compact('hafalan'));
    }

    public function edit(Hafalan $hafalan)
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri || $hafalan->santri_id !== $santri->id) {
            abort(403);
        }
        
        $groups = Group::where('admin_id', $user->id)->get();
        
        return view('hafalans.edit', compact('hafalan', 'groups'));
    }

    public function update(Request $request, Hafalan $hafalan)
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri || $hafalan->santri_id !== $santri->id) {
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

        $hafalan->update($request->only([
            'group_id', 'surah_name', 'start_ayah', 'end_ayah', 'target_date', 'notes'
        ]));

        return redirect()->route('hafalans.index')->with('success', 'Hafalan berhasil diperbarui!');
    }

    public function destroy(Hafalan $hafalan)
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri || $hafalan->santri_id !== $santri->id) {
            abort(403);
        }

        $hafalan->delete();

        return redirect()->route('hafalans.index')->with('success', 'Hafalan berhasil dihapus!');
    }

    public function complete(Hafalan $hafalan)
    {
        $user = Auth::user();
        $santri = Santri::where('user_id', $user->id)->first();
        
        if (!$santri || $hafalan->santri_id !== $santri->id) {
            abort(403);
        }

        $hafalan->update([
            'status' => 'completed',
            'completed_date' => now(),
        ]);

        return back()->with('success', 'Hafalan berhasil diselesaikan!');
    }
}
