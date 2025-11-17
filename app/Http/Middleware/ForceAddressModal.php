<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceAddressModal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('customer')->check()) {
            $customerId = auth('customer')->id();
            $addressCount = \App\Models\Address::where('customers_id', $customerId)->where('cancelled', 0)->count();
            if ($addressCount == 0) {
                session(['force_address_modal' => true]);
                if (
                    !$request->routeIs('sanita.index') &&
                    !$request->is('*/get-districts') &&
                    !$request->is('*/get-cities') &&
                    !$request->routeIs('addresses.store')
                ) {
                    return redirect()->route('sanita.index', ['locale' => app()->getLocale()]);
                }
            } else {
                session()->forget('force_address_modal');
            }
        }
        return $next($request);
    }
}
