@extends('layouts.admin')

@section('title', 'Detalle de la categoría')
@section('heading', $category->name)
@section('subheading', 'Detalle de la categoría')

@section('actions')
    <a href="{{ route('categorias.edit', $category) }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Editar categoría</a>
@endsection

@section('content')
    <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <dl class="grid gap-6 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-slate-500">Estado</dt>
                <dd class="mt-1 font-semibold">{{ $category->is_active ? 'Activa' : 'Inactiva' }}</dd>
            </div>
            <div class="sm:col-span-2">
                <dt class="text-sm font-medium text-slate-500">Descripción</dt>
                <dd class="mt-1 whitespace-pre-line">{{ $category->description ?? 'Sin descripción' }}</dd>
            </div>
        </dl>

        <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-200 pt-5">
            <a href="{{ route('categorias.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-50">Volver</a>
            <form method="POST" action="{{ route('categorias.status', $category) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-lg px-4 py-2 text-sm font-semibold {{ $category->is_active ? 'bg-amber-100 text-amber-900 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-900 hover:bg-emerald-200' }}">
                    {{ $category->is_active ? 'Desactivar' : 'Activar' }}
                </button>
            </form>
        </div>
    </div>
@endsection
