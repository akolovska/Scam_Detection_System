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
        'category_id',
        'reviewed_at',
        'reviewed_by',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function category()
    {
        return $this->belongsTo(ScamCategory::class, 'category_id');
    }
    protected function casts(): array
    {
        return [
            'status' => ScamReportStatus::class,
            'source_type' => SourceType::class,
            'reviewed_at' => 'datetime'
        ];
    }
    public function reports()
    {
        return $this->hasMany(ScamReport::class);
    }
    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
