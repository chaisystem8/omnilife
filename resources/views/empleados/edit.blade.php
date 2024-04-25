@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <h1>Editar Empleado</h1>
                <a class="btn btn-danger" href="{{ route('empleados.index')}}"><span class="glyphicon glyphicon-pencil"></span> Regresar</a>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div>
                <form id="upload-form" enctype="multipart/form-data" method="POST" action="{{ route('empleados.update',$empleado->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="codigo">Código</label>
                        <input type="hidden" value="{{$empleado->codigo}}" id="codigoAux">
                        <input class="form-control" type="text" name="codigo" id="codigo" value="{{$empleado->codigo}}" required>
                        <div id="msg"></div>

                        <label for="nombre">Nombre</label>
                        <input class="form-control" type="text" name="nombre" id="nombre" value="{{$empleado->nombre}}" required>

                        <label for="salarioP">Salario en Pesos</label>
                        <input class="form-control" type="number" name="salarioP" id="salarioP" step="0.01" value="{{$empleado->salarioPesos}}" required>
                        <div id="loading" style="display: none;">
                            <div class="spinner-border text-primary" role="status">
                                <span class="sr-only"></span>
                            </div>
                        </div>
                        <label for="salarioD">Salario en Dólares</label>
                        <input class="form-control" type="number" name="salarioD" id="salarioD" step="0.01" value="{{$empleado->salarioDolares}}" readonly required>

                        <label for="estado">Estado</label>
                        <select id="estadosSelect" class="form-control" name="estado" required>
                            <option value="{{$empleado->estado}}">{{$empleado->estado}}</option>
                        </select>
                        <label for="ciudad">Ciudad</label>
                        <select id="municipiosSelect" class="form-control" name="ciudad" required>
                            <option value="{{$empleado->ciudad}}">{{$empleado->ciudad}}</option>
                        </select>
                        <label for="direccion">Dirección</label>
                        <input class="form-control" type="text" name="direccion" id="direccion" value="{{$empleado->direccion}}" required>
                        <label for="celular">Celular</label>
                        <input class="form-control" type="text" name="celular" id="celular" value="{{$empleado->celular}}" required>
                        <label for="correo">Correo</label>
                        <input class="form-control" type="email" name="correo" id="correo" value="{{$empleado->correo}}" >
                        @error('correo')
                            <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-flex justify-content-center pt-3">
                        <input id="btnSave" type="submit" value="Actualizar Empleado" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script src="https://cdn.datatables.net/2.0.5/js/dataTables.min.js" ></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>


    $(document).ready(function() {
        const salarioDolares = 0;
        $("#btnSave").prop('disabled', false);

    });

     $("#salarioP").blur(function() {
        ws();
    });

    $("#codigo").blur(function() {
        let codigoAux = $("#codigoAux").val();
    if (this.value != '' && this.value !== codigoAux) {
            $.ajax({
                url : `/api/empleados/${this.value}`,
                success : function(response) {
                    if(response == 1){ //Existe
                        $("#btnSave").prop('disabled', true);
                        $("#msg").html('<span class="badge bg-danger">Codigo no disponible</span>')
                    }else{
                            $("#btnSave").prop('disabled', false);
                            $("#msg").html('<span class="badge bg-success">Codigo disponible</span>')
                    }
                }
            });

        }else{
            $("#msg").html('')
            $("#btnSave").prop('disabled', false);
        }

    });


    function ws(){
        document.getElementById("loading").style.display = "block";
        $.ajax({
            url : "https://www.banxico.org.mx/SieAPIRest/service/v1/series/SF43718/datos/oportuno?token=ee21c3b0e6c564aa47aba4519bd515d68eb42559be293ebfd3104b6dd72fd770",
            jsonp : "callback",
            dataType : "jsonp", //Se utiliza JSONP para realizar la consulta cross-site
            success : function(response) {
                let tipoCambio = response.bmx.series[0].datos[0].dato
                salarioDolares = parseFloat(($("#salarioP").val() / tipoCambio).toFixed(2));
                $("#salarioD").val(salarioDolares);
                document.getElementById("loading").style.display = "none";
            }
        });
    }

    const estadosSelect = document.getElementById('estadosSelect');
    const municipiosSelect = document.getElementById('municipiosSelect');

    fetch('/estados.json')
        .then(response => response.json())
        .then(data => {
            data.forEach(estado => {
                const option = document.createElement('option');
                option.value = estado.nombre;
                option.textContent = estado.nombre;
                estadosSelect.appendChild(option);
            });
        })
        .catch(error => {
            console.error('Error al cargar los estados:', error);
        });

    estadosSelect.addEventListener('change', () => {
        municipiosSelect.innerHTML = ''; // Limpiar opciones anteriores
        const estadoSeleccionado = estadosSelect.value;

        fetch('/municipios.json')
            .then(response => response.json())
            .then(data => {
                const municipios = data[estadoSeleccionado];
                municipios.forEach(municipio => {
                    const option = document.createElement('option');
                    option.value = municipio;
                    option.textContent = municipio;
                    municipiosSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error al cargar los municipios:', error);
            });
    });
</script>

@endsection
