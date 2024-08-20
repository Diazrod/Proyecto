<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/iglesia.png') }}" type="image/x-icon">
    <title>Parroquia SMP</title>
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
</head>
<body>

@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content_header')
    <h1>Objetos</h1>
@endsection

@section('content')
    <div class="container">
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createObjetoModal">Crear Objeto</button>
        <table id="example" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Tipo</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($objetos as $objeto)
                    <tr>
                        <td>{{ $objeto->COD_OBJETO }}</td>
                        <td>{{ $objeto->NOM_OBJETO }}</td>
                        <td>{{ $objeto->TIP_OBJETO }}</td>
                        <td>{{ $objeto->DES_OBJETO }}</td>
                        <td>{{ $objeto->IND_OBJETO == '1' ? 'Activo' : 'Inactivo' }}</td>
                        <td>{{ $objeto->USR_ADD }}</td>
                        <td>
                            <button class="btn btn-warning" data-toggle="modal" data-target="#editObjetoModal-{{ $objeto->COD_OBJETO }}">Editar</button>
                            <form action="{{ route('objetos.destroy', $objeto->COD_OBJETO) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Eliminar</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit Objeto Modal -->
                    <div class="modal fade" id="editObjetoModal-{{ $objeto->COD_OBJETO }}" tabindex="-1" role="dialog" aria-labelledby="editObjetoModalLabel-{{ $objeto->COD_OBJETO }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editObjetoModalLabel-{{ $objeto->COD_OBJETO }}">Editar Objeto</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('objetos.update', $objeto->COD_OBJETO) }}" method="POST" class="needs-validation" novalidate>
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="NOM_OBJETO">Nombre del Objeto</label>
                                            <input type="text" name="NOM_OBJETO" id="NOM_OBJETO" class="form-control" value="{{ $objeto->NOM_OBJETO }}" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingrese el nombre del objeto.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="TIP_OBJETO">Tipo del Objeto</label>
                                            <input type="text" name="TIP_OBJETO" id="TIP_OBJETO" class="form-control" value="{{ $objeto->TIP_OBJETO }}" required>
                                            <div class="invalid-feedback">
                                                Por favor, ingrese el tipo del objeto.
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="DES_OBJETO">Descripción</label>
                                            <textarea name="DES_OBJETO" id="DES_OBJETO" class="form-control">{{ $objeto->DES_OBJETO }}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label for="IND_OBJETO">Estado</label>
                                            <select name="IND_OBJETO" id="IND_OBJETO" class="form-control">
                                                <option value="1" {{ $objeto->IND_OBJETO == '1' ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ $objeto->IND_OBJETO == '0' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                        </div>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Create Objeto Modal -->
    <div class="modal fade" id="createObjetoModal" tabindex="-1" role="dialog" aria-labelledby="createObjetoModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createObjetoModalLabel">Crear Objeto</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('objetos.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="form-group">
                            <label for="NOM_OBJETO">Nombre del Objeto</label>
                            <input type="text" name="NOM_OBJETO" id="NOM_OBJETO" class="form-control" required>
                            <div class="invalid-feedback">
                                Por favor, ingrese el nombre del objeto.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="TIP_OBJETO">Tipo del Objeto</label>
                            <input type="text" name="TIP_OBJETO" id="TIP_OBJETO" class="form-control" required>
                            <div class="invalid-feedback">
                                Por favor, ingrese el tipo del objeto.
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="DES_OBJETO">Descripción</label>
                            <textarea name="DES_OBJETO" id="DES_OBJETO" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="IND_OBJETO">Estado</label>
                            <select name="IND_OBJETO" id="IND_OBJETO" class="form-control">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
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
        $('#example').DataTable({
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
        var allInputs = document.querySelectorAll('input');
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
