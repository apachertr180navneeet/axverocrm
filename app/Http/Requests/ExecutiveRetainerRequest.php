<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ExecutiveRetainerRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        // Safely get the ID for unique rule (supports model binding or raw ID)
        $routeParam = $this->route('executive_retainer');
        $ignoreId = null;

        if ($routeParam instanceof \App\Models\ExecutiveRetainerApplication) {
            $ignoreId = $routeParam->id;
        } elseif (is_numeric($routeParam)) {
            $ignoreId = $routeParam;
        } elseif (is_string($routeParam) && $routeParam !== '') {
            $ignoreId = $routeParam;
        }

        return [
            'name' => 'required|string|max:255',
            'mobile' => [
                'required',
                'string',
                'max:20',
                Rule::unique('executive_retainer_applications', 'mobile')->ignore($ignoreId),
            ],
            'email' => 'required|email|max:255',
            'post' => 'required|in:HR Executive,Retainer',
            'date_of_joining' => 'required|date',
            'hired_executives' => 'nullable|array|max:4',
            'hired_executives.*.name' => 'nullable|string|max:255|required_with:hired_executives.*',
            'hired_executives.*.mobile' => 'nullable|string|max:20|required_with:hired_executives.*',
            'hired_executives.*.joining_date' => 'nullable|date|required_with:hired_executives.*',
            'hired_retainers' => 'nullable|array|max:4',
            'hired_retainers.*.name' => 'nullable|string|max:255|required_with:hired_retainers.*',
            'hired_retainers.*.mobile' => 'nullable|string|max:20|required_with:hired_retainers.*',
            'hired_retainers.*.joining_date' => 'nullable|date|required_with:hired_retainers.*',
            'retainer_detail' => 'nullable|array',
            'retainer_detail.name' => 'nullable|string|max:255|required_if:post,Retainer',
            'retainer_detail.mobile' => 'nullable|string|max:20|required_if:post,Retainer',
            'retainer_detail.joining_date' => 'nullable|date|required_if:post,Retainer',
            'terms_accepted' => $this->isMethod('post') && !$this->route('executive_retainer') && !in_array('admin', user_roles()) ? 'required|accepted' : 'sometimes',
        ];
    }

    public function messages()
    {
        return [
            'mobile.unique' => 'This mobile number is already registered.',
            'hired_executives.max' => 'You can add maximum 4 HR Executives.',
            'hired_retainers.max' => 'You can add maximum 4 HR Retainers.',
            'retainer_detail.name.required_if' => 'The retainer name is required when post is Retainer.',
            'retainer_detail.mobile.required_if' => 'The retainer mobile is required when post is Retainer.',
            'retainer_detail.joining_date.required_if' => 'The retainer joining date is required when post is Retainer.',
        ];
    }
}