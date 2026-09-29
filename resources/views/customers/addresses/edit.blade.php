@extends('layouts.admin')

@section('title', 'Editar dirección')
@section('heading', 'Editar dirección')
@section('subheading', $customer->name)

@section('content')
    <form method="POST" action="{{ route('clientes.direcciones.update', [$customer, $address]) }}" class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        @csrf
        @method('PUT')
        @include('customers.addresses._form')
        <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-200 pt-5">
            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Guardar cambios</button>
            <a href="{{ route('clientes.show', $customer) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-50">Cancelar</a>
        </div>
    </form>
@endsection
