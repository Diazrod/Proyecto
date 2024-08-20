<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipo de Eventos</title>
    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/iglesia.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">

    <style>
        th {
            background-color: #48C9B0 !important;
            color: black !important;
            font-size: 1.20rem; /* Tamaño de fuente para los encabezados */
        }
        input.form-control {
            border-color: #48C9B0; /* Color del borde del input */
        }
        .dataTables_wrapper .dataTables_paginate .paginate_button.current, 
        .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
            background-color: #48C9B0 !important;
            color: white !important;
            border-color: #48C9B0 !important;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .btn-close-red {
        background-color: red;
    }
    </style>

@vite(['resources/sass/app.scss', 'resources/js/app.js'])

@extends('adminlte::page')

@section('title', 'Tipo de Evento')

@section('plugins.Datatables', true)

</head>
<body>

@section('content_header')
@stop

@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <!-- Título -->
            <div class="col text-center">
                <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 65px; text-shadow: 2px 2px rgba(72, 201, 176, 0.8); letter-spacing: 1px;">
                    Tipo de Eventos
                </h1>
            </div>
            <!-- Botón Nuevo -->
            <div class="col-auto">
                <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white;" data-bs-toggle="modal" data-bs-target="#nuevoTipoEventoModal">
                    <i class="fas fa-plus"></i> Nuevo Tipo de Eventos
                </button>
            </div>
        </div>

        <div class="container mt-5">
            <!-- Tabla de Tipos de Proyectos -->
            <table id="tipoEventosTable" class="table table-striped">
                <thead style="background-color: #48C9B0; color: white;">
                    <tr>
                        <th>Código</th>
                        <th>Nombre</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ResulEventos as $tipo_eventos)
                        <tr>
                            <td>{{ $tipo_eventos['COD_TIP_EVENTO'] }}</td>
                            <td>{{ $tipo_eventos['NOMBRE'] }}</td>
                            <td>
                                <button class="btn btn-warning btn-sm" onclick="mostrarModificar('{{ $tipo_eventos['COD_TIP_EVENTO'] }}', '{{ $tipo_eventos['NOMBRE'] }}')">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

            <!-- Modal para Nuevo Tipo de Evento -->
        <div class="modal fade" id="nuevoTipoEventoModal" tabindex="-1" aria-labelledby="nuevoTipoEventoModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 30%;">
                <div class="modal-content border-warning">
                    <!-- Encabezado del Modal -->
                    <div class="modal-header" style="background-color: #48C9B0; color: white;">
                        <h5 class="modal-title d-flex align-items-center fw-bold" id="nuevoTipoEventoModalLabel">
                            <i class="fas fa-plus me-2"></i> NUEVO TIPO DE EVENTO
                        </h5>
                    </div>
                    <!-- Cuerpo del Modal -->
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" id="nuevoTipoEventoForm" novalidate method="POST" action="{{ url('/crearEvento') }}">
                         
                        @csrf
                            <div class="col-md-12">
                                <label for="NOMBRE" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" maxlength="50" 
                                    required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                                    onpaste="return false;">
                                <div class="invalid-feedback">
                                    Por favor ingrese el nombre del tipo de evento.
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button id="btnGuardar" class="btn btn-success text-white" type="submit">
                                    <i class="fas fa-save me-2"></i> Guardar
                                </button>
                                <button type="button" class="btn" style="background-color: #e74c3c; color: white; border: none;" data-bs-dismiss="modal">
                                    <i class="fas fa-times"></i> Cerrar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Modificar Tipo de Proyecto -->
        <div class="modal fade" id="modificarTipoEventoModal" tabindex="-1" aria-labelledby="modificarTipoEventoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 30%;">
                    <div class="modal-content border-warning">
                        <div class="modal-header" style="background-color: #48C9B0; color: white;">
                            <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarTipoEventoModalLabel">
                                <i class="fas fa-edit me-2"></i> MODIFICAR TIPO DE EVENTO
                            </h5>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3 needs-validation" id="modificarTipoEventoForm" novalidate method="POST"  action="{{ route('updateTipo_evento', ['id' => $tipo_eventos['COD_TIP_EVENTO']]) }}"  >
                                @csrf
                                @method('PUT')
                                <div class="col-md-3">
                                    <label for="MODIFICAR_COD_TIP_EVENTO" class="form-label">Codigo</label>       
                                    <input type="text" class="form-control"  id="MODIFICAR_COD_TIP_EVENTO" name="COD_TIP_EVENTO" style="width: 100%; pointer-events: none;" >
                                    <div class="invalid-feedback">
                                        Por favor ingrese el nombre del tipo de proyecto.
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <label for="MODIFICAR_NOMBRE" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="MODIFICAR_NOMBRE" maxlength="50" name="NOMBRE" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese el nombre del tipo de proyecto.
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <button id="btnModificar" class="btn btn-success text-white" type="submit">
                                        <i class="fas fa-save me-2"></i> Guardar Cambios
                                    </button>
                                    <button type="button" class="btn" style="background-color: #e74c3c; color: white; border: none;" data-bs-dismiss="modal">
                                        <i class="fas fa-times"></i> Cerrar
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

    </div>
@stop

@section('css')
@stop

@section('js')
<script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>


    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

<script>

$(document).ready(function(){
            $('#tipoEventosTable').DataTable({
                "language": {
                    "search": "Buscar",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "paginate": { 
                        "previous": "Anterior",
                        "next" : "Siguiente",
                        "first": "Primero",
                        "last": "Último"
                    }
                }
            });
        });

        (function () {
        'use strict'
        var forms = document.querySelectorAll('.needs-validation')

        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                    var elements = form.querySelectorAll('.form-control, .form-select')
                    elements.forEach(function(element) {
                        if (element.value === "" && element.required) {
                            element.classList.add('border-danger')
                            element.classList.remove('border-success')
                        } else {
                            element.classList.add('border-success')
                            element.classList.remove('border-danger')
                        }
                    })
                }, false)
            })
    })()

    document.addEventListener('DOMContentLoaded', function() {
        var btnGuardar = document.getElementById('btnGuardar');
        if (btnGuardar) {
            btnGuardar.addEventListener('click', function(event) {
                var form = document.getElementById('nuevoTipoEventoForm');
                if (form.checkValidity() === false) {
                    event.preventDefault(); // Evitar que se envíe el formulario si no es válido
                    event.stopPropagation(); // Detener la propagación del evento
                }
            form.classList.add('was-validated'); // Agregar la clase para activar los estilos de validación
            });
        }
    });



document.addEventListener('DOMContentLoaded', function() {
  var btnGuardar = document.getElementById('btnModificar');
  if (btnGuardar) {
    btnGuardar.addEventListener('click', function(event) {
      var form = document.getElementById('modificarTipoEventoForm');
      if (form.checkValidity() === false) {
        event.preventDefault(); // Evitar que se envíe el formulario si no es válido
        event.stopPropagation(); // Detener la propagación del evento
      }
      form.classList.add('was-validated'); // Agregar la clase para activar los estilos de validación
    });
  }
});

document.getElementById('NOMBRE').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
});

</script>
</script>

        <script>
            $(document).ready(function () {
                $('#tipoEventoTable').DataTable({
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.5/i18n/es.json'
                    }
                });
            });

            function mostrarDetalles(codigo, nombre) {
                $('#detalleCodigo').text(codigo);
                $('#detalleNombre').text(nombre);
                $('#verDetallesModal').modal('show');
            }

            function mostrarModificar(codigo, nombre) {
                $('#MODIFICAR_COD_TIP_EVENTO').val(codigo);
                $('#MODIFICAR_NOMBRE').val(nombre);
                $('#modificarTipoEventoModal').modal('show');
            }

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}'
                });
            @elseif (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: '{{ session('error') }}'
                });
            @endif
        </script>
    @stop
</body>
</html>
