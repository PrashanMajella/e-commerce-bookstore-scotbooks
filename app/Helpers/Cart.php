<?php

namespace App\Helpers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
class Cart
{
    /**
     * Summary of getCartItemsCount
     * @return int
     */
    public static function getCartItemsCount(): int
    {
        $request = request();
        $user = $request->user();

        if($user) {
            return CartItem::where('user_id', $user->id)->sum('quantity');
        } else {
            $cartItems = self::getCookieCartItems();

            return self::getCountFromItems($cartItems);
        }
    }

    /**
     * Summary of getCartItems
     * @return array|\Illuminate\Support\Collection
     */
    public static function getCartItems(): array | \Illuminate\Support\Collection
    {
        $request = request();
        $user = $request->user();

        if ($user) {
            return CartItem::where('user_id', $user->id)->get()->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity
                ];
            });
        } else {
            return self::getCookieCartItems();
        }
    }

    /**
     * Summary of getProductsAndCartItems
     * @return mixed
     */
    public static function getProductsAndCartItems(): mixed
    {
        $cartItems = self::getCartItems();

        $ids = Arr::pluck($cartItems, 'product_id');

        $products = Product::query()->whereIn('id', $ids)->get();

        $cartItems = Arr::keyBy($cartItems, 'product_id');

        $productsByKey = Arr::keyBy($products, 'id');

        return [$products, $cartItems, $productsByKey];
    }

    /**
     * Summary of getCookieCartItems
     * @return array
     */
    public static function getCookieCartItems(): array
    {
        $request = request();

        return json_decode($request->cookie('cart_items', '[]'), true);
    }

    /**
     * Summary of setCookieCartItems
     * @param array $cartItems
     * @return void
     */
    public static function setCookieCartItems(array $cartItems): void
    {
        Cookie::queue('cart_items', json_encode($cartItems), 60 * 24 * 30);
    }


    /**
     * Summary of getCountFromItems
     * @param array $cartItems
     * @return int
     */
    public static function getCountFromItems(array $cartItems): int
    {
        return array_reduce($cartItems, function ($carry, $item) {
            return $carry + $item['quantity'];
        }, 0);
    }

    /**
     * Summary of moveCartItemsIntoDB
     * @return void
     */
    public static function moveCartItemsIntoDB(): void
    {
        $request = request();

        $user = $request->user();

        $cartItems = self::getCookieCartItems();

        $CartItemsDB = CartItem::where('user_id', $user->id)->get()->keyBy('product_id');

        $newCartItems = [];

        foreach ($cartItems as $cartItem) {
            if (isset($CartItemsDB[$cartItem['product_id']])) {
                $quantityDB = $CartItemsDB[$cartItem['product_id']]['quantity'];
                CartItem::where([
                    'user_id' => $user->id,
                    'product_id' => $cartItem['product_id']
                ])->update(['quantity' => $quantityDB + $cartItem['quantity']]);
                continue;
            } else {
                $newCartItems[] = [
                    'user_id' => $user->id,
                    'product_id' => $cartItem['product_id'],
                    'quantity' => $cartItem['quantity'],
                ];
            }
        }

        if (!empty($newCartItems)) {
            CartItem::insert($newCartItems);
        }

        self::destroyCookies();
    }

    public static function destroyCookies() {
        Cookie::queue(Cookie::forget('cart_items'));
    }

    public static function getDetails()
    {
        list($products, $cartItems, $productsByKey) = self::getProductsAndCartItems();

        $totalPrice = 0;

        foreach ($products as $product) {
            $totalPrice += $product->price * $cartItems[$product->id]['quantity'];
        }

        return [$totalPrice, $products, $cartItems, $productsByKey];
    }
}
