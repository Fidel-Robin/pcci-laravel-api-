<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoardOfTrusteeRequest extends FormRequest
{
    public function rules()
    {
        return [

            'image' => 'nullable|image|max:2048',

            'lastname' => 'sometimes|required|string|max:255',
            'firstname' => 'sometimes|required|string|max:255',
            'middlename' => 'nullable|string|max:255',

            'gender' => 'sometimes|required|in:male,female',

            'board_position_id' => 'sometimes|required|exists:board_positions,id',

            'status' => 'sometimes|required|in:active,inactive'
        ];
    }
}
