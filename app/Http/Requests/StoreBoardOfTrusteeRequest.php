<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoardOfTrusteeRequest extends FormRequest
{
    public function rules()
    {
        return [

            'image' => 'nullable|image|max:2048',

            'lastname' => 'required|string|max:255',
            'firstname' => 'required|string|max:255',
            'middlename' => 'nullable|string|max:255',

            'gender' => 'required|in:male,female',

            'board_position_id' => 'required|exists:board_positions,id',

            'status' => 'required|in:active,inactive'
        ];
    }
}
