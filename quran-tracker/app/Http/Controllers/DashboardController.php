<?php

namespace App\Http\Controllers;

use App\Models\Group;
use App\Models\Hafalan;
use App\Models\Murajaah;
use App\Models\Santri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Get user's groups
        $groups = Group::where('admin_id', $user->id)->get();
        
        // Get user's santri profile
        $santri = Santri::where('user_id', $user->id)->first();
        
        // Get today's tasks
        $today = Carbon::today();
        
        $todayHafalans = collect();
        $todayMurajaahs = collect();
        
        if ($santri) {
            $todayHafalans = Hafalan::where('santri_id', $santri->id)
                ->where('target_date', $today)
                ->where('status', 'pending')
                ->get();
                
            $todayMurajaahs = Murajaah::where('santri_id', $santri->id)
                ->where('target_date', $today)
                ->where('status', 'pending')
                ->get();
        }
        
        // Get weekly progress
        $weekStart = Carbon::now()->startOfWeek();
        $weekEnd = Carbon::now()->endOfWeek();
        
        $weeklyHafalans = collect();
        $weeklyMurajaahs = collect();
        
        if ($santri) {
            $weeklyHafalans = Hafalan::where('santri_id', $santri->id)
                ->whereBetween('target_date', [$weekStart, $weekEnd])
                ->get();
                
            $weeklyMurajaahs = Murajaah::where('santri_id', $santri->id)
                ->whereBetween('target_date', [$weekStart, $weekEnd])
                ->get();
        }
        
        // Calculate progress percentages
        $hafalanProgress = $weeklyHafalans->count() > 0 
            ? ($weeklyHafalans->where('status', 'completed')->count() / $weeklyHafalans->count()) * 100 
            : 0;
            
        $murajaahProgress = $weeklyMurajaahs->count() > 0 
            ? ($weeklyMurajaahs->where('status', 'completed')->count() / $weeklyMurajaahs->count()) * 100 
            : 0;
        
        return view('dashboard.index', compact(
            'groups', 
            'santri', 
            'todayHafalans', 
            'todayMurajaahs', 
            'weeklyHafalans', 
            'weeklyMurajaahs',
            'hafalanProgress',
            'murajaahProgress'
        ));
    }
}
