<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoice') }}
        </h2>
    </x-slot>

    <div
        x-data="{
            orderItems: {{
                json_encode($products->map(function ($product) use ($orderItems) {
                    return [
                        'id' => $product->id,
                        'slug' => $product->slug,
                        'image' => $product->image,
                        'title' => $product->title,
                        'description' => $product->description,
                        'price' => $product->price,
                        'quantity' => $orderItems[$product->id]['quantity'],
                        'total' => number_format($product->price * $orderItems[$product->id]['quantity'], 2),
                        'viewCartUrl' => route('product.view', $product),
                    ];
                }))
            }},
            billing: {{
                json_encode([
                    'id' => $billingAddress->id,
                    'first_name' => $billingAddress->first_name,
                    'last_name' => $billingAddress->last_name,
                    'email' => $billingAddress->email,
                    'phone' => $billingAddress->phone,
                    'address1' => $billingAddress->address1,
                    'address2' => $billingAddress->address2,
                    'city' => $billingAddress->city,
                    'state' => $billingAddress->state,
                    'zip_code' => $billingAddress->zip_code,
                    'country_code' => $billingAddress->country_code,
                    'customer_id' => $billingAddress->customer_id,
                    'order_id' => $billingAddress->order_id,
                    'created_at' => date_format($billingAddress->created_at, "Y-m-d H:i:s"),
                    'updated_at' => date_format($billingAddress->updated_at, "Y-m-d H:i:s"),
                ])
            }},
            shipping: {{
                json_encode([
                    'id' => $shippingAddress->id,
                    'first_name' => $shippingAddress->first_name,
                    'last_name' => $shippingAddress->last_name,
                    'email' => $shippingAddress->email,
                    'phone' => $shippingAddress->phone,
                    'address1' => $shippingAddress->address1,
                    'address2' => $shippingAddress->address2,
                    'city' => $shippingAddress->city,
                    'state' => $shippingAddress->state,
                    'zip_code' => $shippingAddress->zip_code,
                    'country_code' => $shippingAddress->country_code,
                    'customer_id' => $shippingAddress->customer_id,
                    'order_id' => $shippingAddress->order_id,
                    'created_at' => date_format($shippingAddress->created_at, "Y-m-d H:i:s"),
                    'updated_at' => date_format($shippingAddress->updated_at, "Y-m-d H:i:s"),
                ])
            }},
            init() {
                Object.assign(this.billing, {
                    full_name: this.billing.first_name + ' ' + this.billing.last_name,
                    address: this.billing.address1 + ', ' + this.billing.address2
                        + ', ' + this.billing.city + ', ' + this.billing.state
                        + ', '+ this.billing.zip_code + ', '+ this.billing.country_code
                        + '.',
                });
                Object.assign(this.shipping, {
                    full_name: this.shipping.first_name + ' ' + this.shipping.last_name,
                    address: this.shipping.address1 + ', ' + this.shipping.address2
                        + ', ' + this.shipping.city + ', ' + this.shipping.state
                        + ', '+ this.shipping.zip_code + ', '+ this.shipping.country_code
                        + '.',
                });
            },
            get orderTotal() {
                let sumPrice = this.orderItems.reduce((accumulator, currentValue) => {
                    return accumulator + Number(currentValue.price) * Number(currentValue.quantity);
                }, 0);

                return Number(sumPrice).toFixed(2);
            },
        }"
        class="py-12"
    >
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 mx-0 sm:mx-[5%]">

                    <div class="px-4 py-5 sm:px-6 flex flex-col items-center justify-center mb-10">
                        <h1 class="text-2xl font-bold leading-6 text-gray-900 uppercase">
                            Invoice
                        </h1>
                        <hr class="my-2 mx-auto w-40 h-1 bg-gray-200 rounded border-0">
                    </div>

                    <div class="flex flex-col items-end justify-end gap-2 m-5">
                        <h2 class="text-lg font-bold uppercase">ScotBooks</h2>
                        <h3 class="text-sm md:text-base text-ellipsis text-justify w-64">
                            Ormiston Grows, Pencaitland Railway Walk,
                            East Lothian, Alba, Scotland,
                            EH35 5AH, United Kingdom.
                        </h3>
                        <h3 x-text="billing.updated_at" class="font-semibold"></h3>
                    </div>

                    <div class="flex flex-col items-start justify-start gap-2 m-5">
                        <h1 class="text-lg font-bold uppercase text-gray-500">Invoice ID: {{ $order->id }}</h1>
                        <h2 class="text-lg font-bold uppercase">BILL TO</h2>
                        <h3 class="text-sm md:text-base text-ellipsis text-justify w-64">
                            <span x-text="billing.address"></span>
                        </h3>
                        <h3 x-text="billing.full_name" class="font-semibold"></h3>
                    </div>

                    <div class="relative overflow-x-auto mb-5 mt-10">
                        <table class="w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3">
                                        Item
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Price
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Quantity
                                    </th>
                                    <th scope="col" class="px-6 py-3">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <template
                                    x-for="item in orderItems"
                                    x-bind:key="item.id"
                                >
                                    <tr class="bg-white border-b">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                            <span x-text="item.title"></span>
                                        </th>
                                        <td class="px-6 py-4">
                                            <span x-text="'$' + item.price"></span>
                                        </td>
                                        <td class="px-6 py-4 capitalize">
                                            <span x-text="item.quantity"></span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <span x-text="'$' + item.total"></span>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-col items-end justify-end my-5">
                        <div class="grid grid-cols-2 gap-2 text-lg font-bold uppercase">
                            <h2 class="text-gray-500">Subtotal:</h2>
                            <span x-text="'$' + orderTotal"></span>
                            <h2 class="text-gray-500">Payment Status:</h2>
                            <span>{{ $order->status }}</span>
                        </div>
                    </div>

                    <div class="overflow-hidden bg-white sm:rounded-lg mt-10">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Billing Information</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Your billing information for the order:
                                <span>{{ $order->id }}</span>
                            </p>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Full name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        <span x-text="billing.full_name"></span>
                                    </dd>
                                </div>

                                <hr />

                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        <span x-text="billing.phone"></span>
                                    </dd>
                                </div>

                                <hr />

                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Email address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        <span x-text="billing.email"></span>
                                    </dd>
                                </div>

                                <hr />

                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        <span x-text="billing.address"></span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                    <hr class="my-4 mx-auto w-48 h-1 bg-gray-500 rounded border-0 md:my-10">

                    <div class="overflow-hidden bg-white sm:rounded-lg">
                        <div class="px-4 py-5 sm:px-6">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Shipping Information</h3>
                            <p class="mt-1 max-w-2xl text-sm text-gray-500">
                                Your shipping information for the order:
                                <span>{{ $order->id }}</span>
                            </p>
                        </div>
                        <div class="border-t border-gray-200">
                            <dl>
                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Full name</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        <span x-text="shipping.full_name"></span>
                                    </dd>
                                </div>

                                <hr />

                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Phone Number</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        <span x-text="shipping.phone"></span>
                                    </dd>
                                </div>

                                <hr />

                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Email address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        <span x-text="shipping.email"></span>
                                    </dd>
                                </div>

                                <hr />

                                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                                    <dt class="text-sm font-medium text-gray-500">Address</dt>
                                    <dd class="mt-1 text-sm text-gray-900 sm:col-span-2 sm:mt-0">
                                        <span x-text="shipping.address"></span>
                                    </dd>
                                </div>
                            </dl>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
