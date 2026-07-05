<?php

namespace App\Listeners;

use App\Enums\UserRole;
use App\Events\HighRiskReportCreated;
use App\Mail\HighRiskReportMail;
use Illuminate\Support\Facades\Mail;
use App\Models\User;

class SendHighRiskReportEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(HighRiskReportCreated $event): void
    {
        $admins = User::where('role', UserRole::ADMIN)->get();

        foreach ($admins as $admin) {
            Mail::to($admin->email)
                ->send(new HighRiskReportMail($event->report));
        }
    }
}
