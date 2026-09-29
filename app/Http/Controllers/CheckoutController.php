<?php

namespace App\Http\Controllers;

use App\Actions\LoadCart;
use App\Actions\PlaceWebOrder;
use App\Http\Requests\StoreWebOrderRequest;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function create(LoadCart $loadCart): View|RedirectResponse
    {
        $cart = $loadCart->handle(session(LoadCart::SESSION_KEY, []));

        if ($cart['items'] === []) {
            return redirect()->route('carrito.index')->with('status', 'Agrega productos antes de continuar.');
        }

        return view('checkout.create', compact('cart'));
    }

    public function store(StoreWebOrderRequest $request, PlaceWebOrder $placeWebOrder): RedirectResponse
    {
        $order = $placeWebOrder->handle(
            $request->validated(),
            $request->session()->get(LoadCart::SESSION_KEY, []),
        );

        $request->session()->forget(LoadCart::SESSION_KEY);

        return redirect()->to(URL::signedRoute('checkout.confirmation', $order));
    }

    public function show(Order $order): View
    {
        abort_unless($order->origin === 'web' && $order->address_id !== null, 404);

        $order->load(['address', 'customer', 'details.product']);

        return view('checkout.show', compact('order'));
    }
}
