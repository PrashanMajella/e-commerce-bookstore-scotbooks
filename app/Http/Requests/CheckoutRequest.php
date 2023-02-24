<?php

namespace App\Http\Requests;

use App\Enums\AddressType;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'billing.first_name' => ['required'],
            'billing.last_name' => ['required'],
            'billing.phone' => ['required', 'min:10'],
            'billing.email' => ['required', 'email'],
            'billing.address1' => ['required'],
            'billing.address2' => ['required'],
            'billing.city' => ['required'],
            'billing.state' => ['required'],
            'billing.zip_code' => ['required'],
            'billing.country_code' => ['required', 'exists:countries,code'],
            'billing.type' => [new Enum(AddressType::class)],

            'shipping.first_name' => ['required'],
            'shipping.last_name' => ['required'],
            'shipping.phone' => ['required', 'min:10'],
            'shipping.email' => ['required', 'email'],
            'shipping.address1' => ['required'],
            'shipping.address2' => ['required'],
            'shipping.city' => ['required'],
            'shipping.state' => ['required'],
            'shipping.zip_code' => ['required'],
            'shipping.country_code' => ['required', 'exists:countries,code'],
            'shipping.type' => [new Enum(AddressType::class)],
        ];
    }
}
