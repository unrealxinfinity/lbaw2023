<?php

namespace App\Http\Requests;
use App\Models\Tag;
use App\Models\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class CreateTagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(Project $project): bool
    {
        return Auth::user()->can('projectCreate', $project);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tagName' => ['string'],
            'project_id' => ['exists:App\Models\Project,id'],
        ];
    }
}
