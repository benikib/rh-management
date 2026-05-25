<?php

namespace App\Http\Controllers;

use App\Services\RHAnalyticsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(protected RHAnalyticsService $analytics)
    {
    }

    public function index(): View
    {
        $globalMetrics = $this->analytics->getGlobalMetrics();
        $departmentMetrics = $this->analytics->getDepartmentMetrics();
        $directionMetrics = $this->analytics->getDirectionMetrics();
        $attendanceTrend = $this->analytics->getAttendanceTrend(14);
        $evaluationTrend = $this->analytics->getEvaluationTrend(6);
        $departmentComparison = $this->analytics->getDepartmentComparison();
        $directionComparison = $this->analytics->getDirectionComparison();
        $topEmployees = $this->analytics->getTopEmployees(5);
        $scoreHistogram = $this->analytics->getScoreHistogram();

        return view('dashboard', compact(
            'globalMetrics',
            'departmentMetrics',
            'directionMetrics',
            'attendanceTrend',
            'evaluationTrend',
            'departmentComparison',
            'directionComparison',
            'topEmployees',
            'scoreHistogram'
        ));
    }

    public function globalStats(): JsonResponse
    {
        return response()->json($this->analytics->getGlobalMetrics());
    }

    public function departmentStats(): JsonResponse
    {
        return response()->json($this->analytics->getDepartmentMetrics());
    }

    public function directionStats(): JsonResponse
    {
        return response()->json($this->analytics->getDirectionMetrics());
    }
}
