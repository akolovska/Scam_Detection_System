<?php

namespace App\Models;

use App\Enums\RiskMethod;
use App\Enums\ScamReportStatus;
use App\Enums\SourceType;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\ScamCategory;

class ScamReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'message_content',
        'source_type',
        'risk_score',
        'status',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function categories()
    {
        return $this->belongsToMany(
            ScamCategory::class,
            'scam_report_categories'
        );
    }
    protected function casts(): array
    {
        return [
            'status' => ScamReportStatus::class,
            'source_type' => SourceType::class
        ];
    }
}
