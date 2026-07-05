<?php

namespace Database\Seeders;

use App\Enums\ScamReportStatus;
use app\Enums\UserRole;
use App\Models\ScamReport;
use App\Models\ScamCategory;
use App\Models\User;
use Illuminate\Database\Seeder;

class ScamReportSeeder extends Seeder
{
    public function run(): void
    {

        $reports = [
            [
                'title' => 'Bank account locked',
                'message_content' => 'Your bank account is locked. Click here to verify immediately.',
                'source_type' => 'sms',
                'category' => 'Bank Scam',
                'risk_score' => 85
            ],
            [
                'title' => 'Lottery win scam',
                'message_content' => 'You won $1,000,000! Send your details to claim your prize.',
                'source_type' => 'email',
                'risk_score' => 92,
                'category' => 'Lottery Scam'
            ],
            [
                'title' => 'Delivery scam',
                'message_content' => 'Your package is waiting. Confirm address to receive it.',
                'source_type' => 'sms',
                'risk_score' => 70,
                'category' => 'Delivery Scam'
            ],
            [
                'title' => 'Instagram Verification',
                'message_content' => 'Your Instagram account requires verification to prevent suspension. Confirm your login information.',
                'source_type' => 'social_media',
                'category' => 'Social Media Scam',
                'risk_score' => 67,
            ],

            [
                'title' => 'Crypto Investment',
                'message_content' => 'Double your Bitcoin investment within 24 hours with our guaranteed trading platform.',
                'source_type' => 'website',
                'category' => 'Investment Scam',
                'risk_score' => 90,
            ],

            [
                'title' => 'Password Reset',
                'message_content' => 'We noticed an unusual login attempt. Reset your password using the link below.',
                'source_type' => 'email',
                'category' => 'Phishing',
                'risk_score' => 73,
            ],

            [
                'title' => 'Meeting Tomorrow',
                'message_content' => 'Hey, are we still meeting at the café tomorrow at 3 PM?',
                'source_type' => 'sms',
                'category' => 'Other',
                'risk_score' => 5,
            ],

            [
                'title' => 'Birthday Wishes',
                'message_content' => 'Happy Birthday! Hope you have an amazing day.',
                'source_type' => 'social_media',
                'category' => 'Other',
                'risk_score' => 2,
            ],

            [
                'title' => 'Invoice Attached',
                'message_content' => 'Please review the attached invoice for your recent purchase.',
                'source_type' => 'email',
                'category' => 'Phishing',
                'risk_score' => 48,
            ],

            [
                'title' => 'Netflix Payment Failed',
                'message_content' => 'Your Netflix payment could not be processed. Update your payment information.',
                'source_type' => 'email',
                'category' => 'Phishing',
                'risk_score' => 69,
            ],

            [
                'title' => 'WhatsApp Support',
                'message_content' => 'Your WhatsApp account will be disabled unless you verify it within 24 hours.',
                'source_type' => 'social_media',
                'category' => 'Social Media Scam',
                'risk_score' => 76,
            ],

            [
                'title' => 'Free Crypto Giveaway',
                'message_content' => 'Send 0.1 BTC and receive 1 BTC back instantly.',
                'source_type' => 'website',
                'category' => 'Investment Scam',
                'risk_score' => 95,
            ],

            [
                'title' => 'Amazon Order',
                'message_content' => 'Your Amazon order has been shipped and will arrive tomorrow.',
                'source_type' => 'email',
                'category' => 'Other',
                'risk_score' => 10,
            ],

            [
                'title' => 'Tax Refund',
                'message_content' => 'You are eligible for a government tax refund. Submit your banking information to receive the payment.',
                'source_type' => 'email',
                'category' => 'Phishing',
                'risk_score' => 81,
            ],

            [
                'title' => 'Bank Security Alert',
                'message_content' => 'A new device has logged into your online banking. Confirm if this was you.',
                'source_type' => 'sms',
                'category' => 'Bank Scam',
                'risk_score' => 86,
            ],

            [
                'title' => 'Coffee Later?',
                'message_content' => 'Do you want to grab coffee after work today?',
                'source_type' => 'sms',
                'category' => 'Other',
                'risk_score' => 1,
            ],

            [
                'title' => 'Facebook Login',
                'message_content' => 'Your Facebook account has unusual activity. Verify your account.',
                'source_type' => 'social_media',
                'category' => 'Social Media Scam',
                'risk_score' => 65,
            ],

            [
                'title' => 'University Schedule',
                'message_content' => 'The updated class schedule is now available on the student portal.',
                'source_type' => 'email',
                'category' => 'Other',
                'risk_score' => 7,
            ],

            [
                'title' => 'Urgent Wire Transfer',
                'message_content' => 'Please transfer the requested amount immediately to complete today\'s transaction.',
                'source_type' => 'email',
                'category' => 'Bank Scam',
                'risk_score' => 83
            ],

            [
                'title' => 'Mobile Carrier Reward',
                'message_content' => 'You have been selected to receive a free smartphone. Click here to claim it.',
                'source_type' => 'sms',
                'category' => 'Lottery Scam',
                'risk_score' => 74,
            ],

        ];

        foreach ($reports as $report) {
            $users = User::where('role', '!=', UserRole::ADMIN)->get();
            $admin = User::where('role', UserRole::ADMIN)->inRandomOrder()->first();
            $category = ScamCategory::firstOrCreate([
                'name' => $report['category']
            ]);
            ScamReport::create([
                'title' => $report['title'],
                'message_content' => $report['message_content'],
                'source_type' => $report['source_type'],
                'category_id' => $category->id,
                'risk_score' => $report['risk_score'],
                'status' => $report['risk_score'] >= 40
                    ? ScamReportStatus::APPROVED
                    : ScamReportStatus::REJECTED,
                'user_id' => $users->random()->id,
                'reviewed_by' => $admin?->id,
                'reviewed_at' => now()
            ]);
        }
    }
}
