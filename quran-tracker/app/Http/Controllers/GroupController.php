<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\GroupMember;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class GroupController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $groups = Group::where('admin_id', $user->id)->with('members')->get();
        
        return view('groups.index', compact('groups'));
    }

    public function create()
    {
        return view('groups.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group = Group::create([
            'name' => $request->name,
            'description' => $request->description,
            'admin_id' => Auth::id(),
            'code' => strtoupper(Str::random(8)),
        ]);

        return redirect()->route('groups.index')->with('success', 'Group berhasil dibuat!');
    }

    public function show(Group $group)
    {
        $group->load(['members.santri', 'hafalans.santri', 'murajaahs.santri']);
        
        return view('groups.show', compact('group'));
    }

    public function edit(Group $group)
    {
        return view('groups.edit', compact('group'));
    }

    public function update(Request $request, Group $group)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $group->update($request->only(['name', 'description']));

        return redirect()->route('groups.index')->with('success', 'Group berhasil diperbarui!');
    }

    public function destroy(Group $group)
    {
        $group->delete();
        
        return redirect()->route('groups.index')->with('success', 'Group berhasil dihapus!');
    }

    public function join(Request $request, Group $group)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        if ($request->code !== $group->code) {
            return back()->with('error', 'Kode group tidak valid!');
        }

        $santri = Santri::where('user_id', Auth::id())->first();
        
        if (!$santri) {
            return back()->with('error', 'Anda belum memiliki profil santri!');
        }

        // Check if already a member
        $existingMember = GroupMember::where('group_id', $group->id)
            ->where('santri_id', $santri->id)
            ->first();

        if ($existingMember) {
            return back()->with('error', 'Anda sudah menjadi anggota group ini!');
        }

        GroupMember::create([
            'group_id' => $group->id,
            'santri_id' => $santri->id,
            'role' => 'member',
            'joined_at' => now(),
        ]);

        return back()->with('success', 'Berhasil bergabung dengan group!');
    }

    public function leave(Group $group)
    {
        $santri = Santri::where('user_id', Auth::id())->first();
        
        if ($santri) {
            GroupMember::where('group_id', $group->id)
                ->where('santri_id', $santri->id)
                ->delete();
        }

        return back()->with('success', 'Berhasil keluar dari group!');
    }
}
