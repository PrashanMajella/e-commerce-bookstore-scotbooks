<?php

namespace App\Http\Middleware;

use App\Models\Customer as CustomerModel;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class Customer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $customer = CustomerModel::query()->where(
            ['created_by' => Auth::user()->id]
        )->first();

        $is_customer = $customer ? true : false;

        if (Auth::user() && $is_customer) {
            return $next($request);
        }

        return Redirect::route('home')->with('status', 'is-not-customer');
    }
}
