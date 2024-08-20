<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Parroquia SMP - Registro de Empleados</title>
    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/iglesia.png') }}" type="image/x-icon">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    
    <style>
        .content1 {
            background-color: white;
            border: 8px solid #48C9B0;
            padding: 10px;
            margin-bottom: 20px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
        .content-header {
            border-bottom: 10px solid gold;
            background-color: #48C9B0;
            padding: 20px;
            color: white;
            margin-bottom: 20px;
        }
        .content-body {
            padding: 20px;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .btn-info, .btn-warning {
            border-radius: 50%;
        }
        .btn-info i, .btn-warning i {
            font-size: 1rem;
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
@stop

@section('content')
<div class="content1">
    <div class="content-header d-flex align-items-center">
        <span style="display: block; text-align: center; margin: 0 auto;">
            <h1 class="fw-bold" style="font-style: italic; font-family: 'Arial', sans-serif; color: black; font-size: 45px; text-shadow: 4px 4px #48C9B0;">Registro de Empleados</h1>
        </span>
        <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 2; // Ajusta esto según tu lógica el id del objeto
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
        <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white;" data-bs-toggle="modal" data-bs-target="#crearEmpleadoModal">
            <i class="fas fa-plus"></i> Nuevo
        </button>
        @endif
    </div>
    <div class="content-body">
        <div class="table-responsive">
        @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
            <table id="example" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Area</th>
                        <th>Fecha de Contrato</th>
                        <th>Salario</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($empleados as $empleado)
                    <tr>
                        <td>{{ $empleado->COD_EMPLEADO }}</td>
                        <td>{{ $empleado->persona->PR_NOMBRE }} {{ $empleado->persona->SG_NOMBRE }} {{ $empleado->persona->PR_APELLIDO }} {{ $empleado->persona->SG_APELLIDO }}</td>
                        <td>{{ $empleado->persona->nom_depto}} {{ $empleado->persona->municipio}} {{ $empleado->persona->nom_barrio}}</td> <!-- Ajusta esto según tu modelo Persona -->
                        <td>{{ $empleado->NOM_AREA }}</td>
                        <td>{{ \Carbon\Carbon::parse($empleado->FECH_CONTRATO)->format('Y-m-d') }}</td>
                        <td>{{ $empleado->SALARIO }}</td>
                        <td>{{ $empleado->EST_EMPLEADO }}</td>
                        <td>
                        @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                            <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editarEmpleadoModal" data-id="{{ $empleado->COD_EMPLEADO }}" data-cod-personas="{{ $empleado->COD_PERSONAS }}" data-nom-area="{{ $empleado->NOM_AREA }}" data-fech-contrato="{{ $empleado->FECH_CONTRATO }}" data-salario="{{ $empleado->SALARIO }}" data-est-empleado="{{ $empleado->EST_EMPLEADO }}">
                                Editar
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
</div>

<!-- Modal para Crear Empleado -->
<div class="modal fade" id="crearEmpleadoModal" tabindex="-1" role="dialog" aria-labelledby="crearEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="crearEmpleadoModalLabel">Crear Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 needs-validation" id="crearEmpleadoForm" action="{{ route('empleados.store') }}" method="POST" novalidate>
            @csrf
            <div class="col-md-6 mb-3">
                <label for="COD_PERSONAS" class="form-label">Código de Persona</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control" id="COD_PERSONAS" name="COD_PERSONAS" required>
                    <button type="button" class="btn btn-secondary" id="abrirSeleccionarPersonaCrear">Seleccionar</button>
                    <div class="invalid-feedback">
                        Por favor, selecciona un código de persona.
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="NOM_AREA" class="form-label">Área</label>
                <input type="text" class="form-control" id="NOM_AREA" name="NOM_AREA" required>
                <div class="invalid-feedback">
                    Por favor, proporciona un área válida.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="FECH_CONTRATO" class="form-label">Fecha de Contrato</label>
                <input type="date" class="form-control" id="FECH_CONTRATO" name="FECH_CONTRATO" required>
                <div class="invalid-feedback">
                    Por favor, proporciona una fecha de contrato válida.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="SALARIO" class="form-label">Salario</label>
                <input type="number" class="form-control" id="SALARIO" name="SALARIO" required>
                <div class="invalid-feedback">
                    Por favor, proporciona un salario válido.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="EST_EMPLEADO" class="form-label">Estado del Empleado</label>
                <select class="form-select" id="EST_EMPLEADO" name="EST_EMPLEADO" required>
                    <option selected disabled value="">Seleccionar...</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona un estado válido.
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Guardar</button>
                <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Editar Empleado -->
<div class="modal fade" id="editarEmpleadoModal" tabindex="-1" role="dialog" aria-labelledby="editarEmpleadoModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editarEmpleadoModalLabel">Editar Empleado</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 needs-validation" id="editarEmpleadoForm" action="" method="POST" novalidate>
            @csrf
            @method('PUT')
            <input type="hidden" id="editar_COD_EMPLEADO" name="COD_EMPLEADO">
            <div class="col-md-6 mb-3">
                <label for="editar_COD_PERSONAS" class="form-label">Código de Persona</label>
                <div class="input-group has-validation">
                    <input type="text" class="form-control" id="editar_COD_PERSONAS" name="COD_PERSONAS" required>
                    <button type="button" class="btn btn-secondary" id="abrirSeleccionarPersonaEditar">Seleccionar</button>
                    <div class="invalid-feedback">
                        Por favor, selecciona un código de persona.
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="editar_NOM_AREA" class="form-label">Área</label>
                <input type="text" class="form-control" id="editar_NOM_AREA" name="NOM_AREA" required>
                <div class="invalid-feedback">
                    Por favor, proporciona un área válida.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="editar_FECH_CONTRATO" class="form-label">Fecha de Contrato</label>
                <input type="date" class="form-control" id="editar_FECH_CONTRATO" name="FECH_CONTRATO" required>
                <div class="invalid-feedback">
                    Por favor, proporciona una fecha de contrato válida.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="editar_SALARIO" class="form-label">Salario</label>
                <input type="number" class="form-control" id="editar_SALARIO" name="SALARIO" required>
                <div class="invalid-feedback">
                    Por favor, proporciona un salario válido.
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <label for="editar_EST_EMPLEADO" class="form-label">Estado del Empleado</label>
                <select class="form-select" id="editar_EST_EMPLEADO" name="EST_EMPLEADO" required>
                    <option selected disabled value="">Seleccionar...</option>
                    <option value="Activo">Activo</option>
                    <option value="Inactivo">Inactivo</option>
                </select>
                <div class="invalid-feedback">
                    Por favor, selecciona un estado válido.
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button class="btn btn-primary" type="submit"><i class="fas fa-save"></i> Actualizar</button>
                <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Seleccionar Persona (Editar Empleado) -->
<div class="modal fade" id="seleccionarPersonaModal" tabindex="-1" role="dialog" aria-labelledby="seleccionarPersonaModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="seleccionarPersonaModalLabel">Seleccionar Persona</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id="tablaPersonas" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
            <thead>
              <tr>
                <th>#</th>
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
                  <button type="button" class="btn btn-primary seleccionar-persona" data-cod-personas="{{ $persona->COD_PERSONAS }}">Seleccionar</button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal para Seleccionar Persona (Crear Empleado) -->
<div class="modal fade" id="seleccionarPersonaModalCrear" tabindex="-1" role="dialog" aria-labelledby="seleccionarPersonaModalLabelCrear" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="seleccionarPersonaModalLabelCrear">Seleccionar Persona</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table id="tablaPersonasCrear" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
            <thead>
              <tr>
                <th>#</th>
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
                  <button type="button" class="btn btn-primary seleccionar-persona-crear" data-cod-personas="{{ $persona->COD_PERSONAS }}">Seleccionar</button>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

@stop

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
    <!-- SweetAlert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            'use strict'

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
        })()

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

            $('#editarEmpleadoModal').on('show.bs.modal', function (event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var cod_personas = button.data('cod-personas');
                var nom_area = button.data('nom-area');
                var fech_contrato = button.data('fech-contrato');
                var salario = button.data('salario');
                var est_empleado = button.data('est-empleado');

                // Asegúrate de que la fecha esté en el formato YYYY-MM-DD
                var formattedDate = new Date(fech_contrato).toISOString().split('T')[0];

                var modal = $(this);
                modal.find('.modal-body #editar_COD_EMPLEADO').val(id);
                modal.find('.modal-body #editar_COD_PERSONAS').val(cod_personas);
                modal.find('.modal-body #editar_NOM_AREA').val(nom_area);
                modal.find('.modal-body #editar_FECH_CONTRATO').val(formattedDate);
                modal.find('.modal-body #editar_SALARIO').val(salario);
                modal.find('.modal-body #editar_EST_EMPLEADO').val(est_empleado);
                
                modal.find('form').attr('action', '/empleados/' + id);
            });

            $('#tablaPersonas').DataTable({
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

            $('#tablaPersonasCrear').DataTable({
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

            $('#abrirSeleccionarPersonaCrear').click(function() {
                $('#seleccionarPersonaModalCrear').appendTo('body').modal('show');
            });

            $('#abrirSeleccionarPersonaEditar').click(function() {
                $('#seleccionarPersonaModal').appendTo('body').modal('show');
            });

            $(document).on('click', '.seleccionar-persona', function() {
                var codPersonas = $(this).data('cod-personas');
                $('#editar_COD_PERSONAS').val(codPersonas);
                $('#seleccionarPersonaModal').modal('hide');
                $('#editarEmpleadoModal').appendTo('body').modal('show');
            });

            $(document).on('click', '.seleccionar-persona-crear', function() {
                var codPersonas = $(this).data('cod-personas');
                $('#COD_PERSONAS').val(codPersonas);
                $('#seleccionarPersonaModalCrear').modal('hide');
                $('#crearEmpleadoModal').appendTo('body').modal('show');
            });

            // Validación para que solo se permitan letras en el campo de nombre
            $('#NOM_AREA, #editar_NOM_AREA').on('input', function() {
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
