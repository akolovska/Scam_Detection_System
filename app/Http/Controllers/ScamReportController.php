<?php

namespace App\Http\Controllers;

use App\Enums\ScamReportStatus;
use app\Enums\UserRole;
use App\Http\Requests\StoreScamReportRequest;
use App\Mail\HighRiskReportMail;
use App\Models\ScamCategory;
use App\Models\ScamReport;
use App\Repositories\ScamReportRepository;
use App\Services\ScamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ScamReportController extends Controller
{
    public function __construct(
        private ScamDetectionService $detectionService
    ) {}

    public function index(Request $request)
    {
        $reports = $this->detectionService->findAll($request);

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }

    public function store(StoreScamReportRequest $request)
    {
        try {
            $report = $this->detectionService->processAndCreateReport(
                $request->validated()
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'message_content' => 'AI service is currently unavailable.'
            ]);
        }

        return redirect()
            ->route('reports.index')
            ->with('success', 'Report submitted successfully.');
    }

    public function show(int $id)
    {
        $report = $this->detectionService->findById($id);

        return view('reports.show', compact('report'));
    }

    public function destroy(int $id)
    {
        $this->detectionService->delete($id);

        return redirect()
            ->route('reports.index')
            ->with('success', 'Report deleted successfully.');
    }
    public function dashboard()
    {
        return view(
            'statistics',
            $this->detectionService->getDashboardStatistics()
        );
    }
    public function review(Request $request, ScamReport $report)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected,pending',
        ]);

        $this->detectionService->reviewReport(
            $report,
            $request->status
        );

        return back()->with('success', 'Report reviewed.');
    }

    public function exportCsv(): StreamedResponse
    {
        $reports = $this->detectionService->getExportData();

        return response()->streamDownload(function () use ($reports) {
            $handle = fopen('php://output', 'w');

            fputcsv($handle, ['ID','Title','Risk','Category']);

            foreach ($reports as $report) {
                fputcsv($handle, [
                    $report->id,
                    $report->title,
                    $report->risk_score,
                    $report->category?->name ?? 'N/A',
                ]);
            }

            fclose($handle);
        }, 'reports.csv');
    }
    public function myReports(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
    {
        $reports = ScamReport::with('category')
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('reports.mine', compact('reports'));
    }

}
