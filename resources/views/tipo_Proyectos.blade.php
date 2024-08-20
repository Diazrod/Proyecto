<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tipo de Proyectos</title>
    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/iglesia.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">

    @extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content_header')
@stop
</head>
<body>
    @section('content_header')
    @stop

    @section('content')
        <div class="container mt-4">
            <div class="d-flex justify-content-between mb-3 align-items-center">
            <div class="col-auto">
                <!-- Coloca aquí la imagen correspondiente a 'Detalles Generales' -->
                <img src="{{ asset('vendor/adminlte/dist/img/general2.png') }}" style="width: 190px; height: 190px;">
            </div>
            <!-- Título -->
                <div class="col text-center">
                    <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 60px; text-shadow: 2px 2px rgba(72, 201, 176, 0.8); letter-spacing: 1px;">
                        Tipo de Proyectos
                    </h1>
                </div>
                <!-- Botón Nuevo -->
                <div class="col-auto">
                <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 17; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
                    <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white;" data-bs-toggle="modal" data-bs-target="#nuevoTipoProyectoModal">
                        <i class="fas fa-plus"></i> Nuevo Tipo de Proyecto
                    </button>
                    @endif
                </div>
            </div>

            <div class="container mt-5">
                <!-- Tabla de Tipos de Proyectos -->
                @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
                <table id="tipoProyectosTable1" class="table table-striped">
                    <thead >
                        <tr>
                            <th style="background-color:#48C9B0; color: black; text-align: center;">Código</th>
                            <th style="background-color:#48C9B0; color: black; text-align: center;">Nombre</th>
                            <th style="background-color:#48C9B0; color: black; text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Tipo as $tipo)
                            <tr>
                                <td style=" text-align: center">{{ $tipo['COD_TIPO_PROYECTO'] }}</td>
                                <td style=" text-align: center">{{ $tipo['NOMBRE'] }}</td>
                                <td style=" text-align: center">
                                @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                                    <button class="btn btn-warning btn-sm" onclick="mostrarModificar('{{ $tipo['COD_TIPO_PROYECTO'] }}', '{{ $tipo['NOMBRE'] }}')">
                                        <i class="fas fa-edit"></i> Modificar
                                    </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @endif
            </div>

            <!-- Modal para Nuevo Tipo de Proyecto -->
            <div class="modal fade" id="nuevoTipoProyectoModal" tabindex="-1" aria-labelledby="nuevoTipoProyectoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 30%;">
                    <div class="modal-content border-warning">
                        <!-- Encabezado del Modal -->
                        <div class="modal-header" style="background-color: #48C9B0; color: white;">
                            <h5 class="modal-title d-flex align-items-center fw-bold" id="nuevoTipoProyectoModalLabel">
                                <i class="fas fa-plus me-2"></i> NUEVO TIPO DE PROYECTO
                            </h5>
                        </div>
                        <!-- Cuerpo del Modal -->
                        <div class="modal-body">
                            <form class="row g-3 needs-validation" id="nuevoTipoProyectoForm" novalidate method="POST" action="{{ url('/Tipo_INS') }}">
                             
                 
                            
                            
                            @csrf

                                <div class="col-md-12">
                                    <label for="NOMBRE" class="form-label">Nombre</label>
                                    <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" maxlength="100" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese el nombre del tipo de proyecto.
                                    </div>
                                </div>

                                <div class="col-12 text-center">
                                    <button id="btnGuardar" class="btn btn-success text-white" type="submit">
                                        <i class="fas fa-save me-2"></i> Guardar
                                    </button>
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button> 

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Ver Detalles -->
            <div class="modal fade" id="verDetallesModal" tabindex="-1" aria-labelledby="verDetallesModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-ml">
                    <div class="modal-content border-info">
                        <div class="modal-header" style="background-color: #48C9B0; color: white;">
                            <h5 class="modal-title d-flex align-items-center fw-bold" id="verDetallesModalLabel">
                                <i class="fas fa-info-circle me-2"></i> DETALLES DEL TIPO DE PROYECTO
                            </h5>
                        </div>
                        <div class="modal-body">
                            <table class="table table-sm">
                                <tbody>
                                    <tr>
                                        <th>Código:</th>
                                        <td id="detalleCodigo"></td>
                                    </tr>
                                    <tr>
                                        <th>Nombre:</th>
                                        <td id="detalleNombre"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" style="background-color: #e74c3c; color: white; border: none;" data-bs-dismiss="modal">
                                <i class="fas fa-times"></i> Cerrar
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Modificar Tipo de Proyecto -->
            <div class="modal fade" id="modificarTipoProyectoModal" tabindex="-1" aria-labelledby="modificarTipoProyectoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 30%;">
                    <div class="modal-content border-warning">
                        <div class="modal-header" style="background-color: #48C9B0; color: white;">
                            <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarTipoProyectoModalLabel">
                                <i class="fas fa-edit me-2"></i> MODIFICAR TIPO DE PROYECTO
                            </h5>
                        </div>
                        <div class="modal-body">
                            <form class="row g-3 needs-validation" id="modificarTipoProyectoForm" novalidate method="POST"  action="{{ route('tipo.update', ['id' => $tipo['COD_TIPO_PROYECTO']]) }}"  >
                                @csrf
                                @method('PUT')



                               

                                <div class="col-md-3">
                                    <label for="MODIFICAR_NOMBRE" class="form-label">Codigo</label>
                                    
                                    <input type="text" class="form-control"  id="MODIFICAR_COD_TIPO_PROYECTO" name="COD_TIPO_PROYECTO" style="width: 100%; pointer-events: none;" >
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
                                    <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button> 
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <style>
                .table th, .table td {
                    border: none;
                }
                .table {
                    margin-bottom: 0;
                }
            </style>
        </div>
    @stop

    @section('js')
        <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        

        <script>
    $(document).ready(function() {
        var table = $('#tipoProyectosTable1').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
        }); 
    });
</script>



        <script>



document.addEventListener('DOMContentLoaded', function() {
  var btnGuardar = document.getElementById('btnGuardar');
  if (btnGuardar) {
    btnGuardar.addEventListener('click', function(event) {
      var form = document.getElementById('nuevoTipoProyectoForm');
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
      var form = document.getElementById('modificarTipoProyectoForm');
      if (form.checkValidity() === false) {
        event.preventDefault(); // Evitar que se envíe el formulario si no es válido
        event.stopPropagation(); // Detener la propagación del evento
      }
      form.classList.add('was-validated'); // Agregar la clase para activar los estilos de validación
    });
  }
});




</script>


        <script>
document.getElementById('NOMBRE').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9ñÑ]/g, '');
});


</script>









        <script>
            $(document).ready(function () {
                $('#tipoProyectosTable').DataTable({
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
                $('#MODIFICAR_COD_TIPO_PROYECTO').val(codigo);
                $('#MODIFICAR_NOMBRE').val(nombre);
                $('#modificarTipoProyectoModal').modal('show');
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
    @section('footer')
<!-- Footer -->
<footer class="mt-5">
    <div class="text-center p-3">
        &copy; 2024 Parroquia SMP. Todos los derechos reservados.
    </div>
</footer>
@endsection
</body>
</html>
