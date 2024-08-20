<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parroquia SMP - Permisos</title>
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
        .form-check-input:checked {
            background-color: green;
            border-color: green;
        }
        .form-check-input:not(:checked) {
            background-color: red;
            border-color: red;
        }
    </style>
</head>
<body>

@extends('adminlte::page')

@section('title', 'Permisos')

@section('content_header')
    <h1>Permisos</h1>
@endsection

@section('content')
    <div class="container">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createPermisoModal">Crear Permiso</button>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <table id="example" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rol</th>
                    <th>Objeto</th>
                    <th>Modulo</th>
                    <th>Consultar</th>
                    <th>Crear</th>
                    <th>Actualizar</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permisos as $permiso)
                    <tr>
                        <td>{{ $permiso->COD_PERMISOS }}</td>
                        <td>{{ $permiso->role ? $permiso->role->NOM_ROL : 'Sin Rol' }}</td>
                        <td>{{ $permiso->objeto ? $permiso->objeto->NOM_OBJETO : 'Sin Objeto' }}</td>
                        <td>{{ $permiso->IND_MODULO == '1' ? 'Sí' : 'No' }}</td>
                        <td>{{ $permiso->IND_SELECT == '1' ? 'Sí' : 'No' }}</td>
                        <td>{{ $permiso->IND_INSERT == '1' ? 'Sí' : 'No' }}</td>
                        <td>{{ $permiso->IND_UPDATE == '1' ? 'Sí' : 'No' }}</td>
                        <td>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#editPermisoModal-{{ $permiso->COD_PERMISOS }}">Editar</button>
                            <form action="{{ route('permisos.destroy', $permiso->COD_PERMISOS) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Permiso Modal -->
                    <div class="modal fade" id="editPermisoModal-{{ $permiso->COD_PERMISOS }}" tabindex="-1" role="dialog" aria-labelledby="editPermisoModalLabel-{{ $permiso->COD_PERMISOS }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPermisoModalLabel-{{ $permiso->COD_PERMISOS }}">Editar Permiso</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('permisos.update', $permiso->COD_PERMISOS) }}" method="POST" class="needs-validation" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="COD_ROL">Rol</label>
                                            <select name="COD_ROL" id="COD_ROL" class="form-control">
                                                @foreach($roles as $rol)
                                                    <option value="{{ $rol->COD_ROL }}" {{ $permiso->COD_ROL == $rol->COD_ROL ? 'selected' : '' }}>
                                                        {{ $rol->NOM_ROL }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="COD_OBJETO">Objeto</label>
                                            <select name="COD_OBJETO" id="COD_OBJETO" class="form-control">
                                                @foreach($objetos as $objeto)
                                                    <option value="{{ $objeto->COD_OBJETO }}" {{ $permiso->COD_OBJETO == $objeto->COD_OBJETO ? 'selected' : '' }}>
                                                        {{ $objeto->NOM_OBJETO }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="IND_MODULO" id="IND_MODULO" class="form-check-input" value="1" {{ $permiso->IND_MODULO == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="IND_MODULO">Gestionar Modulo</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="IND_SELECT" id="IND_SELECT" class="form-check-input" value="1" {{ $permiso->IND_SELECT == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="IND_SELECT">Consultar Registro</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="IND_INSERT" id="IND_INSERT" class="form-check-input" value="1" {{ $permiso->IND_INSERT == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="IND_INSERT">Crear Registro</label>
                                        </div>
                                        <div class="form-group form-check">
                                            <input type="checkbox" name="IND_UPDATE" id="IND_UPDATE" class="form-check-input" value="1" {{ $permiso->IND_UPDATE == '1' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="IND_UPDATE">Actualizar Registro</label>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                                            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Permiso Modal -->
<div class="modal fade" id="createPermisoModal" tabindex="-1" role="dialog" aria-labelledby="createPermisoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createPermisoModalLabel">Crear Permiso</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('permisos.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="COD_ROL">Rol</label>
                        <select name="COD_ROL" id="COD_ROL" class="form-control" required>
                            @foreach($roles as $rol)
                                <option value="{{ $rol->COD_ROL }}">{{ $rol->NOM_ROL }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="COD_OBJETO">Objeto</label>
                        <select name="COD_OBJETO" id="COD_OBJETO" class="form-control" required>
                            @foreach($objetos as $objeto)
                                <option value="{{ $objeto->COD_OBJETO }}">{{ $objeto->NOM_OBJETO }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Checkbox for selecting all permissions -->
                    <div class="form-group">
                        <label for="select_all">Seleccionar Todos los Permisos</label>
                        <input type="checkbox" id="select_all">
                    </div>

                    <div class="form-group">
                        <label for="IND_MODULO">Permiso del Modelo</label>
                        <input type="checkbox" name="IND_MODULO" id="IND_MODULO" value="1">
                    </div>
                    <div class="form-group">
                        <label for="IND_SELECT">Permiso de Consultar</label>
                        <input type="checkbox" name="IND_SELECT" id="IND_SELECT" value="1">
                    </div>
                    <div class="form-group">
                        <label for="IND_INSERT">Permiso de Crear</label>
                        <input type="checkbox" name="IND_INSERT" id="IND_INSERT" value="1">
                    </div>
                    <div class="form-group">
                        <label for="IND_UPDATE">Permiso de Modificar</label>
                        <input type="checkbox" name="IND_UPDATE" id="IND_UPDATE" value="1">
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection

@section('css')
@stop

@section('js')
<script>
    document.getElementById('select_all').addEventListener('change', function() {
        let checkboxes = document.querySelectorAll('#createPermisoModal input[type="checkbox"]');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
</script>
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
        $(document).ready(function() {
            $('#example').DataTable({
                "language": {
                    "search": "Buscar",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente",
                        "first": "Primero",
                        "last": "Último"
                    }
                }
            });
        });

        (function () {
            'use strict'

            // Validación para evitar números y caracteres especiales en campos de texto
            function validateTextInput(event) {
                const pattern = /^[a-zA-Z\s]*$/;
                if (!pattern.test(event.key)) {
                    event.preventDefault();
                }
            }

            // Desactivar copiar/pegar
            function disableCopyPaste(event) {
                event.preventDefault();
            }

            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')

            // Loop over them and prevent submission
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

            // Aplicar validaciones adicionales a campos de texto
            var textInputs = document.querySelectorAll('input[type="text"]');
            textInputs.forEach(function (input) {
                input.addEventListener('keypress', validateTextInput);
                input.addEventListener('paste', disableCopyPaste);
                input.addEventListener('copy', disableCopyPaste);
                input.addEventListener('cut', disableCopyPaste);
            });

            // Desactivar copiar/pegar en todos los campos de entrada
            var allInputs = document.querySelectorAll('input, textarea');
            allInputs.forEach(function (input) {
                input.addEventListener('paste', disableCopyPaste);
                input.addEventListener('copy', disableCopyPaste);
                input.addEventListener('cut', disableCopyPaste);
            });
        })()
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
