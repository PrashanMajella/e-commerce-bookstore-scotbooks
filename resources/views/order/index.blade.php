<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Orders') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
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
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Actions</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                                        <a
                                        href="{{
                                            // $order->status === \App\Enums\OrderStatus::Paid->value
                                            // ? route('order.view', $order)
                                            // : '#'
                                            route('order.view', $order)
                                        }}"
                                            class="font-bold text-blue-500 hover:underline
                                        ">
                                            {{ $key + 1 }}
                                        </a>
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $order->updated_at }}
                                    </td>
                                    <td class="px-6 py-4 capitalize">
                                        @if ($order->status === \App\Enums\OrderStatus::Unpaid->value)
                                            {{ $order->status }}
                                        @endif
                                        @if ($order->status === \App\Enums\OrderStatus::Paid->value)
                                            <span class="text-pink-500">
                                                {{ $order->status }}
                                            </span>
                                        @endif
                                        @if ($order->status === \App\Enums\OrderStatus::Pending->value)
                                            <span class="text-yellow-500">
                                                {{ $order->status }}
                                            </span>
                                        @endif
                                        @if ($order->status === \App\Enums\OrderStatus::Cancelled->value)
                                            <span class="text-red-500">
                                                {{ $order->status }}
                                            </span>
                                        @endif
                                        @if ($order->status === \App\Enums\OrderStatus::Shipped->value)
                                            <span class="text-sky-500">
                                                {{ $order->status }}
                                            </span>
                                        @endif
                                        @if ($order->status === \App\Enums\OrderStatus::Completed->value)
                                            <span class="text-green-500">
                                                {{ $order->status }}
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        {{'$' . $order->total_price }}
                                    </td>
                                    <td class="px-6 py-4 w-[200px] flex md:flex-row flex-col items-center justify-between gap-2">
                                        <a href="{{ route('order.invoice', $order) }}" class="font-medium text-blue-600 hover:underline">View Invoice</a>
                                        @if ($order->status === \App\Enums\OrderStatus::Unpaid->value)
                                        <form method="POST" action="{{ route('checkout.confirmed-with-order', $order) }}">
                                            @csrf
                                            <input type="submit" value="Pay" class="font-medium text-pink-600 hover:underline cursor-pointer">
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="my-5">
                {{ $orders->links() }}
            </div>

            <div class="flex items-center gap-4">
                @if (session('status') === 'order-updated')
                    <x-base-session-toast status="Order cancelled successfully." />
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
