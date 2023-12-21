<?php

namespace App\Http\Requests;

use App\Http\Controllers\FileController;
use App\Models\Member;
use App\Models\Project;
use App\Models\World;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;

class UploadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        switch (request()->type) {
            case 'profile':
                return Auth::user()->can('edit', Member::find($this->route()->id));
            case 'world':
                return Auth::user()->can('edit', World::find($this->route()->id));
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
            'file' => ['required', File::types(['png', 'jpg', 'jpeg', 'gif'])->max(12 * 1024)],
            'type' => ['required', Rule::in(['profile', 'project', 'world'])]
        ];
    }
}
