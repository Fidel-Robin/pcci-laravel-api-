<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Resources\MemberResource;
use App\Models\Applicant;
use App\Models\Member;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index()
    {
        $user = request()->user();

        // Super_admin & admin → get all members
        if ($user->hasAnyRole(['super_admin', 'admin'])) {
            $members = Member::with('applicant')->get();
        }

        // Treasurer → only active members
        elseif ($user->hasRole('treasurer')) {
            $members = Member::with('applicant')->where('status', 'active')->get();
        }

        else {
            // default: empty collection
            $members = collect();
        }

        return MemberResource::collection($members);
    }


    public function store(StoreMemberRequest $request)
    {
        $data = $request->validated();

        $applicant = Applicant::findOrFail($data['applicant_id']);

        // Ensure applicant is approved
        if ($applicant->status !== 'approved') {
            return response()->json([
                'message' => 'Applicant is not approved'
            ], 403);
        }

        // Prevent duplicate membership
        if ($applicant->member) {
            return response()->json([
                'message' => 'Applicant is already a member'
            ], 409);
        }

        $member = Member::create([
            'applicant_id'    => $applicant->id,
            'membership_no'   => 'MBR-' . now()->format('Y') . '-' . Str::padLeft($applicant->id, 5, '0'),
            'membership_type' => $data['membership_type'],
            'activated_at'    => now(),
            'expires_at'      => $data['expires_at'] ?? null,
            'paid_at'         => now(),
            'receipt_no'      => $data['receipt_no'],
            'status'          => 'active',
        ]);

        return new MemberResource($member);
    }
}
