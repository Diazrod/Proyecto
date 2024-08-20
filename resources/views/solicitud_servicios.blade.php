<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud</title>
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
</head>
<body>

@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content_header')
@stop
   
@section('content')
    <div class="container">
        <div class="row align-items-center mb-4">
            <!-- Título -->
            <div class="col text-center">
                <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 65px; text-shadow: 2px 2px rgba(72, 201, 176, 0.8); letter-spacing: 1px;">
                    Solicitudes de Servicios
                </h1>
            </div>
            <!-- Botón Nuevo -->
            <div class="col-auto">
            <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white;" data-bs-toggle="modal" data-bs-target="#nuevoSolicitudModal">
                <i class="fas fa-plus"></i> Nueva Solicitud de Servicio
            </button>
        </div>
    </div>

            <div class="table-responsive">
                <!-- Tabla de Evento -->
                <table id="solicitudTable" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
                    <thead>
                        <tr>
                            <th>Código</th>        
                            <th>Tipo</th>                           
                            <th>Descripcion</th>                                                      
                            <th>Nombre Solicitante</th>
                            <th>Telefono</th>
                            <th>Fecha de servicio</th>
                            <th>Lugar</th>
                            <th>Observaciones</th>
                            <th>Fecha del Registro</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        @foreach ($ResulSolicitud as $solicitud_servicios)
                            <tr>
                                <td>{{ $solicitud_servicios['COD_SOLICITUD'] }}</td>                               
                                <td>{{ $solicitud_servicios['COD_TIP_EVENTO'] }}</td>   
                                <td>{{ $solicitud_servicios['DESC_EVENTO'] }}</td> 
                                <td>{{ $solicitud_servicios['NOM_SOLICITANTE'] }}</td>    
                                <td>{{ $solicitud_servicios['TEL_SOLICITANTE'] }}</td>                      
                                <td>{{ \Carbon\Carbon::parse($solicitud_servicios['FEC_HRS_SERVICIO'])->format('d/m/Y') }}</td>
                                <td>{{ $solicitud_servicios['LUGAR'] }}</td>
                                <td>{{ $solicitud_servicios['OBSERVACION'] }}</td>
                                <td>{{ \Carbon\Carbon::parse($solicitud_servicios['FEC_REGISTRO'])->format('d/m/Y') }}</td>                                                                
                                <td>{{ $solicitud_servicios['ESTADO'] }}</td>                                
                                <td>                               
                                <button class="btn btn-info btn-sm" onclick="mostrarDetalles(
                                    '{{ $solicitud_servicios['COD_SOLICITUD'] }}',
                                    '{{ $solicitud_servicios['COD_TIP_EVENTO'] }}',
                                    '{{ $solicitud_servicios['DESC_EVENTO'] }}',
                                    '{{ $solicitud_servicios['NOM_SOLICITANTE'] }}',
                                    '{{ $solicitud_servicios['TEL_SOLICITANTE'] }}',
                                    '{{ $solicitud_servicios['FEC_HRS_SERVICIO'] }}',
                                    '{{ $solicitud_servicios['LUGAR'] }}',
                                    '{{ $solicitud_servicios['OBSERVACION'] }}',
                                    '{{ $solicitud_servicios['FEC_REGISTRO'] }}',
                                    '{{ $solicitud_servicios['ESTADO'] }}'
                                )">
                                    <i class="fas fa-info-circle"></i> Ver
                                </button>
                                <button class="btn btn-warning btn-sm" onclick="mostrarModificar(
                                    '{{ $solicitud_servicios['COD_SOLICITUD'] }}',
                                    '{{ $solicitud_servicios['COD_TIP_EVENTO'] }}',
                                    '{{ $solicitud_servicios['DESC_EVENTO'] }}',
                                    '{{ $solicitud_servicios['NOM_SOLICITANTE'] }}',
                                    '{{ $solicitud_servicios['TEL_SOLICITANTE'] }}',
                                    '{{ $solicitud_servicios['FEC_HRS_SERVICIO'] }}',
                                    '{{ $solicitud_servicios['LUGAR'] }}',
                                    '{{ $solicitud_servicios['OBSERVACION'] }}',
                                    '{{ $solicitud_servicios['FEC_REGISTRO'] }}',
                                    '{{ $solicitud_servicios['ESTADO'] }}'
                                )">
                                    <i class="fas fa-edit"></i> Modificar
                                </button>
                            </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>


<!-- Modal para Ingresar Nuevo Evento -->
<div class="modal fade" id="nuevoSolicitudModal" tabindex="-1" aria-labelledby="nuevoSolicitudModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
        <div class="modal-content border-warning">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
        <h5 class="modal-title d-flex align-items-center fw-bolde" id="nuevoSolicitudModalLabel">NUEVA SOLICITUD</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Cuerpo del Modal -->
      <div class="modal-body">
        @csrf
    
        <!-- Formulario de Ingreso de Evento -->
       
        <form class="row g-3 needs-validation" id="nuevoSolicitudForm" novalidate method="POST"  action="{{ url('/crearSolicitud') }}">
        @csrf
        <div class="modal-body">
          <div class="form-group">
            <label for="COD_TIP_EVENTO">Tipo de evento</label>
            <input type="text" class="form-control" id="COD_TIP_EVENTO" name="COD_TIP_EVENTO" required>
          </div>
          <div class="form-group">
            <label for="DESC_EVENTO">Descripción</label>
            <input type="text" class="form-control" id="DESC_EVENTO" name="DESC_EVENTO" 
            required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                                    onpaste="return false;">
                                <div class="invalid-feedback">
                                    Por favor ingrese la descripcion de la solicitud.
                                </div>
          </div>
          <div class="form-group">
            <label for="NOM_SOLICITANTE">Nombre del Solicitante</label>
            <input type="text" class="form-control" id="NOM_SOLICITANTE" name="NOM_SOLICITANTE" 
            required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                                    onpaste="return false;">
                                <div class="invalid-feedback">
                                    Por favor ingrese el nombre del solicitante.
                                </div>
          </div>
          <div class="form-group">
            <label for="TEL_SOLICITANTE">Teléfono</label>
            <input type="text" class="form-control" id="TEL_SOLICITANTE" name="TEL_SOLICITANTE" required>
          </div>
          <div class="form-group">
            <label for="FEC_HRS_SERVICIO">Fecha de Servicio</label>
            <input type="datetime-local" class="form-control" id="FEC_HRS_SERVICIO" name="FEC_HRS_SERVICIO" required>
          </div>
          <div class="form-group">
            <label for="LUGAR">Lugar</label>
            <input type="text" class="form-control" id="LUGAR" name="LUGAR" required>
          </div>
          <div class="form-group">
            <label for="OBSERVACION">Observaciones</label>
            <textarea class="form-control" id="OBSERVACION" name="OBSERVACION" required></textarea>
          </div>
          <div class="form-group">
            <label for="FEC_REGISTRO">Fecha de Registro</label>
            <input type="datetime-local" class="form-control" id="FEC_REGISTRO" name="FEC_REGISTRO" required>
          </div>
          <div class="col-md-6">
                <label for="ESTADO" class="form-label">Estado</label>
                <select class="form-select" id="ESTADO" name="ESTADO" required>
                  <option selected disabled value="">Seleccione un estado</option>
                  <option value="PROCESO">PROCESO</option>
                  <option value="APROBADO">APROBADO</option>
                  <option value="RECHAZADO">RECHAZADO</option>
                  <option value="CANCELADO">CANCELADO</option>
                </select>
                <div class="invalid-feedback">
                  Por favor seleccione un estado.
                </div>
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

         
           
          <!-- Modal Ver Detalles Proyecto -->
<div class="modal fade" id="detallesSolicitudModal" tabindex="-1" aria-labelledby="detallesSolicitudModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-ml">
        <div class="modal-content border-info">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="detallesSolicitudModalLabel">
                    <i class="fas fa-info-circle me-2"></i> DETALLES DE LA SOLICITUD
                </h5>
            </div>
            <div class="modal-body">
                <table class="table table-sm" style="border-collapse: collapse;">
                    <tbody>
                        <tr style="border: none;">
                            <th style="border: none;">Código Solicitud:</th>
                            <td id="detalleCodSolicitud" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Código Tipo Evento:</th>
                            <td id="detalleCodTipEvento" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Descripción del Evento:</th>
                            <td id="detalleDescEvento" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Nombre del Solicitante:</th>
                            <td id="detalleNomSolicitante" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Teléfono del Solicitante:</th>
                            <td id="detalleTelSolicitante" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Fecha y Hora del Servicio:</th>
                            <td id="detalleFechaHoraServicio" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Lugar:</th>
                            <td id="detalleLugar" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Observaciones:</th>
                            <td id="detalleObservacion" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Fecha de Registro:</th>
                            <td id="detalleFechaRegistro" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Estado:</th>
                            <td id="detalleEstado" style="border: none;"></td>
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
           

<div class="modal fade" id="modificarSolicitudModal" tabindex="-1" aria-labelledby="modificarSolicitudModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 30%;">
        <div class="modal-content border-warning">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarSolicitudModalLabel">
                    <i class="fas fa-edit me-2"></i> MODIFICAR SOLICITUD
                </h5>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="modificarSolicitudForm" novalidate method="POST" action="{{ route('updateSolicitud', ['id' => $solicitud_servicios['COD_SOLICITUD']]) }}">
                    @csrf
                    @method('PUT')
                    <div class="col-md-3">
                        <label for="modificarCodSolicitud" class="form-label">Código Solicitud</label>       
                        <input type="text" class="form-control" id="modificarCodSolicitud" name="COD_SOLICITUD" style="width: 100%; pointer-events: none;">
                    </div>
                    <div class="col-md-9">
                        <label for="modificarCodTipEvento" class="form-label">Código Tipo Evento</label>
                        <input type="text" class="form-control" id="modificarCodTipEvento" maxlength="50" name="COD_TIP_EVENTO" required>
                    </div>
                    <div class="col-12">
                        <label for="modificarDescEvento" class="form-label">Descripción del Evento</label>
                        <textarea class="form-control" id="modificarDescEvento" name="DESC_EVENTO" rows="3" required></textarea>
                    </div>
                    <div class="col-12">
                        <label for="modificarNomSolicitante" class="form-label">Nombre del Solicitante</label>
                        <input type="text" class="form-control" id="modificarNomSolicitante" name="NOM_SOLICITANTE" required>
                    </div>
                    <div class="col-12">
                        <label for="modificarTelSolicitante" class="form-label">Teléfono del Solicitante</label>
                        <input type="text" class="form-control" id="modificarTelSolicitante" name="TEL_SOLICITANTE" required>
                    </div>
                    <div class="col-12">
                        <label for="modificarFechaHoraServicio" class="form-label">Fecha y Hora del Servicio</label>
                        <input type="datetime-local" class="form-control" id="modificarFechaHoraServicio" name="FEC_HRS_SERVICIO" required>
                    </div>
                    <div class="col-12">
                        <label for="modificarLugar" class="form-label">Lugar</label>
                        <input type="text" class="form-control" id="modificarLugar" name="LUGAR" required>
                    </div>
                    <div class="col-12">
                        <label for="modificarObservacion" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="modificarObservacion" name="OBSERVACION" rows="3" required></textarea>
                    </div>
                    <div class="col-12">
                        <label for="modificarFechaRegistro" class="form-label">Fecha de Registro</label>
                        <input type="datetime-local" class="form-control" id="modificarFechaRegistro" name="FEC_REGISTRO" required>
                    </div>
                    <div class="col-md-6">
                        <label for="modificarEstado" class="form-label">Estado</label>
                        <select class="form-select" id="modificarEstado" name="ESTADO" required>
                        <option selected disabled value="">Seleccione un estado</option>
                        <option value="PROCESO">PROCESO</option>
                        <option value="APROBADO">APROBADO</option>
                        <option value="RECHAZADO">RECHAZADO</option>
                        <option value="CANCELADO">CANCELADO</option>
                        </select>
                        <div class="invalid-feedback">
                        Por favor seleccione un estado.
                        </div>
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
            $('#eventoTable').DataTable({
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

function mostrarDetalles(codSolicitud, codTipEvento, descEvento, nomSolicitante, telSolicitante, fechaHoraServicio, lugar, observacion, fechaRegistro, estado) {
    document.getElementById('detalleCodSolicitud').innerText = codSolicitud;
    document.getElementById('detalleCodTipEvento').innerText = codTipEvento;
    document.getElementById('detalleDescEvento').innerText = descEvento;
    document.getElementById('detalleNomSolicitante').innerText = nomSolicitante;
    document.getElementById('detalleTelSolicitante').innerText = telSolicitante;
    document.getElementById('detalleFechaHoraServicio').innerText = fechaHoraServicio;
    document.getElementById('detalleLugar').innerText = lugar;
    document.getElementById('detalleObservacion').innerText = observacion;
    document.getElementById('detalleFechaRegistro').innerText = fechaRegistro;
    document.getElementById('detalleEstado').innerText = estado;
    new bootstrap.Modal(document.getElementById('detallesSolicitudModal')).show();
}        

function mostrarModificar(codSolicitud, codTipEvento, descEvento, nomSolicitante, telSolicitante, fechaHoraServicio, lugar, observacion, fechaRegistro, estado) {
    document.getElementById('modificarCodSolicitud').value = codSolicitud;
    document.getElementById('modificarCodTipEvento').value = codTipEvento;
    document.getElementById('modificarDescEvento').value = descEvento;
    document.getElementById('modificarNomSolicitante').value = nomSolicitante;
    document.getElementById('modificarTelSolicitante').value = telSolicitante;
    document.getElementById('modificarFechaHoraServicio').value = fechaHoraServicio;
    document.getElementById('modificarLugar').value = lugar;
    document.getElementById('modificarObservacion').value = observacion;
    document.getElementById('modificarFechaRegistro').value = fechaRegistro;
    document.getElementById('modificarEstado').value = estado;
    new bootstrap.Modal(document.getElementById('modificarSolicitudModal')).show();
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