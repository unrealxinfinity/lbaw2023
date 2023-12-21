<?php

namespace App\Http\Requests;

use App\Models\Task;
use App\Models\World;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        switch (request()->type) {
            case 'world':
                return Auth::user()->can('comment', World::find($this->route()->id));
            case 'task':
                return Auth::user()->can('comment', Task::find($this->route()->id));
        }

        return false;
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
            'text' => ['required', 'string'],
            'type' => ['required', Rule::in(['world', 'task'])]
        ];
    }
}
