@extends('layouts.store')

@section('title', 'Carrito')
@section('heading', 'Carrito')
@section('subheading', 'Revisa tus productos antes de continuar al checkout')

@section('content')
    @if ($cart['items'] === [])
        <div class="rounded-xl bg-white p-8 text-center shadow-sm ring-1 ring-stone-200">
            <p class="font-semibold">Tu carrito está vacío.</p>
            <a href="{{ route('catalogo.index') }}" class="mt-4 inline-flex rounded-lg bg-brand-700 px-4 py-2 text-sm font-semibold text-white hover:bg-brand-600">Ver catálogo</a>
        </div>
    @else
        <section class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-stone-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-stone-200 text-sm">
                    <thead class="bg-stone-50 text-left text-xs font-semibold uppercase tracking-wide text-stone-500">
                        <tr>
                            <th class="px-5 py-3">Producto</th>
                            <th class="px-5 py-3 text-right">Precio</th>
                            <th class="px-5 py-3">Cantidad</th>
                            <th class="px-5 py-3 text-right">Subtotal</th>
                            <th class="px-5 py-3"><span class="sr-only">Acciones</span></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-stone-100">
                        @foreach ($cart['items'] as $item)
                            <tr>
                                <td class="px-5 py-4">
                                    <a href="{{ route('catalogo.show', $item['product']) }}" class="font-semibold text-brand-700 hover:text-brand-500">{{ $item['product']->name }}</a>
                                    <p class="mt-1 text-xs text-stone-500">{{ $item['product']->sku }} · {{ $item['product']->availabilityLabel() }}</p>
                                </td>
                                <td class="px-5 py-4 text-right tabular-nums">Q {{ number_format((float) $item['product']->price, 2) }}</td>
                                <td class="px-5 py-4">
                                    <form method="POST" action="{{ route('carrito.update', $item['product']) }}" class="flex items-center gap-2">
                                        @csrf
                                        @method('PATCH')
                                        <label for="quantity-{{ $item['product']->id }}" class="sr-only">Cantidad de {{ $item['product']->name }}</label>
                                        <input id="quantity-{{ $item['product']->id }}" name="quantity" type="number" min="1" value="{{ $item['quantity'] }}" required
                                            class="w-20 rounded-lg border border-stone-300 px-3 py-2 focus:border-brand-500 focus:ring-2 focus:ring-brand-200">
                                        <button type="submit" class="rounded-lg border border-stone-300 px-3 py-2 font-semibold hover:bg-stone-50">Actualizar</button>
                                    </form>
                                </td>
                                <td class="px-5 py-4 text-right font-semibold tabular-nums">Q {{ number_format((float) $item['subtotal'], 2) }}</td>
                                <td class="px-5 py-4 text-right">
                                    <form method="POST" action="{{ route('carrito.destroy', $item['product']) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="font-semibold text-red-700 hover:text-red-500">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-stone-50">
                        <tr>
                            <th colspan="3" class="px-5 py-4 text-right text-base">Total</th>
                            <td class="px-5 py-4 text-right text-lg font-bold tabular-nums">Q {{ number_format((float) $cart['total'], 2) }}</td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </section>

        <div class="flex flex-wrap items-center justify-between gap-3">
            <form method="POST" action="{{ route('carrito.clear') }}">
                @csrf
                @method('DELETE')
                <button type="submit" class="rounded-lg border border-red-200 px-4 py-2 text-sm font-semibold text-red-700 hover:bg-red-50">Vaciar carrito</button>
            </form>

            @if ($cart['can_checkout'])
                <a href="{{ route('checkout.create') }}" class="rounded-lg bg-brand-700 px-5 py-2.5 font-semibold text-white hover:bg-brand-600">Continuar al checkout</a>
            @else
                <span class="rounded-lg bg-stone-300 px-5 py-2.5 font-semibold text-stone-600" aria-disabled="true">Revisa la disponibilidad</span>
            @endif
        </div>
    @endif
@endsection
