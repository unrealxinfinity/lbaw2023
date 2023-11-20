<?php

namespace App\Http\Requests;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;



class CreateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->can('create', Task::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string', 'required', 'max:30'],
            'description' => ['string', 'max:255'],
            'status' => [Rule::in(['BackLog', 'Upcoming', 'In Progress', 'Finalizing', 'Done'])],
            'due_at' => ['date', 'after:today'],
            'effort' => ['integer'],
            'priority' => ['string'],
            'project_id' => ['exists:App\Models\Project,id']
        ];
    }
}
