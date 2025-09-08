<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Santri;
use App\Models\Hafalan;
use App\Models\Murajaah;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function dashboard()
    {
        $user = Auth::user();
        
        // Get all groups managed by this admin
        $groups = Group::where('admin_id', $user->id)->with('members.santri')->get();
        
        // Get all santris in admin's groups
        $groupIds = $groups->pluck('id');
        $santris = Santri::whereHas('groupMembers', function($query) use ($groupIds) {
            $query->whereIn('group_id', $groupIds);
        })->with('groupMembers.group')->get();
        
        // Get statistics
        $totalGroups = $groups->count();
        $totalSantris = $santris->count();
        $totalHafalans = Hafalan::whereIn('group_id', $groupIds)->count();
        $totalMurajaahs = Murajaah::whereIn('group_id', $groupIds)->count();
        
        // Get recent activities
        $recentHafalans = Hafalan::whereIn('group_id', $groupIds)
            ->with(['santri', 'group'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
            
        $recentMurajaahs = Murajaah::whereIn('group_id', $groupIds)
            ->with(['santri', 'group'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
        
        return view('admin.dashboard', compact(
            'groups', 'santris', 'totalGroups', 'totalSantris', 
            'totalHafalans', 'totalMurajaahs', 'recentHafalans', 'recentMurajaahs'
        ));
    }

    public function santris()
    {
        $user = Auth::user();
        
        // Get all groups managed by this admin
        $groupIds = Group::where('admin_id', $user->id)->pluck('id');
        
        // Get all santris in admin's groups
        $santris = Santri::whereHas('groupMembers', function($query) use ($groupIds) {
            $query->whereIn('group_id', $groupIds);
        })->with(['groupMembers.group', 'hafalans', 'murajaahs'])->get();
        
        return view('admin.santris', compact('santris'));
    }

    public function hafalans()
    {
        $user = Auth::user();
        
        // Get all groups managed by this admin
        $groupIds = Group::where('admin_id', $user->id)->pluck('id');
        
        // Get all hafalans in admin's groups
        $hafalans = Hafalan::whereIn('group_id', $groupIds)
            ->with(['santri', 'group'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.hafalans', compact('hafalans'));
    }

    public function murajaahs()
    {
        $user = Auth::user();
        
        // Get all groups managed by this admin
        $groupIds = Group::where('admin_id', $user->id)->pluck('id');
        
        // Get all murajaahs in admin's groups
        $murajaahs = Murajaah::whereIn('group_id', $groupIds)
            ->with(['santri', 'group'])
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.murajaahs', compact('murajaahs'));
    }

    public function reviewHafalan(Request $request, Hafalan $hafalan)
    {
        $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $hafalan->update([
            'status' => 'reviewed',
            'score' => $request->score,
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Hafalan berhasil direview!');
    }

    public function reviewMurajaah(Request $request, Murajaah $murajaah)
    {
        $request->validate([
            'score' => 'required|integer|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $murajaah->update([
            'status' => 'reviewed',
            'score' => $request->score,
            'feedback' => $request->feedback,
        ]);

        return back()->with('success', 'Murajaah berhasil direview!');
    }
}
