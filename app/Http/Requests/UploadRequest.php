<?php

namespace App\Http\Requests;

use App\Http\Controllers\FileController;
use App\Models\Member;
use App\Models\Project;
use App\Models\World;
use Faker\Core\File;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        switch ($this->request()->type) {
            case 'profile':
                return Auth::user()->can('edit', Member::find($this->route()->id));
                break;
            case 'world':
                return Auth::user()->can('edit', World::find($this->route()->id));
                break;
            case 'project':
                return Auth::user()->can('edit', Project::find($this->route()->id));
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
            'file' => ['required', 'file', 'extensions:png,jpg,jpeg,gif'],
            'type' => ['required', Rule::in(['profile', 'project', 'world'])]
        ];
    }
}
