@extends('layouts.admin')

@section('title', 'Ventas')
@section('heading', 'Ventas')
@section('subheading', 'Ventas confirmadas a partir de pedidos')

@section('content')
    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Número</th>
                        <th class="px-5 py-3">Cliente</th>
                        <th class="px-5 py-3">Pedido</th>
                        <th class="px-5 py-3">Fecha</th>
                        <th class="px-5 py-3 text-right">Total</th>
                        <th class="px-5 py-3">Estado</th>
                        <th class="px-5 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($sales as $sale)
                        <tr>
                            <td class="px-5 py-4 font-semibold">
                                <a href="{{ route('ventas.show', $sale) }}" class="text-indigo-700 hover:text-indigo-500">{{ $sale->number }}</a>
                            </td>
                            <td class="px-5 py-4">{{ $sale->customer->name }}</td>
                            <td class="px-5 py-4">{{ $sale->order?->number ?? 'Venta directa' }}</td>
                            <td class="px-5 py-4">{{ $sale->sale_date->format('Y-m-d') }}</td>
                            <td class="px-5 py-4 text-right tabular-nums">Q {{ number_format((float) $sale->total, 2) }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $sale->status === \App\Enums\SaleStatus::Confirmed ? 'bg-emerald-100 text-emerald-800' : 'bg-red-100 text-red-800' }}">{{ $sale->status->label() }}</span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('ventas.show', $sale) }}" class="font-semibold text-indigo-700 hover:text-indigo-500">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-slate-500">Todavía no hay ventas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($sales->hasPages())
            <div class="border-t border-slate-200 px-5 py-4">{{ $sales->links() }}</div>
        @endif
    </div>
@endsection
