<?php
namespace App\Helpers;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Redirect;

class Checkout
{

    /**
     * Summary of getOrderItemsCount
     * @return array<int>
     */
    public static function getOrderItemsCount(): array
    {
        /** @var \App\Models\User $user */
        $user = request()->user();

        /** @var \App\Models\Customer $user */
        $customer = $user->customer;

        $order = Order::query()->where([
            'created_by' => $customer->id
        ])->latest()->first();

        $orderItemCount = OrderItem::query()->where([
            'order_id' => $order->id
        ])->sum('quantity');

        $products = self::getOrderItems();
        $productsCount = count($products);

        return [$productsCount, $orderItemCount];
    }

    /**
     * Summary of getOrderItems
     * @return \Illuminate\Http\RedirectResponse|array
     */
    public static function getOrderItems(): array|\Illuminate\Http\RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = request()->user();

        /** @var \App\Models\Customer $user */
        $customer = $user->customer;

        $order = Order::query()->where([
            'created_by' => $customer->id,
            'status' => OrderStatus::Unpaid->value
        ])->latest()->first();

        if ($order) {
            $orderItem = OrderItem::query()->where([
                'order_id' => $order->id
            ])->get();

            return $orderItem->toArray();
        } else {
            return [];
        }
    }

    /**
     * Summary of getProductsAndOrderItems
     * @return mixed
     */
    public static function getProductsAndOrderItems(): mixed
    {
        $orderItems = self::getOrderItems();

        $ids = Arr::pluck($orderItems, 'product_id');

        $products = Product::query()->whereIn('id', $ids)->get();

        $orderItems = Arr::keyBy($orderItems, 'product_id');

        $productsByKey = Arr::keyBy($products, 'id');

        return [$products, $orderItems, $productsByKey];
    }

    /**
     * Summary of getDetails
     * @return mixed
     */
    public static function getDetails(): mixed
    {
        list($products, $orderItems, $productsByKey) = self::getProductsAndOrderItems();

        $totalPrice = 0;

        foreach ($products as $product) {
            $totalPrice += $product->price * $orderItems[$product->id]['quantity'];
        }

        return [$totalPrice, $products, $orderItems, $productsByKey];
    }

    /**
     * Summary of getDetailsByOrder
     * @param int $order_id
     * @return mixed
     */
    public static function getDetailsByOrder(int $order_id): mixed
    {
        $orderItems = OrderItem::where('order_id', $order_id)->get()->map(function ($item) {
            return [
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'unit_price' => $item->unit_price
            ];
        });

        $ids = Arr::pluck($orderItems, 'product_id');

        $products = Product::query()->whereIn('id', $ids)->get();

        $orderItems = Arr::keyBy($orderItems, 'product_id');

        $productsByKey = Arr::keyBy($products, 'id');

        $totalPrice = 0;

        foreach ($products as $product) {
            $totalPrice += $product->price * $orderItems[$product->id]['quantity'];
        }

        return [$totalPrice, $products, $orderItems, $productsByKey];
    }

    // public function console(Request $request)
    // {
    //     /** @var \App\Models\User $user */
    //     $user = $request->user();

    //     /** @var \App\Models\Customer $user */
    //     $customer = $user->customer;

    //     $order = Order::query()->where([
    //         'created_by' => $customer->id
    //     ])->latest()->first();

    //     $orderItem = OrderItem::query()->where([
    //         'order_id' => $order->id
    //     ])->get();

    //     list($products, $cartItems) = Cart::getProductsAndCartItems();

    //     $total = 0;

    //     foreach ($products as $product) {
    //         $total += $product->price * $cartItems[$product->id]['quantity'];
    //     }

    //     dd($orderItem);

    //     return view('console');
    // }
}

