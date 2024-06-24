@extends('layouts.prestamos')

@section('content')
    <div class="flex justify-start">
        <a href="{{ route('loan_amounts.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded ml-2">Volver</a>
    </div>

    <h1>Listado de Plazos disponibles</h1>

    <div class="flex justify-end">
        <a href="{{ route('terms.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded my-3">
            Nuevo Plazo
        </a>
    </div>

    @if ($terms->count() > 0)
        <table class="min-w-full divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="uppercase">Plazo</th>
                    <th class="uppercase text-center">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($terms as $term)
                    <tr>
                        <td class="whitespace-nowrap">{{ $term->term }}</td>
                        <td class="whitespace-nowrap text-center">
                            <form action="{{ route('terms.destroy', $term->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No hay términos de préstamo registrados.</p>
    @endif
@endsection
