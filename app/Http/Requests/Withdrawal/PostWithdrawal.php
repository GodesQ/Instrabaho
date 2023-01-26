<?php

namespace App\Http\Requests\Withdrawal;

use Illuminate\Foundation\Http\FormRequest;

class PostWithdrawal extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
            'payment_method' => 'required',
            'amount' => 'required',
            'card_number' => 'required_if:payment_method,card',
            'gcash_number' => 'required_if:payment_method,gcash',
            'exp_year' => 'required_if:payment_method,card',
            'exp_month' => 'required_if:payment_method,card',
            'cvc' => 'required_if:payment_method,card',
        ];
    }
}
