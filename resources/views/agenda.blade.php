<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventos</title>

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
        textarea.form-control {
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

@vite(['resources/sass/app.scss', 'resources/js/app.js'])

@extends('adminlte::page')

@section('plugins.Datatables', true)

</head>
<body>

@section('content_header')
@stop
   
@section('content')
    <div class="container mt-4">
        <div class="d-flex justify-content-between mb-3 align-items-center">
            <!-- Título -->
            <div class="col text-center">
                <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 65px; text-shadow: 2px 2px rgba(72, 201, 176, 0.8); letter-spacing: 1px;">
                    Registro de Eventos
                </h1>
            </div>
            <!-- Botón Nuevo -->
            <div class="col-auto">
            <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white;" data-bs-toggle="modal" data-bs-target="#nuevoEventoModal">
                <i class="fas fa-plus"></i> Nuevo Evento
            </button>
            </div>
        </div>
            <div class="table-responsive">
                <table id="EventoTable" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
                    <thead>
                        <tr>
                            <th>Código</th>        
                            <th>Tipo</th>                           
                            <th>Fecha Inicio</th>                                                      
                            <th>Duracion</th>
                            <th>Lugar</th>
                            <th>Descripcion</th>
                            <th>Responsable</th>
                            <th>Estado</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($ResulAgenda as $agenda)
                            <tr>
                                <td>{{ $agenda['COD_EVENTO'] }}</td>                               
                                <td>{{ $agenda['COD_TIP_EVENTO'] }}</td>                              
                                <td>{{ \Carbon\Carbon::parse($agenda['FEC_HRS_EVENTO'])->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($agenda['DURACION_EVENTO'])->format('h/m/s') }}</td>                                                                
                                <td>{{ $agenda['LUGAR'] }}</td>
                                <td>{{ $agenda['DESCRIPCION'] }}</td>
                                <td>{{ $agenda['RESPONSABLE'] }}</td>
                                <td>{{ $agenda['ESTADO'] }}</td>
                                <td>{{ $agenda['OBSERVACIONES'] }}</td>
                                <td>                               
                                <button class="btn btn-info btn-sm" onclick="mostrarDetalles('{{ $agenda['COD_EVENTO'] }}', '{{ $agenda['COD_TIP_EVENTO'] }}', '{{ $agenda['FEC_HRS_EVENTO'] }}', '{{ $agenda['LUGAR'] }}', '{{ $agenda['DESCRIPCION'] }}', '{{ $agenda['RESPONSABLE'] }}', '{{ $agenda['ESTADO'] }}', '{{ $agenda['OBSERVACIONES'] }}')">
                                    <i class="fas fa-info-circle"></i> Ver
                                </button>
                                <button class="btn btn-warning btn-sm" onclick="mostrarModificar('{{ $agenda['COD_EVENTO'] }}', '{{ $agenda['COD_TIP_EVENTO'] }}', '{{ $agenda['FEC_HRS_EVENTO'] }}', '{{ $agenda['LUGAR'] }}', '{{ $agenda['DESCRIPCION'] }}', '{{ $agenda['RESPONSABLE'] }}', '{{ $agenda['ESTADO'] }}', '{{ $agenda['OBSERVACIONES'] }}')">
                                    <i class="fas fa-edit"></i> Modificar
                                </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
    </div> 

<!-- Modal para Ingresar Nuevo Evento -->
<div class="modal fade" id="nuevoEventoModal" tabindex="-1" aria-labelledby="nuevoEventoModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
        <div class="modal-content border-warning">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
        <h5 class="modal-title d-flex align-items-center fw-bolde" id="nuevoEventoModalLabel">NUEVO EVENTO</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Cuerpo del Modal -->
      <div class="modal-body">
        @csrf
        <!-- Botón para seleccionar Tipo de Evento -->
        <div class="mb-3 d-flex justify-content-end">
          <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#tipoEventoModal">
            <i class="fas fa-search me-1"></i> Buscar Tipo Evento
          </button>
        </div>
        
        <!-- Formulario de Ingreso de Evento -->
       
        <form class="row g-3 needs-validation" id="nuevoEventoForm" novalidate method="POST"  action="{{ url('/crearAgenda') }}">
        @csrf
          <div class="row">
              <div class="col-md-3">
                <label for="COD_TIP_EVENTO" class="form-label">Tipo de Evento</label>
                <input type="text" class="form-control" id="COD_TIP_EVENTO" name="COD_TIP_EVENTO" required>
              </div>
              <div class="col-md-5">
                <label for="FEC_HRS_EVENTO" class="form-label">Fecha Inicio</label>
                <input type="date" class="form-control" id="FEC_HRS_EVENTO" name="FEC_HRS_EVENTO" required>
              </div>
              <div class="col-md-4">
                <label for="DURACION_EVENTO" class="form-label">Duración</label>
                <input type="time" class="form-control" id="DURACION_EVENTO" name="DURACION_EVENTO" required>
              </div>
              <div class="mb-3">
                <label for="LUGAR" class="form-label">Lugar</label>
                <input type="text" class="form-control" id="LUGAR" name="LUGAR" 
                    required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                    onpaste="return false;">
                <div class="invalid-feedback">
                    Por favor ingrese el lugar del evento.
                </div>
              </div>
              <div class="mb-3">
                <label for="DESCRIPCION" class="form-label">Descripción</label>
                <textarea class="form-control" id="DESCRIPCION" name="DESCRIPCION" required></textarea>
              </div>
              <div class="col-md-6">
                <label for="RESPONSABLE" class="form-label">Responsable</label>
                <input type="text" class="form-control" id="RESPONSABLE" name="RESPONSABLE" 
                required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                                    onpaste="return false;">
                                <div class="invalid-feedback">
                                    Por favor ingrese el responsable del evento.
                                </div>
              </div>
              <div class="col-md-6">
                <label for="ESTADO" class="form-label">Estado</label>
                <select class="form-select" id="ESTADO" name="ESTADO" required>
                  <option selected disabled value="">Seleccione un estado</option>
                  <option value="PENDIENTE">PENDIENTE</option>
                  <option value="COMPLETO">COMPLETO</option>
                  <option value="CANCELADO">CANCELADO</option>
                </select>
                <div class="invalid-feedback">
                  Por favor seleccione un estado.
                </div>
              </div>
              <div class="mb-3">
                <label for="OBSERVACIONES" class="form-label">Observaciones</label>
                <textarea class="form-control" id="OBSERVACIONES" name="OBSERVACIONES" required></textarea>
              </div>
            </div>
        
          
          <!-- Pie del Modal -->
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success text-white">Guardar Evento</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Modal para seleccionar Tipo Proyecto -->
<div class="modal fade" id="tipoEventoModal" tabindex="-1" aria-labelledby="tipoEventoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 45%;">
        <div class="modal-content border-info">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="tipoEventoModalLabel">
                    <i class="fas fa-list me-2"></i> Seleccionar Tipo de Evento
                </h5>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: 400px;">
                <table id="tipoEventoTable" class="table table-sm table-striped table-bordered" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#nuevoEventoModal">
                    <i class="fas fa-times"></i> Cerrar 
                </button>
            </div>
        </div>
    </div>
</div>

     
          <!-- Modal Ver Detalles Proyecto -->
<div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-ml">
        <div class="modal-content border-info">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="detallesModalLabel">
                    <i class="fas fa-info-circle me-2"></i> DETALLES DEL EVENTO
                </h5>
            </div>
            <div class="modal-body">
                <table class="table table-sm" style="border-collapse: collapse;">
                    <tbody>
                        <tr style="border: none;">
                            <th style="border: none;">Código:</th>
                            <td id="detalleCodigo" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Tipo de Evento:</th>
                            <td id="detalleTipoEvento" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Fecha y Hora:</th>
                            <td id="detalleFechaHora" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Lugar:</th>
                            <td id="detalleLugar" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Descripción:</th>
                            <td id="detalleDescripcion" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Responsable:</th>
                            <td id="detalleResponsable" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Estado:</th>
                            <td id="detalleEstado" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Observaciones:</th>
                            <td id="detalleObservaciones" style="border: none;"></td>
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



 <!-- Modal Modifiacr Evento -->

<div class="modal fade" id="modificarEventoModal" tabindex="-1" aria-labelledby="modificarEventoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 30%;">
        <div class="modal-content border-warning">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarEventoModalLabel">
                    <i class="fas fa-edit me-2"></i> MODIFICAR DETALLES DEL EVENTO
                </h5>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="modificarEventoForm" novalidate method="POST" action="{{ route('updateAgenda', ['id' => $agenda['COD_EVENTO']]) }}">
                    @csrf
                    @method('PUT')
                    <div class="col-md-3">
                        <label for="modificarCOD_EVENTO" class="form-label">Código</label>       
                        <input type="text" class="form-control" id="modificarCOD_EVENTO" name="COD_EVENTO" style="width: 100%; pointer-events: none;">
                    </div>
                    <div class="col-md-9">
                        <label for="modificarCOD_TIP_EVENTO" class="form-label">Tipo de Evento</label>
                        <input type="text" class="form-control" id="modificarCOD_TIP_EVENTO" maxlength="50" name="COD_TIP_EVENTO" required>
                    </div>
                    <div class="col-12">
                        <label for="modificarFEC_HRS_EVENTO" class="form-label">Fecha y Hora</label>
                        <input type="datetime-local" class="form-control" id="modificarFEC_HRS_EVENTO" name="FEC_HRS_EVENTO" required>
                    </div>
                    <div class="col-12">
                        <label for="modificarLUGAR" class="form-label">Lugar</label>
                        <input type="text" class="form-control" id="modificarLUGAR" name="LUGAR" required>
                    </div>
                    <div class="col-12">
                        <label for="modificarDESCRIPCION" class="form-label">Descripción</label>
                        <textarea class="form-control" id="modificarDESCRIPCION" name="DESCRIPCION" rows="3" required></textarea>
                    </div>
                    <div class="col-12">
                        <label for="modificarRESPONSABLE" class="form-label">Responsable</label>
                        <input type="text" class="form-control" id="modificarRESPONSABLE" name="RESPONSABLE" required>
                    </div>
                    <div class="col-md-4">
                        <label for="ESTADO" class="form-label">Estado</label>
                        <select class="form-select" id="modificarESTADO" name="ESTADO" required>
                            <option selected disabled value="">Seleccione un estado</option>
                            <option value="PENDIENTE">PENDIENTE</option>
                            <option value="COMPLETO">COMPLETO</option>
                            <option value="CANCELADO">CANCELADO</option>                        
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un estado.
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="modificarOBSERVACIONES" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="modificarOBSERVACIONES" name="OBSERVACIONES" rows="3" required></textarea>
                    </div>
                    <div class="col-12 text-center">
                        <button id="btnModificar" class="btn btn-success text-white" type="submit">
                            <i class="fas fa-save me-2"></i> Guardar Cambios
                        </button>
                        <button type="button" class="btn" style="background-color: #e74c3c; color: white; border: none;" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cerrar
                        </button>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

<!-- SweetAlert JS -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- FontAwesome JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>

<script>

$(document).ready(function(){
            $('#EventoTable').DataTable({
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


document.addEventListener('DOMContentLoaded', function() {
    const tipoEventoTable = $('#tipoEventoTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/buscar_eventos',
            dataSrc: 'data'
        },
        columns: [
            { 
                data: 'COD_TIP_EVENTO',
                
            },
            { 
                data: 'NOMBRE',
                
            },
            { 
                data: null,
                defaultContent: '<button class="btn btn-success btn-sm"><i class="fas fa-check"></i></button>',
                
            }
        ],
       
        pageLength: 3,
        lengthChange: false,
        scrollY: '200px',
        scrollCollapse: true,
        language: {
            search: "Buscar:",
            paginate: {
                previous: "Ant.",
                next: "Sig."
            },
            info: "",
            infoEmpty: "",
            zeroRecords: ""
        }
    });

    $('#tipoEventoTable tbody').on('click', 'button', function() {
        const data = tipoProyectoTable.row($(this).parents('tr')).data();
        
        document.getElementById('COD_TIP_EVENTO').value = data.COD_TIP_EVENTO;
        document.getElementById('NOMBRE').value = data.NOMBRE;

        $('#tipoEventoModal').modal('hide');
        $('#nuevoEventoModal').modal('show');
    });
});


function mostrarDetalles(codigo, tipoEvento, fechaHora, lugar, descripcion, responsable, estado, observaciones) {
    // Asignar valores a los elementos del modal
    document.getElementById('detalleCodigo').innerText = codigo;
    document.getElementById('detalleTipoEvento').innerText = tipoEvento;
    document.getElementById('detalleFechaHora').innerText = fechaHora;
    document.getElementById('detalleLugar').innerText = lugar;
    document.getElementById('detalleDescripcion').innerText = descripcion;
    document.getElementById('detalleResponsable').innerText = responsable;
    document.getElementById('detalleEstado').innerText = estado;
    document.getElementById('detalleObservaciones').innerText = observaciones;

    // Mostrar el modal
    new bootstrap.Modal(document.getElementById('detallesModal')).show();
}


function mostrarModificar(codigo, tipoEvento, fechaHora, lugar, descripcion, responsable, estado, observaciones) {
                $('#modificarCOD_EVENTO').val(codigo);
                $('#modificarCOD_TIP_EVENTO').val(tipoEvento);
                $('#modificarFEC_HRS_EVENTO').val(fechaHora);
                $('#modificarLUGAR').val(lugar);
                $('#modificarDESCRIPCION').val(descripcion);
                $('#modificarRESPONSABLE').val(responsable);
                $('#modificarESTADO').val(estado);
                $('#modificarOBSERVACIONES').val(observaciones);
                $('#modificarEventoModal').modal('show');
            }


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
