@extends('layouts.admin')

@section('title', 'Empleados')
@section('heading', 'Empleados')
@section('subheading', 'Gestión del personal de la organización')

@section('actions')
    <a href="{{ route('empleados.create') }}" class="rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-500">Nuevo empleado</a>
@endsection

@section('content')
    <div class="overflow-hidden rounded-xl bg-white shadow-sm ring-1 ring-slate-200">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-200 text-sm">
                <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-600">
                    <tr>
                        <th class="px-4 py-3">Empleado</th>
                        <th class="px-4 py-3">Puesto</th>
                        <th class="px-4 py-3">Usuario</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($employees as $employee)
                        <tr>
                            <td class="px-4 py-3 font-medium">{{ $employee->nombres }} {{ $employee->apellidos }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $employee->puesto ?? 'Sin especificar' }}</td>
                            <td class="px-4 py-3 text-slate-600">{{ $employee->user?->email ?? 'Sin asociar' }}</td>
                            <td class="px-4 py-3">
                                <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $employee->is_active ? 'bg-emerald-100 text-emerald-800' : 'bg-slate-200 text-slate-700' }}">
                                    {{ $employee->is_active ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('empleados.show', $employee) }}" class="rounded-md border border-slate-300 px-3 py-1.5 font-medium hover:bg-slate-50">Ver</a>
                                    <a href="{{ route('empleados.edit', $employee) }}" class="rounded-md border border-slate-300 px-3 py-1.5 font-medium hover:bg-slate-50">Editar</a>
                                    <form method="POST" action="{{ route('empleados.status', $employee) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="rounded-md px-3 py-1.5 font-medium {{ $employee->is_active ? 'bg-amber-100 text-amber-900 hover:bg-amber-200' : 'bg-emerald-100 text-emerald-900 hover:bg-emerald-200' }}">
                                            {{ $employee->is_active ? 'Desactivar' : 'Activar' }}
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-slate-500">No hay empleados registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($employees->hasPages())
            <div class="border-t border-slate-200 px-4 py-3">{{ $employees->links() }}</div>
        @endif
    </div>
@endsection
