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
            Datos de Finanzas
        </h1>
    </div>
    <!-- Botón Nuevo -->
    <div class="col-auto">
    <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 21; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
        <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white; border: 2px solid white; box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);" data-bs-toggle="modal" data-bs-target="#nuevoRegistroModal">
            <i class="fas fa-plus"></i> Nuevo Registro
        </button>
        @endif
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
            <table id="finanzasTable" class="table table-striped">
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Tipo de Transacción</th>
                        <th>Fecha</th>
                       
                        <th>Monto</th>
                        
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ResultadosConsultaMes as $finanza)
                        <tr>
                            <td>{{ $finanza['COD_FINANSAS'] }}</td>
                            <td>{{ $finanza['TIPO_TRANS'] }}</td>
                            <td>{{ \Carbon\Carbon::parse($finanza['FECHA'])->format('Y-m-d') }}</td>
                            
                            <td>{{ $finanza['MONTO'] }}</td>
                           
                            <td>
                            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modificarRegistroModal" data-id="{{ $finanza['COD_FINANSAS'] }}" data-tipo="{{ $finanza['TIPO_TRANS'] }}" data-fecha="{{ \Carbon\Carbon::parse($finanza['FECHA'])->format('Y-m-d') }}" data-observaciones="{{ $finanza['OBSERVACIONES'] }}" data-coddetalle="{{ $finanza['COD_DETALLE'] }}" data-codcuenta="{{ $finanza['COD_CUENTA'] }}" data-monto="{{ $finanza['MONTO'] }}" data-nombrecuenta="{{ $finanza['NOMBRE_CUENTA'] }}">
                                    <i class="fas fa-edit"></i> Modificar
                                </button>
                                @endif
                                <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detallesRegistroModal" 
        data-id="{{ $finanza['COD_FINANSAS'] }}" 
        data-tipo="{{ $finanza['TIPO_TRANS'] }}" 
        data-fecha="{{ \Carbon\Carbon::parse($finanza['FECHA'])->format('Y-m-d') }}" 
        data-observaciones="{{ $finanza['OBSERVACIONES'] }}" 
        data-coddetalle="{{ $finanza['COD_DETALLE'] }}" 
        data-codcuenta="{{ $finanza['COD_CUENTA'] }}" 
        data-monto="{{ $finanza['MONTO'] }}" 
        data-nombrecuenta="{{ $finanza['NOMBRE_CUENTA'] }}">
    <i class="fas fa-info-circle"></i> Detalles
</button>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

<!-- Modal para nuevo registro -->
<div class="modal fade" id="nuevoRegistroModal" tabindex="-1" aria-labelledby="nuevoRegistroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content"
     style="
         border: 4px solid #48C9B0; /* Borde grueso con el color deseado */
         box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); /* Reflexión blanca */
     ">
            <div class="modal-header">
            <h5 class="modal-title" id="nuevoRegistroModalLabel">
        <i class="fas fa-plus-circle"></i> <strong>Nuevo Registro finanzas</strong>
    </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  class="row g-3 needs-validation"  novalidate action="{{ route('crear.finanzas') }}" method="POST" id="nuevoRegistroForm" class="row g-3">
                    @csrf
                    <div class="col-md-6">
                        <label for="nom_cuenta" class="form-label">Nombre de la Cuenta</label>
                        <input type="text" class="form-control" id="nom_cuenta" name="nom_cuenta" maxlength="50" required onkeypress="return isLetterKey(event)" onpaste="return false">
                        <div class="invalid-feedback">
                            Por favor ingrese el nombre de la cuenta.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_cuenta" class="form-label">Tipo de Cuenta</label>
                        <select class="form-control" id="tipo_cuenta" name="tipo_cuenta" required>
                        <option value="" disabled selected>Seleccione un tipo de cuenta</option>
                            <option value="INGRESO">Ingreso</option>
                            <option value="EGRESO">Egreso</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione el tipo de cuenta.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="cod_cuenta" class="form-label">Código de la Cuenta</label>
                        <input type="number" class="form-control" id="cod_cuenta" name="cod_cuenta" required onkeypress="return isNumberKey(event)" onpaste="return false">
                        <div class="invalid-feedback">
                            Por favor ingrese el código de la cuenta.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="tipo_trans" class="form-label">Tipo de Transacción</label>
                        <select class="form-control" id="tipo_trans" name="tipo_trans" required>
                        <option value="" disabled selected>Seleccione un tipo de transaccion</option>
                            <option value="INGRESO">Ingreso</option>
                            <option value="EGRESO">Egreso</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione el tipo de transacción.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="monto" class="form-label">Monto</label>
                        <input type="number" class="form-control" id="monto" name="monto" step="0.01" required onkeypress="return isNumberKey(event)" onpaste="return false">
                        <div class="invalid-feedback">
                            Por favor ingrese el monto.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="fecha" class="form-label">Fecha</label>
                        <input type="datetime-local" class="form-control" id="fecha" name="fecha" required>
                        <div class="invalid-feedback">
                            Por favor ingrese la fecha.
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" maxlength="255" required onkeypress="return isLetterKey(event)" onpaste="return false"></textarea>
                        <div class="invalid-feedback">
                            Por favor ingrese observaciones.
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <button type="submit" class="btn btn-success btn-lg">Guardar</button>
                        <button type="button" class="btn btn-secondary btn-lg" style="background-color: red; border-color: red; color: white;" data-bs-dismiss="modal">
    Cancelar
</button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


 <!-- Modal para modificar registro -->
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="modificarRegistroModal" tabindex="-1" aria-labelledby="modificarRegistroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content"
     style="
         border: 4px solid #48C9B0; /* Borde grueso con el color deseado */
         box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); /* Reflexión blanca */
     ">
            <div class="modal-header">
            <h5 class="modal-title" id="modificarRegistroModalLabel">
        <i class="fas fa-edit"></i> <strong>Modificar Registro Finanzas</strong>
    </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form id="editRecordForm" class="needs-validation" novalidate method="POST" action="{{ route('finanzas.update', ['id' => $finanza['COD_FINANSAS']]) }}">
    @csrf
    @method('PUT')
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="modificar_id" class="form-label">Codigo Registro</label>
                            <input type="text" class="form-control" id="modificar_id"  style="pointer-events: none; " name="modificar_id"  required>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label for="modificar_fecha" class="form-label">Fecha</label>
                            <input type="date" class="form-control" id="modificar_fecha" name="modificar_fecha" required>
                        </div>


                       
                    </div>
                    <div class="row">


                   
                    <div class="col-md-6 mb-3">


                            <label for="modificar_tipo_trans" class="form-label">Tipo de Transacción</label>
                            <input type="text" class="form-control" id="modificar_tipo_trans"  style="pointer-events: none; " name="modificar_tipo_trans" required >
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="modificar_monto" class="form-label">Monto</label>
                            <input type="number" class="form-control" id="modificar_monto" name="modificar_monto" required>
                        </div>

                    </div>
                   
                        
                   
                    <div class="row">


                    <div class="col-md-6 mb-3">
                            <label for="modificar_codcuenta" class="form-label">Código Cuenta</label>
                            <input type="text" class="form-control" id="modificar_codcuenta"   style="pointer-events: none; "name="modificar_codcuenta"required>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="modificar_nombrecuenta" class="form-label">Nombre Cuenta</label>
                            <input type="text" class="form-control" id="modificar_nombrecuenta"  style="pointer-events: none; " name="modificar_nombrecuenta"required>
                        </div>
                    </div>

                    <div class="col-md-12 mb-3">
                            <label for="modificar_observaciones" class="form-label">Observaciones</label>
                            <textarea class="form-control" id="modificar_observaciones" name="modificar_observaciones" required></textarea>
                        </div>
                        <input type="hidden" class="form-control" id="modificar_coddetalle">

               
            </div>
            <div class="modal-footer">
    <button type="submit" class="btn btn-success">Guardar Cambios</button>
    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
</div>


            </form>
        </div>
    </div>
</div>


<!-- Modal para Detalles -->
<div class="modal fade" id="detallesRegistroModal" tabindex="-1" aria-labelledby="detallesRegistroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"
             style="
                 border: 4px solid #48C9B0; /* Borde grueso con el color deseado */
                 box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); /* Reflexión blanca */
             ">
            <div class="modal-header">
                <h5 class="modal-title" id="detallesRegistroModalLabel">
                    <i class="fas fa-info-circle"></i> <strong>Detalles de la Finanza</strong>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <th scope="row">ID</th>
                                <td id="detalleId"></td>
                            </tr>
                            <tr>
                                <th scope="row">Tipo</th>
                                <td id="detalleTipo"></td>
                            </tr>
                            <tr>
                                <th scope="row">Fecha</th>
                                <td id="detalleFecha"></td>
                            </tr>
                            <tr>
                                <th scope="row">Observaciones</th>
                                <td id="detalleObservaciones"></td>
                            </tr>
                            <tr>
                                <th scope="row">Código Detalle</th>
                                <td id="detalleCodDetalle"></td>
                            </tr>
                            <tr>
                                <th scope="row">Código Cuenta</th>
                                <td id="detalleCodCuenta"></td>
                            </tr>
                            <tr>
                                <th scope="row">Monto</th>
                                <td id="detalleMonto"></td>
                            </tr>
                            <tr>
                                <th scope="row">Cuenta</th>
                                <td id="detalleNombreCuenta"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" style="background-color: red; color: white;" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            var table = $('#finanzasTable').DataTable({
                language: {
                    "sEmptyTable": "No hay datos disponibles en la tabla",
                    "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                    "sInfoEmpty": "Mostrando 0 a 0 de 0 entradas",
                    "sInfoFiltered": "(filtrado de _MAX_ entradas en total)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ",",
                    "sLengthMenu": "Mostrar _MENU_ entradas",
                    "sLoadingRecords": "Cargando...",
                    "sProcessing": "Procesando...",
                    "sSearch": "Buscar:",
                    "sZeroRecords": "No se encontraron resultados",
                    "oPaginate": {
                        "sFirst": "Primera",
                        "sLast": "Última",
                        "sNext": "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                    }
                }
            });

            // Configuración del campo de búsqueda
            $('#searchInput').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Rellenar el modal de modificar registro con los datos del registro seleccionado
            $('#modificarRegistroModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var tipo = button.data('tipo');
    var fecha = button.data('fecha');
    var observaciones = button.data('observaciones');
    var coddetalle = button.data('coddetalle');
    var codcuenta = button.data('codcuenta');
    var monto = button.data('monto');
    var nombrecuenta = button.data('nombrecuenta');

    var modal = $(this);
    modal.find('#modificar_id').val(id);
    modal.find('#modificar_tipo_trans').val(tipo);
    modal.find('#modificar_fecha').val(fecha);
    modal.find('#modificar_observaciones').val(observaciones);
    modal.find('#modificar_coddetalle').val(coddetalle);
    modal.find('#modificar_codcuenta').val(codcuenta);
    modal.find('#modificar_monto').val(monto);
    modal.find('#modificar_nombrecuenta').val(nombrecuenta);
});

    


            // Validar formularios antes de enviar
            

            // Validación adicional para Código de la Cuenta (máximo 10 dígitos)
            $('#cod_cuenta, #modificar_codcuenta').on('input', function() {
                if (this.value.length > 10) {
                    this.value = this.value.slice(0, 10);
                }
            });

            // Validación adicional para Monto (máximo 7 dígitos)
            $('#monto, #modificar_monto').on('input', function() {
                if (this.value.length > 7) {
                    this.value = this.value.slice(0, 7);
                }
            });
        });
          // Permitir solo letras en el campo
    function isLetterKey(evt) {
        var charCode = evt.which ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 65 || charCode > 90) && (charCode < 97 || charCode > 122) && charCode !== 32) {
            return false;
        }
        return true;
    }

    // Permitir solo números en el campo
    function isNumberKey(evt) {
        var charCode = evt.which ? evt.which : evt.keyCode;
        if (charCode > 31 && (charCode < 48 || charCode > 57)) {
            return false;
        }
        return true;
    }
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var detallesModal = document.getElementById('detallesRegistroModal');
        detallesModal.addEventListener('show.bs.modal', function (event) {
            var button = event.relatedTarget;

            var id = button.getAttribute('data-id');
            var tipo = button.getAttribute('data-tipo');
            var fecha = button.getAttribute('data-fecha');
            var observaciones = button.getAttribute('data-observaciones');
            var coddetalle = button.getAttribute('data-coddetalle');
            var codcuenta = button.getAttribute('data-codcuenta');
            var monto = button.getAttribute('data-monto');
            var nombrecuenta = button.getAttribute('data-nombrecuenta');

            var modalId = detallesModal.querySelector('#detalleId');
            var modalTipo = detallesModal.querySelector('#detalleTipo');
            var modalFecha = detallesModal.querySelector('#detalleFecha');
            var modalObservaciones = detallesModal.querySelector('#detalleObservaciones');
            var modalCodDetalle = detallesModal.querySelector('#detalleCodDetalle');
            var modalCodCuenta = detallesModal.querySelector('#detalleCodCuenta');
            var modalMonto = detallesModal.querySelector('#detalleMonto');
            var modalNombreCuenta = detallesModal.querySelector('#detalleNombreCuenta');

            modalId.textContent = id;
            modalTipo.textContent = tipo;
            modalFecha.textContent = fecha;
            modalObservaciones.textContent = observaciones;
            modalCodDetalle.textContent = coddetalle;
            modalCodCuenta.textContent = codcuenta;
            modalMonto.textContent = monto;
            modalNombreCuenta.textContent = nombrecuenta;
        });
    });
</script>
<script>
document.addEventListener('DOMContentLoaded', function () {
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: '¡Éxito!',
        text: '{{ session('success') }}',
    });
@endif

@if(session('error'))
    Swal.fire({
        icon: 'error',
        title: 'Error',
        text: '{{ session('error') }}',
    });
@endif
});
</script>

<script>
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
</script>

    @stop
</body>
</html>
