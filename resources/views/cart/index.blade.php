<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Cart') }}
        </h2>
    </x-slot>

    <!-- Cart List -->
    <section class="container mx-auto lg:w-2/3 mt-5 p-5">
        <h1 class="text-3xl font-bold mb-2">My Cart Items</h1>
        <div
            x-data="{
                cartItems: {{
                    json_encode($products->map(function ($product) use ($cartItems) {
                        return [
                            'id' => $product->id,
                            'slug' => $product->slug,
                            'image' => $product->image,
                            'title' => $product->title,
                            'description' => $product->description,
                            'price' => $product->price,
                            'quantity' => $cartItems[$product->id]['quantity'],
                            'viewCartUrl' => route('cart.view', $product),
                            'removeFromCartUrl' => route('cart.remove', $product),
                            'updateQuantityUrl' => route('cart.update-quantity', $product)
                        ];
                    }))
                }},
                get cartTotal() {
                    let sumPrice = this.cartItems.reduce((accumulator, currentValue) => {
                        return accumulator + Number(currentValue.price) * Number(currentValue.quantity);
                    }, 0);

                    return Number(sumPrice).toFixed(2);
                },
            }"
            class="bg-white rounded-lg p-3"
        >
            <template x-if="cartItems.length">
                <div>
                    <template
                        x-for="item in cartItems"
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
                                        <!-- Input Group -->
                                        <div class="flex items-center">
                                            <span class="font-semibold text-gray-700 mr-1">Qty:</span>
                                            <input
                                            type="number"
                                            name="quantity"
                                            id="quantity"
                                            min="1"
                                            x-model="product.quantity"
                                            x-on:change="changeQuantity"
                                            class="ml-3 py-1 px-2 w-12"
                                            />
                                        </div>
                                        <!-- Input Group -->
                                        <button
                                            x-on:click.prevent="removeFromCart"
                                            class="text-pink-600 hover:text-pink-500"
                                        >
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </article>
                            <!-- /Cart Item -->
                            <hr class="my-3" />
                        </div>
                    </template>
                    <div>
                        <div class="border-t-1 border-gray-300 mt-5 pt-5">
                            <div class="flex justify-between">
                                <span class="font-bold">Subtotal</span>
                                <span x-text="'$' + cartTotal" class=""></span>
                            </div>
                            <p class="">Shipping and tax will be applied on checkout.</p>
                        </div>
                        <a href="{{ route('checkout.view') }}">
                            <button class="btn-primary w-full mt-3">Checkout</button>
                        </a>
                    </div>
                </div>
            </template>
            <template x-if="!cartItems.length">
                <div class="text-gray-500 text-center py-8">
                    <h1>You don't have any items in the cart.</h1>
                </div>
            </template>
        </div>
    </section>
    <!-- /Cart List -->
</x-app-layout>
