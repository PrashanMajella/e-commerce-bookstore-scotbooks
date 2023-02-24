<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Contact') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-2 md:grid-cols-3">
                    <div class="col-span-2 md:col-span-1 p-5 bg-gray-700 text-white">
                        <h1 class="text-xl my-1 font-bold">Contact Information</h1>
                        <p class="text-justify my-1">
                            Lorem ipsum dolor sit amet consectetur adipisicing
                            elit. Aspernatur deserunt asperiores aperiam aut
                            vero ea nostrum suscipit amet, praesentium quam,
                            sapiente dignissimos eius corrupti dolore vitae.
                            Quibusdam nihil autem quasi?
                        </p>

                        <div class="flex flex-col items-start my-10 gap-5">
                            <div class="flex items-center gap-2">
                                <x-icon-phone></x-icon-phone>
                                <span>+98 87 654 3212</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <x-icon-email></x-icon-email>
                                <span>support@scotbooks.uk</span>
                            </div>
                        </div>

                        <div class="flex items-center justify-center gap-10 my-10">
                            <a href="https://twitter.com/" target="_blank" class="">
                                <x-icon-social-twitter></x-icon-social-twitter>
                            </a>
                            <a href="https://www.facebook.com/" target="_blank" class="">
                                <x-icon-social-facebook></x-icon-social-facebook>
                            </a>
                            <a href="https://www.instagram.com/" target="_blank" class="">
                                <x-icon-social-instagram></x-icon-social-instagram>
                            </a>
                        </div>

                    </div>
                    <div class="col-span-2 p-5">
                        <form method="POST" action="{{ route('contact.store') }}">
                            @csrf
                            <div class="relative mb-5">
                                <div class="">
                                    <header>
                                        <h2 class="text-lg font-medium text-gray-900">
                                            {{ __('Send us a message') }}
                                        </h2>
                                    </header>

                                    <div class="mt-6 space-y-6">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                            <div>
                                                <x-input-label for="first_name" :value="__('First Name')" />
                                                <x-text-input id="first_name" name="first_name" type="text"
                                                    class="mt-1 block w-full" required autofocus
                                                    autocomplete="first_name"
                                                />
                                                <x-input-error class="mt-2" :messages="$errors->get('first_name')" />
                                            </div>

                                            <div>
                                                <x-input-label for="last_name" :value="__('Last Name')" />
                                                <x-text-input id="last_name" name="last_name" type="text"
                                                    class="mt-1 block w-full" required autofocus
                                                    autocomplete="last_name"
                                                />
                                                <x-input-error class="mt-2" :messages="$errors->get('last_name')" />
                                            </div>

                                            <div>
                                                <x-input-label for="phone" :value="__('Phone')" />
                                                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full"
                                                    autofocus autocomplete="phone"
                                                />
                                                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                                            </div>

                                            <div>
                                                <x-input-label for="email" :value="__('Email')" />
                                                <x-text-input id="email" name="email" type="email" class="mt-1 block w-full"
                                                    required autocomplete="email"
                                                />
                                                <x-input-error class="mt-2" :messages="$errors->get('email')" />
                                            </div>
                                        </div>

                                        <div>
                                            <x-input-label for="subject" :value="__('Subject')" />
                                            <x-text-input id="subject" name="subject" type="text" class="mt-1 block w-full"
                                                required autocomplete="subject"
                                            />
                                            <x-input-error class="mt-2" :messages="$errors->get('address1')" />
                                        </div>
                                        <div>
                                            <x-input-label for="message" :value="__('Message')" />
                                            <x-textarea id="message" name="message" class="mt-1 block w-full"
                                                required autocomplete="message"
                                            />
                                            <x-input-error class="mt-2" :messages="$errors->get('message')" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-end gap-4">
                                <x-primary-button>{{ __('Submit') }}</x-primary-button>

                                @if (session('status') === 'message-saved')
                                    <x-base-session-toast status="Message saved successfully." />
                                @endif
                            </div>
                        </form>

                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
