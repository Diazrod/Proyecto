<!DOCTYPE html>
<html lang="en">
<head>
    

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    


    <title>Parroquia SMP - RECONCILIACIÓN</title>
    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/iglesia.png') }}" type="image/x-icon">
  
    <title>Formulario de Reconciliacion - Parroquia SMP</title>
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    
    <!-- Estilos personalizados -->
    <style>
      

.content1 {
    background-color: white;
    border: 8px solid #48C9B0; /* Borde de la vista */
    padding: 10px; /* Espacio interno ajustado */
    margin-bottom: 20px; /* Espacio entre los contenedores .content1 */
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); /* Sombra suave */
}

.content-header {
    border-bottom: 10px solid gold;
    background-color: #48C9B0;
    padding: 20px; /* Aumento del padding superior e inferior */
    color: white;
    margin-bottom: 20px; /* Espacio entre los contenedores .content-header */
}

        .content-body {
            padding: 20px;
        }
        fieldset {
            border: 2px solid #48C9B0; /* Borde de las secciones */
            padding: 15px;
            margin-bottom: 20px;
        }
        legend {
            font-weight: bold;
            margin-bottom: 10px;
            font-size: 20px;
            color: #48C9B0;
        }
        .form-group {
            margin-bottom: 20px;
        }
        

        
        

        input[type="text"],
input[type="date"],
input[type="email"],
input[type="number"],
input[type="password"],
input[type="tel"],
input[type="url"],
input[type="search"],
input[type="time"],
input[type="week"],
input[type="month"],
input[type="datetime-local"],
input[type="color"] {
    width: calc(100% - 200px); /* Ancho del input ajustado según necesidad */
    padding: 8px; /* Padding uniforme */
    border: 2px solid #48C9B0; /* Borde verde */
    border-radius: 4px; /* Borde redondeado */
    box-sizing: border-box; /* Asegura que el padding no afecte al ancho total */
}


        
        
/* Estilos personalizados para la paginación en verde */
#resultadosModal .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    #resultadosModal .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
        background-color: #48C9B0 !important; /* Fondo verde */
        color: #FFFFFF !important; /* Texto blanco */
        border-color: #48C9B0 !important; /* Borde verde */
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
    <div class="content-header d-flex align-items-center justify-content-between">
    
    <div class="text-center flex-grow-1">
        <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 45px; text-shadow: 4px 4px #ffffff;">
            FORMULARIO DE RECONCILIACIÓN
        </h1>
        <h1 class="fw-bold" style="font-style: italic; font-family: 'Times New Roman', serif; color: black; font-size: 33px;">
        PARROQUIA SAN MARTÍN DE PORRES
        </h1>
    </div>

    <a href="{{ url('/sacramentos/reconciliacion') }}" class="btn btn-danger" style="font-size: 16px; margin-top: -85px;">
        <i class="fas fa-times"></i> 
    </a>
</div>

    <div class="content-body">
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Éxito:</strong> {{ session('success') }}
        <button type="button" class="btn-close" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error:</strong> {{ session('error') }}
        <button type="button" class="btn-close" aria-label="Close"></button>
    </div>
@endif
        <form id="miFormulario" action="{{ route('crearREeconciliacion') }}" method="POST" class="row g-3 needs-validation" novalidate>

        
            @csrf
            
            <div class="d-flex justify-content-end">
    <div class="">
   
    <label for="fecha" style="font-weight: bold; font-size: 14px;">
    <i class="fas fa-calendar-alt"></i> Fecha:
    
</label>

        <input type="date" id="fecha" name="fecha" class="form-control form-control-sm" style="width: 60%; display: inline-block; margin-left: 2px;"required >
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
<br>
                <!-- Modal para abrir persona de Párroco -->
                <div class="modal fade" id="resultadosModal" tabindex="-1" aria-labelledby="resultadosModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-m">
                        <<div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                
                                <h3 class="modal-title fw-bold text-white" id="resultadosModalLabel"><i class="fas fa-users me-2 text-white"></i> Registro de Persona</h3>
                                
                                    
                                <a href="#" class="btn btn-danger position-absolute top-0 end-0 m-0 p-2 text-white" style="width: 40px; height: 40px; line-height: 1;" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></a>
    
                            </div>
                            <div class="modal-body">
                            <a href="/Feligreses" class="btn btn-success position-absolute top-3 start-3 m-0 p-2 text-white" style="width: 43px; height: 43px; line-height: 1;" aria-label="Add New">
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

                   <div class="col-md-2">
  <div class="form-group">
    <label for="cod_parroco" style="font-size: 16px;">Código:</label>
    <input type="text" id="cod_parroco" name="cod_parroco" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required >
    <div class="invalid-feedback">
      +
    </div>
  </div>
</div>
<div class="col-md-6">
  <div class="form-group">
    <label for="nombre_parroco" style="font-size: 16px;">Nombre:</label>
    <input type="text" id="nombre_parroco" name="nombre_parroco" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required >
    <div class="invalid-feedback">
      Por favor Selecciones una Persona.
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="dni_parroco" style="font-size: 16px;">DNI:</label>
    <input type="text" id="dni_parroco" name="dni_parroco" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required >
    <div class="invalid-feedback">
     +
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
    <input type="text" id="libro_reg" name="libro_reg" class="form-control form-control-sm" style="width: 100%;" maxlength="50" required>

    <div class="invalid-feedback">
      Por favor ingrese el número de libro.
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="folio_reg" style="font-weight: bold; font-size: 16px;">Folio:</label>
    <input type="number" id="folio_reg" name="folio_reg" class="form-control form-control-sm" value="" style="width: 100%;" maxlength="30">
    <div class="invalid-feedback">
      Por favor ingrese el número de folio.
    </div>
  </div>
</div>
<div class="col-md-4">
  <div class="form-group">
    <label for="numero_reg" style="font-weight: bold; font-size: 16px;">Número:</label>
    <input type="number" id="numero_reg" name="numero_reg" class="form-control form-control-sm" value="" style="width: 100%;" maxlength="30">
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






<!-- datos del la persona que Realiza la Reconciliacion  -->

      
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <fieldset style="border: 4px solid #CCFBF1; padding: 10px; margin-bottom: 15px; height: 100%;">
                <div class="d-flex justify-content-between align-items-center">
                    <legend><i class="fas fa-user"></i> Datos de la Persona</legend>
                    <a type="button" class="btn btn-success btn-sm" id="btnMostrarModal1" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; line-height: 1;">
    <i class="fas fa-user me-2" style="font-size: 1.2rem; center"></i> 
    <span style="font-size: 0.8rem;">Seleccionar Persona</span> 
</a>
                </div>
<br>
                <!-- Contenido del primer fieldset -->
                <div class="modal fade" id="resultadosModal1" tabindex="-1" aria-labelledby="resultadosModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-m">
                        <div class="modal-content" style="background-color: #FFFFFF; border: 6px solid #48C9B0;">
                            <div class="modal-header" style="background-color: #48C9B0; position: relative;">
                                <h3 class="modal-title fw-bold text-white" id="resultadosModalLabel1"><i class="fas fa-users me-2 text-white"></i> Registro de Persona</h3>
                                <a href="#" class="btn btn-danger position-absolute top-0 end-0 m-0 p-2 text-white" style="width: 40px; height: 40px; line-height: 1;" data-bs-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></a>
                            </div>
                            <div class="modal-body">
                            <a href="/Feligreses" class="btn btn-success position-absolute top-3 start-3 m-0 p-2 text-white" style="width: 43px; height: 43px; line-height: 1;" aria-label="Add New">
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

                <!-- Contenido del primer fieldset -->
                <div class="row align-items-center">
    <div class="col-md-2">
        <div class="form-group">
            <label for="cod_personas" style="font-size: 16px;">Código:</label>
            <input type="text" id="cod_personas" name="cod_personas" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required>
            <div class="invalid-feedback">
               +
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="nombre_bautizado" style="font-size: 16px;">Nombre:</label>
            <input type="text" id="nombre" name="nombre" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required>
            <div class="invalid-feedback">
                Por Favor Seleccione una Persona.
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group">
            <label for="dni_bautizado" style="font-size: 16px;">DNI:</label>
            <input type="text" id="dni" name="dni" class="form-control form-control-sm" style="width: 100%; pointer-events: none;" required>
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
    <textarea id="observaciones" name="observaciones" class="form-control form-control-sm" rows="3"  style="resize: none; border: 3px solid #48C9B0;" value="" maxlength="250"></textarea>
    
</div>

                </div>
            </fieldset>
        </div>
    </div>

    




 
<br>
 





<div class="input-group d-flex justify-content-center">
        <button id="btnGuardar" class="btn btn-success" type="submit" onclick="return validarFormulario()"><i class="fas fa-save"></i> Guardar</button>
          
   
    <a href="/sacramentos/reconciliacion" class="btn btn-danger ms-2" id="btnCancelar">
        <i class="fas fa-times-circle"></i> Cancelar
    </a>
</div>

            </fieldset>


        
















            </div>
        </form>
    </div>
</div>
@stop


@section('js')

 <!-- jQuery -->
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>


<script>
    console.log('Hi!');
    
</script>

<script>
document.getElementById('libro_reg').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9\s]/g, '');
});



document.getElementById('folio_reg').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
});

document.getElementById('numero_reg').addEventListener('input', function(e) {
    // Reemplaza cualquier carácter que no sea alfanumérico
    this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
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


validateInput(document.querySelector('#folio_reg'));
validateInput(document.querySelector('#numero_reg'));
validateInput(document.querySelector('#libro_reg'));

validateInput(document.querySelector('#observaciones'));


</script>

<script>




  document.addEventListener('DOMContentLoaded', function() {
    var btnGuardar = document.getElementById('btnGuardar');
    if (btnGuardar) {
      btnGuardar.addEventListener('click', function(event) {
        var form = document.getElementById('miFormulario');
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
    const codParroco = document.getElementById('cod_parroco').value;
    const codPersonas = document.getElementById('cod_personas').value;
    

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
            $('#cod_parroco').val(codigoPersona);
            $('#nombre_parroco').val(nombrePersona);
            $('#dni_parroco').val(dniPersona);

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
                $('#cod_personas').val(codigoPersona);
                $('#nombre').val(nombrePersona);
                $('#dni').val(dniPersona);
                $('#fecha_nacimiento').val(fechaNacimiento);

                // Cerrar modal opcionalmente si así lo deseas
                $('#resultadosModal1').modal('hide');
            });
        }
    });
</script>






    
</script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Éxito',
            text: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @elseif(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 3000
        });
    @endif



    $(document).ready(function() {
        // Cerrar alertas con botón de cierre
        $('.alert .btn-close').click(function() {
            $(this).closest('.alert').fadeOut();
        });
    });
</script>




@stop



</body>
</html>



