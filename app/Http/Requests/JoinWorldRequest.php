<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\World;


class JoinWorldRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('join', World::findOrFail($this->world_id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'exists:App\Models\User,username'],
            'type' => [],
            'world_id' => ['required', 'exists:App\Models\World,id'],            
            'token' => ['required', 'exists:App\Models\Invitation,token'],
            'acceptance' => []
        ];
    }
}
