<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\MembershipType;
use App\Http\Requests\StoreMemberRequest;
use App\Http\Resources\MemberResource;
use Carbon\Carbon;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class MemberController extends Controller
{
    public function index()
    {
        return MemberResource::collection(
            Member::latest()->paginate(10)
        );
    }

   public function store(StoreMemberRequest $request)
    {
         // 1. Find applicant
        $applicant = \App\Models\Applicant::findOrFail($request->applicant_id);

        if ($applicant->status !== 'paid') {
            return response()->json([
                'message' => 'Only applicants with status "paid" can be added as members.'
            ], 422);
        }

        // 2. Prevent duplicate member
        if (\App\Models\Member::where('applicant_id', $request->applicant_id)->exists()) {
            return response()->json([
                'message' => 'This applicant is already a member.'
            ], 422);
        }

        // 3. Get the original payment for this applicant
        $payment = \App\Models\Payment::where('applicant_id', $request->applicant_id)->first();

        if (!$payment) {
            return response()->json([
                'message' => 'Payment record not found for this applicant.'
            ], 422);
        }

        // 4. Get membership type from payment
        $membershipType = \App\Models\MembershipType::findOrFail($payment->membership_type_id);


        // Handle induction date (nullable)
        $inductionDate = $request->induction_date ? \Carbon\Carbon::parse($request->induction_date) : null;

        // Auto-calculate membership_end_date if induction date is set
        $membershipEndDate = $inductionDate ? $inductionDate->copy()->addMonths($membershipType->duration_in_months) : null;

        // Create member
        $member = \App\Models\Member::create([
            'applicant_id' => $request->applicant_id,
            // 'membership_type_id' => $request->membership_type_id,
            'membership_type_id' => $payment->membership_type_id,
            'induction_date' => $inductionDate,
            'membership_end_date' => $membershipEndDate,
            'status' => $inductionDate ? 'active' : 'pending',
        ]);



        //Create user account for member (if not exists)
        $applicant = $member->applicant;

        $generatedPassword = null;

        // Check if user already exists
        if (!User::where('email', $applicant->email)->exists()) {

            $generatedPassword = Str::random(8);

            $user = User::create([
                'name' => $applicant->registered_business_name,
                'email' => $applicant->email,
                'password' => Hash::make($generatedPassword),
            ]);

            $user->assignRole('member');
        }


        return response()->json([
            'message' => 'Member created successfully',
            'member' => new MemberResource($member),
            'generated_password' => $generatedPassword,
        ], 201);
    }


    public function show(Member $member)
    {
        return new MemberResource($member);
    }

    public function update(StoreMemberRequest $request, Member $member)
    {
        $membershipType = MembershipType::findOrFail($request->membership_type_id);

        $inductionDate = $request->induction_date 
            ? Carbon::parse($request->induction_date)
            : null;

        $membershipEndDate = null;

        if ($inductionDate) {
            $membershipEndDate = $inductionDate
                ->copy()
                ->addMonths($membershipType->duration_in_months);
        }

        $member->update([
            'applicant_id' => $request->applicant_id,
            'membership_type_id' => $request->membership_type_id,
            'induction_date' => $inductionDate,
            'membership_end_date' => $membershipEndDate,
            'status' => $inductionDate ? 'active' : 'pending',
        ]);

        return new MemberResource($member);
    }

    public function destroy(Member $member)
    {
        $member->delete();

        return response()->json([
            'message' => 'Member deleted successfully.'
        ]);
    }
}
