<?php

namespace Database\Factories;

use App\Enums\ScamReportStatus;
use App\Models\ScamReport;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ScamReport>
 */
class ScamReportFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'message_content' => fake()->paragraph(),
            'source_type' => fake()->randomElement(['sms', 'email', 'social_media', 'website']),
            'risk_score' => fake()->numberBetween(0, 100),
            'status' => fake()->randomElement([ScamReportStatus::PENDING, ScamReportStatus::APPROVED, ScamReportStatus::REJECTED]),
            'user_id' => User::factory(),
        ];
    }
}
