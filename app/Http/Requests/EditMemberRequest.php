<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

use App\Models\Member;

class EditMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        
        return Auth::user()->can('edit', Member::find($this->route()->id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string','max:250', 'unique:user_info,username,' . Member::find($this->route()->id)->persistentUser->user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'old_password' => ['required', 'string'],
            'birthday' => ['required'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'email' => ['required', 'email','max:250', 'unique:members,email,' . $this->route()->id],
        ];
    }
}
