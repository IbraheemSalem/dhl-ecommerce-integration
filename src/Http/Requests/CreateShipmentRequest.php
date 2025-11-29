<?php

namespace Ibraheem\DhlEcommerceIntegration\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateShipmentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'shipper' => 'required|array',
            'recipient' => 'required|array',
            'items' => 'required|array|min:1',
            'serviceType' => 'required|string',
            'reference' => 'nullable|string',
        ];
    }
}
