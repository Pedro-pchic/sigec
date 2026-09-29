@extends('layouts.admin')

@section('title', 'Detalle de pedido')
@section('heading', $order->number)
@section('subheading', 'Pedido para '.$order->customer->name)

@section('actions')
    <div class="flex flex-wrap gap-3">
        @if ($order->isEditable())
            <a href="{{ route('pedidos.edit', $order) }}" class="rounded-lg border border-stone-300 bg-white px-4 py-2 text-sm font-semibold hover:bg-stone-50">Editar pedido</a>
            <form method="POST" action="{{ route('pedidos.confirm', $order) }}">
                @csrf
                <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">Confirmar pedido</button>
            </form>
        @endif
        @if (in_array($order->status, [\App\Enums\OrderStatus::Pending, \App\Enums\OrderStatus::Confirmed], true))
            <form method="POST" action="{{ route('pedidos.cancel', $order) }}">
                @csrf
                <button type="submit" class="rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Cancelar pedido</button>
            </form>
        @endif
        @if ($order->status === \App\Enums\OrderStatus::Confirmed)
            <form method="POST" action="{{ route('pedidos.sale.store', $order) }}">
                @csrf
                <button type="submit" class="rounded-lg bg-emerald-600 px-4 py-2 text-sm font-semibold text-white hover:bg-emerald-500">Registrar venta y salida</button>
            </form>
        @endif
        @if ($order->sale)
            <a href="{{ route('ventas.show', $order->sale) }}" class="rounded-lg border border-stone-300 bg-white px-4 py-2 text-sm font-semibold hover:bg-stone-50">Ver venta</a>
        @endif
    </div>
@endsection

@section('content')
    <section class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-stone-200">
        <dl class="grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <div>
                <dt class="text-sm font-medium text-stone-500">Cliente</dt>
                <dd class="mt-1"><a href="{{ route('clientes.show', $order->customer) }}" class="font-semibold text-brand-700 hover:text-brand-500">{{ $order->customer->name }}</a></dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-stone-500">Fecha</dt>
                <dd class="mt-1">{{ $order->order_date->format('Y-m-d') }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-stone-500">Estado</dt>
                <dd class="mt-1 font-semibold">{{ $order->status->label() }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-stone-500">Cotización</dt>
                <dd class="mt-1">
                    @if ($order->quote)
                        <a href="{{ route('cotizaciones.show', $order->quote) }}" class="font-semibold text-brand-700 hover:text-brand-500">{{ $order->quote->number }}</a>
                    @else
                        Sin cotización
                    @endif
                </dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-stone-500">Origen</dt>
                <dd class="mt-1">{{ $order->origin === 'web' ? 'Tienda web' : 'Administrativo' }}</dd>
            </div>
            @if ($order->address)
                <div class="sm:col-span-2 lg:col-span-3">
                    <dt class="text-sm font-medium text-stone-500">Dirección de entrega</dt>
                    <dd class="mt-1">
                        {{ $order->address->address }}, {{ $order->address->city }}, {{ $order->address->department }}
                    </dd>
                </div>
            @endif
            <div class="sm:col-span-2 lg:col-span-4">
                <dt class="text-sm font-medium text-stone-500">Notas</dt>
                <dd class="mt-1 whitespace-pre-line">{{ $order->notes ?? 'Sin notas' }}</dd>
            </div>
        </dl>
    </section>

    <section class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-stone-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-stone-200 text-sm">
                <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">
                    <tr>
                        <th class="px-5 py-3">Producto</th>
                        <th class="px-5 py-3 text-right">Cantidad</th>
                        <th class="px-5 py-3 text-right">Precio unitario</th>
                        <th class="px-5 py-3 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-stone-100">
                    @foreach ($order->details as $detail)
                        <tr>
                            <td class="px-5 py-4">
                                <p class="font-semibold">{{ $detail->product->name }}</p>
                                <p class="mt-1 text-xs text-stone-500">{{ $detail->product->sku }}</p>
                            </td>
                            <td class="px-5 py-4 text-right tabular-nums">{{ $detail->quantity }}</td>
                            <td class="px-5 py-4 text-right tabular-nums">Q {{ number_format((float) $detail->unit_price, 2) }}</td>
                            <td class="px-5 py-4 text-right tabular-nums">Q {{ number_format((float) $detail->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-stone-50">
                    <tr>
                        <th colspan="3" class="px-5 py-4 text-right text-base">Total</th>
                        <td class="px-5 py-4 text-right text-base font-bold tabular-nums">Q {{ number_format((float) $order->total, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>

    <div>
        <a href="{{ route('pedidos.index') }}" class="rounded-lg border border-stone-300 bg-white px-4 py-2 text-sm font-semibold hover:bg-stone-50">Volver a pedidos</a>
    </div>
@endsection
