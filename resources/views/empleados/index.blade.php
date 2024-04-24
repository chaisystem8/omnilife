@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <table id="example" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Salario en dólares</th>
                    <th>Salario en pesos</th>
                    <th>Correo</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $empleado)
                <tr>
                    <td>{{ $empleado->codigo }}</td>
                    <td>{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->salarioDolares }}</td>
                    <td>{{ $empleado->salarioPesos }}</td>
                    <td>{{ $empleado->correo }}</td>
                    <td><input type="checkbox" class="statusCheckbox" data-empleado-id="{{ $empleado->id }}" {{ $empleado->estatus ? 'checked' : '' }}></td>
                <td>
                    <a href="{{ route('empleados.edit', ['empleado' => $empleado->id]) }}" class="text-blue-500 hover:text-blue-700 mr-2">Editar</a>
                    <a href="{{ route('empleados.edit', ['empleado' => $empleado->id]) }}" class="text-red-500 hover:text-red-700 delete-btn" data-empleado-id="{{ $empleado->id }}">Borrar</a>
                </td>

                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



@endsection
