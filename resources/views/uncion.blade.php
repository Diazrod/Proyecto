<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
    <title>Parroquia SMP - UNCIÓN ENFERMOS</title>
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
        td {
            text-align: center; /* Centrar el texto en las celdas */
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
        .details-container {
        margin-bottom: 20px;
        padding: 10px;
        border: 4px solid #26A69A; /* Color dorado para el borde */
        border-radius: 5px;
    }

    .details-container div {
        margin-bottom: 5px;
    }

    .details-container strong {
        font-weight: bold;
        margin-right: 10px;
        width: 150px; /* Ajusta el ancho según sea necesario */
        display: inline-block;
    }



    /* Asegúrate de que el body tenga un overflow adecuado cuando el modal esté abierto */
body.modal-open {
    overflow: auto; /* Permite el desplazamiento */
}

/* Asegúrate de que el contenido del modal no sea más alto que la vista */
.modal-content {
    max-height: 90vh; /* Ajusta según sea necesario */
    overflow: auto;   /* Permite el desplazamiento dentro del modal */
}

/* Ajusta el margen del modal para evitar que se sobreponga a la barra de desplazamiento */
.modal-dialog {
    margin: 30px auto; /* Ajusta según sea necesario */
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
                <!-- Coloca aquí la imagen correspondiente a 'Detalles Generales' -->
                <img src="{{ asset('vendor/adminlte/dist/img/general.png') }}" style="width: 190px; height: 190px;">
            </div>
            <div class="col">
                <h1 class="fw-bold text-center" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 55px; text-shadow: 4px 4px #48C9B0;">REGISTROS DE UNCION ENFERMOS</h1>
            </div>
            <div class="col-auto">
            <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 10; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
            <a href="/ins_uncion" class="btn btn-lg fw-bold" style="background-color: #1ABC9C; color: white; border: 2px solid #FFD700;" onclick="abrirModalNuevo()"><i class="fas fa-plus"></i> Nuevo Registro</a>
            @endif  
        </div>
        </div>
        <div class="table-responsive">
            
    @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
            <table id="example" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
            <thead>
                    <tr>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">Código</th>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">DNI</th>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">Nombre</th>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">Fecha</th>
                        
                        
                        
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ResulSacramentos as $uncion)
                        <tr>
                            <td tyle=" text-align: center;">{{ $uncion['COD_UNCION'] ?? 'N/A' }}</td>
                            <td>{{ $uncion['DNI'] ?? 'N/A' }}</td>
                            <td>{{ $uncion['NOMBRE_PERSONA'] ?? 'N/A' }}</td>
                            <td>{{ $uncion['DIA_UNCION'] ?? 'N/A' }} {{ $uncion['MES_UNCION'] ?? 'N/A' }} del {{ $uncion['ANIO_UNCION'] ?? 'N/A' }}</td>
                            
                            
                            <td>
                            <a href="#" class="btn btn-success btn-sm" onclick="mostrarDetallesUncion('{{ $uncion['COD_UNCION'] ?? 'N/A' }}', '{{ $uncion['DNI'] ?? 'N/A' }}', '{{ $uncion['NOMBRE_PERSONA'] ?? 'N/A' }}', '{{ $uncion['DIA_UNCION'] ?? 'N/A' }} {{ $uncion['MES_UNCION'] ?? 'N/A' }} del {{ $uncion['ANIO_UNCION'] ?? 'N/A' }}', '{{ $uncion['NOMBRE_SACERDOTE'] ?? 'N/A' }}', '{{ $uncion['LUGAR_SACRAMENTO'] ?? 'N/A' }}', '{{ $uncion['LIBRO_REG'] ?? 'N/A' }}', '{{ $uncion['FOLIO_REG'] ?? 'N/A' }}', '{{ $uncion['NUMERO_REG'] ?? 'N/A' }}', '{{ $uncion['OBSERVACIONES'] ?? 'N/A' }}')" title="Ver Detalles">
    <i class="fas fa-info-circle"></i>
</a>

                                  <!-- Botón de modificar con ícono -->
                                   
                                @php
// Definir un array asociativo para convertir nombres de mes a números
$meses = [
    'Enero' => '01',
    'Febrero' => '02',
    'Marzo' => '03',
    'Abril' => '04',
    'Mayo' => '05',
    'Junio' => '06',
    'Julio' => '07',
    'Agosto' => '08',
    'Septiembre' => '09',
    'Octubre' => '10',
    'Noviembre' => '11',
    'Diciembre' => '12',
];

// Obtener las partes de la fecha
$dia = $uncion['DIA_UNCION'] ?? '00';
$mes_nombre = $uncion['MES_UNCION'] ?? 'Enero'; // Nombre del mes
$anio = $uncion['ANIO_UNCION'] ?? date('Y');

// Convertir el nombre del mes a su número correspondiente
$mes_numero = $meses[$mes_nombre] ?? '00';

// Formatear la fecha como Año-Mes-Día (YYYY-MM-DD)
$fecha_formateada = sprintf("%d-%02d-%02d", $anio, $mes_numero, $dia);
@endphp

@if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
<a href="#" class="btn btn-warning btn-sm" 
   onclick="editarActa(
       '{{ $uncion['COD_UNCION'] }}',
       '{{ $uncion['COD_PERSONAS'] }}',
       '{{ $uncion['DNI'] }}',
       '{{ $uncion['NOMBRE_PERSONA'] }}',
       '{{ $fecha_formateada }}',
       '{{ $uncion['COD_SACERDOTE'] }}',
       '{{ $uncion['NOMBRE_SACERDOTE'] }}',
       '{{ $uncion['LUGAR_SACRAMENTO'] }}',
       '{{ $uncion['LIBRO_REG'] }}',
       '{{ $uncion['FOLIO_REG'] }}',
       '{{ $uncion['NUMERO_REG'] }}',
       '{{ $uncion['OBSERVACIONES'] }}'
   )" title="Modificar Registro">
    <i class="fas fa-edit"></i>
</a>
@endif
                            
                            
                            
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>
    </div>

    
   
    
<!-- Modal para editar unción -->
<div class="modal fade" id="editarModalUncion" tabindex="-1" aria-labelledby="editarModalUncionLabel" aria-hidden="true">
<div class="modal-dialog modal-xl">
            <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
                <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                    <h5 class="modal-title fw-bold text-white" id="editarModalOrdenLabel"><i class="fas fa-edit me-2 text-white"></i>EDITAR DETALLES DE UNCIÓN ENFERMOS</h5>
                    <a href="#" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-0" data-bs-dismiss="modal" aria-label="Close" title="Cerrar">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <div class="modal-body">
                <form id="updateUncionForm" action="{{ route('uncion.update', ['id' => $uncion['COD_UNCION']]) }}" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('PUT')

                    <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <label for="editarCodUncion" class="form-label">
                                <i class="fas fa-id-card-alt"></i> Código de Unción Enfermos:
                            </label>
                            <input type="text" class="form-control" name="editarCodigoUncion" id="editarCodigoUncion" style="width: 75%; pointer-events: none;" >
                        </div>
                        <div>
                            <label for="editarFechaUncion" class="form-label" style="font-weight: bold; font-size: 16px;">
                                <i class="fas fa-calendar-alt"></i> Fecha:
                            </label>
                            <input type="date" class="form-control"  name="editarFechaUncion" id="editarFechaUncion" style="width: 100%;" required>
                            <div class="invalid-feedback">
                                Por favor ingrese la Fecha.
                            </div>
                        </div>
                    </div>
                    
                    .

                    <div class="container">
                        <div class="row align-items-center">
                            <!-- Datos del Párroco -->
                            <div class="col-md-6">
                                <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <legend><i class="fas fa-church"></i> Datos del Párroco</legend>
                                        <a type="button" class="btn btn-success btn-sm" id="btnMostrarModal" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; line-height: 1;">
    <i class="fas fa-user me-2" style="font-size: 1.2rem; center"></i> 
    <span style="font-size: 0.8rem;">Seleccionar Persona</span> 
</a>

       </div>
<br>
       <!-- Modal para abrir persona de Párroco -->
       <div class="modal fade" id="resultadosModal" tabindex="-1" aria-labelledby="resultadosModalLabel" aria-hidden="true">
       <style>
.custom-modal-size {
max-width: 40%; /* Ajusta según tus necesidades */
}
</style>

<div class="modal-dialog custom-modal-size modal-dialog-centered">
<!-- Contenido del modal -->



               <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
   <div class="modal-header" style="background-color: #48C9B0; position: relative;">
       
                       <h3 class="modal-title fw-bold text-white" id="resultadosModalLabel"><i class="fas fa-users me-2 text-white"></i> Registro de Persona</h3>
                       
                           
                       <a href="#" class="btn btn-danger position-absolute top-0 end-0 m-0 p-2 text-white" style="width: 40px; height: 40px; line-height: 1;" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></a>

                   </div>
                   <div class="modal-body">
                   <a href="#" class="btn btn-success position-absolute top-3 start-3 m-0 p-2 text-white" style="width: 43px; height: 43px; line-height: 1;" data-bs-dismiss="modal" aria-label="Add New">
           <i class="fas fa-user-plus"></i>
       </a>
                       <table id="tablaResultados" class="table table-striped table-bordered" style="width: 100%">
                           <thead>
                               <tr>
                                   <th>#</th> <!-- Nueva columna para el botón con ícono -->
                                   <th>Código</th>
                                   <th>Nombre</th>
                                   <th>DNI</th>
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

                                    <div class="row align-items-center">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="cod_parroco" style="font-size: 16px;">Código:</label>
                                                <input type="text" id="editarCodSacerdote" name="editarCodSacerdote" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required>
                                                <div class="invalid-feedback">
                                                    Por favor ingrese el código del párroco.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-8">
                                            <div class="form-group">
                                                <label for="nombre_parroco" style="font-size: 16px;">Nombre:</label>
                                                <input type="text" id="editarNombreSacerdoteUncion" name="editarNombreSacerdoteUncion" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required>
                                                <div class="invalid-feedback">
                                                    Por favor ingrese el nombre del párroco.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>

                            <div class="col-md-6">
                                <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%;">
                                    <legend><i class="fas fa-list-alt"></i> Datos de Registro</legend>
                                    .
                                    <div class="row">
                                        
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="libro_reg" style="font-weight: bold; font-size: 16px;">Libro:</label>
                                                <input type="text" id="editarLibroRegistro" name="editarLibroRegistro" class="form-control form-control-sm" style="width: 100%;" maxlength="50" required>
                                                <div class="invalid-feedback">
                                                    Por favor ingrese el número de libro.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="folio_reg" style="font-weight: bold; font-size: 16px;">Folio:</label>
                                                <input type="number" id="editarFolioRegistro" name="editarFolioRegistro" class="form-control form-control-sm" style="width: 100%;" maxlength="30">
                                                <div class="invalid-feedback">
                                                    Por favor ingrese el número de folio.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="numero_reg" style="font-weight: bold; font-size: 16px;">Número:</label>
                                                <input type="number" id="editarNumeroRegistro" name="editarNumeroRegistro" class="form-control form-control-sm" style="width: 100%;" maxlength="30">
                                                <div class="invalid-feedback">
                                                    Por favor ingrese el número.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                        </div>

                        <div class="container">
                            <div class="row">
                                <div class="col-md-6">
                                    <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%;">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <legend><i class="fas fa-user"></i> Datos de la Persona</legend>
                                        </div>

                                        <!-- Modal para abrir persona -->
                                        <div class="modal fade" id="resultadosModalPersona" tabindex="-1" aria-labelledby="resultadosModalPersonaLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-m">
                                                <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
                                                    <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                                                        <h3 class="modal-title fw-bold text-white" id="resultadosModalPersonaLabel">
                                                            <i class="fas fa-users me-2 text-white"></i> Registro de Persona
                                                        </h3>
                                                        <a href="#" class="btn btn-danger position-absolute top-0 end-0 m-0 p-2 text-white" style="width: 40px; height: 40px; line-height: 1;" data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="fas fa-times"></i>
                                                        </a>
                                                    </div>
                                                    <div class="modal-body">
                                                        <a href="#" class="btn btn-success position-absolute top-3 start-3 m-0 p-2 text-white" style="width: 43px; height: 43px; line-height: 1;" data-bs-dismiss="modal" aria-label="Add New">
                                                            <i class="fas fa-user-plus"></i>
                                                        </a>
                                                        <table id="tablaResultadosPersona" class="table table-striped table-bordered" style="width: 100%">
                                                            <thead>
                                                                <tr>
                                                                    <th>#</th>
                                                                    <th>Código</th>
                                                                    <th>Nombre</th>
                                                                    <th>DNI</th>
                                                                    <th>Fecha Nacimiento</th>
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
<br><br>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group">
                                                    <label for="cod_persona" style="font-size: 16px;">Código:</label>
                                                    <input type="text" id="editarCodPersona" name="editarCodPersona" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required>
                                                    <div class="invalid-feedback">
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label for="nombre_persona" style="font-size: 16px;">Nombre:</label>
                                                    <input type="text" id="editarNombrePersonaUncion" name="editarNombrePersonaUncion" class="form-control form-control-sm" style="width: 100%; pointer-events: none;"  required>
                                                    <div class="invalid-feedback">
                                                        Por favor Seleccione una Persona.
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="nombre_persona" style="font-size: 16px;">DNI:</label>
                                                    <input type="text" id="editarDNIUncion" name="#editarDNIUncion" class="form-control form-control-sm" style="width: 100%; pointer-events: none; " required>
                                                    <div class="invalid-feedback">
                                                        
                                                    </div>
                                                </div>
                                            </div>





                                        </div>
                                    </fieldset>
                                </div>



                                <!-- Segundo fieldset -->
        <div class="col-md-6">
            <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%;">
                <div class="d-flex justify-content-between align-items-center">
                <legend> <i class="fas fa-info-circle"></i> Otros Datos</legend>

                    
                </div>

                <!-- Contenido del segundo fieldset -->
            

                <div class="form-group">
    <label for="campo4" style="font-size: 16px;">Observaciones:</label>
    <textarea id="editarObservacionesUncion" name="editarObservacionesUncion" class="form-control form-control-sm" rows="1" maxlength="250" style="resize: none; border: 2px solid #48C9B0;" value=""></textarea>
    
</div>

<div class="form-group">
    <label for="campo4" style="font-size: 16px;">Lugar:</label>
    <textarea id="editarLugarSacramento" name="editarLugarSacramento" class="form-control form-control-sm" rows="1" maxlength="200" style="resize: none; border: 2px solid #48C9B0;" value=""></textarea>
    
</div>

                </div>
            </fieldset>
        </div>
    </div>
                            </div>
                        </div>
                    
                        <div class="modal-footer justify-content-end">

                   <button id="btnGuardar" type="submit" class="btn btn-success" onclick="return validarFormulario()">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <button id="btnCancelar" type="button" class="btn btn-danger me-2" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i> Cancelar
                    </button>
                    
                </div>


                </form>
            </div>
        </div>
    </div>
</div>


















    <!-- Modal para mostrar la detalles  -->
    <div class="modal fade" id="detallesModalUncion" tabindex="-1" aria-labelledby="detallesModalUncionLabel" aria-hidden="true">
    <div class="modal-dialog modal-m">
        <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                <h5 class="modal-title fw-bold text-white" id="detallesModalUncionLabel"><i class="fas fa-id-card-alt me-2 text-white"></i>DETALLES DE UNCION DE LOS ENFERMOS</h5>
                <a href="#" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-0" data-bs-dismiss="modal" aria-label="Close" title="Cerrar">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="modal-body">
                <div class="details-container">
                    <div><strong>Código Registro:</strong> <span id="detallesCodigoUncion"></span></div>
                    <div><strong>DNI:</strong> <span id="detallesDNIUncion"></span></div>
                    <div><strong>Nombre Persona:</strong> <span id="detallesNombrePersonaUncion"></span></div>
                    <div><strong>Fecha Unción:</strong> <span id="detallesFechaUncion"></span></div>
                    <div><strong>Nombre Sacerdote:</strong> <span id="detallesNombreSacerdoteUncion"></span></div>
                    <div><strong>Lugar:</strong> <span id="detallesLugarSacramentoUncion"></span></div>
                    <div><strong>Libro de Registro:</strong> <span id="detallesLibroRegistroUncion"></span></div>
                    <div><strong>Folio de Registro:</strong> <span id="detallesFolioRegistroUncion"></span></div>
                    <div><strong>Número de Registro:</strong> <span id="detallesNumeroRegistroUncion"></span></div>
                    <div><strong>Observaciones:</strong> <span id="detallesObservacionesUncion"></span></div>
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

    <!-- jsPDF -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>

   
   
   
   
   
   
   
   
   
   
   
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
  document.addEventListener('DOMContentLoaded', function() {
    var btnGuardar = document.getElementById('btnGuardar');
    if (btnGuardar) {
      btnGuardar.addEventListener('click', function(event) {
        var form = document.getElementById('updateUncionForm');
        if (form.checkValidity() === false) {
          event.preventDefault(); // Evitar que se envíe el formulario si no es válido
          event.stopPropagation(); // Detener la propagación del evento
        }
        form.classList.add('was-validated'); // Agregar la clase para activar los estilos de validación
      });
    }
  });
</script>






<!-- Incluir SweetAlert desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function validarFormulario() {
    // Obtener los valores de los campos
    const codParroco = document.getElementById('editarCodSacerdote').value;
    const codPersonas = document.getElementById('editarCodPersona').value;
    

    // Crear un array con los valores
    const ids = [codParroco, codPersonas];

    // Verificar si hay valores duplicados
    const duplicados = ids.filter((item, index) => ids.indexOf(item) !== index && item !== '');

    if (duplicados.length > 0) {
        // Mostrar mensaje con SweetAlert
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El siguientes códigos están duplicados: ' + duplicados.join(', ')
        });
        return false; // Prevenir el envío del formulario
    }

    return true; // Permitir el envío del formulario
}
</script>










<script>
        $(document).ready(function(){
            $('#example').DataTable({
                "language": {
                    "search": "Buscar",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "paginate": { 
                        "previous": "Anterior", 
                        "next": "Siguiente" 
                    }
                }
            });
        });

        function mostrarConstancia(codigo, nombre, parroquia, fechaConfirmacion, madre, padre, madrina, padrino, parroco) {
            $('#nombreConstancia').text(nombre);
            $('#parroquiaBautizoConstancia').text(parroquia);
            $('#fechaConfirmacionConstancia').text(fechaConfirmacion);
            $('#nombreParrocoConstancia').text(parroco);
            $('#constanciaModal').modal('show');
        }

        function imprimirConstancia() {
            var printContent = document.getElementById('constanciaContent').innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;

            // Recargar la página después de imprimir
            location.reload();
        }

        

function mostrarDetallesUncion(codigo, dni, nombre, fecha, sacerdote, lugar, libro, folio, numero, observaciones) {
    document.getElementById('detallesCodigoUncion').innerText = codigo;
    document.getElementById('detallesDNIUncion').innerText = dni;
    document.getElementById('detallesNombrePersonaUncion').innerText = nombre;
    document.getElementById('detallesFechaUncion').innerText = fecha;
    document.getElementById('detallesNombreSacerdoteUncion').innerText = sacerdote;
    document.getElementById('detallesLugarSacramentoUncion').innerText = lugar;
    document.getElementById('detallesLibroRegistroUncion').innerText = libro;
    document.getElementById('detallesFolioRegistroUncion').innerText = folio;
    document.getElementById('detallesNumeroRegistroUncion').innerText = numero;
    document.getElementById('detallesObservacionesUncion').innerText = observaciones;
    var detallesModal = new bootstrap.Modal(document.getElementById('detallesModalUncion'));
    detallesModal.show();
}

    </script>

<script>
function validateInput(input) {
    input.addEventListener('input', function () {
        // Se eliminó la validación de longitud de caracteres
    });
    input.addEventListener('paste', function (e) {
        e.preventDefault(); // Desactivar pegado
    });
    input.addEventListener('copy', function (e) {
        e.preventDefault(); // Desactivar copiado
    });
    input.addEventListener('cut', function (e) {
        e.preventDefault(); // Desactivar corte
    });
}

// Aplicar validación a los campos especificados
validateInput(document.querySelector('#editarCodigoUncion'));
validateInput(document.querySelector('#editarCodPersona'));
validateInput(document.querySelector('#editarDNIUncion'));
validateInput(document.querySelector('#editarNombrePersonaUncion'));
validateInput(document.querySelector('#editarFechaUncion'));
validateInput(document.querySelector('#editarCodSacerdote'));
validateInput(document.querySelector('#editarNombreSacerdoteUncion'));
validateInput(document.querySelector('#editarLugarSacramento'));
validateInput(document.querySelector('#editarLibroRegistro'));
validateInput(document.querySelector('#editarFolioRegistro'));
validateInput(document.querySelector('#editarNumeroRegistro'));
validateInput(document.querySelector('#editarObservacionesUncion'));


</script>



<script>
document.getElementById('editarLibroRegistro').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '');
});



document.getElementById('editarFolioRegistro').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
});

document.getElementById('editarNumeroRegistro').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
});


</script>







<script>
    function editarActa(codUncion, codPersona, dni, nombrePersona, fechaUncion, codSacerdote, nombreSacerdote, lugarSacramento, libroRegistro, folioRegistro, numeroRegistro, observaciones) {
        // Abrir modal
        $('#editarModalUncion').modal('show');
        
        // Rellenar campos del formulario
        $('#editarCodigoUncion').val(codUncion);
        $('#editarCodPersona').val(codPersona);
        $('#editarDNIUncion').val(dni); // Asegúrate de tener un campo con este ID en tu modal
        $('#editarNombrePersonaUncion').val(nombrePersona);
        $('#editarFechaUncion').val(fechaUncion);
        $('#editarCodSacerdote').val(codSacerdote);
        $('#editarNombreSacerdoteUncion').val(nombreSacerdote);
        $('#editarLugarSacramento').val(lugarSacramento); // Asegúrate de tener un campo con este ID en tu modal
        $('#editarLibroRegistro').val(libroRegistro);
        $('#editarFolioRegistro').val(folioRegistro);
        $('#editarNumeroRegistro').val(numeroRegistro);
        $('#editarObservacionesUncion').val(observaciones);
    }
</script>


<script>
   $(document).ready(function() {
    $('#btnMostrarModal').click(function() {
        $('#resultadosModal').modal('show'); // Mostrar modal al hacer clic en el botón
        cargarTablaResultados(); // Cargar los datos en la tabla
    });

    function cargarTablaResultados() {
        // Destruir instancia existente de DataTable si existe
        if ($.fn.DataTable.isDataTable('#tablaResultados')) {
            $('#tablaResultados').DataTable().destroy();
        }

        $('#tablaResultados').DataTable({
            "processing": false,
            "serverSide": true,
            "searching": true, // Habilitar búsqueda
            "paging": true, // Habilitar paginación
            "lengthChange": false, // Deshabilitar el control de cambiar la cantidad de registros por página
            "pageLength": 3, // Mostrar 5 registros por página
            "info": false, // Deshabilitar información de cantidad de registros
            "language": { // Configuración de idioma
                "search": "       Buscar por DNI:", // Cambiar el texto del botón de búsqueda a español
                "paginate": {
                    "previous": "Anterior",
                    "next": "Siguiente"
                },
               
                "zeroRecords": "No se encontraron registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "emptyTable": "No hay datos disponibles en la tabla", // Mensaje cuando la tabla está vacía
        "loadingRecords": "Cargando...", // Mensaje durante la carga de registros
        "processing":     "Procesando...", // Mensaje durante el procesamiento
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
                        return '<a href="#" class="btn btn-success rounded-circle btnCopiarParroco" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;" data-codigo="' + row.COD_PERSONAS + '">' +
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
        $('#tablaResultados').css('font-size', '0.8em');



        $('#tablaResultados').on('click', '.btnCopiarParroco', function() {
            var codigoPersona = $(this).data('codigo');
            var nombrePersona = $(this).closest('tr').find('td:nth-child(3)').text(); // Obtener el nombre desde la columna correspondiente
            var dniPersona = $(this).closest('tr').find('td:nth-child(4)').text(); // Obtener el DNI desde la columna correspondiente

            // Ejemplo de cómo actualizar los campos del párroco con los datos de la persona seleccionada
            $('#editarCodSacerdote').val(codigoPersona);
            $('#editarNombreSacerdoteUncion').val(nombrePersona);
           

            // Cerrar modal opcionalmente si así lo deseas
            $('#resultadosModal').modal('hide');
        });






    }



    $('#resultadosModal').on('hidden.bs.modal', function () {
    $('body').removeClass('modal-open');
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
