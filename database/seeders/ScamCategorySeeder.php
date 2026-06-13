<?php

namespace Database\Seeders;

use App\Models\ScamCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ScamCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ScamCategory::insert([
            [
                'name' => 'Bank Scam',
                'description' => 'Fraudulent messages pretending to be from banks.',
            ],
            [
                'name' => 'Lottery Scam',
                'description' => 'Fake winnings and prize notifications.',
            ],
            [
                'name' => 'Delivery Scam',
                'description' => 'Fake package tracking and delivery requests.',
            ],
            [
                'name' => 'Investment Scam',
                'description' => 'Fraudulent investment opportunities and crypto schemes.',
            ],
            [
                'name' => 'Social Media Scam',
                'description' => 'Scams conducted through social media platforms.',
            ],
            [
                'name' => 'Phishing',
                'description' => 'Attempts to steal credentials or personal information.',
            ],
        ]);
    }
}
