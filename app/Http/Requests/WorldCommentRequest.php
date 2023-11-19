<?php

namespace App\Http\Requests;

use App\Models\World;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class WorldCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('comment', World::find($this->route()->id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'member' => ['exists:App\Models\Member,id'],
            'text' => ['required', 'string']
        ];
    }
}
