<?php

namespace App\Http\Resources;

use App\Models\CustomerAddress;
use Illuminate\Http\Resources\Json\JsonResource;
use Nette\Utils\DateTime;

class CustomerResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'status' => $this->status,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => (new DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new DateTime($this->updated_at))->format('Y-m-d H:i:s'),
            'address' => [
                'id' => $this->customerAddress()->id,
                'address1' => $this->customerAddress()->address1,
                'address2' => $this->customerAddress()->address2,
                'city' => $this->customerAddress()->city,
                'state' => $this->customerAddress()->state,
                'zip_code' => $this->customerAddress()->zip_code,
                'country_code' => $this->customerAddress()->country_code,
                'customer_id' => $this->customerAddress()->customer_id,
                'created_at' => (new DateTime($this->customerAddress()->created_at))->format('Y-m-d H:i:s'),
                'updated_at' => (new DateTime($this->customerAddress()->updated_at))->format('Y-m-d H:i:s'),
            ]
        ];
    }

    private function customerAddress() {
        return CustomerAddress::query()->where(
            'customer_id', $this->id
        )->first();
    }
}
