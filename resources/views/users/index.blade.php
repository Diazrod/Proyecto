<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .alert {
            background-color: #fff;
        }
        .good .fa-times {
            display: none;
        }
        .wrong .fa-check {
            display: none;
        }
        .valid-feedback,
        .invalid-feedback {
            margin-left: 1.5rem;
        }
    </style>
</head>
<body>

@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1>Usuarios</h1>
@endsection

@section('content')
    <div class="container">
    <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 25; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
        <button class="btn btn-primary mb-3" data-toggle="modal" data-target="#createUserModal"> <i class="fas fa-user-plus"></i> Crear Usuario</button>
        @endif
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
        <table id="example" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role ? $user->role->NOM_ROL : 'Sin Rol' }}</td>
                        <td>{{ $user->IND_USER == '1' ? 'Activo' : 'Inactivo' }}</td>
                        <td>
                        @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                            <button class="btn btn-warning" data-toggle="modal" data-target="#editUserModal-{{ $user->id }}"><i class="fas fa-user-edit"></i> Editar</button>
                            @endif
                            <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">  <i class="fas fa-user-times"></i> Eliminar</button>
                            </form>
                        </td>
                    </tr>

                    <!-- Edit User Modal -->
                    <div class="modal fade" id="editUserModal-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel-{{ $user->id }}" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserModalLabel-{{ $user->id }}">Editar Usuario</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('users.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="COD_PERSONAS">Código de Persona</label>
                                            <div class="input-group">
                                                <input type="text" name="COD_PERSONAS" id="COD_PERSONAS_EDIT_{{ $user->id }}" class="form-control" value="{{ $user->COD_PERSONAS }}" readonly>
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#selectPersonModalEdit-{{ $user->id }}">Seleccionar Persona</button>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Nombre</label>
                                            <input type="text" name="name" id="name_edit_{{ $user->id }}" class="form-control" value="{{ $user->name }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" name="email" id="email_edit_{{ $user->id }}" class="form-control" value="{{ $user->email }}" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="COD_ROL">Rol</label>
                                            <select name="COD_ROL" id="COD_ROL_edit_{{ $user->id }}" class="form-control">
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->COD_ROL }}" {{ $user->COD_ROL == $role->COD_ROL ? 'selected' : '' }}>
                                                        {{ $role->NOM_ROL }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="IND_USER">Estado</label>
                                            <select name="IND_USER" id="IND_USER_edit_{{ $user->id }}" class="form-control">
                                                <option value="1" {{ $user->IND_USER == '1' ? 'selected' : '' }}>Activo</option>
                                                <option value="0" {{ $user->IND_USER == '0' ? 'selected' : '' }}>Inactivo</option>
                                            </select>
                                        </div>
                                        <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                    </div>
                                        
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

    <!-- Create User Modal -->
    <div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createUserModalLabel">Crear Usuario</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="COD_PERSONAS">Código de Persona</label>
                            <div class="input-group">
                                <input type="text" name="COD_PERSONAS" id="COD_PERSONAS_create" class="form-control" readonly>
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#selectPersonModalCreate">Seleccionar Persona</button>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" name="name" id="name_create" class="form-control" required>
                            <div class="invalid-feedback">Solo se permiten letras.</div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" id="email_create" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" name="password" id="password_create" class="form-control" required>
                            <div class="valid-feedback">Correcto</div>
                            <div class="invalid-feedback">Incorrecto</div>
                        </div>
                        <div class="alert px-4 py-3 mb-0 d-none" role="alert" id="password_alert_create">
                            <ul class="list-unstyled mb-0">
                                <li class="requirements leng">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <i class="fas fa-times text-danger me-3"></i>
                                    Tu contraseña debe tener al menos 8 caracteres</li>
                                <li class="requirements big-letter">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <i class="fas fa-times text-danger me-3"></i>
                                    Tu contraseña debe tener al menos 1 letra mayúscula.</li>
                                <li class="requirements num">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <i class="fas fa-times text-danger me-3"></i>
                                    Tu contraseña debe tener al menos 1 número.</li>
                                <li class="requirements special-char">
                                    <i class="fas fa-check text-success me-2"></i>
                                    <i class="fas fa-times text-danger me-3"></i>
                                    Tu contraseña debe tener al menos 1 carácter especial.</li>
                            </ul>
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirmar Contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation_create" class="form-control" required>
                            <div class="invalid-feedback" id="password_confirmation_error_create">Las contraseñas no coinciden</div>
                        </div>
                        <div class="form-group">
                            <label for="COD_ROL">Rol</label>
                            <select name="COD_ROL" id="COD_ROL_create" class="form-control">
                                @foreach($roles as $role)
                                    <option value="{{ $role->COD_ROL }}">{{ $role->NOM_ROL }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="IND_USER">Estado</label>
                            <select name="IND_USER" id="IND_USER_create" class="form-control">
                                <option value="1">Activo</option>
                                <option value="0">Inactivo</option>
                            </select>
                        </div>
                        <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Select Person Modal for Create -->
    <div class="modal fade" id="selectPersonModalCreate" tabindex="-1" role="dialog" aria-labelledby="selectPersonModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="selectPersonModalLabel">Seleccionar Persona</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table id="personTableCreate" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($personas as $persona)
                                <tr>
                                    <td>{{ $persona->COD_PERSONAS }}</td>
                                    <td>{{ $persona->PR_NOMBRE }} {{ $persona->SG_NOMBRE }} {{ $persona->PR_APELLIDO }} {{ $persona->SG_APELLIDO }}</td>
                                    <td>
                                        <button class="btn btn-primary select-person" data-id="{{ $persona->COD_PERSONAS }}" data-pr_nombre="{{ $persona->PR_NOMBRE }}" data-pr_apellido="{{ $persona->PR_APELLIDO }}" data-target="#COD_PERSONAS_create" data-username-input="#name_create" data-dismiss="modal">Seleccionar</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Select Person Modal for Edit -->
    @foreach($users as $user)
        <div class="modal fade" id="selectPersonModalEdit-{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="selectPersonModalLabel-{{ $user->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="selectPersonModalLabel-{{ $user->id }}">Seleccionar Persona</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table id="personTableEdit-{{ $user->id }}" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($personas as $persona)
                                    <tr>
                                        <td>{{ $persona->COD_PERSONAS }}</td>
                                        <td>{{ $persona->PR_NOMBRE }} {{ $persona->SG_NOMBRE }} {{ $persona->PR_APELLIDO }} {{ $persona->SG_APELLIDO }}</td>
                                        <td>
                                            <button class="btn btn-primary select-person" data-id="{{ $persona->COD_PERSONAS }}" data-pr_nombre="{{ $persona->PR_NOMBRE }}" data-pr_apellido="{{ $persona->PR_APELLIDO }}" data-target="#COD_PERSONAS_EDIT_{{ $user->id }}" data-username-input="#name_edit_{{ $user->id }}" data-dismiss="modal">Seleccionar</button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
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

            $('#personTableCreate').DataTable({
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

                $('#personTableEdit-{{ $user->id }}').DataTable({
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
            
                $('#informacion').on('hidden.bs.modal', function () {
            $('#informacionContent span').text('');  // Limpiar contenido del modal al cerrarlo
        });
            $(document).on('click', '.select-person', function() {
                var id = $(this).data('id');
                var prNombre = $(this).data('pr_nombre');
                var prApellido = $(this).data('pr_apellido');
                var target = $(this).data('target');
                var usernameInput = $(this).data('username-input');

                $(target).val(id);

                var username = prNombre.charAt(0).toLowerCase() + prApellido.toLowerCase();
                $(usernameInput).val(username);

                checkUsernameAvailability(username, usernameInput);
            });

            function checkUsernameAvailability(username, usernameInput) {
                $.ajax({
                    url: '{{ route("users.checkUsername") }}',
                    type: 'GET',
                    data: { username: username },
                    success: function(response) {
                        if (!response.available) {
                            alert('El nombre de usuario "' + username + '" ya está en uso. Por favor, elige otro.');
                            $(usernameInput).val('');
                        }
                    }
                });
            }

            const passwordCreate = document.getElementById("password_create");
            const passwordAlertCreate = document.getElementById("password_alert_create");
            const requirementsCreate = document.querySelectorAll("#password_alert_create .requirements");
            const lengCreate = document.querySelector("#password_alert_create .leng");
            const bigLetterCreate = document.querySelector("#password_alert_create .big-letter");
            const numCreate = document.querySelector("#password_alert_create .num");
            const specialCharCreate = document.querySelector("#password_alert_create .special-char");
            const passwordConfirmationCreate = document.getElementById("password_confirmation_create");
            const passwordConfirmationErrorCreate = document.getElementById("password_confirmation_error_create");

            requirementsCreate.forEach((element) => element.classList.add("wrong"));

            passwordCreate.addEventListener("focus", () => {
                passwordAlertCreate.classList.remove("d-none");
                if (!passwordCreate.classList.contains("is-valid")) {
                    passwordCreate.classList.add("is-invalid");
                }
            });

            passwordCreate.addEventListener("input", () => {
                const value = passwordCreate.value;
                const isLengthValid = value.length >= 8;
                const hasUpperCase = /[A-Z]/.test(value);
                const hasNumber = /\d/.test(value);
                const hasSpecialChar = /[!@#$%^&*()\[\]{}\\|;:'",<.>/?`~]/.test(value);

                lengCreate.classList.toggle("good", isLengthValid);
                lengCreate.classList.toggle("wrong", !isLengthValid);
                bigLetterCreate.classList.toggle("good", hasUpperCase);
                bigLetterCreate.classList.toggle("wrong", !hasUpperCase);
                numCreate.classList.toggle("good", hasNumber);
                numCreate.classList.toggle("wrong", !hasNumber);
                specialCharCreate.classList.toggle("good", hasSpecialChar);
                specialCharCreate.classList.toggle("wrong", !hasSpecialChar);

                const isPasswordValid = isLengthValid && hasUpperCase && hasNumber && hasSpecialChar;

                if (isPasswordValid) {
                    passwordCreate.classList.remove("is-invalid");
                    passwordCreate.classList.add("is-valid");

                    requirementsCreate.forEach((element) => {
                        element.classList.remove("wrong");
                        element.classList.add("good");
                    });

                    passwordAlertCreate.classList.remove("alert-warning");
                    passwordAlertCreate.classList.add("alert-success");
                } else {
                    passwordCreate.classList.remove("is-valid");
                    passwordCreate.classList.add("is-invalid");

                    passwordAlertCreate.classList.add("alert-warning");
                    passwordAlertCreate.classList.remove("alert-success");
                }
            });

            passwordCreate.addEventListener("blur", () => {
                passwordAlertCreate.classList.add("d-none");
            });

            passwordConfirmationCreate.addEventListener("input", () => {
                if (passwordCreate.value !== passwordConfirmationCreate.value) {
                    passwordConfirmationCreate.classList.add("is-invalid");
                    passwordConfirmationErrorCreate.classList.add("d-block");
                } else {
                    passwordConfirmationCreate.classList.remove("is-invalid");
                    passwordConfirmationErrorCreate.classList.remove("d-block");
                }
            });

            document.getElementById("createUserModal").addEventListener("hidden.bs.modal", () => {
                passwordCreate.value = "";
                passwordConfirmationCreate.value = "";
                passwordCreate.classList.remove("is-valid", "is-invalid");
                passwordConfirmationCreate.classList.remove("is-invalid");
                requirementsCreate.forEach((element) => {
                    element.classList.add("wrong");
                    element.classList.remove("good");
                });

                document.getElementById("name_create").value = "";
                document.getElementById("email_create").value = "";
                document.getElementById("COD_ROL_create").selectedIndex = 0;
                document.getElementById("IND_USER_create").selectedIndex = 0;
            });

            // Validación para que solo se permitan letras en el campo de nombre
            document.getElementById("name_create").addEventListener("input", function() {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });

            // Deshabilitar copiar/pegar en todos los campos de entrada
            $('input').on('paste', function(e) {
                e.preventDefault();
            });

            $('input').on('copy', function(e) {
                e.preventDefault();
            });

            $('input').on('cut', function(e) {
                e.preventDefault();
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
