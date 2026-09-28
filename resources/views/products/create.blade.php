@extends('layouts.admin')

@section('title', 'Crear producto')
@section('heading', 'Crear producto')
@section('subheading', 'Registra un producto en el catálogo')

@section('content')
    <form method="POST" action="{{ route('productos.store') }}" class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        @csrf
        @include('products._form')

        <div class="mt-6 flex justify-end gap-3 border-t border-slate-200 pt-5">
            <a href="{{ route('productos.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-50">Cancelar</a>
            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Guardar producto</button>
        </div>
    </form>
@endsection
