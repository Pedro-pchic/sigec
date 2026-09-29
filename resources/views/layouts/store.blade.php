<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Tienda') | SIGEC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen overflow-x-hidden bg-stone-100 text-stone-900 antialiased">
    <div class="flex min-h-screen flex-col">
        <header class="sticky top-0 z-30 border-b border-stone-200/90 bg-stone-50/95 backdrop-blur">
            <div class="mx-auto flex min-h-20 w-full max-w-7xl items-center justify-between gap-3 px-4 py-3 sm:px-6 lg:px-8">
                <a href="{{ route('catalogo.index') }}" class="flex min-w-0 items-center gap-3 rounded-lg focus-visible:outline-2 focus-visible:outline-offset-4 focus-visible:outline-brand-600">
                    <span class="grid size-10 shrink-0 place-items-center rounded-xl bg-stone-950 text-lg font-black text-white shadow-sm">S</span>
                    <span class="min-w-0">
                        <span class="block truncate text-lg font-bold tracking-wide text-stone-950">SIGEC</span>
                        <span class="hidden text-[0.65rem] font-bold uppercase tracking-[0.18em] text-brand-700 sm:block">Tienda de calzado</span>
                    </span>
                </a>

                <nav class="flex shrink-0 items-center gap-1 text-sm font-semibold" aria-label="Navegación de tienda">
                    <a href="{{ route('catalogo.index') }}" @class([
                        'rounded-lg px-3 py-2',
                        'bg-brand-100 text-brand-900' => request()->routeIs('catalogo.*'),
                        'text-stone-700 hover:bg-stone-200/70' => ! request()->routeIs('catalogo.*'),
                    ])>Catálogo</a>
                    <a href="{{ route('carrito.index') }}" @class([
                        'rounded-lg px-3 py-2',
                        'bg-brand-100 text-brand-900' => request()->routeIs('carrito.*', 'checkout.*'),
                        'text-stone-700 hover:bg-stone-200/70' => ! request()->routeIs('carrito.*', 'checkout.*'),
                    ])>Carrito</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="inline-flex rounded-lg border border-stone-300 bg-white px-3 py-2 text-stone-700 shadow-sm hover:border-brand-300 hover:text-brand-800">
                            <span class="sm:hidden">Admin</span>
                            <span class="hidden sm:inline">Administración</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="inline-flex rounded-lg border border-stone-300 bg-white px-3 py-2 text-stone-700 shadow-sm hover:border-brand-300 hover:text-brand-800">
                            <span class="sm:hidden">Acceso</span>
                            <span class="hidden sm:inline">Iniciar sesión</span>
                        </a>
                    @endauth
                </nav>
            </div>
        </header>

        <main data-store-content class="mx-auto flex w-full max-w-7xl flex-1 flex-col gap-6 px-4 py-8 sm:px-6 sm:py-10 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-xs font-bold uppercase tracking-[0.18em] text-brand-700">Colección SIGEC</p>
                <h1 class="mt-2 text-3xl font-bold tracking-tight text-stone-950 sm:text-4xl">@yield('heading')</h1>
                @hasSection('subheading')
                    <p class="mt-2 text-sm leading-6 text-stone-600 sm:text-base">@yield('subheading')</p>
                @endif
            </div>

            @if (session('status'))
                <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-900 shadow-sm" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-900 shadow-sm" role="alert">
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

        <footer class="border-t border-stone-200 bg-stone-950 text-stone-400">
            <div class="mx-auto flex w-full max-w-7xl flex-col gap-1 px-4 py-6 text-sm sm:flex-row sm:items-center sm:justify-between sm:px-6 lg:px-8">
                <p class="font-semibold text-stone-200">SIGEC · Calzado con carácter</p>
                <p>Compra clara, atención cercana.</p>
            </div>
        </footer>
    </div>
</body>
</html>
