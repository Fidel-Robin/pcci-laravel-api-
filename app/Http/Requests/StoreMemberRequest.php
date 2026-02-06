<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMemberRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->hasRole('treasurer|super_admin');
    }

    public function rules(): array
    {
        return [
            'applicant_id'    => 'required|exists:applicants,id',
            'membership_type' => 'required|string|max:50',
            'receipt_no'      => 'required|string|max:50|unique:members,receipt_no',
            'expires_at'      => 'nullable|date|after:today',
        ];
    }
}
