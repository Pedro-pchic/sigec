<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Administración') | SIGEC</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900">
    <header class="border-b border-slate-200 bg-white shadow-sm">
        <div class="mx-auto flex max-w-7xl flex-wrap items-center justify-between gap-4 px-4 py-4 sm:px-6 lg:px-8">
            <a href="{{ route('dashboard') }}" class="text-xl font-bold tracking-tight text-indigo-700">SIGEC</a>

            <nav class="flex flex-wrap items-center gap-2 text-sm font-medium" aria-label="Navegación principal">
                <a href="{{ route('dashboard') }}" class="rounded-md px-3 py-2 hover:bg-slate-100">Dashboard</a>
                @can('manage-users')
                    <a href="{{ route('usuarios.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100">Usuarios</a>
                @endcan
                @can('manage-employees')
                    <a href="{{ route('empleados.index') }}" class="rounded-md px-3 py-2 hover:bg-slate-100">Empleados</a>
                @endcan
                @can('manage-catalog')
                    <div class="flex items-center gap-1 rounded-md border border-slate-200 p-1">
                        <span class="px-2 text-xs font-semibold uppercase tracking-wide text-slate-500">Catálogo</span>
                        <a href="{{ route('categorias.index') }}" class="rounded-md px-3 py-1.5 hover:bg-slate-100">Categorías</a>
                        <a href="{{ route('productos.index') }}" class="rounded-md px-3 py-1.5 hover:bg-slate-100">Productos</a>
                    </div>
                @endcan
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="rounded-md bg-slate-900 px-3 py-2 text-white hover:bg-slate-700">Cerrar sesión</button>
                </form>
            </nav>
        </div>
    </header>

    <main class="mx-auto flex max-w-7xl flex-col gap-6 px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold tracking-tight">@yield('heading')</h1>
                @hasSection('subheading')
                    <p class="mt-1 text-sm text-slate-600">@yield('subheading')</p>
                @endif
            </div>
            @yield('actions')
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800" role="status">
                {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800" role="alert">
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
</body>
</html>
