<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class invocesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'invoice_number' => 'required',
            'invoice_Date' => 'required',
            'Due_date' => 'required',
            'product' => 'required',
            'section_id' => 'required',
            'Amount_collection' => 'required',
            'Amount_Commission' => 'required',
            'Discount' => 'required',
            'Value_VAT' => 'required',
            'Rate_VAT' => 'required',
            'Total' => 'required',
            'Status' => 'required',
            'Value_Status' => 'required',
          
        ];
    }

    public function massages(){
        return
       [  'invoice_number.required'=>'رقم الفاتوره مطلوب',
            'invoice_Date.required'=>'تاريخ الفاتوره مطلوب',
            'Due_date.required'=>'رقم الفاتوره مطلوب',
            'product.required'=>'رقم الفاتوره مطلوب',
            'section_id.required'=>'رقم الفاتوره مطلوب',
            'Amount_collection.required'=>'رقم الفاتوره مطلوب',
            'Amount_Commission.required'=>'رقم الفاتوره مطلوب',
            'Discount.required'=>'رقم الفاتوره مطلوب',
            'Value_VAT.required'=>'رقم الفاتوره مطلوب',
            'Rate_VAT.required'=>'رقم الفاتوره مطلوب',
            'Total.required'=>'رقم الفاتوره مطلوب',
            'Status.required'=>'رقم الفاتوره مطلوب',
            'Value_Status.required'=>'رقم الفاتوره مطلوب',
          
    ];}
}
