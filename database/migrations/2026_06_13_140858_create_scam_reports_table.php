<?php

use App\Enums\ScamReportStatus;
use App\Enums\SourceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('scam_reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('message_content');
            $table->string('source_type')->default(SourceType::SOCIAL_MEDIA);
            $table->unsignedInteger('risk_score');
            $table->string('status')->default(ScamReportStatus::PENDING);
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scam_reports');
    }
};
