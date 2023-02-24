<section
    x-data="checkout({{
        json_encode([
            'user' => $user,
            'customer' => $customer,
            'billing' => $billingAddress,
            'shipping' => $shippingAddress,
            'countries' => $countries,
            'submission_route' => route('checkout.store')
        ])
    }})"
>

    <form method="POST" action="{{ route('checkout.store') }}">
        @csrf
        <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Billing Information') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Enter your card information, phone and email address.') }}
                    </p>
                </header>

                <div class="mt-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="billing.first_name" :value="__('First Name')" />
                            <x-text-input id="billing.first_name" name="billing[first_name]" type="text"
                                class="mt-1 block w-full" required autofocus
                                autocomplete="billing.first_name"
                                x-model="billing.first_name" />
                            <x-input-error class="mt-2" :messages="$errors->get('billing.first_name')" />
                        </div>

                        <div>
                            <x-input-label for="billing.last_name" :value="__('Last Name')" />
                            <x-text-input id="billing.last_name" name="billing[last_name]" type="text"
                                class="mt-1 block w-full" required autofocus
                                autocomplete="billing.last_name"
                                x-model="billing.last_name" />
                            <x-input-error class="mt-2" :messages="$errors->get('billing.last_name')" />
                        </div>

                        <div>
                            <x-input-label for="billing.phone" :value="__('Phone')" />
                            <x-text-input id="billing.phone" name="billing[phone]" type="text" class="mt-1 block w-full"
                                required autofocus autocomplete="billing.phone"
                                x-model="billing.phone" />
                            <x-input-error class="mt-2" :messages="$errors->get('billing.phone')" />
                        </div>

                        <div>
                            <x-input-label for="billing.email" :value="__('Email')" />
                            <x-text-input id="billing.email" name="billing[email]" type="email" class="mt-1 block w-full"
                                required autocomplete="billing.email"
                                x-model="billing.email" />
                            <x-input-error class="mt-2" :messages="$errors->get('billing.email')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="billing.address1" :value="__('Address 1')" />
                        <x-text-input id="billing.address1" name="billing[address1]" type="text" class="mt-1 block w-full"
                            required autocomplete="billing.address1"
                            x-model="billing.address1" />
                        <x-input-error class="mt-2" :messages="$errors->get('billing.address1')" />
                    </div>

                    <div>
                        <x-input-label for="billing.address2" :value="__('Address 2')" />
                        <x-text-input id="billing.address2" name="billing[address2]" type="text" class="mt-1 block w-full"
                            required autocomplete="billing.address2"
                            x-model="billing.address2" />
                        <x-input-error class="mt-2" :messages="$errors->get('billing.address2')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="billing.city" :value="__('City')" />
                            <x-text-input id="billing.city" name="billing[city]" type="text" class="mt-1 block w-full"
                                messages="" required autocomplete="billing.city"
                                x-model="billing.city" />
                            <x-input-error class="mt-2" :messages="$errors->get('billing.city')" />
                        </div>

                        <div>
                            <x-input-label for="billing.zip_code" :value="__('Zip Code')" />
                            <x-text-input id="billing.zip_code" name="billing[zip_code]" type="text"
                                class="mt-1 block w-full" required autocomplete="billing.zip_code"
                                x-model="billing.zip_code" />
                            <x-input-error class="mt-2" :messages="$errors->get('billing.zip_code')" />
                        </div>

                        <div>
                            <x-input-label for="billing.country_code" :value="__('Country')" />
                            <x-select-input id="billing.country_code" name="billing[country_code]" type="text"
                                class="mt-1 block w-full" required autocomplete="billing.country_code"
                                x-model="billing.country_code">
                                <option value="">Select Country</option>
                                <template x-for="country in countries" x-bind:key="country.code">
                                    <option x-bind:value="country.code" x-text="country.name"></option>
                                </template>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('billing.country_code')" />
                        </div>

                        <template x-if="states.billing.length">
                            <div>
                                <x-input-label for="billing.state" :value="__('State')" />
                                <x-select-input id="billing.state" name="billing[state]" type="text" class="mt-1 block w-full"
                                    required autocomplete="billing.state"
                                    x-model="billing.state">
                                    <option value="">Select State</option>
                                    <template x-for="state in states.billing" x-bind:key="state.code">
                                        <option :value="state.name" x-text="state.name"></option>
                                    </template>
                                </x-select-input>
                                <x-input-error class="mt-2" :messages="$errors->get('billing.state')" />
                            </div>
                        </template>

                        <template x-if="!states.billing.length">
                            <div>
                                <x-input-label for="billing.state" :value="__('State')" />
                                <x-text-input id="billing.state" name="billing[state]" type="text"
                                    class="mt-1 block w-full" required autocomplete="billing.state"
                                    x-model="billing.state" />
                                <x-input-error class="mt-2" :messages="$errors->get('billing.state')" />
                            </div>
                        </template>

                        <div class="hidden">
                            <x-input-label for="billing.type" :value="__('Type')" />
                            <x-text-input id="billing.type" name="billing[type]" type="hidden"
                                class="mt-1 block w-full" required autocomplete="billing.type"
                                x-model="billing.type" />
                            <x-input-error class="mt-2" :messages="$errors->get('billing.type')" />
                        </div>
                    </div>
                </div>
            </div>

            <hr class="lg:hidden my-4 mx-auto w-48 h-1 bg-gray-500 rounded border-0 md:my-10">
            <div class="absolute hidden lg:block left-1/2 inset-y-20 -ml-1 w-1 rounded bg-gray-500"></div>

            <div>
                <header>
                    <div class="flex items-center justify-between">
                        <div class="">
                            <h2 class="text-lg font-medium text-gray-900">
                                {{ __('Shipping Information') }}
                            </h2>

                            <p class="mt-1 text-sm text-gray-600">
                                {{ __('Enter your dilivery information, phone and email address.') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <x-input-label for="same_as_billing" :value="__('Same as Billing')" />
                            <x-text-input id="same_as_billing" type="checkbox"
                                class="mt-1 block" x-on:click="sameAsBilling"
                            />
                        </div>
                    </div>
                </header>

                <div class="mt-6 space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="shipping.first_name" :value="__('First Name')" />
                            <x-text-input id="shipping.first_name" name="shipping[first_name]" type="text"
                                class="mt-1 block w-full" required autofocus
                                autocomplete="shipping.first_name"
                                x-model="shipping.first_name" />
                            <x-input-error class="mt-2" :messages="$errors->get('shipping.first_name')" />
                        </div>

                        <div>
                            <x-input-label for="shipping.last_name" :value="__('Last Name')" />
                            <x-text-input id="shipping.last_name" name="shipping[last_name]" type="text"
                                class="mt-1 block w-full" required autofocus
                                autocomplete="shipping.last_name"
                                x-model="shipping.last_name" />
                            <x-input-error class="mt-2" :messages="$errors->get('shipping.last_name')" />
                        </div>

                        <div>
                            <x-input-label for="shipping.phone" :value="__('Phone')" />
                            <x-text-input id="shipping.phone" name="shipping[phone]" type="text" class="mt-1 block w-full"
                                required autofocus autocomplete="shipping.phone"
                                x-model="shipping.phone" />
                            <x-input-error class="mt-2" :messages="$errors->get('shipping.phone')" />
                        </div>

                        <div>
                            <x-input-label for="shipping.email" :value="__('Email')" />
                            <x-text-input id="shipping.email" name="shipping[email]" type="email" class="mt-1 block w-full"
                                required autocomplete="shipping.email"
                                x-model="shipping.email" />
                            <x-input-error class="mt-2" :messages="$errors->get('shipping.email')" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="shipping.address1" :value="__('Address 1')" />
                        <x-text-input id="shipping.address1" name="shipping[address1]" type="text" class="mt-1 block w-full"
                            required autocomplete="shipping.address1"
                            x-model="shipping.address1" />
                        <x-input-error class="mt-2" :messages="$errors->get('shipping.address1')" />
                    </div>

                    <div>
                        <x-input-label for="shipping.address2" :value="__('Address 2')" />
                        <x-text-input id="shipping.address2" name="shipping[address2]" type="text" class="mt-1 block w-full"
                            required autocomplete="shipping.address2"
                            x-model="shipping.address2" />
                        <x-input-error class="mt-2" :messages="$errors->get('shipping.address2')" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="shipping.city" :value="__('City')" />
                            <x-text-input id="shipping.city" name="shipping[city]" type="text" class="mt-1 block w-full"
                                required autocomplete="shipping.city"
                                x-model="shipping.city" />
                            <x-input-error class="mt-2" :messages="$errors->get('shipping.city')" />
                        </div>

                        <div>
                            <x-input-label for="shipping.zip_code" :value="__('Zip Code')" />
                            <x-text-input id="shipping.zip_code" name="shipping[zip_code]" type="text"
                                class="mt-1 block w-full" required autocomplete="shipping.zip_code"
                                x-model="shipping.zip_code" />
                            <x-input-error class="mt-2" :messages="$errors->get('shipping.zip_code')" />
                        </div>

                        <div>
                            <x-input-label for="shipping.country_code" :value="__('Country')" />
                            <x-select-input id="shipping.country_code" name="shipping[country_code]" type="text"
                                class="mt-1 block w-full" required autocomplete="shipping.country_code"
                                x-model="shipping.country_code">
                                <option value="">Select Country</option>
                                <template x-for="country in countries" x-bind:key="country.code">
                                    <option x-bind:value="country.code" x-text="country.name"></option>
                                </template>
                            </x-select-input>
                            <x-input-error class="mt-2" :messages="$errors->get('shipping.country_code')" />
                        </div>

                        <template x-if="states.shipping.length">
                            <div>
                                <x-input-label for="shipping.state" :value="__('State')" />
                                <x-select-input id="shipping.state" name="shipping[state]" type="text" class="mt-1 block w-full"
                                    required autocomplete="shipping.state"
                                    x-model="shipping.state">
                                    <option value="">Select State</option>
                                    <template x-for="state in states.shipping" x-bind:key="state.code">
                                        <option :value="state.name" x-text="state.name"></option>
                                    </template>
                                </x-select-input>
                                <x-input-error class="mt-2" :messages="$errors->get('shipping.state')" />
                            </div>
                        </template>

                        <template x-if="!states.shipping.length">
                            <div>
                                <x-input-label for="shipping.state" :value="__('State')" />
                                <x-text-input id="shipping.state" name="shipping[state]" type="text"
                                    class="mt-1 block w-full" required autocomplete="shipping.state"
                                    x-model="shipping.state" />
                                <x-input-error class="mt-2" :messages="$errors->get('shipping.state')" />
                            </div>
                        </template>

                        <div class="hidden">
                            <x-input-label for="shipping.type" :value="__('Type')" />
                            <x-text-input id="shipping.type" name="shipping[type]" type="hidden"
                                class="mt-1 block w-full" required autocomplete="shipping.type"
                                x-model="shipping.type" />
                            <x-input-error class="mt-2" :messages="$errors->get('shipping.type')" />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <br />
        <hr class="mb-5" />

        <div class="flex items-center justify-end gap-4">
            <x-primary-button>{{ __('Submit') }}</x-primary-button>
        </div>
    </form>
</section>
