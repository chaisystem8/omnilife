@extends('layouts.app')

@section('content')



<div class="container">
    @if (session('success'))
        <div id="success-message" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    <div class="row">
        <div class="col">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Listado de Empleados</h1>
                <a class="btn btn-primary" href="{{ route('empleados.create')}}"><span class="glyphicon glyphicon-pencil"></span> Crear Empleado</a>
            </div>
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
                            <a class="btn btn-secondary" onclick="detalle({{ $empleado->id }})"> Detalle </a>
                            <a class="btn btn-danger" onclick="eliminar('{{ $empleado->id }}', '{{ $empleado->nombre }}')"> Eliminar </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>



    <form id="deleteForm" action="" method="POST" style="display: none;"> @csrf @method('DELETE') </form>

    <!-- Modal -->
    <div class="modal fade" id="detalleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Detalle de Empleado</h5>
            </div>
            <div class="modal-body" id="modal">

            </div>
            <canvas id="myChart" width="400" height="250"></canvas>
            <canvas id="myChart2" width="400" height="250"></canvas>


            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="cerrar()">Cerrar</button>
            </div>
        </div>
        </div>
    </div>



<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.min.js"></script>


<script>





    $(document).ready(function() {
        new DataTable('#empleados', {
            language: {
                url: './es-ES.json',
            },
        });
    });


    function eliminar(id, nombre){
        Swal.fire({
            title: `¿Estás seguro de borrar al empleado ${nombre}?`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, eliminarlo!'
        }).then((result) => {
            if (result.isConfirmed) {
                if (result.isConfirmed) {
                    const formAction = `/empleados/${id}`;
                    $('#deleteForm').attr('action', formAction);
                    $('#deleteForm').submit();
                }
            }
        });
    }


    function detalle(id){
        $.ajax({
            url: `/empleados/${id}`,
            type: 'GET',
            success: function(response) {
                console.log(response)

                var canvas1 = document.getElementById('myChart');
    var canvas2 = document.getElementById('myChart2');

    // Grafica para salario en pesos
    var data1 = {
        labels: [],
        datasets: [
            {
                label: "Proyeccion en 6 meses (Pesos)",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(75,192,192,0.4)",
                borderColor: "rgba(75,192,192,1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(75,192,192,1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 5,
                pointHitRadius: 10,
                data: [],
            }
        ]
    };

    // Grafica para salario en dólares
    var data2 = {
        labels: [],
        datasets: [
            {
                label: "Proyeccion en 6 meses (Dólares)",
                fill: false,
                lineTension: 0.1,
                backgroundColor: "rgba(255, 99, 132, 0.4)",
                borderColor: "rgba(255, 99, 132, 1)",
                borderCapStyle: 'butt',
                borderDash: [],
                borderDashOffset: 0.0,
                borderJoinStyle: 'miter',
                pointBorderColor: "rgba(255, 99, 132, 1)",
                pointBackgroundColor: "#fff",
                pointBorderWidth: 1,
                pointHoverRadius: 5,
                pointHoverBackgroundColor: "rgba(255, 99, 132, 1)",
                pointHoverBorderColor: "rgba(220,220,220,1)",
                pointHoverBorderWidth: 2,
                pointRadius: 5,
                pointHitRadius: 10,
                data: [],
            }
        ]
    };

    // Iteramos sobre la proyección salarial en la respuesta y la agregamos a los datos de ambas gráficas
    response.proyeccionSalario.forEach(function(proyeccion) {
        data1.labels.push(proyeccion.mes);
        data1.datasets[0].data.push(proyeccion.salarioP);

        data2.labels.push(proyeccion.mes);
        data2.datasets[0].data.push(proyeccion.salarioD);
    });

    var myLineChart1 = Chart.Line(canvas1,{
        data: data1,
        showLines: true
    });

    var myLineChart2 = Chart.Line(canvas2,{
        data: data2,
        showLines: true
    });



        $("#modal").html(`
            <div class="row">
                <div class="col-md-6">
                    <h5>Codigo: ${response.empleado.codigo}</h5>
                    <h5>Nombre: ${response.empleado.nombre}</h5>
                    <h5>Salario en Pesos: $${response.empleado.salarioPesos}</h5>
                    <h5>Salario en Dólares: $${response.empleado.salarioDolares}</h5>
                </div>
                <div class="col-md-6">
                    <h5>Estado: ${response.empleado.estado}</h5>
                    <h5>Ciudad: ${response.empleado.ciudad}</h5>
                    <h5>Dirección: ${response.empleado.direccion}</h5>
                    <h5>Celular: ${response.empleado.celular}</h5>
                    <h5>Correo: ${response.empleado.correo}</h5>
                </div>
            </div>`)

                $('#detalleModal').modal('show');
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar los detalles del empleado:', error);
            }
            });


    }
    function cerrar(){
        $('#detalleModal').modal('hide');
    }


</script>

@endsection
