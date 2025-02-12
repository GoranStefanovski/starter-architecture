<?php

namespace App\Applications\LeaveRequest\Requests;

use App\Http\Requests\ApiFormRequest;

class NewLeaveRequestRequest extends ApiFormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // we will handle this with middleware
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'request_to' => 'required',
            'leave_type_id' => 'required',
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'sometimes|date|after_or_equal:start_date',
        ];

        return $rules;
    }
    public function messages(){
        return [
            'request_to.required' => 'The assign to field is required',
            'leave_type_id.required' => 'The leave type field is required',
        ];
    }
}
