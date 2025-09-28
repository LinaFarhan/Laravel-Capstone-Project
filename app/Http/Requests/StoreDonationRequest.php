<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDonationRequest extends FormRequest
{
    /*  يتحقق من أن المستخدم مسؤول أو متطوع */
public function authorize()
{
    return $this->user() && ($this->user()->isAdmin() ||$this->user()->isVolunteer());
}

    /*  يتحقق من حالة التوصيل، الملف، والملاحظات */
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
