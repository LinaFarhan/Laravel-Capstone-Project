<?php
 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules()
    {
        return [
            'donor_name' => 'required|string|max:255',
            'type' => 'required|in:food,clothing,medical,financial,other',
            'quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,received,distributed,expired',
            'description' => 'nullable|string|max:1000',
        ];
    }
}