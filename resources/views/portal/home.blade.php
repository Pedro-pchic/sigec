@extends('layouts.store')

@section('title', 'Calzado para cada paso')
@section('meta_description', 'Descubre el catálogo de calzado SIGEC, compra en línea y consulta el estado de tu pedido.')

@section('content')
    <section class="relative overflow-hidden rounded-3xl bg-stone-950 px-6 py-14 text-white shadow-xl sm:px-10 sm:py-20 lg:px-16" aria-labelledby="hero-title">
        <div class="absolute -right-24 -top-24 size-72 rounded-full bg-brand-600/30 blur-3xl" aria-hidden="true"></div>
        <div class="absolute -bottom-20 right-1/4 size-56 rounded-full bg-camel/20 blur-3xl" aria-hidden="true"></div>
        <div class="relative max-w-3xl">
            <p class="text-xs font-bold uppercase tracking-[0.24em] text-brand-300">Colección SIGEC</p>
            <h1 id="hero-title" class="mt-4 text-4xl font-black tracking-tight sm:text-5xl lg:text-6xl">Calzado para avanzar con confianza.</h1>
            <p class="mt-5 max-w-2xl text-base leading-7 text-stone-300 sm:text-lg">Explora productos disponibles, compra desde un flujo seguro y recibe atención directa cuando la necesites.</p>
            <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('catalogo.index') }}" class="ui-button bg-brand-500 text-white hover:bg-brand-400 focus-visible:outline-brand-300">Explorar productos</a>
                <a href="{{ route('seguimiento.create') }}" class="ui-button border border-white/30 bg-white/10 text-white hover:bg-white/20 focus-visible:outline-white">Consultar mi pedido</a>
            </div>
        </div>
    </section>

    <section class="py-6" aria-labelledby="categories-title">
        <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Encuentra tu estilo</p>
                <h2 id="categories-title" class="mt-2 text-2xl font-bold tracking-tight sm:text-3xl">Compra por categoría</h2>
            </div>
            <a href="{{ route('catalogo.index') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-500">Ver catálogo completo →</a>
        </div>

        @if ($categories->isEmpty())
            <div class="ui-empty-state mt-6">Las categorías estarán disponibles próximamente.</div>
        @else
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($categories as $category)
                    <a href="{{ route('catalogo.index', ['category_id' => $category->id]) }}" class="ui-card group flex min-h-32 items-end overflow-hidden p-5 hover:ring-brand-300 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">
                        <div>
                            <p class="text-lg font-bold text-stone-950 group-hover:text-brand-800">{{ $category->name }}</p>
                            @if ($category->description)
                                <p class="mt-1 line-clamp-2 text-sm leading-6 text-stone-600">{{ $category->description }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </section>

    <section id="promociones" class="scroll-mt-28 rounded-3xl border border-dashed border-brand-300 bg-brand-50 px-6 py-10 sm:px-10" aria-labelledby="promotions-title">
        <div class="max-w-2xl">
            <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Promociones</p>
            <h2 id="promotions-title" class="mt-2 text-2xl font-bold tracking-tight text-stone-950">Sin promociones activas por ahora</h2>
            <p class="mt-3 leading-7 text-stone-700">Cuando existan ofertas reales las encontrarás aquí. Mientras tanto, consulta disponibilidad y precios vigentes en nuestro catálogo.</p>
            <a href="{{ route('catalogo.index') }}" class="ui-button ui-button-primary mt-5">Ir al catálogo</a>
        </div>
    </section>

    <section class="grid gap-5 py-6 md:grid-cols-3" aria-label="Beneficios de compra">
        @foreach ([
            ['title' => 'Disponibilidad clara', 'body' => 'El catálogo muestra el estado actual de cada producto.'],
            ['title' => 'Compra integrada', 'body' => 'Catálogo, carrito y checkout funcionan en un solo recorrido.'],
            ['title' => 'Atención directa', 'body' => 'Envíanos una consulta o revisa el estado de tu pedido en línea.'],
        ] as $benefit)
            <article class="ui-card p-6">
                <span class="mb-4 block size-2 rounded-full bg-brand-600 ring-4 ring-brand-100" aria-hidden="true"></span>
                <h2 class="text-lg font-bold">{{ $benefit['title'] }}</h2>
                <p class="mt-2 text-sm leading-6 text-stone-600">{{ $benefit['body'] }}</p>
            </article>
        @endforeach
    </section>

    <section class="rounded-3xl bg-espresso px-6 py-10 text-stone-100 sm:px-10 sm:py-12">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-300">Conoce SIGEC</p>
                <h2 class="mt-2 text-2xl font-bold sm:text-3xl">Una experiencia comercial cercana, también en digital.</h2>
                <p class="mt-3 leading-7 text-stone-300">Integramos nuestro catálogo y atención para que comprar y consultar sea sencillo.</p>
            </div>
            <div class="flex flex-col gap-3 sm:flex-row">
                <a href="{{ route('nosotros') }}" class="ui-button border border-white/30 text-white hover:bg-white/10 focus-visible:outline-white">Sobre nosotros</a>
                <a href="{{ route('contacto.create') }}" class="ui-button bg-white text-stone-950 hover:bg-brand-50 focus-visible:outline-white">Contactar</a>
            </div>
        </div>
    </section>
@endsection
