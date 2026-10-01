<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="@yield('meta_description', 'SIGEC: calzado, compra en línea y atención cercana en un solo lugar.')">
    <link rel="canonical" href="{{ url()->current() }}">
    <title>@yield('title', 'Inicio') | SIGEC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-cream text-stone-900 antialiased">
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-30 border-b border-stone-200/90 bg-warm-white/95 backdrop-blur">
            <div class="mx-auto flex min-h-20 w-full max-w-7xl items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
                <a href="{{ route('inicio') }}" class="flex min-w-0 items-center gap-3 rounded-lg focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-brand-600">
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-stone-950 text-lg font-black text-white shadow-sm">S</span>
                    <span class="min-w-0">
                        <span class="block truncate text-lg font-bold tracking-wide text-stone-950">SIGEC</span>
                        <span class="hidden text-[0.65rem] font-bold uppercase tracking-[0.18em] text-brand-700 sm:block">Calzado &amp; atención</span>
                    </span>
                </a>

                <nav class="hidden items-center gap-1 text-sm font-semibold xl:flex" aria-label="Navegación principal">
                    @foreach ([
                        ['route' => 'inicio', 'active' => 'inicio', 'label' => 'Inicio'],
                        ['route' => 'catalogo.index', 'active' => 'catalogo.*', 'label' => 'Productos'],
                        ['route' => 'nosotros', 'active' => 'nosotros', 'label' => 'Nosotros'],
                        ['route' => 'contacto.create', 'active' => 'contacto.*', 'label' => 'Contacto'],
                        ['route' => 'seguimiento.create', 'active' => 'seguimiento.*', 'label' => 'Mi pedido'],
                    ] as $item)
                        <a href="{{ route($item['route']) }}" @class([
                            'rounded-lg px-3 py-2 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600',
                            'bg-brand-100 text-brand-900' => request()->routeIs($item['active']),
                            'text-stone-700 hover:bg-stone-200/70' => ! request()->routeIs($item['active']),
                        ])>{{ $item['label'] }}</a>
                    @endforeach
                    <a href="{{ route('inicio') }}#promociones" class="rounded-lg px-3 py-2 text-stone-700 hover:bg-stone-200/70 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600">Promociones</a>
                    <a href="{{ route('carrito.index') }}" @class([
                        'rounded-lg px-3 py-2 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600',
                        'bg-brand-100 text-brand-900' => request()->routeIs('carrito.*', 'checkout.*'),
                        'text-stone-700 hover:bg-stone-200/70' => ! request()->routeIs('carrito.*', 'checkout.*'),
                    ])>Carrito</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="ui-button ui-button-secondary ui-button-compact">Administración</a>
                    @else
                        <a href="{{ route('login') }}" class="ui-button ui-button-secondary ui-button-compact">Iniciar sesión</a>
                    @endauth
                </nav>

                <details class="relative xl:hidden">
                    <summary class="grid size-11 cursor-pointer list-none place-items-center rounded-lg border border-stone-300 bg-white text-stone-800 shadow-sm focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-brand-600" aria-label="Abrir navegación">
                        <svg class="size-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                            <path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16" />
                        </svg>
                    </summary>
                    <nav class="absolute right-0 mt-3 flex w-64 flex-col gap-1 rounded-2xl bg-white p-3 text-sm font-semibold shadow-xl ring-1 ring-stone-200" aria-label="Navegación móvil">
                        <a href="{{ route('inicio') }}" class="rounded-lg px-3 py-2 hover:bg-brand-50">Inicio</a>
                        <a href="{{ route('catalogo.index') }}" class="rounded-lg px-3 py-2 hover:bg-brand-50">Productos</a>
                        <a href="{{ route('inicio') }}#promociones" class="rounded-lg px-3 py-2 hover:bg-brand-50">Promociones</a>
                        <a href="{{ route('nosotros') }}" class="rounded-lg px-3 py-2 hover:bg-brand-50">Nosotros</a>
                        <a href="{{ route('contacto.create') }}" class="rounded-lg px-3 py-2 hover:bg-brand-50">Contacto</a>
                        <a href="{{ route('seguimiento.create') }}" class="rounded-lg px-3 py-2 hover:bg-brand-50">Consultar pedido</a>
                        <a href="{{ route('carrito.index') }}" class="rounded-lg px-3 py-2 hover:bg-brand-50">Carrito</a>
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-lg px-3 py-2 hover:bg-brand-50">Administración</a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-lg px-3 py-2 hover:bg-brand-50">Iniciar sesión</a>
                        @endauth
                    </nav>
                </details>
            </div>
        </header>

        <main data-store-content class="mx-auto flex w-full max-w-7xl flex-1 flex-col gap-6 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
            @hasSection('heading')
                <div class="max-w-3xl">
                    <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">SIGEC</p>
                    <h1 class="mt-2 text-3xl font-bold tracking-tight text-stone-950 sm:text-4xl">@yield('heading')</h1>
                    @hasSection('subheading')
                        <p class="mt-2 text-sm leading-6 text-stone-600 sm:text-base">@yield('subheading')</p>
                    @endif
                </div>
            @endif

            @if (session('status'))
                <div class="ui-alert-success" role="status">{{ session('status') }}</div>
            @endif

            @if ($errors->any())
                <div class="ui-alert-danger" role="alert">
                    <p class="font-semibold">Revisa los datos ingresados.</p>
                    <ul class="mt-2 list-disc space-y-1 pl-5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>

        <footer class="border-t border-stone-800 bg-stone-950 text-stone-400">
            <div class="mx-auto grid w-full max-w-7xl gap-6 px-4 py-8 text-sm sm:grid-cols-2 sm:px-6 lg:grid-cols-[1fr_auto] lg:px-8">
                <div>
                    <p class="font-semibold text-stone-100">SIGEC · Calzado con carácter</p>
                    <p class="mt-1">Compra clara, atención cercana.</p>
                </div>
                <nav class="flex flex-wrap gap-x-5 gap-y-2" aria-label="Navegación de pie de página">
                    <a href="{{ route('catalogo.index') }}" class="hover:text-white">Productos</a>
                    <a href="{{ route('nosotros') }}" class="hover:text-white">Nosotros</a>
                    <a href="{{ route('contacto.create') }}" class="hover:text-white">Contacto</a>
                    <a href="{{ route('seguimiento.create') }}" class="hover:text-white">Mi pedido</a>
                </nav>
            </div>
        </footer>
    </div>
</body>
</html>
