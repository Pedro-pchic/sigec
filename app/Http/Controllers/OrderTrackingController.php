<?php

namespace App\Http\Controllers;

use App\Http\Requests\TrackOrderRequest;
use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OrderTrackingController extends Controller
{
    public function create(): View
    {
        return view('portal.tracking');
    }

    public function show(TrackOrderRequest $request): View
    {
        $data = $request->validated();
        $email = Str::lower($data['email']);

        $order = Order::query()
            ->where('number', $data['number'])
            ->whereHas('customer', function (Builder $query) use ($email): void {
                $query->whereRaw('LOWER(email) = ?', [$email]);
            })
            ->first();

        if ($order === null) {
            throw ValidationException::withMessages([
                'number' => 'No encontramos un pedido con esos datos.',
            ]);
        }

        return view('portal.tracking', compact('order'));
    }
}
