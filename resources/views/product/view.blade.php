<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $product->title }}
        </h2>
    </x-slot>

    <!-- Product Item -->
    <section
        x-data="productItem({{ json_encode([
            'id' => $product->id,
            'image' => $product->image,
            'title' => $product->title,
            'description' => $product->description,
            'price' => $product->price,
            'addToCartUrl' => route('cart.add', $product),
        ]) }})"
        class="grid grid-cols-3 md:grid-cols-5 gap-6 p-5"
    >
        <div class="col-span-3">
        <!-- Carousel -->
        <div
            x-data="{
                images: [product.image],
                activeImage: null,
                transitionEnter: 250,
                transitionLeave: 3500,
                interval: 10000,
                limit: 5,
                init() {
                    this.activeImage = this.images.length > 0 ? this.images[0] : null;
                    this.images.splice(this.limit);

                    const autoSlide = () => this.next();

                    setInterval(() => {
                        autoSlide();
                    }, this.interval + this.transitionEnter + this.transitionLeave);
                },
                prev() {
                    let index = this.images.indexOf(this.activeImage);

                    if (index === 0) {
                        index = this.images.length;
                    }
                    this.activeImage = this.images[index - 1];
                },
                next() {
                    let index = this.images.indexOf(this.activeImage);

                    if (index === this.images.length - 1) {
                        index = -1;
                    };
                    this.activeImage = this.images[index + 1];
                },
            }"
        >
            <div
                class="relative flex items-center justify-center overflow-hidden"
            >
            <template x-for="(item, index) in images" :key="index">
                <!-- <div class="w-full aspect-video"> -->
                <img
                    x-show="activeImage === item"
                    x-transition:leave.duration.250ms
                    x-transition:enter.duration.3500ms
                    :src="item"
                    :alt="item"
                    class="w-[500px] h-full object-cover"
                />
                <!-- </div> -->
            </template>
            <button
                x-on:click.prevent="prev"
                    class="absolute left-2 top-1/2 -translate-y-1/2 bg-black/10 rounded-full text-white p-2 hover:bg-black/5 hover:text-pink-400 transition duration-700 ease-in-out"
                >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-10 h-10"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M15.75 19.5L8.25 12l7.5-7.5"
                    />
                </svg>
            </button>
            <button
                x-on:click.prevent="next"
                    class="absolute right-2 top-1/2 -translate-y-1/2 bg-black/10 rounded-full text-white p-2 hover:bg-black/5 hover:text-pink-400 transition duration-700 ease-in-out"
                >
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke-width="1.5"
                    stroke="currentColor"
                    class="w-10 h-10"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M8.25 4.5l7.5 7.5-7.5 7.5"
                    />
                </svg>
            </button>
            </div>
            <div class="relative flex items-center justify-center gap-1 my-2">
            <!-- Prev Button  -->
            <button
                class="absolute left-5 top-1/2 -translate-y-1/2 py-2 rounded-sm bg-black/10 text-white hover:bg-black/20"
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
                        d="M15.75 19.5L8.25 12l7.5-7.5"
                    />
                </svg>
            </button>
            <!-- /Prev Button  -->
            <!-- Next Button  -->
            <button
                class="absolute right-5 top-1/2 -translate-y-1/2 py-2 rounded-sm bg-black/10 text-white hover:bg-black/20"
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
                        d="M8.25 4.5l7.5 7.5-7.5 7.5"
                    />
                </svg>
            </button>
            <!-- /Next Button  -->
            <div class="flex items-center mx-20 overflow-hidden">
                <template x-for="(item, index) in images" :key="index">
                <button
                    x-on:click="activeImage = item"
                    class="flex items-center justify-center border"
                    :class="{'border-pink-400' : activeImage === item}"
                >
                    <img
                        :src="item"
                        alt=""
                        class="w-[160px] h-[80px] object-cover"
                    />
                </button>
                </template>
            </div>
            </div>
        </div>
        <!-- /Carousel -->
        </div>
        <div class="col-span-3 md:col-span-2">
            <h1 x-text="product.description" class="text-lg font-semibold text-justify"></h1>
            <p  x-text="product.price" class="text-xl font-bold mb-3"></p>
            <div class="flex items-center gap-2 mb-3">
                <p class="flex items-center text text-orange-400">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                        />
                    </svg>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                        />
                    </svg>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                        />
                    </svg>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                        />
                    </svg>
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                        class="h-4 w-4"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"
                        />
                    </svg>
                </p>
                <a href="#" class="text-pink-700 hover:text-pink-600">64 Reviews</a>
            </div>
            <div class="flex items-center justify-between mb-3">
                <label for="quantity" class="">Quantity:</label>
                <input
                    type="number"
                    name="quantity"
                    id="quantity"
                    value="1"
                    min="1"
                    x-ref="quantity"
                    class="py-1 px-2 w-24"
                    style="background-color: white"
                />
            </div>
            <button
                x-on:click="addToCart($refs.quantity.value)"
                class="flex items-center gap-2 btn-primary w-full justify-center"
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

            <hr class="my-5 border-white" />

            <!-- Description -->
            <div x-data="{ expanded: false }" class="mb-6">
                <div x-show="expanded" x-collapse.min.120px class="text-gray-500 wysiwyg-content">
                    <p x-text="product.description" class=""></p>
                    {{-- <h4>About the item</h4>
                    <ul class="list-disc pl-6">
                        <div  x-text="product.description"></div>
                    </ul> --}}
                </div>
                {{-- <p class="text-right">
                    <a href="javascript:void(0)" x-text="expanded ? 'Read Less' : 'Read More'" x-on:click="expanded = !expanded" class="primary"></a>
                </p> --}}
            </div>
        <!-- /Description -->
        </div>
    </section>
    <!-- /Product Item -->
</x-app-layout>
