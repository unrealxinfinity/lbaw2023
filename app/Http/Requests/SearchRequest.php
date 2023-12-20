<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class SearchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {   
        if(Auth::check()){
            return Auth::user()->can('showSearchResults',Member::where('user_id','=',Auth::user()->user_id)->first());
        }
        else{
            return true;
        }
        
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'anything' => ['required', 'string']
        ];
    }
}
