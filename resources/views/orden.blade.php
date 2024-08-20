<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parroquia SMP - Orden Sacerdotal</title>
   
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
            text-align: center; /* Centrar el texto en las celdas */
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
                <h1 class="fw-bold text-center" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 50px; text-shadow: 4px 4px #48C9B0;">REGISTROS DE ORDENACIÓN SACERDOTAL</h1>
            </div>
            <div class="col-auto">
            <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 9; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
            <a href="/ins_orden" class="btn btn-lg fw-bold" style="background-color: #1ABC9C; color: white; border: 2px solid #FFD700;" onclick="abrirModalNuevo()"><i class="fas fa-plus"></i> Nuevo Registro</a>
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
                        <th style="background-color:#48C9B0; color: black; text-align: center;">Nombre Sacerdote</th>
                        
                        
                    
                        
                        <th style="background-color:#48C9B0; color: black; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ResulSacramentos as $orden)
                        <tr>
                            <td>{{ $orden['COD_ORDEN'] ?? 'N/A' }}</td>
                            <td>{{ $orden['DNI'] ?? 'N/A' }}</td>
                            <td>{{ $orden['NOMBRE_PERSONA'] ?? 'N/A' }}</td>
                            <td>{{ $orden['DIA_ORDENACION'] ?? 'N/A' }} {{ $orden['MES_ORDENACION'] ?? 'N/A' }} del {{ $orden['ANIO_ORDENACION'] ?? 'N/A' }}</td>
                            <td>{{ $orden['NOMBRE_SACERDOTE'] ?? 'N/A' }}</td>
                            
                            
                           
                            
                            <td>

                            <a href="#" class="btn btn-success btn-sm" onclick="mostrarDetallesOrden('{{ $orden['COD_ORDEN'] ?? 'N/A' }}', '{{ $orden['DNI'] ?? 'N/A' }}', '{{ $orden['NOMBRE_PERSONA'] ?? 'N/A' }}', '{{ $orden['DIA_ORDENACION'] ?? 'N/A' }} {{ $orden['MES_ORDENACION'] ?? 'N/A' }} del {{ $orden['ANIO_ORDENACION'] ?? 'N/A' }}', '{{ $orden['NOMBRE_SACERDOTE'] ?? 'N/A' }}', '{{ $orden['LUGAR_SACRAMENTO'] ?? 'N/A' }}', '{{ $orden['LIBRO_REG'] ?? 'N/A' }}', '{{ $orden['FOLIO_REG'] ?? 'N/A' }}', '{{ $orden['NUMERO_REG'] ?? 'N/A' }}', '{{ $orden['OBSERVACIONES'] ?? 'N/A' }}')" title="Ver Detalles">
    <i class="fas fa-info-circle"></i>
</a>

                                <!-- Botones de acciones -->
                               
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
$dia = $orden['DIA_ORDENACION'] ?? '00';
$mes_nombre = $orden['MES_ORDENACION'] ?? 'Enero'; // Nombre del mes
$anio = $orden['ANIO_ORDENACION'] ?? date('Y');

// Convertir el nombre del mes a su número correspondiente
$mes_numero = $meses[$mes_nombre] ?? '00';

// Formatear la fecha como Año-Mes-Día (YYYY-MM-DD)
$fecha_formateada = sprintf("%d-%02d-%02d", $anio, $mes_numero, $dia);
@endphp

@if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
<a href="#" class="btn btn-warning btn-sm"
   onclick="mostrarDetalles(
       '{{ $orden['COD_ORDEN'] }}',
       '{{ $orden['COD_PERSONAS'] }}',
       '{{ $orden['DNI'] }}',
       '{{ $orden['NOMBRE_PERSONA'] }}',
       '{{ $fecha_formateada }}',
       '{{ $orden['COD_SACERDOTE'] }}',
       '{{ $orden['NOMBRE_SACERDOTE'] }}',
       '{{ $orden['LUGAR_SACRAMENTO'] }}',
       '{{ $orden['LIBRO_REG'] }}',
       '{{ $orden['FOLIO_REG'] }}',
       '{{ $orden['NUMERO_REG'] }}',
       '{{ $orden['OBSERVACIONES'] }}'
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

    
<!-- Modal para editar ordenación -->
<div class="modal fade" id="editarModalOrden" tabindex="-1" aria-labelledby="editarModalOrdenLabel" aria-hidden="true">
       

        <div class="modal-dialog modal-xl   modal-dialog-scrollable" role="document"      >
            <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
                <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                    <h6 class="modal-title fw-bold text-white" id="editarModalOrdenLabel"><i class="fas fa-edit me-2 text-white"></i>EDITAR DETALLES DE ORDENACIÓN SACERDOTAL</h5>
                    <a href="#" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-0" data-bs-dismiss="modal" aria-label="Close" title="Cerrar">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
                <div class="modal-body">
                    

                <form id="updateordenForm" action="{{ route('orden.update', ['id' =>  $orden['COD_ORDEN'] ]) }}" method="POST" class="row g-3 needs-validation" novalidate>
    @csrf
    @method('PUT')


    
    <div class="d-flex justify-content-between align-items-center">
    <div class="me-3">
        <label for="editarCodReconciliacion" class="form-label">
            <i class="fas fa-id-card-alt"></i> Código de Orden Sacerdotal:
        </label>
        
        <input type="text" class="form-control" name="editarCodigoOrden" id="editarCodigoOrden"  class="form-control" style="width: 75%; pointer-events: none;">
   
    </div>
    <div>
        <label for="editarFechaReconciliacion" class="form-label" style="font-weight: bold; font-size: 16px;">
            <i class="fas fa-calendar-alt"></i> Fecha:
        </label>
        <input type="Date" class="form-control" name="editarFechaOrdenacion" id="editarFechaOrdenacion"  class="form-control form-control-sm" style="width: 100%;" required >
       
        
        
        <div class="invalid-feedback">
      Por favor ingrese la Fecha .
    </div>
    </div>
    
</div>


.<br>


<div class="container">
    <div class="row align-items-center">
        <!-- Datos del Párroco -->
        <div class="col-md-6">
            <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%;">
                <!-- Botón para abrir la modal -->
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
      +
    </div>
  </div>
</div>
<div class="col-md-8">
  <div class="form-group">
    <label for="nombre_parroco" style="font-size: 16px;">Nombre:</label>
    <input type="text" id="editarNombreSacerdoteOrden" name="editarNombreSacerdoteOrden" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required >
    
    <div class="invalid-feedback">
      Por favor Selecciones una Persona.
    </div>
  </div>
</div>


                </div>
            </fieldset>
        </div>

       
        <div class="col-md-6 ">
            <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%; " >
            <legend><i class="fas fa-list-alt"></i> Datos de Registro</legend>
.
                <div class="row">

                <div class="col-md-4">
  <div class="form-group">
    <label for="libro_reg" style="font-weight: bold; font-size: 16px;">Libro:</label>
    <input type="text" id="editarLibroRegistro" name="editarLibroRegistro" class="form-control form-control-sm" style="width: 100%;" required maxlength="50" >
    <div class="invalid-feedback">
      Por favor ingrese el número de libro.
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="folio_reg" style="font-weight: bold; font-size: 16px;">Folio:</label>
    <input type="number" id="editarFolioRegistro" name="editarFolioRegistro" class="form-control form-control-sm" value="" style="width: 100%;"  maxlength="30">
    <div class="invalid-feedback">
      Por favor ingrese el número de folio.
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="numero_reg" style="font-weight: bold; font-size: 16px;">Número:</label>
    <input type="number" id="editarNumeroRegistro" name="editarNumeroRegistro" class="form-control form-control-sm" value="" style="width: 100%;"  maxlength="30">
    <div class="invalid-feedback">
      Por favor ingrese el número.
    </div>
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

                <!-- Contenido del primer fieldset -->
                <div class="modal fade" id="resultadosModal1" tabindex="-1" aria-labelledby="resultadosModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-m">
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
<br>
<br>

                <!-- Contenido del primer fieldset -->
                <div class="row align-items-center">
    <div class="col-md-2">
        <div class="form-group">
            <label for="cod_personas" style="font-size: 16px;">Código:</label>
            <input type="text" id="editarCodPersonas" name="editarCodPersonas" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required>
            <div class="invalid-feedback">
             +
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="nombre_bautizado" style="font-size: 16px;">Nombre:</label>
            <input type="text" id="editarNombrePersonaOrden" name="editarNombrePersonaOrden" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required>
            <div class="invalid-feedback">
            Por Favor Seleccione una Persona.
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="dni_bautizado" style="font-size: 16px;">DNI:</label>
            <input type="text" id="editarDNIOrden" name="editarDNIOrden" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required>
            <div class="invalid-feedback">
               +
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
    <textarea id="editarObservacionesOrden" name="editarObservacionesOrden" class="form-control form-control-sm" rows="1" maxlength="250" style="resize: none; border: 2px solid #48C9B0;" value=""></textarea>
    
</div>

<div class="form-group">
    <label for="campo4" style="font-size: 16px;">Lugar:</label>
    <textarea id="editarLugarSacramento" name="editarLugarSacramento" class="form-control form-control-sm" rows="1" maxlength="200" style="resize: none; border: 2px solid #48C9B0;" value=""></textarea>
    
</div>

                </div>
            </fieldset>
        </div>
    </div>
















                       
        
    <!-- Contenedor para centrar el botón -->
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


  <!-- Modal para mostrar detalles de la ordenación -->  
    <!-- Modal para mostrar detalles de ordenación -->
<div class="modal fade" id="detallesModalOrden" tabindex="-1" aria-labelledby="detallesModalOrdenLabel" aria-hidden="true">

    <div class="modal-dialog modal-m">
        <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                <h5 class="modal-title fw-bold text-white" id="detallesModalOrdenLabel"><i class="fas fa-id-card-alt me-2 text-white"></i>DETALLES DE ORDEN SACERDOTAL</h5>
                <a href="#" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-0" data-bs-dismiss="modal" aria-label="Close" title="Cerrar">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="modal-body">
                <div class="details-container">
                    <div><strong>Código Orden:</strong> <span id="detallesCodigoOrden"></span></div>
                    <div><strong>DNI:</strong> <span id="detallesDNIOrden"></span></div>
                    <div><strong>Nombre Persona:</strong> <span id="detallesNombrePersonaOrden"></span></div>
                    <div><strong>Fecha Ordenación:</strong> <span id="detallesFechaOrdenacion"></span></div>
                    <div><strong>Nombre Sacerdote:</strong> <span id="detallesNombreSacerdote"></span></div>
                    <div><strong>Lugar Sacramento:</strong> <span id="detallesLugarSacramento"></span></div>
                    <div><strong>Libro de Registro:</strong> <span id="detallesLibroRegistroOrden"></span></div>
                    <div><strong>Folio de Registro:</strong> <span id="detallesFolioRegistroOrden"></span></div>
                    <div><strong>Número de Registro:</strong> <span id="detallesNumeroRegistroOrden"></span></div>
                    <div><strong>Observaciones:</strong> <span id="detallesObservacionesOrden"></span></div>
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
        var form = document.getElementById('updateordenForm');
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

        function mostrarDetalles(codigo) {
           
            var contenido = '<p>Detalles de la ordenación para el código ' + codigo + '</p>';
            $('#ordenContent').html(contenido);
            $('#ordenModal').modal('show');
        }

        function editarOrden(codigo) {
            
            alert('Editar ordenación con código ' + codigo);
        }

        function imprimirConstancia() {
            // Función para imprimir la constancia
            var printContent = document.getElementById('ordenContent').innerHTML;
            var originalContent = document.body.innerHTML;
            document.body.innerHTML = printContent;
            window.print();
            document.body.innerHTML = originalContent;

            // Recargar la página después de descargar el PDF
location.reload();
        }

        function descargarConstanciaPDF() {
            // Función para descargar la constancia en PDF
            var { jsPDF } = window.jspdf;
            var doc = new jsPDF();

            doc.setFontSize(20);
            doc.text("Constancia de Ordenación Sacerdotal", 20, 20);

            doc.setFontSize(12);
            doc.text("Detalles de la ordenación:", 20, 40);
            // Añadir más detalles según sea necesario

            doc.save("constancia_ordenacion.pdf");
            // Recargar la página después de descargar el PDF
location.reload();
        }

        function mostrarDetallesOrden(codigo, dni, nombre, fecha, sacerdote, lugar, libro, folio, numero, observaciones) {
    document.getElementById('detallesCodigoOrden').innerText = codigo;
    document.getElementById('detallesDNIOrden').innerText = dni;
    document.getElementById('detallesNombrePersonaOrden').innerText = nombre;
    document.getElementById('detallesFechaOrdenacion').innerText = fecha;
    document.getElementById('detallesNombreSacerdote').innerText = sacerdote;
    document.getElementById('detallesLugarSacramento').innerText = lugar;
    document.getElementById('detallesLibroRegistroOrden').innerText = libro;
    document.getElementById('detallesFolioRegistroOrden').innerText = folio;
    document.getElementById('detallesNumeroRegistroOrden').innerText = numero;
    document.getElementById('detallesObservacionesOrden').innerText = observaciones;
    var detallesModal = new bootstrap.Modal(document.getElementById('detallesModalOrden'));
    detallesModal.show();
}

    </script>




<!-- Incluir SweetAlert desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function validarFormulario() {
    // Obtener los valores de los campos
    const codParroco = document.getElementById('editarCodSacerdote').value;
    const codPersonas = document.getElementById('editarCodPersonas').value;
    

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
            $('#editarNombreSacerdoteOrden').val(nombrePersona);
           

            // Cerrar modal opcionalmente si así lo deseas
            $('#resultadosModal').modal('hide');
        });






    }

    $('#resultadosModal').on('hidden.bs.modal', function () {
    $('body').removeClass('modal-open');
});
});





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
validateInput(document.querySelector('#editarCodigoOrden'));
validateInput(document.querySelector('#editarCodPersonas'));
validateInput(document.querySelector('#editarDNIOrden'));
validateInput(document.querySelector('#editarNombrePersonaOrden'));
validateInput(document.querySelector('#editarFechaOrdenacion'));
validateInput(document.querySelector('#editarCodSacerdote'));
validateInput(document.querySelector('#editarNombreSacerdoteOrden'));
validateInput(document.querySelector('#editarLugarSacramento'));
validateInput(document.querySelector('#editarLibroRegistro'));
validateInput(document.querySelector('#editarFolioRegistro'));
validateInput(document.querySelector('#editarNumeroRegistro'));
validateInput(document.querySelector('#editarObservacionesOrden'));


</script>

    


<script>
    function mostrarDetalles(codOrden, codPersonas, dni, nombrePersona, fechaOrdenacion, codSacerdote, nombreSacerdote, lugarSacramento, libroRegistro, folioRegistro, numeroRegistro, observaciones) {
        // Abrir modal
        $('#editarModalOrden').modal('show');
        
        // Rellenar campos del formulario
        $('#editarCodigoOrden').val(codOrden);
        $('#editarCodPersonas').val(codPersonas);
        $('#editarDNIOrden').val(dni);
        $('#editarNombrePersonaOrden').val(nombrePersona);
        $('#editarFechaOrdenacion').val(fechaOrdenacion);
        $('#editarCodSacerdote').val(codSacerdote);
        $('#editarNombreSacerdoteOrden').val(nombreSacerdote);
        $('#editarLugarSacramento').val(lugarSacramento);
        $('#editarLibroRegistro').val(libroRegistro);
        $('#editarFolioRegistro').val(folioRegistro);
        $('#editarNumeroRegistro').val(numeroRegistro);
        $('#editarObservacionesOrden').val(observaciones);
    
}

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
