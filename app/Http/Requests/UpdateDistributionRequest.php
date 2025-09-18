<?php
 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDistributionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && (auth()->user()->isAdmin() || auth()->user()->isVolunteer());
    }

    public function rules()
    {
        return [
            'delivery_status' => 'required|in:assigned,in_progress,delivered,cancelled',
            'proof_file' => 'nullable|file|max:2048|mimes:jpg,png,pdf',
            'notes' => 'nullable|string|max:1000',
        ];
    }
}