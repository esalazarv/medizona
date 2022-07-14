<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // TODO: implement authorization rules
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'customer_id' => ['sometimes', 'exists:customers,id'],
            'items' => ['sometimes', 'array', 'min:1'],
            'items.*.id' => ['required', 'exists:items'],
            'items.*.quantity' => ['required', 'min:1'],
        ];
    }
}
