<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Finanzas</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
    
    </style>

@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content_header')
@stop
</head>
<body>
   

    @section('content')
    <div class="content">
        
   
    <div class="d-flex justify-content-between mb-3 align-items-center">
        <!-- Título -->
        <div class="col text-center">
            <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 65px; text-shadow: 2px 2px rgba(48, 201, 176, 0.8); letter-spacing: 1px;">
                Datos de Cuenta
            </h1>
        </div>
        <!-- Botón Nuevo -->
        <div class="col-auto">
        <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 14; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
            <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white; border: 2px solid white; box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);" data-bs-toggle="modal" data-bs-target="#newRecordModal">
                <i class="fas fa-plus"></i> Nuevo Registro
            </button>
            @endif
        </div>
    </div>
</div>










        
        <!-- Mostrar mensaje de error si existe -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="table-responsive">
        @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
            <table id="cuentaTable" class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-codigo">COD_CUENTA</th>
                        <th class="col-nombre">NOMBRE</th>
                        <th class="col-tipo">TIPO_CUENTA</th>
                        <th class="col-acciones">ACCIONES</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ResultadosCuenta as $cuenta)
                        <tr>
                            <td>{{ $cuenta['COD_CUENTA'] }}</td>
                            <td>{{ $cuenta['NOMBRE'] }}</td>
                            <td>{{ $cuenta['TIPO_CUENTA'] }}</td>
                            <td>
                            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editRecordModal" data-cuenta-id="{{ $cuenta['COD_CUENTA'] }}" data-cuenta-nombre="{{ $cuenta['NOMBRE'] }}" data-cuenta-tipo="{{ $cuenta['TIPO_CUENTA'] }}">
                                    Modificar
                                </button>
                             @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    <!-- Modal para nuevo registro -->
    <div class="modal fade" id="newRecordModal" tabindex="-1" aria-labelledby="newRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content"
     style="
         border: 4px solid #48C9B0; /* Borde grueso con el color deseado */
         box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); /* Reflexión blanca */
     ">
                <div class="modal-header">
                <h5 class="modal-title" id="newRecordModalLabel">
        <i class="fas fa-plus"></i> <strong>Nuevo Registro Cuenta</strong>
    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('crear.Cuenta') }}" method="POST" id="newRecordForm" class="needs-validation" novalidate>
                        @csrf


                        <div class="d-flex justify-content-between mb-3">
    <div class="flex-fill me-2">
        <label for="newNombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="newNombre" name="nombre" required>
        <div class="invalid-feedback">
            Por favor ingrese el nombre.
        </div>
    </div>
    <div class="flex-fill ms-2">
        <label for="newTipo" class="form-label">Tipo de Cuenta</label>
        <select class="form-select" id="newTipo" name="tipo_cuenta" required>
            <option value="INGRESO">Ingreso</option>
            <option value="EGRESO">Egreso</option>
        </select>
        <div class="invalid-feedback">
            Por favor seleccione el tipo de cuenta.
        </div>
    </div>
</div>



<div class="d-flex justify-content-center mb-3">
    <button type="submit" class="btn btn-success me-2">
        <i class="fas fa-save"></i> Guardar
    </button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
        <i class="fas fa-times"></i> Cancelar
    </button>
</div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para modificar registro -->
    <div class="modal fade" id="editRecordModal" tabindex="-1" aria-labelledby="editRecordModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content"
     style="
         border: 4px solid #48C9B0; /* Borde grueso con el color deseado */
         box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); /* Reflexión blanca */
     ">
                <div class="modal-header">
                <h5 class="modal-title" id="editRecordModalLabel">
        <i class="fas fa-pencil-alt"></i> <strong>Modificar Registro Cuenta</strong>
    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <form id="editRecordForm" class="needs-validation" novalidate method="POST" action="{{ route('cuenta.update', ['id' => $cuenta['COD_CUENTA']]) }}">
    @csrf
    @method('PUT')

                       
                        <div class="row">
    <div class="col-md-3 mb-2">
        <label for="editCuentaId" class="form-label">ID Cuenta</label>
        <input type="text" class="form-control" id="editCuentaId" name="cuenta_id" required>
    </div>
    <div class="col-md-6 mb-4">
        <label for="editNombre" class="form-label">Nombre</label>
        <input type="text" class="form-control" id="editNombre" name="nombre" required>
        <div class="invalid-feedback">
            Por favor ingrese el nombre.
        </div>
    </div>
    <div class="col-md-3 mb-3">
        <label for="editTipo" class="form-label">Tipo </label>
        <select class="form-select" id="editTipo" name="tipo_cuenta" required>
            <option value="INGRESO">Ingreso</option>
            <option value="EGRESO">Egreso</option>
        </select>
        <div class="invalid-feedback">
            Por favor seleccione el tipo de cuenta.
        </div>
    </div>
</div>

<div class="modal-footer">
    <!-- Botón Guardar Cambios -->
    <button type="submit" class="btn btn-success">
        <i class="fas fa-save"></i> Guardar Cambios
    </button>

    <!-- Botón Cancelar -->
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
        <i class="fas fa-times"></i> Cancelar
    </button>
</div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @stop

    @section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    @stop

    @section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            $('#cuentaTable').DataTable({
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json"
                },
                "pagingType": "full_numbers",
                "pageLength": 10,
            });

            // Inicialización de los modales
            const editModal = new bootstrap.Modal(document.getElementById('editRecordModal'));
            const newRecordModal = new bootstrap.Modal(document.getElementById('newRecordModal'));

            $('#cuentaTable').on('click', 'button.btn-warning', function () {
                const row = $(this).closest('tr');
                const id = row.find('td:eq(0)').text();
                const nombre = row.find('td:eq(1)').text();
                const tipo = row.find('td:eq(2)').text();

                $('#editCuentaId').val(id);
                $('#editNombre').val(nombre);
                $('#editTipo').val(tipo);

                editModal.show();
            });

            $('#newRecordForm').on('submit', function (e) {
                e.preventDefault();

                const form = $(this);
                if (form[0].checkValidity() === false) {
                    e.stopPropagation();
                } else {
                    Swal.fire({
                        title: 'Confirmar',
                        text: '¿Está seguro de que desea guardar este registro?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.off('submit').submit();
                        }
                    });
                }
                form.addClass('was-validated');
            });

            $('#editRecordForm').on('submit', function (e) {
                e.preventDefault();

                const form = $(this);
                if (form[0].checkValidity() === false) {
                    e.stopPropagation();
                } else {
                    Swal.fire({
                        title: 'Confirmar',
                        text: '¿Está seguro de que desea guardar los cambios?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, guardar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.off('submit').submit();
                        }
                    });
                }
                form.addClass('was-validated');
            });
        });
    </script>
    @stop
</body>
</html>
