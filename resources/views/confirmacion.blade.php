<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parroquia SMP - CONFIRMACIÓN</title>
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


    


@media print {
    .ocultar-impresion {
        display: none;
    }
    @page {
        size: 8.5in 11in; /* Tamaño carta */
        margin: 2.54cm; /* Margen de 1 pulgada (2.54 cm) */
    }
    .printable {
        margin: 2.54cm;
        width: 100%;
        height: auto;
    }
    .modal-content {
        padding: 0;
    }
    .modal-footer {
        display: none;
    }
}



.ocultar-impresion {
    display: none;
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
                <h1 class="fw-bold text-center" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 55px; text-shadow: 4px 4px #48C9B0;">Registros de Confirmación</h1>
            </div>
            <div class="col-auto">
            <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 6; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
            <a href="/ins_confirmacion" class="btn btn-lg fw-bold" style="background-color: #1ABC9C; color: white; border: 2px solid #FFD700;" onclick="abrirModalNuevo()"><i class="fas fa-plus"></i> Nuevo Registro</a>
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
                        <th style="background-color:#48C9B0; color: black; text-align: center;">Nombre </th>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">Fecha Confirmación</th>
                        
                       
                        <th style="background-color:#48C9B0; color: black; text-align: center;" >Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ResulConfirmaciones as $confirmacion)
                        <tr>
                            <td style=" text-align: center;" >{{ $confirmacion['COD_CONFIRMACION'] ?? 'N/A' }}</td>
                            <td>{{ $confirmacion['DNI'] ?? 'N/A' }}</td>
                            <td>{{ $confirmacion['NOMBRE_COMPLETO'] ?? 'N/A' }}</td>
                            <td>{{ $confirmacion['DIA'] ?? 'N/A' }} {{ $confirmacion['MES'] ?? 'N/A' }} del {{ $confirmacion['AÑO'] ?? 'N/A' }}</td>
                            
                            
                            
                           
                            <td>

 <!-- Botón de detalles con ícono -->
                            <a href="#" class="btn btn-success btn-sm" onclick="mostrarDetalles('{{ $confirmacion['COD_CONFIRMACION'] }}', '{{ $confirmacion['DNI'] }}', '{{ $confirmacion['NOMBRE_COMPLETO'] }}', '{{ $confirmacion['DIA'] }} {{ $confirmacion['MES'] }} del {{ $confirmacion['AÑO'] }}', '{{ $confirmacion['NOMBRE_MONSEÑOR'] }}', '{{ $confirmacion['PARROQUIA_BAUTIZO'] }}', '{{ isset($confirmacion['FEC_BAUTIZO']) ? (new DateTime($confirmacion['FEC_BAUTIZO']))->format('d/m/Y') : 'N/A' }}', '{{ $confirmacion['NOMBRE_MADRE'] }}', '{{ $confirmacion['NOMBRE_PADRE'] }}', '{{ $confirmacion['PADRINOS'] }}', '{{ $confirmacion['NOMBRE_PARROCO'] }}', '{{ $confirmacion['LIBRO_REG'] }}', '{{ $confirmacion['FOLIO_REG'] }}', '{{ $confirmacion['NUMERO_REG'] }}', '{{ $confirmacion['OBSERVACIONES'] }}')" title="Ver Detalles"><i class="fas fa-info-circle"></i></a>

                                <!-- Botón de constacio con ícono -->
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

// Obtener las partes de la fecha de confirmación
$dia_confirmacion = $confirmacion['DIA'] ?? '00';
$mes_nombre_confirmacion = $confirmacion['MES'] ?? 'Enero'; // Nombre del mes
$anio_confirmacion = $confirmacion['AÑO'] ?? date('Y');

// Convertir el nombre del mes a su número correspondiente
$mes_numero_confirmacion = $meses[$mes_nombre_confirmacion] ?? '00';

// Formatear la fecha como Año-Mes-Día (YYYY-MM-DD)
$fecha_formateada_confirmacion = sprintf("%d-%02d-%02d", $anio_confirmacion, $mes_numero_confirmacion, $dia_confirmacion);
@endphp

<a href="#" class="btn btn-primary btn-sm" onclick="mostrarConstancia(
    '{{ $confirmacion['COD_CONFIRMACION'] }}',
    '{{ $confirmacion['DNI'] }}',
    '{{ $confirmacion['COD_PERSONAS'] }}',
    '{{ $confirmacion['NOMBRE_COMPLETO'] }}',
    '{{ $confirmacion['FECH_NACIMINETO'] }}',
    '{{ $confirmacion['GENERO'] }}',
    '{{ $fecha_formateada_confirmacion }}', <!-- Aquí usas la fecha formateada -->
    '{{ $confirmacion['COD_MONS'] }}',
    '{{ $confirmacion['NOMBRE_MONSEÑOR'] }}',
    '{{ $confirmacion['PARROQUIA_BAUTIZO'] }}',
    '{{ $confirmacion['FEC_BAUTIZO'] }}',
    '{{ $confirmacion['COD_MADRE'] }}',
    '{{ $confirmacion['NOMBRE_MADRE'] }}',
    '{{ $confirmacion['COD_PADRE'] }}',
    '{{ $confirmacion['NOMBRE_PADRE'] }}',
    '{{ $confirmacion['COD_PARROCO'] }}',
    '{{ $confirmacion['NOMBRE_PARROCO'] }}',
    '{{ $confirmacion['LIBRO_REG'] }}',
    '{{ $confirmacion['FOLIO_REG'] }}',
    '{{ $confirmacion['NUMERO_REG'] }}',
    '{{ $confirmacion['OBSERVACIONES'] }}',
    '{{ $confirmacion['PADRINOS'] }}',
    '{{ $confirmacion['NOM_CIUDAD'] }}'
)" title="Ver Constancia">
    <i class="fas fa-file-alt"></i>
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
$dia = $confirmacion['DIA'] ?? '00';
$mes_nombre = $confirmacion['MES'] ?? 'Enero'; // Nombre del mes
$anio = $confirmacion['AÑO'] ?? date('Y');

// Convertir el nombre del mes a su número correspondiente
$mes_numero = $meses[$mes_nombre] ?? '00';

// Formatear la fecha como Año-Mes-Día (YYYY-MM-DD)
$fecha_formateada = sprintf("%d-%02d-%02d", $anio, $mes_numero, $dia);
@endphp




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
$dia = $confirmacion['DIA'] ?? '00';
$mes_nombre = $confirmacion['MES'] ?? 'Enero'; // Nombre del mes
$anio = $confirmacion['AÑO'] ?? date('Y');

// Convertir el nombre del mes a su número correspondiente
$mes_numero = $meses[$mes_nombre] ?? '00';

// Formatear la fecha como Año-Mes-Día (YYYY-MM-DD)
$fecha_formateada = sprintf("%d-%02d-%02d", $anio, $mes_numero, $dia);

// Formatear la fecha de bautizo
$fecha_bautizo = date('Y-m-d', strtotime($confirmacion['FEC_BAUTIZO']));
@endphp
@if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
<a href="#" class="btn btn-warning btn-sm" 
   onclick="editarActa(
       '{{ $confirmacion['COD_CONFIRMACION'] }}',
       '{{ $confirmacion['DNI'] }}',
       '{{ $confirmacion['COD_PERSONAS'] }}',
       '{{ $confirmacion['NOMBRE_COMPLETO'] }}',
       '{{ $fecha_formateada }}',
       '{{ $confirmacion['COD_MONS'] }}',
       '{{ $confirmacion['NOMBRE_MONSEÑOR'] }}',
       '{{ $confirmacion['PARROQUIA_BAUTIZO'] }}',
       '{{ $fecha_bautizo }}',
       '{{ $confirmacion['COD_MADRE'] }}',
       '{{ $confirmacion['NOMBRE_MADRE'] }}',
       '{{ $confirmacion['COD_PADRE'] }}',
       '{{ $confirmacion['NOMBRE_PADRE'] }}',
       '{{ $confirmacion['COD_PARROCO'] }}',
       '{{ $confirmacion['NOMBRE_PARROCO'] }}',
       '{{ $confirmacion['LIBRO_REG'] }}',
       '{{ $confirmacion['FOLIO_REG'] }}',
       '{{ $confirmacion['NUMERO_REG'] }}',
       '{{ $confirmacion['OBSERVACIONES'] }}',
       '{{ $confirmacion['PADRINOS'] }}',
       '{{ $confirmacion['NOM_CIUDAD'] }}'
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

    <!-- Modal para mostrar la constancia -->
    <div class="modal fade" id="constanciaModal" tabindex="-1" aria-labelledby="constanciaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable" role="document">
        <div class="modal-content">

        <div class="modal-header" style="background-color: #48C9B0;">
        <h5 class="modal-title" id="constanciaModalLabel" style="font-family: 'Cambria', serif; font-size: 24px; font-weight: bold; text-align: center; color: white;">
            <i class="fas fa-book"></i> CONSTANCIA DE CONFIRMACIÓN
          </h5>
                <a href="/sacramentos/confirmacion" class="btn btn-danger text-white">
  <i class="fas fa-times"></i> 
</a>
            

            
            
            
            
            </div>


            <div class="modal-body">
                <div id="constanciaContent">
                   

                <h5 class="modal-title" style="font-family: 'Cambria', serif; font-size: 16px; text-align: center; font-weight: bold;">
                CONSTANCIA DE CONFIRMACIÓN
                    </h5>
                    <br>
                    <h5 class="modal-title" style="font-family: 'Cambria', serif; text-align: justify; font-size: 14px;">
                    El infrascrito  cura Párroco de la Parroquia San Martin de Porres. 
                    </h5>



                    <br>
                    <h5 class="modal-title" style="font-family: 'Cambria', serif; font-size: 16px; text-align: center; font-weight: bold;">
                    HACE CONSTAR QUE:
                    </h5>
                    <br>
                    <p style="font-family: 'Cambria', serif; font-size: 14px;  text-align: justify;">
                    En el Libro de Confirmas número  <span id="libroRegConstancia"></span>,  Folio <span id="folioRegConstancia"></span> N° <span id="numeroRegConstancia"></span>, se encuentra la constancia que dice:
                    </p>

                    <p style="font-family: 'Cambria', serif; font-size: 14px;">
                        El día <span id="fechaConfirmacionConstancia"></span>, Monseñor:  <span id="nombreMonsConstancia"></span> confirmó solemnemente a: 
                    </p>
            
            

                    <p style="font-family: 'Cambria', serif; font-size: 14px; text-align: center; font-weight: bold; text-transform: uppercase;">
                        <span id="nombreConstancia"></span>
                    </p>




                    <p style="font-family: 'Cambria', serif; font-size: 14px;">
                        <span id="generoConstancia" style="font-weight: bold;"></span>: 
                        <span id="nombreMadreConstancia"></span>, 
                        <span id="nombrePadreConstancia"></span>.
                    </p>

                    <p style="font-family: 'Cambria', serif; font-size: 14px;  text-align: justify;"><strong>PADRINOS: </strong> <span id="padrinosConstancia"></span></p>
                    <br>



                    <p style="font-family: 'Cambria', serif; font-size: 14px;  text-align: justify;">
                        <strong>OBSERVACIONES:</strong> Ninguna.
                    </p>
                    <p style="font-family: 'Cambria', serif; font-size: 14px;  text-align: justify;">
                        <strong>ES CONFORME:</strong> al original
                    </p>

                    <p style="font-family: 'Cambria', serif; font-size: 14px;  text-align: justify;">
                    Y para los efectos que se deseen y en derecho correspondan, extiendo la presente constancia en Tegucigalpa, M.D.C.,  <span id="fechaActualTexto"></span>.
                    </p>
                    <br><br><br><br><br><br><br>
                    <p style="font-family: 'Cambria', serif; font-size: 16px; text-align: center; font-weight: bold; font-style: italic;">
                        Pbro. Santos Pablo Vásquez Ávila
                    </p>
                    <p style="font-family: 'Cambria', serif; font-size: 16px; text-align: center; font-weight: bold; font-style: italic;">
                        Párroco
                    </p>













                    
                    <p class="ocultar-impresion">DNI: <span id="dniConstancia"></span></p>
                    <p class="ocultar-impresion">Parroquia de Bautizo: <span id="parroquiaBautizoConstancia"></span></p>
                    <p class="ocultar-impresion">Fecha de Bautizo: <span id="fecBautizoConstancia"></span></p>
                    
                   
                    <p class="ocultar-impresion">Fecha de Nacimiento: <span id="fechaNacimientoConstancia"></span></p>
                   
                    <p class="ocultar-impresion">Nombre del Párroco: <span id="nombreParrocoConstancia"></span></p>
                    
                    <p class="ocultar-impresion">Observaciones: <span id="observacionesConstancia"></span></p>
                    
                    <p class="ocultar-impresion">Ciudad: <span id="nomCiudadConstancia"></span></p>
                   
                   
                </div>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-info" onclick="imprimirConstancia()"><i class="fas fa-print"></i> Imprimir</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal editar confirmacion -->
<div class="modal fade" id="editarModalConfirmacion" tabindex="-1" aria-labelledby="editarModalConfirmacionLabel" aria-hidden="true">
<div class="modal-dialog modal-xl modal-dialog-scrollable" role="document">
            <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
                <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                    <h5 class="modal-title fw-bold text-white" id="editarModalOrdenLabel"><i class="fas fa-edit me-2 text-white"></i>EDITAR DETALLES DE CONFIRMACIÓN</h5>
                  
                  
                    <a href="#" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-0" data-bs-dismiss="modal" aria-label="Close" title="Cerrar">
                      
                    
                    
                    
                    <i class="fas fa-times"></i>
                    </a>
                </div>
                
      <div class="modal-body">
        
      <form id="updateConfirmacionForm" action="{{ route('confirmacion.update', ['id' => $confirmacion['COD_CONFIRMACION'] ]) }}" method="POST" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('PUT')

        <div class="d-flex justify-content-between align-items-center">
                        <div class="me-3">
                            <label for="editarCodUncion" class="form-label">
                                <i class="fas fa-id-card-alt"></i> Código Registro:
                            </label>
                            <input type="text" class="form-control" name="editarCodigoConfirmacion" id="editarCodigoConfirmacion" readonly>
                        </div>
                        <div>
                            <label for="editarFechaUncion" class="form-label" style="font-weight: bold; font-size: 16px;">
                                <i class="fas fa-calendar-alt"></i> Fecha:
                            </label>
                            <input type="date" class="form-control" name="editarFechaConfirmacion"id="editarFechaConfirmacion" style="width: 100%;" required>
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
                <!-- Botón para abrir la modal -->
                <div class="d-flex justify-content-between align-items-center">
                    <legend><i class="fas fa-church"></i> Datos del Párroco</legend>
                    <a type="button" class="btn btn-success btn-sm" id="btnMostrarModal" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; line-height: 1;">
    <i class="fas fa-user me-2" style="font-size: 1.2rem; center"></i> 
    <span style="font-size: 0.8rem;">Seleccionar Persona</span> 
</a> 
                </div>

                <!-- Modal para abrir persona de Párroco -->
                <div class="modal fade" id="resultadosModal" tabindex="-1" aria-labelledby="resultadosModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 40%;">
                        <<div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
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

                <div class="row align-items-center">

                   <div class="col-md-3">
  <div class="form-group">
    <label for="cod_parroco" style="font-size: 16px;">Código:</label>
    <input type="text" id="editarCodParroco" name="editarCodParroco" class="form-control form-control-sm" style="width: 100%;  pointer-events: none;" required >
    <div class="invalid-feedback">
      Por favor ingrese el código del parroco.
    </div>
  </div>
</div>
<div class="col-md-7">
  <div class="form-group">
    <label for="nombre_parroco" style="font-size: 16px;">Nombre:</label>
    <input type="text" id="editarNombreParroco" name="editarNombreParroco" class="form-control form-control-sm" style="width: 100%;  pointer-events: none;" required >
    <div class="invalid-feedback">
      Por favor ingrese el nombre del parroco.
    </div>
  </div>
</div>



                </div>
            </fieldset>
        </div>

        <!-- Datos de Registro -->
        <div class="col-md-6 ">
            <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%; " >
            <legend><i class="fas fa-list-alt"></i> Datos de Registro</legend>

                <div class="row">

                <div class="col-md-4">
  <div class="form-group">
    <label for="libro_reg" style="font-weight: bold; font-size: 16px;">Libro:</label>
    <input type="text" id="editarLibroRegistro" name="editarLibroRegistro" class="form-control form-control-sm" style="width: 100%;" required maxlength="50">
    <div class="invalid-feedback">
      Por favor ingrese el número de libro.
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="folio_reg" style="font-weight: bold; font-size: 16px;">Folio:</label>
    <input type="number" id="editarFolioRegistro" name="editarFolioRegistro" class="form-control form-control-sm" style="width: 100%;" required  maxlength="30">
    <div class="invalid-feedback">
      Por favor ingrese el número de folio.
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="numero_reg" style="font-weight: bold; font-size: 16px;">Número:</label>
    <input type="number" id="editarNumeroRegistro" name="editarNumeroRegistro" class="form-control form-control-sm" style="width: 100%;" required  maxlength="30">
    <div class="invalid-feedback">
      Por favor ingrese el número.
    </div>
  </div>
</div>

                    
                    </div>
                </div>
            </fieldset>
        </div>
    






<!-- datos del bautizado -->

      
<div class="container">
<fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%;">

    <div class="d-flex justify-content-between align-items-center">
    <legend><i class="fas fa-user"></i> Datos de la Persona</legend>
                    
                </div>

               
                <div class="modal fade" id="resultadosModal1" tabindex="-1" aria-labelledby="resultadosModalLabel1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 40%;">
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
    



    
        
                <div class="row align-items-center">
                <div class="col-md-2">
    <div class="form-group">
        <label for="cod_personas" style="font-size: 16px;">Código:</label>
        <input type="text" id="editarCodPersona" name="editarCodPersona" class="form-control form-control-sm" style="width: 100%;  pointer-events: none;" required>
        <div class="invalid-feedback">
            Este campo es requerido.
        </div>
    </div>
</div>

<div class="col-md-4">
    <div class="form-group">
        <label for="nombre_bautizado" style="font-size: 16px;">Nombre:</label>
        <input type="text" id="editarNombreCompleto" name="editarNombreCompleto" class="form-control form-control-sm" style="width: 100%;  pointer-events: none;" required>
        <div class="invalid-feedback">
            Este campo es requerido.
        </div>
    </div>
</div>

<div class="col-md-2">
    <div class="form-group">
        <label for="dni_bautizado" style="font-size: 16px;">DNI:</label>
        <input type="text" id="editarDNIPersona" name="editarDNIPersona" class="form-control form-control-sm" style="width: 100%;  pointer-events: none;" required>
        <div class="invalid-feedback">
            Este campo es requerido.
        </div>
    </div>
</div>



<div class="col-md-3">
    <div class="form-group">
        <label for="ciudad_nacimiento" style="font-size: 16px;">Ciudad de Nacimiento:</label>
        <input type="text" id="editarCiudad" name="editarCiudad" class="form-control form-control-sm" style="width: 100%;" required  maxlength="100">
        <div class="invalid-feedback">
            Este campo es requerido.
        </div>
    </div>
</div>

       


    
    </fieldset>

</div>



<div class="container">
    <div class="row">
        <div class="col-md-6">
            <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%;">
                <div class="d-flex justify-content-between align-items-center">
                <legend><i class="fas fa-dove"></i> Datos de Bautizo</legend>

                   
                </div>


                
                <!-- Contenido del primer fieldset -->
                <div class="row align-items-center">
    <div class="col-md-7">
        <div class="form-group">
            <label for="cod_personas" style="font-size: 16px;">Nombre Parroquia:</label>
            <input type="text" id="editarParroquiaBautizo" name="editarParroquiaBautizo" class="form-control form-control-sm" style="width: 100%;" required  maxlength="100">
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>
    </div>

    <div class="col-md-5">
        <div class="form-group">
            <label for="nombre_bautizado" style="font-size: 16px;">Fecha de Bautizo:</label>
            <input type="date" id="editarFechaBautizo" name="editarFechaBautizo" class="form-control form-control-sm" style="width: 100%;" required>
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>
    </div>

    

    
</div>

        
        




            </fieldset>
        </div>

        <!-- Segundo fieldset -->
      
                <!-- Contenido del segundo fieldset -->







                <div class="col-md-6">
        <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%;">
                


<!-- Botón para abrir la tercera modal -->
<div class="d-flex justify-content-between align-items-center">
<legend>
    <i class="fas fa-user-tie"></i> Datos de Monseñor
</legend>


<a type="button" class="btn btn-success btn-sm" id="btnMostrarModal4" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; line-height: 1;">
    <i class="fas fa-user me-2" style="font-size: 1.2rem; center"></i> 
    <span style="font-size: 0.8rem;">Seleccionar Persona</span> 
</a> 
</div>


<!-- Modal para buscar otra persona -->
<div class="modal fade" id="resultadosModal4" tabindex="-1" aria-labelledby="resultadosModalLabel4" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" style="max-width: 40%;">
        <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                <h3 class="modal-title fw-bold text-white" id="resultadosModalLabel3"><i class="fas fa-users me-2 text-white"></i> Registro de Personas</h3>
                <a href="#" class="btn btn-danger position-absolute top-0 end-0 m-0 p-2 text-white" style="width: 40px; height: 40px; line-height: 1;" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></a>
            </div>
            <div class="modal-body">
                <a href="#" class="btn btn-success position-absolute top-3 start-3 m-0 p-2 text-white" style="width: 43px; height: 43px; line-height: 1;" data-bs-dismiss="modal" aria-label="Add New">
                    <i class="fas fa-user-plus"></i>
                </a>
                <table id="tablaResultados4" class="table table-striped table-bordered" style="width: 100%">
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



                <div class="form-group row align-items-center">
                    
                <div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="cod_monseñor" style="font-size: 16px;">Código:</label>
            <input type="text" id="editarCodMons" name="editarCodMons" class="form-control form-control-sm" style="width: 100%;   pointer-events: none" required>
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="form-group">
            <label for="nombre_monseñor" style="font-size: 16px;">Nombre de Monseñor:</label>
            <input type="text" id="editarNombreMonsenor" name="editarNombreMonsenor" class="form-control form-control-sm" style="width: 100%;  pointer-events: none;" required>
            <div class="invalid-feedback">
                Este campo es requerido.
            </div>
        </div>
    </div>

   
</div>
                </div>
            </fieldset>
            </div> 


             
        </div>
    </div>

    
<br>


<!-- Datos de los Padres -->
<div class="container">
    <div class="row">
       <!-- Madre -->
        <div class="col-md-6">
        <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 20px; height: 100%;">
                




<!-- Botón para abrir la segunda modal -->
<div class="d-flex justify-content-between align-items-center">
<legend><img src="https://png.pngtree.com/png-vector/20191110/ourlarge/pngtree-mother-icon-flat-style-png-image_1959222.jpg" alt="Icono Madre" style="width: 24px; height: 24px;"> Datos Madre</legend>

<a type="button" class="btn btn-success btn-sm" id="btnMostrarModal2" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; line-height: 1;">
    <i class="fas fa-user me-2" style="font-size: 1.2rem; center"></i> 
    <span style="font-size: 0.8rem;">Seleccionar Persona</span> 
</a> 
</div>




             <!-- Modal datos madre -->
<div class="modal fade" id="resultadosModal2" tabindex="-1" aria-labelledby="resultadosModalLabel2" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" style="max-width: 40%;">
        <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                <h3 class="modal-title fw-bold text-white" id="resultadosModalLabel2"><i class="fas fa-users me-2 text-white"></i> Registro de Persona</h3>
                <a href="#" class="btn btn-danger position-absolute top-0 end-0 m-0 p-2 text-white" style="width: 40px; height: 40px; line-height: 1;" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></a>
            </div>
            <div class="modal-body">
                <a href="#" class="btn btn-success position-absolute top-3 start-3 m-0 p-2 text-white" style="width: 43px; height: 43px; line-height: 1;" data-bs-dismiss="modal" aria-label="Add New">
                    <i class="fas fa-user-plus"></i>
                </a>
                <table id="tablaResultados2" class="table table-striped table-bordered" style="width: 100%">
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








                <div class="form-group row align-items-center">
                    
                    <div class="col-md-3">
                        <label for="cod_madre" style="font-size: 16px;">Código:</label>
                        <input type="text" id="editarCodMadre" name="editarCodMadre" class="form-control form-control-sm" style="width: 100%;  pointer-events: none;" value="">

                    </div>
                    <div class="col-md-7">
                        <label for="nombre_madre" style="font-size: 16px;">Nombre:</label>
                        <input type="text" id="editarNombreMadre" name="editarNombreMadre" class="form-control form-control-sm" style="width: 100%;  pointer-events: none;" >
                    </div>
                    
                </div>
            </fieldset>
        </div>

        <!-- Padre -->
        <div class="col-md-6">
        <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%;">
                


<!-- Botón para abrir la tercera modal -->
<div class="d-flex justify-content-between align-items-center">
<legend><i class="fas fa-user-tie"></i> Datos Padre</legend>

<a type="button" class="btn btn-success btn-sm" id="btnMostrarModal3" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; line-height: 1;">
    <i class="fas fa-user me-2" style="font-size: 1.2rem; center"></i> 
    <span style="font-size: 0.8rem;">Seleccionar Persona</span> 
</a> 
</div>


<!-- Modal para buscar otra persona -->
<div class="modal fade" id="resultadosModal3" tabindex="-1" aria-labelledby="resultadosModalLabel3" aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" style="max-width: 40%;">
        <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                <h3 class="modal-title fw-bold text-white" id="resultadosModalLabel3"><i class="fas fa-users me-2 text-white"></i> Registro de Personas</h3>
                <a href="#" class="btn btn-danger position-absolute top-0 end-0 m-0 p-2 text-white" style="width: 40px; height: 40px; line-height: 1;" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></a>
            </div>
            <div class="modal-body">
                <a href="#" class="btn btn-success position-absolute top-3 start-3 m-0 p-2 text-white" style="width: 43px; height: 43px; line-height: 1;" data-bs-dismiss="modal" aria-label="Add New">
                    <i class="fas fa-user-plus"></i>
                </a>
                <table id="tablaResultados3" class="table table-striped table-bordered" style="width: 100%">
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



                <div class="form-group row align-items-center">
                    
                    <div class="col-md-3">
                        <label for="cod_padre" style="font-size: 16px;">Código:</label>
                        <input type="text" id="editarCodPadre" name="editarCodPadre" class="form-control form-control-sm" style="width: 80%;  pointer-events: none;" value="" >
                    </div>
                    <div class="col-md-7">
                        <label for="nombre_padre" style="font-size: 16px;">Nombre:</label>
                        <input type="text" id="editarNombrePadre" name="editarNombrePadre" class="form-control form-control-sm" style="width: 100%;  pointer-events: none;" >
                    </div>
                   
                </div>
            </fieldset>
            </div> </div> </div> </div>
            <span style="font-size: 0.8rem;"></span> 

  



  
          








            <div class="container">
    <div class="row">
        <!-- Primer fieldset -->
        <div class="col-md-6">
            <fieldset class="h-100" style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; min-height: 120px;">
                <div class="d-flex justify-content-between align-items-center">
                <legend> <i class="fas fa-info-circle"></i> Otros Datos</legend>
                </div>
                <!-- Contenido del primer fieldset -->
                <div class="row align-items-center">
                    <div class="form-group">
                        <label for="campo4" style="font-size: 16px;">Observaciones:</label>
                        <textarea id="editarObservaciones" name="editarObservaciones" class="form-control form-control-sm" rows="2" maxlength="250" style="resize: none; border: 3px solid #48C9B0;"></textarea>
                    </div>
                </div>
            </fieldset>
        </div>

        <!-- Segundo fieldset -->
        <div class="col-md-6">
            <fieldset class="h-100" style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 20px; min-height: 120px;">
                <legend><i class="fas fa-users"></i> Datos de los Padrinos</legend>
                <div class="form-group row align-items-center">
                    <div class="col-md-12">
                        <div class="d-flex">
                            <div class="me-3" style="flex: 1;">
                                <label for="padrinos" style="font-size: 16px; display: block; margin-right: 10px;">Padrinos:</label>
                                <textarea id="editarPadrinos" name="editarPadrinos" class="form-control form-control-sm" rows="1" maxlength="300" style="resize: none; border: 2px solid #48C9B0;" value=""></textarea>
    
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </div>
    </div>
</div>



<br>

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





























<!-- Modal para mostrar los detalles  -->
    <div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                <h5 class="modal-title fw-bold text-white" id="detallesModalLabel"><i class="fas fa-id-card-alt me-2 text-white"></i>DETALLES DE CONFIRMACION</h5>
                <a href="#" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-0" data-bs-dismiss="modal" aria-label="Close" title="Cerrar">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="modal-body">
    <div class="details-container">
        <div><strong>Código:</strong> <span id="detallesCodigo"></span></div>
        <div><strong>DNI:</strong> <span id="detallesDNI"></span></div>
        <div><strong>Nombre:</strong> <span id="detallesNombre"></span></div>
        <div><strong>Fecha:</strong> <span id="detallesFecha"></span></div>
        <div><strong>Nombre Monseñor:</strong> <span id="detallesMonseñor"></span></div>
        <div><strong>Parroquia de Bautizo:</strong> <span id="detallesPaBAutizo"></span></div>
        <div><strong>Fecha Bautizo:</strong> <span id="detallesFechaBautizo"></span></div>
        <div><strong>Nombre Madre:</strong> <span id="detallesNombreMadre"></span></div>
        <div><strong>Nombre Padre:</strong> <span id="detallesNombrePadre"></span></div>
        <div><strong>Padrinos:</strong> <span id="detallesPadrinos"></span></div>
        <div><strong>Nombre Parroco:</strong> <span id="detallesNombreParroco"></span></div>
        <div><strong>Libro de Registro:</strong> <span id="detallesLibroRegistro"></span></div>
        <div><strong>Folio de Registro:</strong> <span id="detallesFolioRegistro"></span></div>
        <div><strong>Numero de Registro:</strong> <span id="detallesNumeroRegistro"></span></div>
        <div><strong>Observaciones:</strong> <span id="detallesObservaciones"></span></div>

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



    <script>

    function mostrarDetalles(codigo, dni, nombre, fecha, nombreMonseñor, parroquiaBautizo, fechaBautizo, nombreMadre, nombrePadre, Padrinos, nombreParroco, libroRegistro, folioRegistro, numeroRegistro, observaciones) {
    document.getElementById('detallesCodigo').innerText = codigo || 'N/A';
    document.getElementById('detallesDNI').innerText = dni || 'N/A';
    document.getElementById('detallesNombre').innerText = nombre || 'N/A';
    document.getElementById('detallesFecha').innerText = fecha || 'N/A';
    document.getElementById('detallesMonseñor').innerText = nombreMonseñor || 'N/A';
    document.getElementById('detallesPaBAutizo').innerText = parroquiaBautizo || 'N/A';
    document.getElementById('detallesFechaBautizo').innerText = fechaBautizo || 'N/A';
    document.getElementById('detallesNombreMadre').innerText = nombreMadre || 'N/A';
    document.getElementById('detallesNombrePadre').innerText = nombrePadre || 'N/A';
    document.getElementById('detallesPadrinos').innerText = Padrinos || 'N/A';
    document.getElementById('detallesNombreParroco').innerText = nombreParroco || 'N/A';
    document.getElementById('detallesLibroRegistro').innerText = libroRegistro || 'N/A';
    document.getElementById('detallesFolioRegistro').innerText = folioRegistro || 'N/A';
    document.getElementById('detallesNumeroRegistro').innerText = numeroRegistro || 'N/A';
    document.getElementById('detallesObservaciones').innerText = observaciones || 'N/A';

    // Mostrar el modal
    var detallesModal = new bootstrap.Modal(document.getElementById('detallesModal'));
    detallesModal.show();
}

</script>


    <script>




document.addEventListener('DOMContentLoaded', function() {
  var btnGuardar = document.getElementById('btnGuardar');
  if (btnGuardar) {
    btnGuardar.addEventListener('click', function(event) {
      var form = document.getElementById('updateConfirmacionForm');
      if (form.checkValidity() === false) {
        event.preventDefault(); // Evitar que se envíe el formulario si no es válido
        event.stopPropagation(); // Detener la propagación del evento
      }
      form.classList.add('was-validated'); // Agregar la clase para activar los estilos de validación
    });
  }
});

</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
function validarFormulario() {
    // Obtener los valores de los campos
    const codParroco = document.getElementById('editarCodParroco').value;
    const codPersonas = document.getElementById('editarCodPersona').value;
    const codMadre = document.getElementById('editarCodMadre').value;
    const codPadre = document.getElementById('editarCodPadre').value;

    // Crear un array con los valores
    const ids = [codParroco, codPersonas, codMadre, codPadre];

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










<!-- Agrega esto dentro de la sección 'content-body' donde se encuentra la modal -->
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
            $('#editarCodParroco').val(codigoPersona);
            $('#editarNombreParroco').val(nombrePersona);
            // Cerrar modal opcionalmente si así lo deseas
            $('#resultadosModal').modal('hide');
        });






    }
});
</script>



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
                $('#editarCodParroco').val(codigoPersona);
                $('#editarNombreParroco').val(nombrePersona);
              
               

                // Cerrar modal opcionalmente si así lo deseas
                $('#resultadosModal1').modal('hide');
            });
        }
    });
</script>

<!-- Script para la segunda modal para buscar persona de Párroco -->
<script>
    $(document).ready(function() {
        $('#btnMostrarModal2').click(function() {
            $('#resultadosModal2').modal('show'); // Mostrar modal al hacer clic en el botón
            cargarTablaResultados2(); // Cargar los datos en la tabla
        });

        function cargarTablaResultados2() {
            // Destruir instancia existente de DataTable si existe
            if ($.fn.DataTable.isDataTable('#tablaResultados2')) {
                $('#tablaResultados2').DataTable().destroy();
            }

            $('#tablaResultados2').DataTable({
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
                            return '<a href="#" class="btn btn-success rounded-circle btnCopiarParroco2" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;" data-codigo="' + row.COD_PERSONAS + '">' +
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
            $('#tablaResultados2').css('font-size', '0.8em');

            // Acción al hacer clic en el botón de copiar persona de Párroco
            $('#tablaResultados2').on('click', '.btnCopiarParroco2', function() {
                var codigoPersona = $(this).data('codigo');
                var nombrePersona = $(this).closest('tr').find('td:nth-child(3)').text(); // Obtener el nombre desde la columna correspondiente
                var dniPersona = $(this).closest('tr').find('td:nth-child(4)').text(); // Obtener el DNI desde la columna correspondiente
                var fechaNacimiento = $(this).closest('tr').find('td:nth-child(5)').text(); // Obtener la fecha de nacimiento desde la columna correspondiente

                // Ejemplo de cómo actualizar los campos de parroco con los datos de la persona seleccionada
                $('#editarCodMadre').val(codigoPersona);
                $('#editarNombreMadre').val(nombrePersona);
               

                // Cerrar modal opcionalmente si así lo deseas
                $('#resultadosModal2').modal('hide');
            });
        }
    });
</script>







<!-- Script para la tercera modal para buscar otra persona -->
<script>
    $(document).ready(function() {
        $('#btnMostrarModal3').click(function() {
            $('#resultadosModal3').modal('show'); // Mostrar modal al hacer clic en el botón
            cargarTablaResultados3(); // Cargar los datos en la tabla
        });

        function cargarTablaResultados3() {
            // Destruir instancia existente de DataTable si existe
            if ($.fn.DataTable.isDataTable('#tablaResultados3')) {
                $('#tablaResultados3').DataTable().destroy();
            }

            $('#tablaResultados3').DataTable({
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
                            return '<a href="#" class="btn btn-success rounded-circle btnCopiarOtraPersona" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;" data-codigo="' + row.COD_PERSONAS + '">' +
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
            $('#tablaResultados3').css('font-size', '0.8em');

            // Acción al hacer clic en el botón de copiar otra persona
            $('#tablaResultados3').on('click', '.btnCopiarOtraPersona', function() {
                var codigoPersona = $(this).data('codigo');
                var nombrePersona = $(this).closest('tr').find('td:nth-child(3)').text(); // Obtener el nombre desde la columna correspondiente
                var dniPersona = $(this).closest('tr').find('td:nth-child(4)').text(); // Obtener el DNI desde la columna correspondiente
                var fechaNacimiento = $(this).closest('tr').find('td:nth-child(5)').text(); // Obtener la fecha de nacimiento desde la columna correspondiente

                // Ejemplo de cómo actualizar los campos con los datos de la persona seleccionada
                $('#editarCodPadre').val(codigoPersona);
                $('#editarNombrePadre').val(nombrePersona);
                

                // Cerrar modal opcionalmente si así lo deseas
                $('#resultadosModal3').modal('hide');
            });
        }
    });

    
</script>










<!-- Script para la segunda modal para buscar persona de Párroco -->
<script>
    $(document).ready(function() {
        $('#btnMostrarModal4').click(function() {
            $('#resultadosModal4').modal('show'); // Mostrar modal al hacer clic en el botón
            cargarTablaResultados2(); // Cargar los datos en la tabla
        });

        function cargarTablaResultados2() {
            // Destruir instancia existente de DataTable si existe
            if ($.fn.DataTable.isDataTable('#tablaResultados4')) {
                $('#tablaResultados4').DataTable().destroy();
            }

            $('#tablaResultados4').DataTable({
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
                            return '<a href="#" class="btn btn-success rounded-circle btnCopiarParroco2" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;" data-codigo="' + row.COD_PERSONAS + '">' +
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
            $('#tablaResultados4').css('font-size', '0.8em');

            // Acción al hacer clic en el botón de copiar persona de Párroco
            $('#tablaResultados4').on('click', '.btnCopiarParroco2', function() {
                var codigoPersona = $(this).data('codigo');
                var nombrePersona = $(this).closest('tr').find('td:nth-child(3)').text(); // Obtener el nombre desde la columna correspondiente
                var dniPersona = $(this).closest('tr').find('td:nth-child(4)').text(); // Obtener el DNI desde la columna correspondiente
                var fechaNacimiento = $(this).closest('tr').find('td:nth-child(5)').text(); // Obtener la fecha de nacimiento desde la columna correspondiente

                // Ejemplo de cómo actualizar los campos de parroco con los datos de la persona seleccionada
                $('#editarCodMons').val(codigoPersona);
                $('#editarNombreMonsenor').val(nombrePersona);
               

                // Cerrar modal opcionalmente si así lo deseas
                $('#resultadosModal4').modal('hide');
            });
        }
    });
</script>

















    
    <script>
    function editarActa(codConfirmacion, dni, codPersona, nombreCompleto, fechaConfirmacion, codMons, nombreMonsenor, parroquiaBautizo, fechaBautizo, codMadre, nombreMadre, codPadre, nombrePadre, codParroco, nombreParroco, libroRegistro, folioRegistro, numeroRegistro, observaciones, padrinos,ciudad) {
        // Abrir modal
        $('#editarModalConfirmacion').modal('show');

        // Rellenar campos del formulario
        $('#editarCodigoConfirmacion').val(codConfirmacion);
        $('#editarDNIPersona').val(dni);
        $('#editarCodPersona').val(codPersona);
        $('#editarNombreCompleto').val(nombreCompleto);
        $('#editarFechaConfirmacion').val(fechaConfirmacion);
        $('#editarCodMons').val(codMons);
        $('#editarNombreMonsenor').val(nombreMonsenor);
        $('#editarParroquiaBautizo').val(parroquiaBautizo);
        $('#editarFechaBautizo').val(fechaBautizo);
        $('#editarCodMadre').val(codMadre);
        $('#editarNombreMadre').val(nombreMadre);
        $('#editarCodPadre').val(codPadre);
        $('#editarNombrePadre').val(nombrePadre);
        $('#editarCodParroco').val(codParroco);
        $('#editarNombreParroco').val(nombreParroco);
        $('#editarLibroRegistro').val(libroRegistro);
        $('#editarFolioRegistro').val(folioRegistro);
        $('#editarNumeroRegistro').val(numeroRegistro);
        $('#editarObservaciones').val(observaciones);
        $('#editarPadrinos').val(padrinos);
        $('#editarCiudad').val(ciudad);
    
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
validateInput(document.querySelector('#editarCodigoConfirmacion'));
validateInput(document.querySelector('#editarDNIPersona'));
validateInput(document.querySelector('#editarCodPersona'));
validateInput(document.querySelector('#editarNombreCompleto'));
validateInput(document.querySelector('#editarFechaConfirmacion'));
validateInput(document.querySelector('#editarCodMons'));
validateInput(document.querySelector('#editarNombreMonsenor'));
validateInput(document.querySelector('#editarParroquiaBautizo'));
validateInput(document.querySelector('#editarFechaBautizo'));
validateInput(document.querySelector('#editarCodMadre'));
validateInput(document.querySelector('#editarNombreMadre'));
validateInput(document.querySelector('#editarCodPadre'));
validateInput(document.querySelector('#editarNombrePadre'));
validateInput(document.querySelector('#editarCodParroco'));
validateInput(document.querySelector('#editarNombreParroco'));
validateInput(document.querySelector('#editarLibroRegistro'));
validateInput(document.querySelector('#editarFolioRegistro'));
validateInput(document.querySelector('#editarNumeroRegistro'));
validateInput(document.querySelector('#editarObservaciones'));
validateInput(document.querySelector('#editarPadrinos'));
validateInput(document.querySelector('#editarCiudad'));

// Establecer valores en los campos de edición

</script>




<script>

document.getElementById('editarParroquiaBautizo').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-zñÑ\s]/g, '');
});
document.getElementById('editarLibroRegistro').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '');
});

document.getElementById('#editarFolioRegistro').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
});

document.getElementById('editarNumeroRegistro').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
});



document.getElementById('editarCiudad').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-zñÑ\s]/g, '');
});
</script>







<script>
        document.getElementById('editarPadrinos').addEventListener('input', function(event) {
            const input = event.target;
            const value = input.value;

            // Permitir solo letras, números, espacios y comas
            const sanitizedValue = value.replace(/[^a-zA-ZñÑ, ]/g, '');

            if (value !== sanitizedValue) {
                input.value = sanitizedValue;
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

      


    </script>






<script>
    function numeroEnTexto(num) {
        const unidades = ['Cero', 'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis', 'Siete', 'Ocho', 'Nueve'];
        const decenas = ['Diez', 'Once', 'Doce', 'Trece', 'Catorce', 'Quince', 'Dieciséis', 'Diecisiete', 'Dieciocho', 'Diecinueve'];
        const decenasMultiples = ['Veinte', 'Veintiuno', 'Veintidós', 'Veintitrés', 'Veinticuatro', 'Veinticinco', 'Veintiséis', 'Veintisiete', 'Veintiocho', 'Veintinueve'];
        const decenasDecenas = ['Treinta', 'Cuarenta', 'Cincuenta', 'Sesenta', 'Setenta', 'Ochenta', 'Noventa'];
        const centenas = ['Cien', 'Doscientos', 'Trescientos', 'Cuatrocientos', 'Quinientos', 'Seiscientos', 'Setecientos', 'Ochocientos', 'Novecientos'];
        const miles = ['Mil', 'Dos mil', 'Tres mil', 'Cuatro mil', 'Cinco mil', 'Seis mil', 'Siete mil', 'Ocho mil', 'Nueve mil'];

        if (num < 10) return unidades[num];
        if (num < 20) return decenas[num - 10];
        if (num < 30) return decenasMultiples[num - 20];
        if (num < 100) return decenasDecenas[Math.floor(num / 10) - 3] + (num % 10 === 0 ? '' : ' y ' + unidades[num % 10]);
        if (num < 1000) return centenas[Math.floor(num / 100) - 1] + (num % 100 === 0 ? '' : ' ' + numeroEnTexto(num % 100));
        if (num < 2000) return miles[0] + (num % 1000 === 0 ? '' : ' ' + numeroEnTexto(num % 1000));
        if (num < 10000) return miles[Math.floor(num / 1000) - 1] + (num % 1000 === 0 ? '' : ' ' + numeroEnTexto(num % 1000));

        return num.toString(); // En un caso real, necesitarías más lógica para manejar números grandes
    }

    function mostrarConstancia(
        codConfirmacion, dni, codPersonas, nombreCompleto, fechaNacimiento, genero, fechaConfirmacion,
        codMons, nombreMons, parroquiaBautizo, fecBautizo, codMadre, nombreMadre,
        codPadre, nombrePadre, codParroco, nombreParroco, libroReg, folioReg, numeroReg, observaciones, padrinos, nomCiudad
    ) {
        // Función para convertir un número de mes a nombre de mes
        function numeroAMes(numero) {
            const meses = [
                'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
            ];
            return meses[numero - 1] || 'Mes desconocido';
        }

        // Función para convertir un número de día a nombre del día en texto
        function numeroADia(numero) {
            const dias = [
                'Uno', 'Dos', 'Tres', 'Cuatro', 'Cinco', 'Seis',
                'Siete', 'Ocho', 'Nueve', 'Diez', 'Once', 'Doce',
                'Trece', 'Catorce', 'Quince', 'Dieciséis', 'Diecisiete',
                'Dieciocho', 'Diecinueve', 'Veinte', 'Veintiuno', 'Veintidós',
                'Veintitrés', 'Veinticuatro', 'Veinticinco', 'Veintiséis', 'Veintisiete',
                'Veintiocho', 'Veintinueve', 'Treinta', 'Treinta y uno'
            ];
            return dias[numero - 1] || 'Día desconocido';
        }

        // Función para convertir un número de año a texto
        function numeroAAnioTexto(numero) {
            return numeroEnTexto(numero);
        }

        // Función para convertir una fecha en formato YYYY-MM-DD a texto
        function fechaEnLetras(fecha) {
            const partes = fecha.split('-');
            const año = partes[0];
            const mes = parseInt(partes[1], 10);
            const dia = parseInt(partes[2], 10);
            return `${numeroADia(dia)} del mes de ${numeroAMes(mes)} de ${numeroAAnioTexto(parseInt(año, 10))}`;
        }

        // Función para obtener la fecha actual en formato texto
        function fechaActualEnLetras() {
            const ahora = new Date();
            const dia = ahora.getDate();
            const mes = ahora.getMonth() + 1; // Los meses son de 0 a 11
            const año = ahora.getFullYear();
            return fechaEnLetras(`${año}-${mes.toString().padStart(2, '0')}-${dia.toString().padStart(2, '0')}`);
        }

        // Extraer la fecha en formato YYYY-MM-DD sin la parte de la hora
        const fechaNacimientoSoloFecha = fechaNacimiento.split('T')[0]; 
        
        // Convertir la fecha de nacimiento a letras
        const fechaNacimientoEnLetras = fechaEnLetras(fechaNacimientoSoloFecha);

        // Convertir la fecha de confirmación a letras
        const fechaConfirmacionEnLetras = fechaEnLetras(fechaConfirmacion);

        // Convertir la fecha actual a letras
        const fechaActualEnLetrasTexto = fechaActualEnLetras();

        const textoGenero = genero === 'F' ? 'HIJA DE' : 'HIJO DE';

        // Asignar el contenido al elemento
        document.getElementById('nombreConstancia').textContent = nombreCompleto;
        document.getElementById('dniConstancia').textContent = dni;
        document.getElementById('fechaConfirmacionConstancia').textContent = fechaConfirmacionEnLetras; // Muestra la fecha en letras
        document.getElementById('nombreMonsConstancia').textContent = nombreMons;
        document.getElementById('generoConstancia').textContent = textoGenero;
        document.getElementById('fechaNacimientoConstancia').textContent = fechaNacimientoEnLetras; // Muestra la fecha en letras
        document.getElementById('parroquiaBautizoConstancia').textContent = parroquiaBautizo;
        document.getElementById('fecBautizoConstancia').textContent = fechaEnLetras(fecBautizo);
        document.getElementById('nombreMadreConstancia').textContent = nombreMadre;
        document.getElementById('nombrePadreConstancia').textContent = nombrePadre;
        document.getElementById('nombreParrocoConstancia').textContent = nombreParroco;
        document.getElementById('libroRegConstancia').textContent = libroReg;
        document.getElementById('folioRegConstancia').textContent = folioReg;
        document.getElementById('numeroRegConstancia').textContent = numeroReg;
        document.getElementById('observacionesConstancia').textContent = observaciones;
        document.getElementById('padrinosConstancia').textContent = padrinos;
        document.getElementById('nomCiudadConstancia').textContent = nomCiudad;
        document.getElementById('fechaActualTexto').textContent = fechaActualEnLetrasTexto; // Muestra la fecha actual en letras

        const constanciaModal = new bootstrap.Modal(document.getElementById('constanciaModal'));
        constanciaModal.show();
    }

    function imprimirConstancia() {
        const printContent = document.getElementById('constanciaContent').innerHTML;
        const originalContent = document.body.innerHTML;

        document.body.innerHTML = printContent;
        window.print();
        document.body.innerHTML = originalContent;
        window.location.reload();
    }
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
