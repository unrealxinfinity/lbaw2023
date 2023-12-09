<?php

namespace App\Http\Requests;

use App\Models\Task;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class EditTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        
        return Auth::user()->can('edit', Task::where('id', $this->route()->id)->first());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['string'],
            'description' => ['string'],
            'status' => [Rule::in('BackLog', 'Upcoming', 'In Progress', 'Finalizing', 'Done')],
            'due_at' => ['date', 'after:today'],
            'effort' => ['integer'],
            'priority' => ['string'],
        ];
    }
}
