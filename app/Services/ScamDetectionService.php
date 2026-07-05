<?php

namespace App\Services;

use App\Enums\ScamReportStatus;
use app\Enums\UserRole;
use App\Events\HighRiskReportCreated;
use App\Mail\HighRiskReportMail;
use App\Models\ScamCategory;
use App\Models\ScamReport;
use App\Repositories\ScamReportRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class ScamDetectionService
{

    public function __construct(private ScamReportRepository $reportRepository,
    )
    {}
    public function findAll(Request $request)
    {
        $query = $this->reportRepository->query();

        if ($request->filled('source_type')) {
            $query->where('source_type', $request->source_type);
        }

        if ($request->filled('risk')) {

            $query->when($request->risk === 'low', function ($q) {
                $q->whereBetween('risk_score', [0,39]);
            });

            $query->when($request->risk === 'medium', function ($q) {
                $q->whereBetween('risk_score', [40,69]);
            });

            $query->when($request->risk === 'high', function ($q) {
                $q->whereBetween('risk_score', [70,100]);
            });
        }

        return $query->with('user')->get();
    }
    public function findById(int $id): ScamReport
    {
        return $this->reportRepository->findById($id);
    }
    public function delete(int $id): void
    {
        $this->reportRepository->delete($id);
    }
    public function processAndCreateReport(array $data): ScamReport
    {
        $result = $this->calculateRisk($data['message_content']);

        $riskScore = $result['risk_score'] ?? 0;
        $categoryName = $result['category'] ?? 'Other';

        $category = ScamCategory::firstOrCreate([
            'name' => $categoryName
        ]);

        $report = $this->reportRepository->save([
            'title' => $data['title'],
            'message_content' => $data['message_content'],
            'source_type' => $data['source_type'],
            'risk_score' => $riskScore,
            'category_id' => $category->id,
            'status' => ScamReportStatus::PENDING,
            'user_id' => auth()->id(),
        ]);

        if ($riskScore >= 70) {
            event(new HighRiskReportCreated($report));
        }

        return $report;
    }

    public function calculateRisk(string $message): array
    {
        $response = Http::withToken(env('HF_API_KEY'))
            ->post('https://router.huggingface.co/v1/chat/completions', [
                'model' => 'deepseek-ai/DeepSeek-V3',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a scam detection system.
                        Scoring guidelines:

                        - 0–30 (Low Risk):
                          Legitimate or everyday messages with no obvious scam indicators.

                        - 31–69 (Medium Risk):
                          Suspicious messages that contain one or two scam indicators such as urgency, requests to click a link, verify information, unexpected prizes, unknown senders, or unusual requests, but without strong evidence of fraud.

                        - 70–100 (High Risk):
                          Messages with multiple clear scam indicators such as impersonating a bank or company, requesting passwords, verification codes, personal or financial information, cryptocurrency payments, gift cards, threats, account suspension, or fake prizes.

                        Choose a score that best reflects the overall risk. Use the full range from 0 to 100 and avoid assigning only extreme values.

                        Return ONLY valid JSON. Do not include explanations or markdown. Choose "Other" only if the message is not a scam.

                        {
                          "risk_score": number from 0-100,
                          "category": one of:
                            "Phishing",
                            "Bank Scam",
                            "Lottery Scam",
                            "Delivery Scam",
                            "Social Media Scam",
                            "Investment Scam",
                            "Other"
                        }

                        Choose exactly one category from the list above.
                        Do not invent new categories.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $message
                    ]
                ]
            ]);

        $content = $response['choices'][0]['message']['content'] ?? '{}';

        preg_match('/\{.*\}/s', $content, $matches);

        $decoded = json_decode($matches[0] ?? '{}', true);

        return [
            'risk_score' => $decoded['risk_score'] ?? 0,
            'category' => $decoded['category'] ?? 'other',
        ];
    }
    public function reviewReport(ScamReport $report, string $status): ScamReport
    {

        return $this->reportRepository->updateStatus($report->id, [
            'status' => $status,
            'reviewed_by' => auth()->id(),
            'reviewed_at' => now(),
        ]);
    }
    public function getDashboardStatistics(): array
    {
        $total = ScamReport::count();

        $low = ScamReport::whereBetween('risk_score', [0, 39])->count();

        $medium = ScamReport::whereBetween('risk_score', [40, 69])->count();

        $high = ScamReport::whereBetween('risk_score', [70, 100])->count();

        $topCategory = ScamCategory::withCount('reports')
            ->orderByDesc('reports_count')
            ->first();

        $categories = ScamCategory::withCount('reports')->get();

        return compact(
            'total',
            'low',
            'medium',
            'high',
            'topCategory',
            'categories'
        );
    }
    public function getExportData(): \Illuminate\Database\Eloquent\Collection
    {
        return ScamReport::with('category')->get();
    }
}
