<?php

namespace App\Http\Requests;

use App\Models\World;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class AddMemberToWorldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('addMember', World::find($this->route()->id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'type' => [Rule::in(['true', 'false'])],
            'world_id' => ['exists:App\Models\World,id'],
            'username' => ['exists:App\Models\User,username']
        ];
    }
}
