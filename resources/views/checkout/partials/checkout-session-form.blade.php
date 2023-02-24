<section>
    <form method="post" action="{{ route('checkout.confirmed') }}">
        @csrf
        <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-12">
            <div class="">
                <header>
                    <h2 class="text-lg font-medium text-gray-900">
                        {{ __('Checkout Confirmation') }}
                    </h2>

                    <p class="mt-1 text-sm text-gray-600">
                        {{ __('Confirm to make payment for your order.') }}
                    </p>
                </header>
            </div>
        </div>

        <div class="flex items-center justify-center gap-4">
            <x-primary-button>{{ __('Proceed to Checkout') }}</x-primary-button>
        </div>

        <div class="flex items-center gap-4">
            @if (session('status') === 'checkout-saved')
                <x-base-session-toast status="Checkout information saved successfully." />
            @endif
        </div>
    </form>
</section>
