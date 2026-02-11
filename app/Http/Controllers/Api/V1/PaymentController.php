<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Payment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRequest;
use App\Http\Requests\UpdatePaymentRequest;
use App\Http\Resources\PaymentResource;
use App\Models\MembershipType;  

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with(['applicant', 'membershipType', 'receivedBy'])->latest()->paginate(10);

        return PaymentResource::collection($payments);
    }

    // public function store(StorePaymentRequest $request)
    // {
    //     $payment = Payment::create($request->validated());

    //     return new PaymentResource($payment);
    // }

    public function store(StorePaymentRequest $request)
    {
        $membershipType = MembershipType::findOrFail($request->membership_type_id);

        $payment = Payment::create([
            'applicant_id' => $request->applicant_id,
            'membership_type_id' => $request->membership_type_id,
            'or_number' => 'OR-' . date('Y') . '-' . str_pad(Payment::count() + 1, 3, '0', STR_PAD_LEFT),
            'amount' => $membershipType->price,
            'received_by_user_id' => auth()->id(),
            'payment_date' => now()->toDateString(),
        ]);

        // ✅ Auto-update the applicant status to "paid"
        $payment->applicant->update(['status' => 'paid']);

        return new PaymentResource($payment);
    }


    public function show(Payment $payment)
    {
        $payment->load(['applicant', 'membershipType', 'receivedBy']);

        return new PaymentResource($payment);
    }

    public function update(UpdatePaymentRequest $request, Payment $payment)
    {
        $payment->update($request->validated());

        return new PaymentResource($payment);
    }

    public function destroy(Payment $payment)
    {
        $payment->delete();

        return response()->json([
            'message' => 'Payment deleted successfully'
        ]);
    }
}
