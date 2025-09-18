<?php
 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAidRequestRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->isBeneficiary();
    }

    public function rules()
    {
        return [
            'type' => 'required|in:food,clothing,medical,financial,other',
            'description' => 'required|string|max:1000',
            'document' => 'nullable|file|max:2048|mimes:pdf,jpg,png'
        ];
    }
}