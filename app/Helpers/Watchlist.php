<?php

namespace App\Helpers;

use App\Models\WatchlistItem;
use App\Models\Product;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cookie;
class Watchlist
{
    /**
     * Summary of getWatchlistItemsCount
     * @return int
     */
    public static function getWatchlistItemsCount(): int
    {
        $request = request();
        $user = $request->user();

        if($user) {
            return WatchlistItem::where('user_id', $user->id)->count();
        } else {
            $WatchlistItems = self::getCookieWatchlistItems();

            return self::getCountFromItems($WatchlistItems);
        }
    }

    /**
     * Summary of getWatchlistItems
     * @return array|\Illuminate\Support\Collection
     */
    public static function getWatchlistItems(): array | \Illuminate\Support\Collection
    {
        $request = request();
        $user = $request->user();

        if ($user) {
            return WatchlistItem::where('user_id', $user->id)->get()->map(function ($item) {
                return [
                    'product_id' => $item->product_id,
                ];
            });
        } else {
            return self::getCookieWatchlistItems();
        }
    }

    /**
     * Summary of getProductsAndWatchlistItems
     * @return mixed
     */
    public static function getProductsAndWatchlistItems(): mixed
    {
        $WatchlistItems = self::getWatchlistItems();

        $ids = Arr::pluck($WatchlistItems, 'product_id');

        $products = Product::query()->whereIn('id', $ids)->get();

        $WatchlistItems = Arr::keyBy($WatchlistItems, 'product_id');

        return [$products, $WatchlistItems];
    }

    /**
     * Summary of getCookieWatchlistItems
     * @return array
     */
    public static function getCookieWatchlistItems(): array
    {
        $request = request();

        return json_decode($request->cookie('watchlist_items', '[]'), true);
    }

    /**
     * Summary of setCookieWatchlistItems
     * @param array $WatchlistItems
     * @return void
     */
    public static function setCookieWatchlistItems(array $WatchlistItems): void
    {
        Cookie::queue('watchlist_items', json_encode($WatchlistItems), 60 * 24 * 30);
    }


    /**
     * Summary of getCountFromItems
     * @param array $WatchlistItems
     * @return int
     */
    public static function getCountFromItems(array $WatchlistItems): int
    {
        return count($WatchlistItems);
    }

    /**
     * Summary of moveWatchlistItemsIntoDB
     * @return void
     */
    public static function moveWatchlistItemsIntoDB(): void
    {
        $request = request();

        $user = $request->user();

        $WatchlistItems = self::getCookieWatchlistItems();

        $WatchlistItemsDB = WatchlistItem::where('user_id', $user->id)->get()->keyBy('product_id');

        $newWatchlistItems = [];

        foreach ($WatchlistItems as $WatchlistItem) {
            if (isset($WatchlistItemsDB[$WatchlistItem['product_id']])) {
                continue;
            } else {
                $newWatchlistItems[] = [
                    'user_id' => $user->id,
                    'product_id' => $WatchlistItem['product_id']
                ];
            }
        }

        if (!empty($newWatchlistItems)) {
            WatchlistItem::insert($newWatchlistItems);
        }

        self::destroyCookies();
    }

    public static function destroyCookies() {
        Cookie::queue(Cookie::forget('watchlist_items'));
    }
}
