<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveDoctorReviewRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'decision' => [
                'required',
                'in:benign,suspicious,malignant',
            ],

            'notes' => [
                'nullable',
                'string',
                'max:5000',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'decision.required' =>
            'Please select a review decision.',

            'decision.in' =>
            'The selected review decision is invalid.',

            'notes.max' =>
            'Review notes may not exceed 5000 characters.',
        ];
    }
}
