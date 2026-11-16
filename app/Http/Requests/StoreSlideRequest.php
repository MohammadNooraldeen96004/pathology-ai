<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSlideRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slide' => [
                'required',
                'file',
                'mimes:tif,tiff',
                'max:1048576',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'slide.required' => 'Please select a pathology slide.',
            'slide.file' => 'The uploaded slide must be a valid file.',
            'slide.mimes' => 'The pathology slide must be a TIF or TIFF file.',
            'slide.max' => 'The pathology slide must not exceed 1 GB.',
        ];
    }
}