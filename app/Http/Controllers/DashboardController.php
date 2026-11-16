<?php

namespace App\Http\Controllers;

use App\Models\cases;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $cases = cases::with([
            'patient',
            'slides.AiAnalysis',
        ])
            ->where('doctor_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();

        $activeCasesCount = $cases
            ->whereIn('status', ['pending', 'processing'])
            ->count();

        $completedCasesCount = $cases
            ->where('status', 'completed')
            ->count();

        $slidesAwaitingAiCount = $cases
            ->flatMap(fn($case) => $case->slides)
            ->filter(function ($slide) {
                $analysis = $slide->AiAnalysis;

                return !$analysis ||
                    in_array($analysis->status, ['pending', 'processing'], true);
            })
            ->count();

        return view('dashboard', compact(
            'cases',
            'activeCasesCount',
            'completedCasesCount',
            'slidesAwaitingAiCount'
        ));
    }
}
