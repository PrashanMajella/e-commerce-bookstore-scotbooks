<x-app-layout>

    <x-section-hero></x-section-hero>

    <x-section-promo></x-section-promo>

    <x-section-products></x-section-products>

    <x-section-feature></x-section-feature>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (!Auth::user())
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 text-center">
                        {{ __("You're not logged in!") }}
                    </div>
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            @if (session('status') === 'is-not-customer')
                <x-base-session-toast-error status="To access this page; the user must be made at least one order." />
            @endif
            @if (session('status') === 'orders-empty')
                <x-base-session-toast-error status="To access this page; the user must have at least one payable order." />
            @endif
        </div>
    </div>
</x-app-layout>
