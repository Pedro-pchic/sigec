@extends('layouts.admin')

@section('title', 'Editar categoría')
@section('heading', 'Editar categoría')
@section('subheading', $category->name)

@section('content')
    <form method="POST" action="{{ route('categorias.update', $category) }}" class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        @csrf
        @method('PUT')
        @include('categories._form')

        <div class="mt-6 flex justify-end gap-3 border-t border-slate-200 pt-5">
            <a href="{{ route('categorias.show', $category) }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-50">Cancelar</a>
            <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Actualizar categoría</button>
        </div>
    </form>
@endsection
