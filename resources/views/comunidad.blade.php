<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comunidades</title>
    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/iglesia.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    
    <!-- Incluir jsPDF versión 2.4.0 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

    <!-- Incluir html2canvas -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>

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
                <!-- Título -->
                <div class="col-auto">
                <!-- Coloca aquí la imagen correspondiente a 'Detalles Generales' -->
                <img src="{{ asset('vendor/adminlte/dist/img/general2.png') }}" style="width: 190px; height: 190px;">
            </div>
                <div class="col text-center">
                    <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 65px; text-shadow: 2px 2px rgba(72, 201, 176, 0.8); letter-spacing: 1px;">
                        Registros de Comunidades
                    </h1>
                </div>
                <!-- Botón Nuevo -->
                <div class="col-auto">
                <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 13; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
                    <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white;" data-bs-toggle="modal" data-bs-target="#nuevoComunidadModal">
                        <i class="fas fa-plus"></i> Nueva Comunidad
                    </button>
                    @endif
                </div>
            </div>

            <div class="container mt-5">
                <!-- Tabla de Comunidades -->
                @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
                <table id="comunidadesTable" class="table table-striped">
                    <thead >
                        <tr>
                            <th style="background-color:#48C9B0; color: black; text-align: center;">Código Comunidad</th>
                            <th style="background-color:#48C9B0; color: black; text-align: center;">Nombre Comunidad</th>
                            <th class="d-none">Dirección</th>
                            <th style="background-color:#48C9B0; color: black; text-align: center;">Cantidad de Familias</th>
                            <th style="background-color:#48C9B0; color: black; text-align: center;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($comunidades as $comunidad)
                            <tr>
                                <td  style=" text-align: center"> {{ $comunidad['COD_COMUNIDAD'] }}</td>
                                <td style=" text-align: center">{{ $comunidad['NOM_COMUNIDAD'] }}</td>
                                <td class="d-none">{{ $comunidad['DIRECC_COMUNIDAD'] }}</td>
                                <td style=" text-align: center">{{ $comunidad['CANT_FAMILIAS'] }}</td>
                                <td style=" text-align: center">
                                    <button class="btn btn-info btn-sm btn-detalles" data-codigo="{{ $comunidad['COD_COMUNIDAD'] }}" data-nombre="{{ $comunidad['NOM_COMUNIDAD'] }}" data-direccion="{{ $comunidad['DIRECC_COMUNIDAD'] }}" data-cantidad="{{ $comunidad['CANT_FAMILIAS'] }}">
                                        <i class="fas fa-info-circle"></i> Detalles
                                    </button>
                                    @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                                    <button class="btn btn-warning btn-sm btn-modificar" data-codigo="{{ $comunidad['COD_COMUNIDAD'] }}" data-nombre="{{ $comunidad['NOM_COMUNIDAD'] }}" data-direccion="{{ $comunidad['DIRECC_COMUNIDAD'] }}" data-cantidad="{{ $comunidad['CANT_FAMILIAS'] }}">
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

            <!-- Modal para Nueva Comunidad -->
            <div class="modal fade" id="nuevoComunidadModal" tabindex="-1" aria-labelledby="nuevoComunidadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
                    <div class="modal-content border-warning">
                        <!-- Encabezado del Modal -->
                        <div class="modal-header" style="background-color: #48C9B0; color: white;">
                            <h5 class="modal-title d-flex align-items-center fw-bold" id="nuevoComunidadModalLabel">
                                <i class="fas fa-plus me-2"></i> NUEVA COMUNIDAD
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <!-- Cuerpo del Modal -->
                        <div class="modal-body">
                            <form class="row g-3 needs-validation" id="nuevoComunidadForm" novalidate method="POST" action="{{ url('/Comunidad_INS') }}">
                                @csrf
                                <div class="col-md-6">
                                    <label for="NOM_COMUNIDAD" class="form-label">Nombre de la Comunidad</label>
                                    <input type="text" class="form-control" id="NOM_COMUNIDAD" name="NOM_COMUNIDAD" maxlength="100" required>
                                    <div class="invalid-feedback">Por favor, ingrese el nombre de la comunidad.</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="DIRECC_COMUNIDAD" class="form-label">Dirección</label>
                                    <input type="text" class="form-control" id="DIRECC_COMUNIDAD" name="DIRECC_COMUNIDAD" maxlength="200" required>
                                    <div class="invalid-feedback">Por favor, ingrese la dirección de la comunidad.</div>
                                </div>
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Guardar
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

            <!-- Modal para Detalles de Comunidad -->
            <div class="modal fade" id="detallesComunidadModal" tabindex="-1" aria-labelledby="detallesComunidadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header" style="background-color: #48C9B0; color: white;">
                            <h5 class="modal-title" id="detallesComunidadModalLabel">
                                <i class="fas fa-info-circle me-2"></i> Detalles de Comunidad
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div id="comunidadDetalles"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal para Modificar Comunidad -->
            <div class="modal fade" id="modificarComunidadModal" tabindex="-1" aria-labelledby="modificarComunidadModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 40%;">
                    <div class="modal-content border-warning">
                        <div class="modal-header" style="background-color: #48C9B0; color: white;">
                            <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarComunidadModalLabel">
                                <i class="fas fa-edit me-2"></i> MODIFICAR COMUNIDAD
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <form id="modificarComunidadForm" class="row g-3 needs-validation" novalidate method="POST" action="{{ route('comunidad.update', ['id' => $comunidad['COD_COMUNIDAD']]) }}">
    

                        @csrf
                                @method('PUT')
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modificarComunidadId" class="form-label">Código Comunidad</label>
                                        <input type="text" class="form-control" id="modificarComunidadId" name="COD_COMUNIDAD" style="width: 100%; pointer-events: none;" required>
                                        <div class="invalid-feedback">El código de la comunidad es obligatorio.</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="modificarCantidad" class="form-label">Cantidad de Familias</label>
                                        <input type="number" class="form-control" id="modificarCantidad" name="CANT_FAMILIAS" style="width: 100%; pointer-events: none;" required>
                                        <div class="invalid-feedback">Por favor, ingrese la cantidad de familias.</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="modificarNombre" class="form-label">Nombre de la Comunidad</label>
                                        <input type="text" class="form-control" id="modificarNombre" name="NOM_COMUNIDAD" maxlength="100" required>
                                        <div class="invalid-feedback">Por favor, ingrese el nombre de la comunidad.</div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="mb-3">
                                        <label for="modificarDireccion" class="form-label">Dirección</label>
                                        <input type="text" class="form-control" id="modificarDireccion" name="DIRECC_COMUNIDAD" maxlength="200" required>
                                        <div class="invalid-feedback">Por favor, ingrese la dirección de la comunidad.</div>
                                    </div>
                                </div>
                             
                                <div class="col-md-12 text-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save"></i> Guardar Cambios
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
        </div>

        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <!-- Custom Script -->
        <script>
            $(document).ready(function() {
                var table = $('#comunidadesTable').DataTable({
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

                // Evento para abrir modal de detalles
                $('#comunidadesTable').on('click', '.btn-info', function () {
                    var data = table.row($(this).closest('tr')).data();
                    $('#comunidadDetalles').html(`
                        <p><strong>Código Comunidad:</strong> ${data[0]}</p>
                        <p><strong>Nombre Comunidad:</strong> ${data[1]}</p>
                        <p><strong>Dirección:</strong> ${data[2]}</p>
                        <p><strong>Cantidad de Familias:</strong> ${data[3]}</p>
                    `);
                    $('#detallesComunidadModal').modal('show');
                });

                // Evento para abrir modal de modificación
                $('#comunidadesTable').on('click', '.btn-warning', function () {
                    var data = table.row($(this).closest('tr')).data();
                    $('#modificarComunidadId').val(data[0]);
                    $('#modificarNombre').val(data[1]);
                    $('#modificarDireccion').val(data[2]);
                    $('#modificarCantidad').val(data[3]);
                    $('#modificarComunidadModal').modal('show');
                });

                // Enviar formulario de modificación
              

                // Validaciones del formulario
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
                            }, false)
                        })
                })();

                // Funciones adicionales de validación
                function validateInput(input) {
                    input.addEventListener('input', function () {
                        this.value = this.value.replace(/[^a-zA-Z0-9\s]/g, ''); // Eliminar caracteres especiales
                        if (this.value.length > 100) {
                            this.value = this.value.slice(0, 100); // Limitar a 100 caracteres
                        }
                    });
                    input.addEventListener('paste', function (e) {
                        e.preventDefault(); // Desactivar pegado
                    });
                    input.addEventListener('copy', function (e) {
                        e.preventDefault(); // Desactivar copiado
                    });
                    input.addEventListener('cut', function (e) {
                        e.preventDefault(); // Desactivar corte
                    });
                }

                // Aplicar validación a todos los campos
                validateInput(document.querySelector('#NOM_COMUNIDAD'));
                validateInput(document.querySelector('#DIRECC_COMUNIDAD'));
                validateInput(document.querySelector('#modificarNombre'));
                validateInput(document.querySelector('#modificarDireccion'));
            });
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
