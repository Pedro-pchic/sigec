@extends('layouts.admin')

@section('title', 'Nuevo cliente')
@section('heading', 'Nuevo cliente')
@section('subheading', 'Registra un cliente comercial sin crear una cuenta de usuario')

@section('content')
    <form method="POST" action="{{ route('clientes.store') }}" class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        @csrf
        @include('customers._form')
        <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-200 pt-5">
            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Crear cliente</button>
            <a href="{{ route('clientes.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-50">Cancelar</a>
        </div>
    </form>
@endsection
