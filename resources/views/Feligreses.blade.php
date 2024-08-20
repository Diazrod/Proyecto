
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
@stop

@section('content')
<div class="container">
    <div class="row align-items-center mb-4">
        <div class="col-auto">
        </div>
        <div class="col">
            <h1 class="fw-bold text-center" style="font-style: italic; font-family: 'Arial', sans-serif; color: black; font-size: 65px; text-shadow: 4px 4px #48C9B0;">Registro de Feligres</h1>
        </div>
        <div class="col-auto">
            <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 1; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
            <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white;" data-bs-toggle="modal" data-bs-target="#crearPersonaModal">
                <i class="fas fa-plus"></i> Nuevo
            </button>
            @endif
        </div>
    </div>

    @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
    <div class="table-responsive">
        <table id="example" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Fecha Nacimiento</th>
                    <th>Género</th>
                    <th>Personería</th>
                    <th>Estado Civil</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ResulPersonas as $Feligreses)
                <tr>
                    <td>{{ $Feligreses['COD_PERSONAS'] ?? 'N/A' }}</td>
                    <td>
                        {{ $Feligreses['PR_NOMBRE'] ?? '' }} {{ $Feligreses['SG_NOMBRE'] ?? '' }} {{ $Feligreses['PR_APELLIDO'] ?? '' }} {{ $Feligreses['SG_APELLIDO'] ?? '' }}
                    </td>
                    <td>{{ $Feligreses['DNI_PERSONA'] ?? 'N/A' }}</td>
                    <td>{{ $Feligreses['NUM_TELEFONO'] ?? 'N/A' }}</td>
                    <td>{{ $Feligreses['FECH_NACIMINETO'] ?? 'N/A' }}</td>
                    <td>{{ $Feligreses['GENERO'] ?? 'N/A' }}</td>
                    <td>{{ $Feligreses['PERSONERIA'] ?? 'N/A' }}</td>
                    <td>{{ $Feligreses['EST_CIVIL'] ?? 'N/A' }}</td>
                    <td>
                        <a href="#" class="btn btn-primary btn-sm" onclick="mostrarInformacion('{{ $Feligreses['COD_PERSONAS']}}', '{{ $Feligreses['FECH_REGISTRO'] }}', '{{ $Feligreses['COD_DIRECCION'] }}', '{{ $Feligreses['NOM_DEPTO'] }}', '{{ $Feligreses['MUNICIPIO'] }}', '{{ $Feligreses['NOM_BARRIO'] }}', '{{ $Feligreses['NOM_CALLE']}}')" title="Ver" data-bs-toggle="modal" data-bs-target="#informacion">
                            <i class="fas fa-file-alt"></i>
                        </a>
                        @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modificarPersonaModal"
                            data-id="{{ $Feligreses['COD_PERSONAS'] }}"
                            data-pr_nombre="{{ $Feligreses['PR_NOMBRE'] }}"
                            data-sg_nombre="{{ $Feligreses['SG_NOMBRE'] }}"
                            data-pr_apellido="{{ $Feligreses['PR_APELLIDO'] }}"
                            data-sg_apellido="{{ $Feligreses['SG_APELLIDO'] }}"
                            data-dni="{{ $Feligreses['DNI_PERSONA'] }}"
                            data-telefono="{{ $Feligreses['NUM_TELEFONO'] }}"
                            data-fech_nacimiento="{{ $Feligreses['FECH_NACIMINETO'] }}"
                            data-genero="{{ $Feligreses['GENERO'] }}"
                            data-personeria="{{ $Feligreses['PERSONERIA'] }}"
                            data-est_civil="{{ $Feligreses['EST_CIVIL'] }}"
                            data-nom_depto="{{ $Feligreses['NOM_DEPTO'] }}"
                            data-municipio="{{ $Feligreses['MUNICIPIO'] }}"
                            data-nom_barrio="{{ $Feligreses['NOM_BARRIO'] }}"
                            data-nom_calle="{{ $Feligreses['NOM_CALLE'] }}">
                            <i class="fas fa-edit"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
<!-- ************************************************FIN TABLA ***********************************-->


<!-- The Modal -->
<div class="modal fade" id="informacion" tabindex="-1" aria-labelledby="informacionLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal Header -->
            <div class="modal-header">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div id="informacionContent">
                    <p>Fecha Registro: <span id="fecha"></span></p>
                    <p>Id Dirección: <span id="id"></span></p>
                    <p>Departamento: <span id="depto"></span></p>
                    <p>Municipio: <span id="municipio"></span></p>
                    <p>Barrio: <span id="barrio"></span></p>
                    <p>Calle: <span id="calle"></span></p>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <!-- Puedes añadir botones de acción aquí -->
            </div>
        </div>
    </div>
</div>

<!-- Modal para crear persona -->
<div class="modal fade" id="crearPersonaModal" tabindex="-1" aria-labelledby="crearPersonaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="crearPersonaModalLabel">Crear Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="{{ route('crearPersona') }}" method="POST">
                    @csrf
                    <fieldset style="border: 2px solid #FCF3CF; padding: 20px; margin-bottom: 15px;">
                        <legend><i class="fas fa-user"></i> Datos Personales</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="pr_nombre" class="form-label">Primer Nombre</label>
                                    <input type="text" class="form-control" id="pr_nombre" name="pr_nombre" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el primer nombre.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sg_nombre" class="form-label">Segundo Nombre</label>
                                    <input type="text" class="form-control" id="sg_nombre" name="sg_nombre">
                                </div>
                                <div class="form-group">
                                    <label for="pr_apellido" class="form-label">Primer Apellido</label>
                                    <input type="text" class="form-control" id="pr_apellido" name="pr_apellido" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el primer apellido.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="sg_apellido" class="form-label">Segundo Apellido</label>
                                    <input type="text" class="form-control" id="sg_apellido" name="sg_apellido">
                                </div>
                                <div class="form-group">
                                    <label for="dni_persona" class="form-label">DNI</label>
                                    <input type="text" class="form-control" id="dni_persona" name="dni_persona" required maxlength="15">
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el DNI.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="num_telefono" class="form-label">Número de Teléfono</label>
                                    <input type="text" class="form-control" id="num_telefono" name="num_telefono" required maxlength="8">
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el número de teléfono.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="fech_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="fech_nacimiento" name="fech_nacimiento" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese la fecha de nacimiento.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="genero" class="form-label">Género</label>
                                    <select class="form-select select-custom" id="genero" name="genero" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, seleccione el género.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="personeria" class="form-label">Personería</label>
                                    <select class="form-select select-custom" id="personeria" name="personeria" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="Natural">Natural</option>
                                        <option value="Juridica">Jurídica</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, seleccione la personería.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="est_civil" class="form-label">Estado Civil</label>
                                    <select class="form-select select-custom" id="est_civil" name="est_civil" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="S">Soltero/a</option>
                                        <option value="C">Casado/a</option>
                                        <option value="D">Divorciado/a</option>
                                        <option value="V">Viudo/a</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, seleccione el estado civil.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nom_depto" class="form-label">Nombre del Departamento</label>
                                    <input type="text" class="form-control" id="nom_depto" name="nom_depto" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el nombre del departamento.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="municipio" class="form-label">Municipio</label>
                                    <input type="text" class="form-control" id="municipio" name="municipio" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el municipio.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nom_barrio" class="form-label">Nombre del Barrio</label>
                                    <input type="text" class="form-control" id="nom_barrio" name="nom_barrio" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el nombre del barrio.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="nom_calle" class="form-label">Nombre de la Calle</label>
                                    <input type="text" class="form-control" id="nom_calle" name="nom_calle" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el nombre de la calle.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
                        <button type="reset" class="btn btn-warning mx-2"><i class="fas fa-sync"></i> Limpiar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para modificar persona -->
<div class="modal fade" id="modificarPersonaModal" tabindex="-1" aria-labelledby="modificarPersonaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modificarPersonaModalLabel">Modificar Persona</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate action="{{ route('actualizarPersona', '') }}" method="POST" id="modificarPersonaForm">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="modificar_cod_persona" name="cod_persona">
                    <fieldset style="border: 2px solid #FCF3CF; padding: 20px; margin-bottom: 15px;">
                        <legend><i class="fas fa-user"></i> Datos Personales</legend>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modificar_pr_nombre" class="form-label">Primer Nombre</label>
                                    <input type="text" class="form-control" id="modificar_pr_nombre" name="pr_nombre" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el primer nombre.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_sg_nombre" class="form-label">Segundo Nombre</label>
                                    <input type="text" class="form-control" id="modificar_sg_nombre" name="sg_nombre">
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el segundo nombre.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_pr_apellido" class="form-label">Primer Apellido</label>
                                    <input type="text" class="form-control" id="modificar_pr_apellido" name="pr_apellido" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el primer apellido.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_sg_apellido" class="form-label">Segundo Apellido</label>
                                    <input type="text" class="form-control" id="modificar_sg_apellido" name="sg_apellido">
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el segundo apellido.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_dni_persona" class="form-label">DNI</label>
                                    <input type="text" class="form-control" id="modificar_dni_persona" name="dni_persona" required maxlength="15">
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el DNI.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_num_telefono" class="form-label">Número de Teléfono</label>
                                    <input type="text" class="form-control" id="modificar_num_telefono" name="num_telefono" required maxlength="8">
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el número de teléfono.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_fech_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                    <input type="date" class="form-control" id="modificar_fech_nacimiento" name="fech_nacimiento" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese la fecha de nacimiento.
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="modificar_genero" class="form-label">Género</label>
                                    <select class="form-select select-custom" id="modificar_genero" name="genero" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="M">Masculino</option>
                                        <option value="F">Femenino</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, seleccione el género.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_personeria" class="form-label">Personería</label>
                                    <select class="form-select select-custom" id="modificar_personeria" name="personeria" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="Natural">Natural</option>
                                        <option value="Juridica">Jurídica</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, seleccione la personería.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_est_civil" class="form-label">Estado Civil</label>
                                    <select class="form-select select-custom" id="modificar_est_civil" name="est_civil" required>
                                        <option value="">Seleccionar...</option>
                                        <option value="S">Soltero/a</option>
                                        <option value="C">Casado/a</option>
                                        <option value="D">Divorciado/a</option>
                                        <option value="V">Viudo/a</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor, seleccione el estado civil.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_nom_depto" class="form-label">Nombre del Departamento</label>
                                    <input type="text" class="form-control" id="modificar_nom_depto" name="nom_depto" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el nombre del departamento.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_municipio" class="form-label">Municipio</label>
                                    <input type="text" class="form-control" id="modificar_municipio" name="municipio" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el municipio.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_nom_barrio" class="form-label">Nombre del Barrio</label>
                                    <input type="text" class="form-control" id="modificar_nom_barrio" name="nom_barrio" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el nombre del barrio.
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="modificar_nom_calle" class="form-label">Nombre de la Calle</label>
                                    <input type="text" class="form-control" id="modificar_nom_calle" name="nom_calle" required>
                                    <div class="invalid-feedback">
                                        Por favor, ingrese el nombre de la calle.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save"></i> Guardar</button>
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
                    </div>
                </form>
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

        $('#informacion').on('hidden.bs.modal', function () {
            $('#informacionContent span').text('');  // Limpiar contenido del modal al cerrarlo
        });

        function mostrarInformacion(codigo, fecha, id, depto, municipio, barrio, calle) {
            $('#fecha').text(fecha);
            $('#id').text(id);
            $('#depto').text(depto);
            $('#municipio').text(municipio);
            $('#barrio').text(barrio);
            $('#calle').text(calle);

            $('#informacion').modal('show');
        }

        $('#modificarPersonaModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Botón que activó el modal
            var id = button.data('id');
            var pr_nombre = button.data('pr_nombre');
            var sg_nombre = button.data('sg_nombre');
            var pr_apellido = button.data('pr_apellido');
            var sg_apellido = button.data('sg_apellido');
            var dni = button.data('dni');
            var telefono = button.data('telefono');
            var fech_nacimiento = button.data('fech_nacimiento');
            var genero = button.data('genero');
            var personeria = button.data('personeria');
            var est_civil = button.data('est_civil');
            var nom_depto = button.data('nom_depto');
            var municipio = button.data('municipio');
            var nom_barrio = button.data('nom_barrio');
            var nom_calle = button.data('nom_calle');

            var modal = $(this);
            modal.find('.modal-body #modificar_cod_persona').val(id);
            modal.find('.modal-body #modificar_pr_nombre').val(pr_nombre);
            modal.find('.modal-body #modificar_sg_nombre').val(sg_nombre);
            modal.find('.modal-body #modificar_pr_apellido').val(pr_apellido);
            modal.find('.modal-body #modificar_sg_apellido').val(sg_apellido);
            modal.find('.modal-body #modificar_dni_persona').val(dni);
            modal.find('.modal-body #modificar_num_telefono').val(telefono);
            modal.find('.modal-body #modificar_fech_nacimiento').val(fech_nacimiento);
            modal.find('.modal-body #modificar_genero').val(genero);
            modal.find('.modal-body #modificar_personeria').val(personeria);
            modal.find('.modal-body #modificar_est_civil').val(est_civil);
            modal.find('.modal-body #modificar_nom_depto').val(nom_depto);
            modal.find('.modal-body #modificar_municipio').val(municipio);
            modal.find('.modal-body #modificar_nom_barrio').val(nom_barrio);
            modal.find('.modal-body #modificar_nom_calle').val(nom_calle);

            // Actualizar la acción del formulario con el ID correcto
            var formAction = "{{ route('actualizarPersona', '') }}/" + id;
            modal.find('#modificarPersonaForm').attr('action', formAction);
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

            // Validación para permitir solo números y guiones en el campo DNI y limitar a 15 caracteres
            function validateDniInput(event) {
                const pattern = /^[0-9-]*$/;
                if (!pattern.test(event.key)) {
                    event.preventDefault();
                }
            }

            // Validación para permitir solo números en campos numéricos y limitar el teléfono a 8 caracteres
            function validatePhoneInput(event) {
                const pattern = /^[0-9]*$/;
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
            var textInputs = document.querySelectorAll('input[type="text"]:not(#dni_persona):not(#num_telefono)');
            textInputs.forEach(function (input) {
                input.addEventListener('keypress', validateTextInput);
                input.addEventListener('paste', disableCopyPaste);
                input.addEventListener('copy', disableCopyPaste);
                input.addEventListener('cut', disableCopyPaste);
            });

            // Aplicar validaciones adicionales a campo DNI
            var dniInput = document.getElementById('dni_persona');
            if (dniInput) {
                dniInput.addEventListener('keypress', validateDniInput);
                dniInput.addEventListener('paste', disableCopyPaste);
                dniInput.addEventListener('copy', disableCopyPaste);
                dniInput.addEventListener('cut', disableCopyPaste);
            }

            // Aplicar validaciones adicionales a campo Teléfono
            var phoneInput = document.getElementById('num_telefono');
            if (phoneInput) {
                phoneInput.addEventListener('keypress', validatePhoneInput);
                phoneInput.addEventListener('paste', disableCopyPaste);
                phoneInput.addEventListener('copy', disableCopyPaste);
                phoneInput.addEventListener('cut', disableCopyPaste);
            }

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
