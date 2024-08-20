<!DOCTYPE html>
<html lang="es">
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

    

    @extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content_header')
@stops
</head>
<body>
    @section('content_header')
    @stop

    @section('content')
        <div class="container mt-4">

            <div class="d-flex justify-content-between mb-3 align-items-center">
            <div class="col-auto">
                <!-- Coloca aquí la imagen correspondiente a 'Detalles Generales' -->
                <img src="{{ asset('vendor/adminlte/dist/img/general2.png') }}" style="width: 190px; height: 190px;">
            </div>
                <div class="col text-center">
                    <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 55px; text-shadow: 2px 2px rgba(72, 201, 176, 0.8); letter-spacing: 1px;">
                        Solicitud de Ayuda Social
                    </h1>
                </div>
                <!-- Botón Nuevo -->
                <div class="col-auto">
                <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 16; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
                <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white;" data-bs-toggle="modal" data-bs-target="#nuevaSolicitudModal">
    <i class="fas fa-plus"></i> Nueva Solicitud
</button>
@endif
                </div>
            </div>

            <div class="container mt-5">
        <!-- Tabla de Solicitudes -->
        @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
        <table id="solicitudesTable" class="table table-striped">
            <thead style="background-color: #48C9B0; color: white;">
                <tr>
                    <th  style="background-color:#48C9B0; color: black; text-align: center;">Código</th>
                    <th  style="background-color:#48C9B0; color: black; text-align: center;">Nombre</th>
                    <th  style="background-color:#48C9B0; color: black; text-align: center;">Tipo de Ayuda</th>
                    <th  style="background-color:#48C9B0; color: black; text-align: center;">Fecha de Solicitud</th>
                    <th  style="background-color:#48C9B0; color: black; text-align: center;">Fecha de Resolución</th>
                    <th  style="background-color:#48C9B0; color: black; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($solicitudes as $solicitud)
                    <tr>
                        <td style="text-align: center">{{ $solicitud['COD_SOLICITUD'] }}</td>
                        <td style="text-align: center">{{ $solicitud['NOMBRE_COMPLETO'] }}</td>
                        <td style="text-align: center">{{ $solicitud['TIPO_AYUDA_DEFINIDO'] }}</td>
                        <td style="text-align: center">{{ \Carbon\Carbon::parse($solicitud['FEC_SOLICITUD'])->format('d/m/Y') }}</td>
                        <td style="text-align: center">{{ \Carbon\Carbon::parse($solicitud['FEC_RESOLUCION'])->format('d/m/Y') }}</td>
                        <td>
                            <button class="btn btn-info btn-sm" onclick="mostrarDetalles('{{ $solicitud['COD_SOLICITUD'] }}', '{{ $solicitud['NOMBRE_COMPLETO'] }}', '{{ $solicitud['TIPO_AYUDA_DEFINIDO'] }}', '{{ $solicitud['COD_PERSONAS'] }}', '{{ \Carbon\Carbon::parse($solicitud['FEC_SOLICITUD'])->format('d/m/Y') }}', '{{ $solicitud['ESTADO'] }}', '{{ $solicitud['OBSERVACIONES'] }}')">
                                <i class="fas fa-info-circle"></i> Ver
                            </button>
                            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                            <button class="btn btn-warning btn-sm" onclick="mostrarModificar(
    '{{ $solicitud['COD_SOLICITUD'] }}',
    '{{ $solicitud['NOMBRE_COMPLETO'] }}',
    '{{ $solicitud['TIPO_AYUDA_DEFINIDO'] }}',
    '{{ $solicitud['COD_PERSONAS'] }}',
    '{{ \Carbon\Carbon::parse($solicitud['FEC_SOLICITUD'])->format('Y-m-d') }}',
    '{{ \Carbon\Carbon::parse($solicitud['FEC_RESOLUCION'])->format('Y-m-d') }}',
    '{{ $solicitud['ESTADO'] }}',
    '{{ $solicitud['OBSERVACIONES'] }}'
)">
    <i class="fas fa-edit"></i> Editar
</button>
@endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
            
        <!-- Modal para Nueva Solicitud -->
<div class="modal fade" id="nuevaSolicitudModal" tabindex="-1" aria-labelledby="nuevaSolicitudModalLabel" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
        <div class="modal-content border-warning">
            <!-- Encabezado del Modal -->
            <div class="modal-header" style="background-color: #48C9B0; color: white;"> <!-- Color del encabezado -->
                <h5 class="modal-title d-flex align-items-center fw-bold" id="nuevaSolicitudModalLabel">
                    <i class="fas fa-plus me-2"></i> NUEVA SOLICITUD DE AYUDA SOCIAL
                </h5>
               
            </div>
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="nuevaSolicitudForm" novalidate method="POST" action="{{ url('/solicitud_INS') }}">
                
                    @csrf

                    <div class="d-flex justify-content-end mb-3">
                        <a href="#" class="btn btn-success btn-sm d-flex align-items-center" id="btnMostrarModal1" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; line-height: 1;">
                            <i class="fas fa-user me-1" style="font-size: 1rem;"></i>
                            <span style="font-size: 0.7rem;">Seleccionar Persona</span>
                        </a>
                    </div>



                    <div class="modal fade" id="resultadosModal1" tabindex="-1" aria-labelledby="resultadosModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 45%;">
        <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                <h3 class="modal-title fw-bold text-white" id="resultadosModalLabel1"><i class="fas fa-users me-2 text-white"></i> Registro de Persona</h3>
                <a href="#" class="btn btn-danger position-absolute top-0 end-0 m-0 p-2 text-white" style="width: 40px; height: 40px; line-height: 1;" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></a>
            </div>
            <div class="modal-body">
                <a href="#" class="btn btn-success position-absolute top-3 start-3 m-0 p-2 text-white" style="width: 43px; height: 43px; line-height: 1;" data-bs-dismiss="modal" aria-label="Add New">
                    <i class="fas fa-user-plus"></i>
                </a>
                <table id="tablaResultados1" class="table table-striped table-bordered" style="width: 100%">
                    <thead>
                        <tr>
                            <th>#</th> <!-- Nueva columna para el botón con ícono -->
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Fecha Nacimiento</th>
                            <!-- Agrega aquí las columnas adicionales que desees mostrar -->
                        </tr>
                    </thead>
                                    <tbody>
                                        <!-- Los datos del DataTable se cargarán aquí dinámicamente -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
    


       
                    <!-- Campo de Código de Persona -->
                    <div class="col-md-6">
                        <label for="CODIGO_PERSONA" class="form-label">Código de Persona</label>
                        <input type="text" class="form-control" id="CODIGO_PERSONA" name="CODIGO_PERSONA" style="width: 100%; pointer-events: none;" required>
                        <div class="invalid-feedback">
                            .
                        </div>
                    </div>
                    <!-- Otros Campos del Formulario -->
                    <div class="col-md-6">
                        <label for="NOMBRE" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" style="width: 100%; pointer-events: none;"  required>
                        <div class="invalid-feedback">
                            Por Seleccione una Persona.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="TIPO_AAYUDA" class="form-label">Tipo de Ayuda</label>
                        <select class="form-select" id="TIPO_AAYUDA" name="TIPO_AAYUDA" required>
                            <option selected disabled value="">Selecciones Tipo Ayuda</option>
                            <option value="ALIMENTARIA">ALIMENTOS</option>
                            <option value="MÉDICA">MÉDICA</option>
                            <option value="ECONÓMICA">ECONOMICA</option>
                            <option value="VIVIENDA">VIVIENDA</option>
                           
                            <!-- Agrega más opciones según sea necesario -->
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un tipo de ayuda.
                        </div>
                    </div>
                   
                    <div class="col-md-6">
                        <label for="FECHA_SOLICITUD" class="form-label">Fecha de Solicitud</label>
                        <input type="date" class="form-control" id="FECHA_SOLICITUD" name="FECHA_SOLICITUD" required>
                        <div class="invalid-feedback">
                            Por favor ingrese la fecha de solicitud.
                        </div>
                    </div>
                    <div class="col-md-6">
    <label for="FECHA_RESOLUCION" class="form-label">Fecha de Resolución</label>
    <input type="date" class="form-control" id="FECHA_RESOLUCION" name="FECHA_RESOLUCION" >
    <div class="invalid-feedback">
        Por favor ingrese la fecha de resolución.
    </div>
</div>

                    <div class="col-md-6">
                        <label for="ESTADO" class="form-label">Estado</label>
                        <select class="form-select" id="ESTADO" name="ESTADO" required>
                            <option selected disabled value="">Seleccione un estado</option>
                            <option value="PENDIENTE">PENDIENTE</option>
                            <option value="EN PROCESO">PROCESO</option>
                            <option value="APROBADA">APROBADO</option>
                            <option value="RECHAZADA">RECHAZADA</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un estado.
                        </div>
                    </div>
                    <div class="col-12">
    <label for="OBSERVACIONES" class="form-label">Observaciones</label>
    <textarea class="form-control" id="OBSERVACIONES" name="OBSERVACIONES" maxlength="500" rows="3" placeholder="Ingrese observaciones adicionales" maxlength="100" onpaste="return false;" oncopy="return false;" oncut="return false;"></textarea>
    <div class="invalid-feedback">
        Por favor ingrese observaciones adicionales.
    </div>
</div>

                   
                    
                
            </div>
            <!-- Pie del Modal con Botón Rojo -->
            <div class="modal-footer">
            <div class="col-12 text-center">
                        <button id="btnGuardar" class="btn btn-success text-white" type="submit">
                            <i class="fas fa-save me-2"></i> Guardar
                        </button>
                        <a href="/solicitud" class="btn btn-danger" >
    <i class="fas fa-times"></i> Cerrar
</a>

            </div>

            </form>
        </div>
    </div>
</div>
</div>



            <!-- Modal Ver Detalles -->
            <div class="modal fade" id="verDetallesModal" tabindex="-1" aria-labelledby="verDetallesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-ml"> <!-- Tamaño pequeño para el modal -->
        <div class="modal-content border-info">
            <div class="modal-header" style="background-color: #48C9B0; color: white;"> <!-- Color del encabezado -->
                <h5 class="modal-title d-flex align-items-center fw-bold" id="verDetallesModalLabel">
                    <i class="fas fa-info-circle me-2"></i> DETALLES DE SOLICITUD
                </h5>
                
            </div>
            <div class="modal-body">
                <table class="table table-sm"> <!-- Clase table-sm para tamaño reducido -->
                    <tbody>
                        <tr>
                            <th>Código:</th>
                            <td id="detalleCodigo"></td>
                        </tr>
                        <tr>
                            <th>Código Persona:</th>
                            <td id="detalleDescripcion"></td>
                        </tr>
                        <tr>
                            <th>Nombre:</th>
                            <td id="detalleNombre"></td>
                        </tr>
                        <tr>
                            <th>Tipo de Ayuda:</th>
                            <td id="detalleTipoAyuda"></td>
                        </tr>
                        <tr>
                            <th>Fecha de Solicitud:</th>
                            <td id="detalleFechaSolicitud"></td>
                        </tr>
                        <tr>
                            <th>Estado:</th>
                            <td id="detalleEstado"></td>
                        </tr>
                        <tr>
                            <th>Observaciones:</th>
                            <td id="detalleObservaciones"></td>
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

<!-- Estilos CSS para quitar los bordes de la tabla -->
<style>
    .table th, .table td {
        border: none;
    }
    .table {
        margin-bottom: 0;
    }
</style>


            <!-- Modal Modificar Solicitud -->
            <div class="modal fade" id="modificarSolicitudModal" tabindex="-1" aria-labelledby="modificarSolicitudModalLabel" aria-hidden="true">
                
                <div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
        <div class="modal-content border-warning">
            <!-- Encabezado del Modal -->
            <div class="modal-header" style="background-color: #48C9B0; color: white;"> <!-- Color del encabezado -->
                <h5 class="modal-title d-flex align-items-center fw-bold" id="nuevaSolicitudModalLabel">
                    <i class="fas fa-edit me-2"></i> MODIFICAR SOLICITUD DE AYUDA SOCIAL
                </h5>
                        </div>
                        <div class="modal-body">
                        <form class="row g-3 needs-validation" id="modificarSolicitudForm" 
      action="{{ route('social.update', ['id' => $solicitud['COD_SOLICITUD']]) }}" 
      novalidate method="POST">
    @csrf
    @method('PUT')
                            
                            
                        

                                <div class="col-md-3">
                                    <label for="MODIFICAR_NOMBRE" class="form-label">Codigo Solicitud</label>
                                    <input type="NUMBER"  class="form-control" name="MODIFICAR_COD_SOLICITUD" id="MODIFICAR_COD_SOLICITUD" style="width: 100%; pointer-events: none;" name="MODIFICAR_COD_SOLICITUD">
                                    <div class="invalid-feedback">
                                        Por favor ingrese el nombre del solicitante.
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="MODIFICAR_DESCRIPCION" class="form-label">Codigo Persona</label>
                                    <input type="text" class="form-control" name="MODIFICAR_DESCRIPCION" id="MODIFICAR_DESCRIPCION" style="width: 100%; pointer-events: none;" name="MODIFICAR_DESCRIPCION" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese una descripción.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="MODIFICAR_NOMBRE" class="form-label">Nombre Persona</label>
                                    <input type="text" class="form-control" id="MODIFICAR_NOMBRE" style="width: 100%; pointer-events: none;" name="MODIFICAR_NOMBRE" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese el nombre del solicitante.
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for="MODIFICAR_TIPO_AAYUDA" class="form-label">Tipo de Ayuda</label>
                                    <select class="form-select" id="MODIFICAR_TIPO_AAYUDA" name="MODIFICAR_TIPO_AAYUDA" required>
                                    <option selected disabled value="">Selecciones Tipo Ayuda</option>
                                    <option value="ALIMENTARIA">ALIMENTOS</option>
                            <option value="MÉDICA">MÉDICA</option>
                            <option value="ECONÓMICA">ECONOMICA</option>
                            <option value="VIVIENDA">VIVIENDA</option>
                                    </select>
                                    <div class="invalid-feedback">
                                        Por favor seleccione un tipo de ayuda.
                                    </div>
                                </div>
                               
                                <div class="col-md-6">
                                    <label for="MODIFICAR_FECHA_SOLICITUD" class="form-label">Fecha de Solicitud</label>
                                    <input type="TEXT" class="form-control" id="MODIFICAR_FECHA_SOLICITUD" name="MODIFICAR_FECHA_SOLICITUD" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese la fecha de solicitud.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="MODIFICAR_FECHA_SOLICITUD" class="form-label">Fecha de Resolución</label>
                                    <input type="TEXT" class="form-control" id="MODIFICAR_RESOLUCION" name="MODIFICAR_RESOLUCION" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese la fecha de solicitud.
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label for="MODIFICAR_ESTADO" class="form-label">Estado</label>
                                    <select class="form-select" id="MODIFICAR_ESTADO" name="MODIFICAR_ESTADO" required>
                            <option selected disabled value="">Seleccione un estado</option>
                            <option value="PENDIENTE">PENDIENTE</option>
                            <option value="EN PROCESO">PROCESO</option>
                            <option value="APROBADA">APROBADO</option>
                            <option value="RECHAZADA">RECHAZADA</option>
                        </select>
                                    <div class="invalid-feedback">
                                        Por favor seleccione un estado.
                                    </div>
                                </div>
                                <div class="col-12">
    <label for="MODIFICAR_OBSERVACIONES" class="form-label">Observaciones</label>
    <textarea class="form-control" id="MODIFICAR_OBSERVACIONES"  maxlength="500" name="MODIFICAR_OBSERVACIONES" rows="3" maxlength="100" 
              placeholder="Ingrese observaciones adicionales" 
              onpaste="return false;" 
              oncopy="return false;" 
              oncut="return false;"></textarea>
    <div class="invalid-feedback">
        Por favor ingrese observaciones adicionales.
    </div>
</div>

                                
                                <div class="modal-footer text-end">
    <button id="btnGuardar1" class="btn btn-success text-white me-2" type="submit">
        <i class="fas fa-save me-2"></i> Guardar Cambios
    </button>
    <a href="/solicitud" class="btn btn-danger">
        <i class="fas fa-times"></i> Cerrar
    </a>
</div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @stop

     <!-- Scripts -->
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    // scrip de la modal para buscar persona bautizada 
    $(document).ready(function() {
        $('#btnMostrarModal1').click(function() {
            $('#resultadosModal1').modal('show'); // Mostrar modal al hacer clic en el botón
            cargarTablaResultados1(); // Cargar los datos en la tabla
        });

        function cargarTablaResultados1() {
            // Destruir instancia existente de DataTable si existe
            if ($.fn.DataTable.isDataTable('#tablaResultados1')) {
                $('#tablaResultados1').DataTable().destroy();
            }

            $('#tablaResultados1').DataTable({
                "processing": false, // Mostrar mensaje "Cargando..." durante la carga
                "serverSide": true, // Habilitar procesamiento del lado del servidor
                "searching": true, // Habilitar búsqueda
                "paging": true, // Habilitar paginación
                "lengthChange": false, // Deshabilitar el control de cambiar la cantidad de registros por página
                "pageLength": 3, // Mostrar 3 registros por página
                "info": false, // Deshabilitar información de cantidad de registros
                "language": { // Configuración de idioma
                    "search": "Buscar por DNI:", // Cambiar el texto del botón de búsqueda a español
                    "paginate": {
                        "previous": "Anterior",
                        "next": "Siguiente"
                    },
                    "zeroRecords": "No se encontraron registros",
                    "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                    "emptyTable": "No hay datos disponibles en la tabla", // Mensaje cuando la tabla está vacía
                    "loadingRecords": "Cargando...", // Mensaje durante la carga de registros
                    "processing": "Procesando...", // Mensaje durante el procesamiento
                    "infoFiltered": "(filtrado de _MAX_ registros totales)"
                },
                "ajax": {
                    "url": "{{ route('personas.obtener') }}",
                    "type": "GET",
                    "dataSrc": "data" // Asegurarse de que DataTables use la propiedad 'data' de la respuesta
                },




                
                "columns": [
                    {
                        "data": null,
                        "render": function(data, type, row, meta) {
                            return '<a href="#" class="btn btn-success rounded-circle btnCopiarParroco1" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;" data-codigo="' + row.COD_PERSONAS + '">' +
                                '<i class="fas fa-check-circle text-white"></i>' +
                                '</a>';
                        }
                    },
                    { "data": "COD_PERSONAS" },
                    {
                        "data": null,
                        "render": function (data, type, row) {
                            return `${row.PR_NOMBRE} ${row.SG_NOMBRE} ${row.PR_APELLIDO} ${row.SG_APELLIDO}`;
                        }
                    },
                    { "data": "DNI_PERSONA" },
                    { 
                        "data": "FECH_NACIMINETO",
                        "render": function(data, type, row) {
                            var date = new Date(data);
                            return date.toLocaleDateString();
                        }
                    }
                ]
            });

            // Cambiar tamaño de letra de la tabla
            $('#tablaResultados1').css('font-size', '0.8em');

            // Acción al hacer clic en el botón de copiar persona de Párroco
            $('#tablaResultados1').on('click', '.btnCopiarParroco1', function() {
    var codigoPersona = $(this).data('codigo');
    var nombrePersona = $(this).closest('tr').find('td:nth-child(3)').text(); // Obtener el nombre desde la columna correspondiente
    var dniPersona = $(this).closest('tr').find('td:nth-child(4)').text(); // Obtener el DNI desde la columna correspondiente
    var fechaNacimiento = $(this).closest('tr').find('td:nth-child(5)').text(); // Obtener la fecha de nacimiento desde la columna correspondiente


                // Ejemplo de cómo actualizar los campos del párroco con los datos de la persona seleccionada
                $('#CODIGO_PERSONA').val(codigoPersona);
                $('#NOMBRE').val(nombrePersona);
               

                // Cerrar modal opcionalmente si así lo deseas
                $('#resultadosModal1').modal('hide');
            });
        }
    });
</script>

<script>




  document.addEventListener('DOMContentLoaded', function() {
    var btnGuardar = document.getElementById('btnGuardar');
    if (btnGuardar) {
      btnGuardar.addEventListener('click', function(event) {
        var form = document.getElementById('nuevaSolicitudForm');
        if (form.checkValidity() === false) {
          event.preventDefault(); // Evitar que se envíe el formulario si no es válido
          event.stopPropagation(); // Detener la propagación del evento
        }
        form.classList.add('was-validated'); // Agregar la clase para activar los estilos de validación
      });
    }
  });



 


</script>

<script>




  document.addEventListener('DOMContentLoaded', function() {
    var btnGuardar = document.getElementById('btnGuardar1');
    if (btnGuardar) {
      btnGuardar.addEventListener('click', function(event) {
        var form = document.getElementById('modificarSolicitudForm');
        if (form.checkValidity() === false) {
          event.preventDefault(); 
          event.stopPropagation(); 
        }
        form.classList.add('was-validated');
      });
    }
  });



 


</script>
    <script>
    $(document).ready(function() {
        $('#solicitudesTable').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "pageLength": 10,
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar _MENU_ registros por página",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "No hay registros disponibles",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "paginate": {
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    });

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

    

    function mostrarDetalles(codigo, nombre, tipoAyuda, descripcion, fechaSolicitud, estado, observaciones) {
        $('#detalleCodigo').text(codigo);
        $('#detalleNombre').text(nombre);
        $('#detalleTipoAyuda').text(tipoAyuda);
        $('#detalleDescripcion').text(descripcion);
        $('#detalleFechaSolicitud').text(fechaSolicitud);
        $('#detalleEstado').text(estado);
        $('#detalleObservaciones').text(observaciones);
        $('#verDetallesModal').modal('show');
    }

    function mostrarModificar(codigo, nombre, tipoAyuda, descripcion, fechaSolicitud,fechaResolucion, estado, observaciones) {
        $('#MODIFICAR_COD_SOLICITUD').val(codigo);
        $('#MODIFICAR_NOMBRE').val(nombre);
        $('#MODIFICAR_TIPO_AAYUDA').val(tipoAyuda);
        $('#MODIFICAR_DESCRIPCION').val(descripcion);
        $('#MODIFICAR_FECHA_SOLICITUD').val(fechaSolicitud);
        $('#MODIFICAR_RESOLUCION').val(fechaResolucion);
        $('#MODIFICAR_ESTADO').val(estado);
        $('#MODIFICAR_OBSERVACIONES').val(observaciones);
        $('#modificarSolicitudModal').modal('show');
    }
    </script>
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
