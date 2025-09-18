<?php
 
namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAidRequestRequest extends FormRequest
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
    
    public function messages()
    {
        return [
            'type.required' => 'نوع المساعدة مطلوب',
            'type.in' => 'نوع المساعدة غير صالح',
            'description.required' => 'وصف الطلب مطلوب',
            'description.max' => 'وصف الطلب يجب ألا يتجاوز 1000 حرف',
            'document.file' => 'المستند يجب أن يكون ملف',
            'document.max' => 'حجم المستند يجب ألا يتجاوز 2 ميجابايت',
            'document.mimes' => 'صيغة الملف يجب أن تكون PDF, JPG, أو PNG'
        ];
    }
}