<?php

namespace Database\Seeders;

use App\Enums\ScamReportStatus;
use App\Models\ScamReport;
use App\Models\ScamCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ScamReportSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();

        $reports = [
            [
                'title' => 'Bank account locked',
                'message_content' => 'Your bank account is locked. Click here to verify immediately.',
                'source_type' => 'sms',
                'risk_score' => 85,
            ],
            [
                'title' => 'Lottery win scam',
                'message_content' => 'You won $1,000,000! Send your details to claim your prize.',
                'source_type' => 'email',
                'risk_score' => 92,
            ],
            [
                'title' => 'Delivery scam',
                'message_content' => 'Your package is waiting. Confirm address to receive it.',
                'source_type' => 'sms',
                'risk_score' => 70,
            ],
            [
                'title' => 'Normal message',
                'message_content' => 'Hey, are we still meeting tomorrow?',
                'source_type' => 'chat',
                'risk_score' => 5,
            ],
        ];

        foreach ($reports as $data) {
            ScamReport::create([
                'title' => $data['title'],
                'message_content' => $data['message_content'],
                'source_type' => $data['source_type'],
                'risk_score' => $data['risk_score'],
                'status' => ScamReportStatus::PENDING,
                'user_id' => $user->id,
            ]);
        }
    }
}
