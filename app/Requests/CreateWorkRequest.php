<?php

namespace App\Requests;

use App\Core\FormRequest;

class CreateWorkRequest extends FormRequest
{
    public function rules()
    {
        $workStatus = implode(',', WORK_STATUS);
        return [
            'work_name' => 'required',
            'starting_date' => ['required', 'regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/'],
            'ending_date' => ['required', 'regex:/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/', 'after:starting_date'],
            'status' => 'required|in:'.$workStatus,
        ];
    }

    public function messages()
    {
        return [
            'work_name.required' => 'Work name is required',
            'starting_date.required' => 'Starting date is required',
            'starting_date.regex' => 'Starting date invalid',
            'ending_date.required' => 'Ending date is required',
            'ending_date.regex' => 'Ending date invalid',
            'ending_date.after' => 'Ending date must be more than Starting date',
            'status.required' => 'Status is required',
            'status.in' => 'Status invalid',
        ];
    }
}