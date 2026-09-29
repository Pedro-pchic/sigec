@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Resumen administrativo inicial')

@section('content')
    <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4" aria-label="Indicadores generales">
        @foreach ([
            ['label' => 'Total de usuarios', 'value' => $totalUsers],
            ['label' => 'Usuarios activos', 'value' => $activeUsers],
            ['label' => 'Total de empleados', 'value' => $totalEmployees],
            ['label' => 'Empleados activos', 'value' => $activeEmployees],
        ] as $metric)
            <article class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                <p class="text-sm font-medium text-slate-600">{{ $metric['label'] }}</p>
                <p class="mt-2 text-3xl font-bold tracking-tight text-indigo-700">{{ $metric['value'] }}</p>
            </article>
        @endforeach
    </section>
@endsection
