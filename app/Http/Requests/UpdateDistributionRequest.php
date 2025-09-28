<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
class UpdateDistributionRequest extends FormRequest
{
    public function authorize()
    {
        return $this->check() && ($this->user()->isAdmin() || $this->user()->isVolunteer());
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
