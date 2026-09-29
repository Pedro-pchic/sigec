@extends('layouts.store')

@section('title', 'Catálogo')
@section('heading', 'Catálogo')
@section('subheading', 'Explora nuestros productos y consulta su disponibilidad')

@section('content')
    <form method="GET" action="{{ route('catalogo.index') }}" class="grid gap-4 rounded-xl bg-white p-5 shadow-sm ring-1 ring-stone-200 sm:grid-cols-[1fr_14rem_auto] sm:items-end">
        <div>
            <label for="search" class="block text-sm font-medium">Buscar por nombre o SKU</label>
            <input id="search" name="search" type="search" value="{{ $search }}" maxlength="100" placeholder="Ej. Zapato o CAL-001"
                class="mt-2 w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-brand-500 focus:ring-2 focus:ring-brand-200">
        </div>
        <div>
            <label for="category_id" class="block text-sm font-medium">Categoría</label>
            <select id="category_id" name="category_id" class="mt-2 w-full rounded-lg border border-stone-300 px-3 py-2 focus:border-brand-500 focus:ring-2 focus:ring-brand-200">
                <option value="">Todas</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected($categoryId === $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="rounded-lg bg-brand-700 px-4 py-2 font-semibold text-white hover:bg-brand-600">Filtrar</button>
    </form>

    @if ($products->isEmpty())
        <div class="rounded-xl bg-white p-8 text-center shadow-sm ring-1 ring-stone-200">
            <p class="font-semibold">No encontramos productos.</p>
            <p class="mt-1 text-sm text-stone-600">Prueba con otra búsqueda o categoría.</p>
        </div>
    @else
        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach ($products as $product)
                <article class="group flex overflow-hidden rounded-2xl bg-white shadow-sm ring-1 ring-stone-200 transition-shadow hover:shadow-md sm:flex-col">
                    <div class="grid w-28 shrink-0 place-items-center bg-brand-50 text-brand-800 sm:h-36 sm:w-full" aria-hidden="true">
                        <span class="text-3xl font-black tracking-tight">{{ mb_strtoupper(mb_substr($product->name, 0, 2)) }}</span>
                    </div>
                    <div class="flex min-w-0 flex-1 flex-col gap-4 p-5">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-stone-500">{{ $product->category->name }}</p>
                            <h2 class="mt-1 text-lg font-bold">{{ $product->name }}</h2>
                            <p class="mt-1 text-xs text-stone-500">{{ $product->sku }}</p>
                        </div>
                        <span class="inline-flex items-center rounded-full px-2.5 py-1 text-xs font-semibold ring-1 ring-inset ring-current/10 {{ $product->availabilityLabel() === 'Agotado' ? 'bg-red-100 text-red-700' : ($product->availabilityLabel() === 'Stock bajo' ? 'bg-amber-100 text-amber-800' : 'bg-emerald-100 text-emerald-700') }}">
                            {{ $product->availabilityLabel() }}
                        </span>
                    </div>
                    <p class="mt-auto text-xl font-bold tabular-nums">Q {{ number_format((float) $product->price, 2) }}</p>
                    <a href="{{ route('catalogo.show', $product) }}" class="rounded-lg border border-brand-200 px-4 py-2 text-center text-sm font-semibold text-brand-700 hover:bg-brand-50">Ver producto</a>
                    </div>
                </article>
            @endforeach
        </div>

        {{ $products->links() }}
    @endif
@endsection
