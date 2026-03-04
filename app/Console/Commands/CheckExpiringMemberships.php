<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Member;
use App\Models\ExpiringMembershipNotification;
use Carbon\Carbon;

class CheckExpiringMemberships extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:expiring-memberships';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $monthsBefore = [3, 2, 1];

        foreach ($monthsBefore as $month) {

            $targetDate = Carbon::now()->addMonths($month)->toDateString();

            $members = Member::whereDate('membership_end_date', $targetDate)->get();

            foreach ($members as $member) {

                ExpiringMembershipNotification::firstOrCreate([
                    'member_id' => $member->id,
                    'message' => "Membership will expire in {$month} month(s) on {$member->membership_end_date}"
                ]);
            }
        }
    }
}
