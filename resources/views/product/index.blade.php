<x-app-layout>
    <!-- Knowing is not enough; we must apply. Being willing is not enough; we must do. - Leonardo da Vinci -->
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Products') }}
        </h2>
    </x-slot>

    <!-- Product List -->
    <section
        x-data="requestManager({{ json_encode([
            'watchlistStatusUrl' => route('watchlist.status'),
        ])}})"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 p-5"
    >
        @foreach ($products as $product)
            <!-- Product product -->
            <article
                x-data="productItem({{ json_encode([
                    'id' => $product->id,
                    'image' => $product->image,
                    'title' => $product->title,
                    'description' => $product->description,
                    'price' => $product->price,
                    'viewUrl' => route('product.view', $product),
                    'addToCartUrl' => route('cart.add', $product),
                    'addToWatchlistUrl' => route('watchlist.add', $product),
                ]) }})"
                class="bg-white rounded-md shadow-md border border-transparent hover:border-pink-500 transition-colors overflow-hidden"
            >
                <a x-bind:href="product.viewUrl">
                    <img
                        x-bind:src="product.image"
                        x-bind:alt="product.image"
                        class="w-full h-[500px] object-cover hover:scale-105 hover:-rotate-1 transition"
                    />
                </a>
                <div class="p-3 flex flex-col h-[200px]">
                    <a x-bind:href="product.viewUrl">
                        <h3
                            x-text="product.title"
                            class="font-semibold text-black hover:text-gray-600 text-justify text-ellipsis break-all h-[70px] mb-5 overflow-hidden"
                        ></h3>
                    </a>
                    <p x-text="'$' + product.price" class="text-xl font-bold"></p>
                    <div class="flex items-center justify-between mt-auto">
                        <button
                            x-on:click="addToWatchlist"
                            class="flex items-center justify-center w-10 h-10 rounded-full border border-pink-700 text-pink-700 hover:text-white hover:bg-pink-700 transition-colors active:bg-pink-800"
                        >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6"
                            x-bind:class="[isInWatchlist() ? 'fill-pink-700 text-white' : '']"
                        >
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z"
                            />
                        </svg>
                        </button>
                        <button
                        x-on:click="addToCart()"
                        class="flex items-center gap-2 btn-primary"
                        >
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-6 h-6"
                        >
                            <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M2.25 3h1.386c.51 0 .955.343 1.087.835l.383 1.437M7.5 14.25a3 3 0 00-3 3h15.75m-12.75-3h11.218c1.121-2.3 2.1-4.684 2.924-7.138a60.114 60.114 0 00-16.536-1.84M7.5 14.25L5.106 5.272M6 20.25a.75.75 0 11-1.5 0 .75.75 0 011.5 0zm12.75 0a.75.75 0 11-1.5 0 .75.75 0 011.5 0z"
                            />
                        </svg>
                        Add to Cart
                        </button>
                    </div>
                </div>
            </article>
            <!-- /Product product -->
        @endforeach
    </section>


    <div class="mx-10 my-5">
        {{ $products->links() }}
    </div>

    <!-- /Product List -->
    @if (session('status') === 'cart-empty')
        <x-base-session-toast-error status="To access this page; the user must have at least one item in the cart." />
    @endif
    
</x-app-layout>
