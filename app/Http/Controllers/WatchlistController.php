<?php

namespace App\Http\Controllers;

use App\Helpers\Watchlist;
use App\Models\Product;
use App\Models\WatchlistItem;
use Illuminate\Http\Request;

class WatchlistController extends Controller
{
    public function index()
    {
        list($products, $watchlistItems) = Watchlist::getProductsAndWatchlistItems();

        return view('watchlist.index', compact('products'));
    }

    public function show(Product $product) {
        return view('product.view', compact('product'));
    }

    public function add(Request $request, Product $product)
    {
        $user = $request->user();

        if ($user) {
            $watchlistItem = WatchlistItem::where([
                'user_id' => $user->id,
                'product_id' => $product->id
            ])->first();

            if ($watchlistItem) {
                $watchlistItem->delete();
            } else {
                $data = [
                    'user_id' => $user->id,
                    'product_id' => $product->id,
                ];

                WatchlistItem::create($data);
            }

            return response([
                'count' => Watchlist::getWatchlistItemsCount(),
                'items' => Watchlist::getWatchlistItems()
            ]);
        } else {
            $watchlistItems = Watchlist::getCookieWatchlistItems();

            $productFound = false;

            foreach ($watchlistItems as &$item) {
                if ($item['product_id'] === $product->id) {
                    $productFound = true;
                    break;
                }
            }

            if (!$productFound) {
                $watchlistItems[] = [
                    'user_id' => null,
                    'product_id' => $product->id
                ];
            } else {
                foreach ($watchlistItems as $key => &$item) {
                    if ($item['product_id'] === $product->id) {
                        array_splice($watchlistItems, $key, 1);
                        break;
                    }
                }
            }

            Watchlist::setCookieWatchlistItems($watchlistItems);

            return response([
                'count' => Watchlist::getCountFromItems($watchlistItems),
                'items' => $watchlistItems
            ]);
        }
    }

    public function remove(Request $request, Product $product)
    {
        $user = $request->user();

        if ($user) {
            $watchlistItem = WatchlistItem::query()->where([
                'user_id' => $user->id,
                'product_id' => $product->id
            ])->first();

            if ($watchlistItem) {
                $watchlistItem->delete();
            }

            return response([
                'count' => Watchlist::getWatchlistItemsCount(),
                'items' => Watchlist::getWatchlistItems()
            ]);
        } else {
            $watchlistItems = Watchlist::getCookieWatchlistItems();

            foreach ($watchlistItems as $key => &$item) {
                if ($item['product_id'] === $product->id) {
                    array_splice($watchlistItems, $key, 1);
                    break;
                }
            }

            Watchlist::setCookieWatchlistItems($watchlistItems);

            return response([
                'count' => Watchlist::getCountFromItems($watchlistItems),
                'items' => $watchlistItems
            ]);
        }
    }

    public function status(Request $request)
    {
        return response([
            'count' => Watchlist::getWatchlistItemsCount(),
            'items' => Watchlist::getWatchlistItems()
        ]);
    }
}
