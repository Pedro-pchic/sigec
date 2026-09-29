@extends('layouts.admin')

@section('title', 'Órdenes de compra')
@section('heading', 'Órdenes de compra')
@section('subheading', 'Borradores, órdenes pendientes y recepciones')

@section('actions')
    @can('manage-purchases')
        <a href="{{ route('compras.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Nueva orden</a>
    @endcan
@endsection

@section('content')
    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                    <tr>
                        <th class="px-4 py-3">Número</th>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Proveedor</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-right">Total</th>
                        <th class="px-4 py-3 text-right">Acción</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($purchases as $purchase)
                        @php
                            $statusClass = match ($purchase->status) {
                                \App\Enums\PurchaseStatus::Draft => 'bg-slate-200 text-slate-700',
                                \App\Enums\PurchaseStatus::Pending => 'bg-amber-100 text-amber-900',
                                \App\Enums\PurchaseStatus::Received => 'bg-emerald-100 text-emerald-800',
                                \App\Enums\PurchaseStatus::Cancelled => 'bg-red-100 text-red-800',
                            };
                        @endphp
                        <tr>
                            <td class="px-4 py-3 font-mono text-xs font-semibold">{{ $purchase->number }}</td>
                            <td class="px-4 py-3">{{ $purchase->order_date->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 font-medium">{{ $purchase->supplier->name }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $statusClass }}">{{ $purchase->status->label() }}</span>
                            </td>
                            <td class="px-4 py-3 text-right tabular-nums">{{ number_format((float) $purchase->total, 2) }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('compras.show', $purchase) }}" class="rounded-md border border-slate-300 px-3 py-1.5 font-medium hover:bg-slate-50">Ver orden</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-10 text-center text-slate-500">No hay órdenes de compra registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($purchases->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">{{ $purchases->links() }}</div>
        @endif
    </div>
@endsection
