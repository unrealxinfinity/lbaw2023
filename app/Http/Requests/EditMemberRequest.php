<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        
        return Auth::user()->can('edit', User::where('username', $this->route()->username)->first()->persistentUser->member);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $user = User::where('username', $this->route()->username)->first();
        $member = $user->persistentUser->member;
        return [
            'username' => ['required', 'string','max:250', 'unique:user_info,username,' . $user->id],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'old_password' => ['nullable', 'string'],
            'birthday' => ['required'],
            'name' => ['required', 'string'],
            'description' => ['required', 'string'],
            'email' => ['required', 'email','max:250', 'unique:members,email,' . $member->id],
        ];
    }
}
