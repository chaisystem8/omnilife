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

<script>
    $(document).ready(function() {
        Swal.fire("SweetAlert2 is working!");
        ws();
    });

     function ws(){
        $.ajax({
            url : "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno?token=ee21c3b0e6c564aa47aba4519bd515d68eb42559be293ebfd3104b6dd72fd770",
            jsonp : "callback",
            dataType : "jsonp", //Se utiliza JSONP para realizar la consulta cross-site
            success : function(response) {
                console.log(response.bmx.series[0].datos[0].dato);
            }
        });
    }


</script>

@endsection
