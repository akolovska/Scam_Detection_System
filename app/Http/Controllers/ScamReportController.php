<?php

namespace App\Http\Controllers;

use App\Enums\ScamReportStatus;
use App\Http\Requests\StoreScamReportRequest;
use App\Models\ScamCategory;
use App\Repositories\ScamReportRepository;
use App\Services\ScamDetectionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScamReportController extends Controller
{
    public function __construct(
        private ScamReportRepository $reportRepository,
        private ScamDetectionService $detectionService
    ) {}

    public function index(Request $request)
    {
        $query = $this->reportRepository->query();

        if ($request->filled('source_type')) {
            $query->where('source_type', $request->source_type);
        }

        if ($request->filled('risk')) {

            $query->when($request->risk === 'low', function ($q) {
                $q->whereBetween('risk_score', [0, 39]);
            });

            $query->when($request->risk === 'medium', function ($q) {
                $q->whereBetween('risk_score', [40, 69]);
            });

            $query->when($request->risk === 'high', function ($q) {
                $q->whereBetween('risk_score', [70, 100]);
            });
        }

        $reports = $query->with('user')->get();

        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        return view('reports.create');
    }


    public function store(StoreScamReportRequest $request)
    {
        $data = $request->validated();
        try {
            $result = $this->detectionService->calculateRisk(
                $data['message_content']
            );
        } catch (\Exception $e) {
            return back()->withErrors([
                'message_content' => 'AI service is currently unavailable. Try again later.'
            ]);
        }
        $riskScore = $result['risk_score'] ?? 0;
        $categoryName = $result['category'] ?? 'other';

        $report = $this->reportRepository->save([
            'title' => $data['title'],
            'message_content' => $data['message_content'],
            'source_type' => $data['source_type'],
            'risk_score' => $riskScore,
            'status' => ScamReportStatus::PENDING,
            'user_id' => Auth::id(),
        ]);

        $category = ScamCategory::where('name', 'LIKE', "%$categoryName%")->first();

        if ($category) {
            $report->categories()->attach($category->id);
        }

        return redirect()
            ->route('reports.index')
            ->with('success', 'Report submitted successfully.');
    }

    public function show(int $id)
    {
        $report = $this->reportRepository->findById($id);
        return view('reports.show', compact('report'));
    }

    public function destroy(int $id)
    {
        $report = $this->reportRepository->findById($id);
        $report->delete();

        return redirect()
            ->route('reports.index')
            ->with('success', 'Report deleted successfully.');
    }
}
