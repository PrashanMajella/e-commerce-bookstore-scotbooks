<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('About Us') }}
        </h2>
    </x-slot>

    <div class="bg-white">
        <div
            class="mx-auto grid max-w-2xl grid-cols-1 items-center gap-y-16 gap-x-8 py-24 px-4 sm:px-6 sm:py-32 lg:max-w-7xl lg:grid-cols-2 lg:px-8">
            <div class="flex flex-col gap-8">
                <div class="">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Our Mission</h2>
                    <p class="mt-4 text-gray-500">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Soluta nostrum alias expedita provident voluptate quaerat
                        recusandae nobis id, nulla, cupiditate consequatur
                        doloremque ab, accusantium sint neque amet quibusdam
                        veritatis placeat?
                    </p>
                </div>
                <div class="">
                    <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Our Vision</h2>
                    <p class="mt-4 text-gray-500">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                        Soluta nostrum alias expedita provident voluptate quaerat
                        recusandae nobis id, nulla, cupiditate consequatur
                        doloremque ab, accusantium sint neque amet quibusdam
                        veritatis placeat?
                    </p>
                </div>
            </div>
            <div class="grid grid-cols-2 grid-rows-2 gap-2 sm:gap-6 lg:gap-8">
                <img src="{{ asset('storage/images/app/product-1.jpg') }}"
                    alt=""
                    class="rounded-lg bg-gray-100 w-[250px] h-[250px] object-cover">
                <img src="{{ asset('storage/images/app/product-2.jpg') }}"
                    alt=""
                    class="rounded-lg bg-gray-100 w-[250px] h-[250px] object-cover">
                <img src="{{ asset('storage/images/app/product-3.jpg') }}"
                    alt=""
                    class="rounded-lg bg-gray-100 w-[250px] h-[250px] object-cover">
                <img src="{{ asset('storage/images/app/product-4.jpg') }}"
                    alt=""
                    class="rounded-lg bg-gray-100 w-[250px] h-[250px] object-cover">
            </div>
        </div>
    </div>
</x-app-layout>
