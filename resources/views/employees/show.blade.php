@extends('layouts.admin')

@section('title', 'Detalle del empleado')
@section('heading', $employee->nombres.' '.$employee->apellidos)
@section('subheading', 'Detalle del empleado')

@section('actions')
    <a href="{{ route('empleados.edit', $employee) }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Editar empleado</a>
@endsection

@section('content')
    <div class="rounded-xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
        <dl class="grid gap-6 sm:grid-cols-2">
            <div>
                <dt class="text-sm font-medium text-slate-500">Estado</dt>
                <dd class="mt-1 font-semibold">{{ $employee->is_active ? 'Activo' : 'Inactivo' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Puesto</dt>
                <dd class="mt-1">{{ $employee->puesto ?? 'Sin especificar' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Teléfono</dt>
                <dd class="mt-1">{{ $employee->telefono ?? 'Sin especificar' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Fecha de contratación</dt>
                <dd class="mt-1">{{ $employee->fecha_contratacion?->format('d/m/Y') ?? 'Sin especificar' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Usuario asociado</dt>
                <dd class="mt-1">{{ $employee->user?->email ?? 'Sin asociar' }}</dd>
            </div>
            <div>
                <dt class="text-sm font-medium text-slate-500">Dirección</dt>
                <dd class="mt-1">{{ $employee->direccion ?? 'Sin especificar' }}</dd>
            </div>
        </dl>

        <div class="mt-6 flex flex-wrap gap-3 border-t border-slate-200 pt-5">
            <a href="{{ route('empleados.index') }}" class="rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold hover:bg-slate-50">Volver</a>
            <form method="POST" action="{{ route('empleados.status', $employee) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="rounded-lg px-4 py-2 text-sm font-semibold {{ $employee->is_active ? 'bg-amber-100 text-amber-900 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-900 hover:bg-emerald-200' }}">
                    {{ $employee->is_active ? 'Desactivar' : 'Activar' }}
                </button>
            </form>
        </div>
    </div>
@endsection
