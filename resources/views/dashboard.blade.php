@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Vista general de usuarios y equipo de trabajo')

@section('content')
    <section class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4" aria-label="Indicadores generales">
        @foreach ([
            ['label' => 'Total de usuarios', 'value' => $totalUsers, 'eyebrow' => 'Accesos'],
            ['label' => 'Usuarios activos', 'value' => $activeUsers, 'eyebrow' => 'Accesos'],
            ['label' => 'Total de empleados', 'value' => $totalEmployees, 'eyebrow' => 'Equipo'],
            ['label' => 'Empleados activos', 'value' => $activeEmployees, 'eyebrow' => 'Equipo'],
        ] as $metric)
            <article class="ui-card relative overflow-hidden p-6">
                <span class="absolute inset-y-0 left-0 w-1 bg-brand-600" aria-hidden="true"></span>
                <div class="flex items-start justify-between gap-4">
                    <div>
                        <p class="text-[0.68rem] font-bold uppercase tracking-[0.16em] text-brand-700">{{ $metric['eyebrow'] }}</p>
                        <p class="mt-2 text-sm font-medium text-stone-600">{{ $metric['label'] }}</p>
                    </div>
                    <span class="size-2 rounded-full bg-amber-400 ring-4 ring-amber-100" aria-hidden="true"></span>
                </div>
                <p class="mt-5 text-4xl font-bold tracking-tight text-stone-950">{{ $metric['value'] }}</p>
            </article>
        @endforeach
    </section>
@endsection
