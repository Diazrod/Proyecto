<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parroquia SMP</title>
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
</head>
<body>

@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content_header')
@endsection

@section('content')
    <div class="container">
        <h1>Roles</h1>
        <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 26; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createRoleModal">Crear Rol</button>
        @endif
        @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
        <table id="example" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                    <th>Usuario</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $role)
                    <tr>
                        <td>{{ $role->COD_ROL }}</td>
                        <td>{{ $role->NOM_ROL }}</td>
                        <td>{{ $role->DES_ROL }}</td>
                        <td>{{ $role->IND_ROL == '1' ? 'Activo' : 'Inactivo' }}</td>
                        <td>{{ $role->USR_ADD }}</td>
                        <td>
                        @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                            <button class="btn btn-warning btn-edit" data-bs-toggle="modal" data-bs-target="#editRoleModal-{{ $role->COD_ROL }}" data-id="{{ $role->COD_ROL }}">Editar</button>
                            @endif
                        </td>
                    </tr>

                    <!-- Edit Role Modal -->
                    <div class="modal fade" id="editRoleModal-{{ $role->COD_ROL }}" tabindex="-1" role="dialog" aria-labelledby="editRoleModalLabel-{{ $role->COD_ROL }}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editRoleModalLabel-{{ $role->COD_ROL }}">Editar Rol</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('roles.update', $role->COD_ROL) }}" method="POST" class="form-update">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label for="NOM_ROL" class="form-label">Nombre del Rol</label>
                                            <input type="text" name="NOM_ROL" id="NOM_ROL" class="form-control" value="{{ $role->NOM_ROL }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="DES_ROL" class="form-label">Descripción</label>
                                            <textarea name="DES_ROL" id="DES_ROL" class="form-control">{{ $role->DES_ROL }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="IND_ROL" class="form-label">Estado</label>
                                            <select name="IND_ROL" id="IND_ROL" class="form-control">
                                                <option value="1" {{ $role->IND_ROL == '1' ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ $role->IND_ROL == '0' ? 'selected' : '' }}>Inactivo</option>
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
        @endif
    </div>

    <!-- Create Role Modal -->
    <div class="modal fade" id="createRoleModal" tabindex="-1" role="dialog" aria-labelledby="createRoleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createRoleModalLabel">Crear Rol</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('roles.store') }}" method="POST" id="createRoleForm">
                        @csrf
                        <div class="mb-3">
                            <label for="NOM_ROL" class="form-label">Nombre del Rol</label>
                            <input type="text" name="NOM_ROL" id="NOM_ROL" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label for="DES_ROL" class="form-label">Descripción</label>
                            <textarea name="DES_ROL" id="DES_ROL" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="IND_ROL" class="form-label">Estado</label>
                            <select name="IND_ROL" id="IND_ROL" class="form-control">
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