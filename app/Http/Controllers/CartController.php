<?php

namespace App\Http\Controllers;

use App\Helpers\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use PhpParser\Node\Const_;

class CartController extends Controller
{
    public function index()
    {
        list($products, $cartItems) = Cart::getProductsAndCartItems();

        $total = 0;

        foreach ($products as $product) {
            $total += $product->price * $cartItems[$product->id]['quantity'];
        }

        return view('cart.index', compact('cartItems', 'products', 'total'));
    }

    public function show(Product $product) {
        return view('product.view', compact('product'));
    }

    public function add(Request $request, Product $product)
    {
        $quantity = $request->post('quantity', 1);

        $user = $request->user();

        if ($user) {
            $cartItem = CartItem::where([
                'user_id' => $user->id,
                'product_id' => $product->id
            ])->first();

            if ($cartItem) {
                $cartItem->quantity += $quantity;
                $cartItem->update();
            } else {
                $data = [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                ];

                CartItem::create($data);
            }

            return response([
                'count' => Cart::getCartItemsCount()
            ]);
        } else {
            $cartItems = Cart::getCookieCartItems();

            $productFound = false;

            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id) {
                    $item['quantity'] += $quantity;
                    $productFound = true;
                    break;
                }
            }

            if (!$productFound) {
                $cartItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price
                ];
            }

            Cart::setCookieCartItems($cartItems);

            return response([
                'count' => Cart::getCountFromItems($cartItems)
            ]);
        }
    }

    public function remove(Request $request, Product $product)
    {
        $user = $request->user();

        if ($user) {
            $cartItem = CartItem::query()->where([
                'user_id' => $user->id,
                'product_id' => $product->id
            ])->first();

            if ($cartItem) {
                $cartItem->delete();
            }

            return response([
                'count' => Cart::getCartItemsCount()
            ]);
        } else {
            $cartItems = Cart::getCookieCartItems();

            foreach ($cartItems as $key => &$item) {
                if ($item['product_id'] === $product->id) {
                    array_splice($cartItems, $key, 1);
                    break;
                }
            }

            Cart::setCookieCartItems($cartItems);

            return response([
                'count' => Cart::getCountFromItems($cartItems)
            ]);
        }
    }


    public function updateQuantity(Request $request, Product $product)
    {
        $quantity = (int)$request->post('quantity');

        $user = $request->user();

        if ($user) {
            CartItem::where([
                'user_id' => $user->id,
                'product_id' => $product->id
            ])->update(['quantity' => $quantity]);

            return response([
                'count' => Cart::getCartItemsCount()
            ]);
        } else {
            $cartItems = Cart::getCookieCartItems();

            foreach ($cartItems as &$item) {
                if ($item['product_id'] === $product->id) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }

            Cart::setCookieCartItems($cartItems);

            return response([
                'count' => Cart::getCountFromItems($cartItems)
            ]);
        }
    }
}
