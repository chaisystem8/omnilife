@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-end">
        <div class="col-auto">
            <a class="btn btn-primary" href="{{ route('empleados.create')}}"><span class="glyphicon glyphicon-pencil"></span> Crear Empleado</a>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-12 overflow-auto">
            <table id="empleados" class="table table-striped table-bordered table-responsive" style="width:100%">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Salario en dólares</th>
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
                        <td>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" checked>
                            </div>
                        </td>
                        <td>
                            <a class="btn btn-primary" href="{{ route('empleados.edit', $empleado->id)}}"><span class="glyphicon glyphicon-pencil"></span> Editar</a>
                            <a class="btn btn-secondary" onclick="eliminar({{ $empleado->id }})"> Detalle </a>
                            <a class="btn btn-danger" onclick="eliminar({{ $empleado->id }})"> Eliminar </a>
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
        new DataTable('#empleados', {
            language: {
                url: './es-ES.json',
            },
        });
    });

    function eliminar(id){
        console.log(1)
    }

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
