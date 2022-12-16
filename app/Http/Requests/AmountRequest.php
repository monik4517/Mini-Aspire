<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use App\Models\LoanInstallment;
class AmountRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        $amount_installment = LoanInstallment::where('id',$this->id)->first();
        $amount = 1;
        if(!empty($amount_installment)){
            $amount = $amount_installment->amount;
        }
        return [
            'amount' => 'required|numeric|gte:'.$amount,
        ];
    }

    
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json(['errors' => $validator->errors()], config('constants.validation_codes.unprocessable_entity')));
    }
}
