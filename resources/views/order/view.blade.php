<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Order') }}
        </h2>
    </x-slot>

    <!-- Cart List -->
    <section class="container mx-auto lg:w-2/3 mt-5 p-5">
        <h1 class="text-3xl font-bold mb-2">Order: {{ $order->id }}</h1>
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
                            'viewCartUrl' => route('product.view', $product),
                        ];
                    }))
                }},
                get orderTotal() {
                    let sumPrice = this.orderItems.reduce((accumulator, currentValue) => {
                        return accumulator + Number(currentValue.price) * Number(currentValue.quantity);
                    }, 0);

                    return Number(sumPrice).toFixed(2);
                },
            }"
            class="bg-white rounded-lg p-3"
        >

            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left text-gray-500">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Order ID
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Date
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Subtotal
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="bg-white border-b">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                {{ $order->id }}
                            </th>
                            <td class="px-6 py-4">
                                {{ $order->created_at }}
                            </td>
                            <td class="px-6 py-4 capitalize">
                                {{ $order->status }}
                            </td>
                            <td class="px-6 py-4">
                                {{'$' . $order->total_price }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <template x-if="orderItems.length">
                <div>
                    <template
                        x-for="item in orderItems"
                        x-bind:key="item.id"
                    >
                        <div>
                            <!-- Cart Item -->
                            <article
                                x-data="productItem(item)"
                                class="flex flex-col md:flex-row items-center gap-4"
                            >
                                <a x-bind:href="product.viewCartUrl">
                                    <div class="flex items-center w-60 h-100 overflow-hidden">
                                        <img x-bind:src="product.image" alt="" class="object-contain" />
                                    </div>
                                </a>
                                <div class="flex flex-col gap-4 w-full">
                                    <div class="flex items-center justify-between w-full">
                                        <h3 x-text="product.title" class=""></h3>
                                        <span
                                            x-text="'$' + product.price"
                                            class="text-lg font-semibold"
                                        ></span>
                                    </div>

                                    <div class="flex items-center justify-between w-full">
                                        <div class="flex items-center">
                                            <span class="font-semibold text-gray-700 mr-1">Qty:</span>
                                            <span x-text="product.quantity" class="text-gray-500"></span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                            <!-- /Cart Item -->
                            <hr class="my-3" />
                        </div>
                    </template>
                    @if ($order->status === \App\Enums\OrderStatus::Unpaid->value)
                        <div>
                            <div class="border-t-1 border-gray-300 mt-5 pt-5">
                                <div class="flex justify-between">
                                    <span class="font-bold">Subtotal</span>
                                    <span x-text="'$' + orderTotal" class=""></span>
                                </div>
                                <p class="">This request can be made if this order is not involved with any transaction.</p>
                            </div>
                            <form method="POST" action="{{ route('order.update', $order) }}">
                                @csrf
                                @method('patch')
                                <input type="hidden" name="status" id="status" value="{{ \App\Enums\OrderStatus::Cancelled->value }}">
                                <a href.prevent="#">
                                    <button type="submit" class="btn-gray w-full mt-3">Cancel Order</button>
                                </a>
                            </form>
                        </div>
                    @else
                        <div>
                            <div class="border-t-1 border-gray-300 mt-5 pt-5">
                                <div class="flex justify-between">
                                    <span class="font-bold">Subtotal</span>
                                    <span x-text="'$' + orderTotal" class=""></span>
                                </div>
                                <h1 class="text-xl capitalize flex items-center justify-end">
                                    {{ $order->status }}
                                </h1>
                            </div>
                        </div>
                    @endif
                </div>
            </template>
            <template x-if="!orderItems.length">
                <div class="text-gray-500 text-center py-8">
                    <h1>You don't have any items in cart.</h1>
                </div>
            </template>
        </div>
    </section>
    <!-- /Cart List -->
</x-app-layout>
