@extends('layouts.admin')

@section('title', 'Clientes')
@section('heading', 'Clientes')
@section('subheading', 'Administración de clientes y contactos comerciales')

@section('actions')
    <a href="{{ route('clientes.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Nuevo cliente</a>
@endsection

@section('content')
    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                    <tr>
                        <th class="px-5 py-3">Cliente</th>
                        <th class="px-5 py-3">NIT</th>
                        <th class="px-5 py-3">Teléfono</th>
                        <th class="px-5 py-3">Direcciones</th>
                        <th class="px-5 py-3">Cotizaciones</th>
                        <th class="px-5 py-3">Estado</th>
                        <th class="px-5 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($customers as $customer)
                        <tr>
                            <td class="px-5 py-4">
                                <a href="{{ route('clientes.show', $customer) }}" class="font-semibold text-indigo-700 hover:text-indigo-500">{{ $customer->name }}</a>
                                <p class="mt-1 text-xs text-slate-500">{{ $customer->email ?? 'Sin correo registrado' }}</p>
                            </td>
                            <td class="px-5 py-4">{{ $customer->nit ?? '—' }}</td>
                            <td class="px-5 py-4">{{ $customer->phone ?? '—' }}</td>
                            <td class="px-5 py-4">{{ $customer->addresses_count }}</td>
                            <td class="px-5 py-4">{{ $customer->quotes_count }}</td>
                            <td class="px-5 py-4">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $customer->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-100 text-slate-600' }}">
                                    {{ $customer->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-5 py-4 text-right">
                                <a href="{{ route('clientes.show', $customer) }}" class="font-semibold text-indigo-700 hover:text-indigo-500">Ver</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-slate-500">Todavía no hay clientes registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($customers->hasPages())
            <div class="border-t border-slate-200 px-5 py-4">{{ $customers->links() }}</div>
        @endif
    </div>
@endsection
