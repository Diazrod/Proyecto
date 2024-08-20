<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyectos</title>
    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/iglesia.png') }}" type="image/x-icon">

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">

    <!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.min.css">

@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content_header')
@stop
</head>

<body>
    

    @section('content')
        <div class="container mt-4">
            <div class="d-flex justify-content-between mb-3 align-items-center">
            <div class="col-auto">
                <!-- Coloca aquí la imagen correspondiente a 'Detalles Generales' -->
                <img src="{{ asset('vendor/adminlte/dist/img/general2.png') }}" style="width: 190px; height: 190px;">
            </div>
                <div class="col text-center">
                    <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 60px; text-shadow: 2px 2px rgba(72, 201, 176, 0.8); letter-spacing: 1px;">
                        Registros de Proyectos
                    </h1>
                </div>
                <!-- Botón Nuevo -->
                <div class="col-auto">
                <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 18; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
                    <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white;" data-bs-toggle="modal" data-bs-target="#nuevoProyectoModal">
                        <i class="fas fa-plus"></i> Nuevo Proyecto
                    </button>
                    @endif
                </div>
            </div>

            <div class="container mt-5">
                   <!-- Tabla de Proyectos -->
                 
        <table id="proyectosTable" class="table table-striped">
            <thead>
                <tr>
                    <th style="background-color:#48C9B0; color: black; text-align: center;">Código</th>
                    <th style="background-color:#48C9B0; color: black; text-align: center;">Nombre</th>
                    <th style="background-color:#48C9B0; color: black; text-align: center;">Fecha Inicio</th>
                    <th style="background-color:#48C9B0; color: black; text-align: center;">Estado</th>
                    <th style="background-color:#48C9B0; color: black; text-align: center;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($Proyectos as $proyecto)
                    <tr>
                        <td style="text-align: center">{{ $proyecto['COD_PROYECTO'] }}</td>
                        <td style="text-align: center">{{ $proyecto['NOMBRE'] }}</td>
                        <td style="text-align: center">{{ \Carbon\Carbon::parse($proyecto['FEC_INICIO'])->format('d/m/Y') }}</td>
                        <td style="text-align: center">{{ $proyecto['ESTADO'] }}</td>
                        <td style="text-align: center">
                            <button class="btn btn-info btn-sm" onclick="mostrarDetalles('{{ $proyecto['COD_PROYECTO'] }}', '{{ $proyecto['NOMBRE'] }}', '{{ $proyecto['COD_TIPO_PROYECTO'] }}', '{{ $proyecto['tipo'] }}','{{ $proyecto['OBSERVACIONES'] }}', '{{ $proyecto['FEC_INICIO'] }}', '{{ $proyecto['FEC_FIN'] }}', '{{ $proyecto['RECURSOS_NECESARIOS'] }}', '{{ $proyecto['ESTADO'] }}')">
                                <i class="fas fa-info-circle"></i> Detalles
                            </button>
                            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                            <button class="btn btn-warning btn-sm" onclick="mostrarModificar('{{ $proyecto['COD_PROYECTO'] }}', '{{ $proyecto['NOMBRE'] }}', '{{ $proyecto['COD_TIPO_PROYECTO'] }}', '{{ $proyecto['tipo'] }}','{{ $proyecto['OBSERVACIONES'] }}', '{{ $proyecto['FEC_INICIO'] }}', '{{ $proyecto['FEC_FIN'] }}', '{{ $proyecto['RECURSOS_NECESARIOS'] }}', '{{ $proyecto['ESTADO'] }}')">
                                <i class="fas fa-edit"></i> Modificar
                            </button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        
            </div>

            <!-- Modal para Nuevo Proyecto -->
            <div class="modal fade" id="nuevoProyectoModal" tabindex="-1" aria-labelledby="nuevoProyectoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
        <div class="modal-content border-warning">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="nuevoProyectoModalLabel">
                    <i class="fas fa-plus me-2"></i> NUEVO PROYECTO
                </h5>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="nuevoProyectoForm" novalidate method="POST" action="{{ url('/Proyecto_INS') }}">
                    @csrf

                    <!-- Botón para seleccionar Tipo Proyecto -->


                    <div class="d-flex justify-content-end">
    <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#tipoProyectoModal">
        <i class="fas fa-search me-1"></i> Buscar Tipo Proyecto
    </button>
</div>





                    <div class="col-md-3 ">
                       
                        <label for="COD_TIPO_PROYECTO" class="form-label">Código Tipo Proyecto</label>
                        <input type="text" class="form-control" id="COD_TIPO_PROYECTO" name="COD_TIPO_PROYECTO" style="width: 100%; pointer-events: none;" required>
                    </div>

                    <div class="col-md-4">
                        <label for="NOM_TIPO" class="form-label">Nombre Tipo Proyecto</label>
                        <input type="text" class="form-control" id="NOM_TIPO" name="NOM_TIPO"  style="width: 100%; pointer-events: none;" required>
                        <div class="invalid-feedback">
                            Por favor seleccione un Tipo Proyecto.
                        </div>
                    </div>

                    <!-- Otros campos del formulario -->
                    <div class="col-md-5">
                        <label for="NOMBRE" class="form-label">Nombre Proyecto</label>
                        <input type="text" class="form-control" id="NOMBRE" name="NOMBRE"  required maxlength="255" required>
                        <div class="invalid-feedback">
                            Por favor ingrese el nombre del proyecto.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="FEC_INICIO" class="form-label">Fecha Inicio</label>
                        <input type="date" class="form-control" id="FEC_INICIO" name="FEC_INICIO" required>
                        <div class="invalid-feedback">
                            Por favor seleccione la fecha.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="FEC_FIN" class="form-label">Fecha Finalización</label>
                        <input type="date" class="form-control" id="FEC_FIN" name="FEC_FIN">
                    </div>
                    <div class="col-md-4">
                        <label for="ESTADO" class="form-label">Estado</label>
                        <select class="form-select" id="ESTADO" name="ESTADO" required>
                            <option selected disabled value="">Seleccione un estado</option>
                            <option value="PLANIFICADO">PLANIFICADO</option>
                            <option value="EN_PROGRESO">EN PROGRESO</option>
                            <option value="FINALIZADO">FINALIZADO</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un estado.
                        </div>
                    </div>
                    <div class="col-md-12">
    <label for="RECURSOS_NECESARIOS" class="form-label">Recursos Necesarios</label>
    <textarea class="form-control" id="RECURSOS_NECESARIOS"  maxlength="500" name="RECURSOS_NECESARIOS" onpaste="return false;" oncopy="return false;" oncut="return false;"></textarea>
</div>

                    <div class="col-md-12">
    <label for="OBSERVACIONES" class="form-label">Observaciones</label>
    <textarea class="form-control" id="OBSERVACIONES" name="OBSERVACIONES"  maxlength="500" onpaste="return false;" oncopy="return false;" oncut="return false;"></textarea>
</div>

                    <div class="col-12 text-center">
                        <button id="btnGuardar" class="btn btn-success text-white" type="submit">
                            <i class="fas fa-save me-2"></i> Guardar
                        </button>
                        <button type="button" class="btn btn-danger ms-2" data-bs-dismiss="modal">
                            <i class="fas fa-times"></i> Cancelar
                        </button> 

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal para seleccionar Tipo Proyecto -->
<div class="modal fade" id="tipoProyectoModal" tabindex="-1" aria-labelledby="tipoProyectoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 45%;">
        <div class="modal-content border-info">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="tipoProyectoModalLabel">
                    <i class="fas fa-list me-2"></i> Seleccionar Tipo de Proyecto
                </h5>
            </div>
            <div class="modal-body" style="overflow-y: auto; max-height: 400px;">
                <!-- Botón Nuevo Proyecto -->
                <a href="/tipo_Proyectos" class="btn btn-success mb-3" id="nuevoProyectoBtn">
                    <i class="fas fa-plus"></i> Nuevo Proyecto
                </a>
                
                <table id="tipoProyectoTable" class="table table-sm table-striped table-bordered" style="width: 100%;">
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
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal" data-bs-toggle="modal" data-bs-target="#nuevoProyectoModal">
                    <i class="fas fa-times"></i> Cerrar 
                </button>
            </div>
        </div>
    </div>
</div>



           
          <!-- Modal Ver Detalles Proyecto -->
<div class="modal fade" id="verDetallesModal" tabindex="-1" aria-labelledby="verDetallesModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-ml">
        <div class="modal-content border-info">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="verDetallesModalLabel">
                    <i class="fas fa-info-circle me-2"></i> DETALLES DEL PROYECTO
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
                            <th style="border: none;">Nombre:</th>
                            <td id="detalleNombre" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Código Tipo Proyecto:</th>
                            <td id="detallecodtipo" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Nombre Tipo Proyecto:</th>
                            <td id="detalletipo" style="border: none;"></td>
                        </tr>
                       
                        <tr style="border: none;">
                            <th style="border: none;">Fecha Inicio:</th>
                            <td id="detalleFechaInicio" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Fecha Fin:</th>
                            <td id="detalleFechaFin" style="border: none;"></td>
                        </tr>
                        
                        <tr style="border: none;">
                            <th style="border: none;">Estado:</th>
                            <td id="detalleEstado" style="border: none;"></td>
                        </tr>

                        <tr style="border: none;">
                            <th style="border: none;">Recursos Necesarios:</th>
                            <td id="detalleRecursosNecesarios" style="border: none;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th style="border: none;">Observaciones:</th>
                            <td id="detalleObservaciones" style="border: none;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
            <a href="/Proyectos" class="btn btn-danger" >
    <i class="fas fa-times"></i> Cancelar
</a>
            </div>
        </div>
    </div>
</div>


            <!-- Modal Modificar Proyecto -->
            <div class="modal fade" id="modificarProyectoModal" tabindex="-1" aria-labelledby="modificarProyectoModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
                    <div class="modal-content border-warning">
                        <div class="modal-header" style="background-color: #48C9B0; color: white;">
                            <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarProyectoModalLabel">
                                <i class="fas fa-edit me-2"></i> MODIFICAR PROYECTO
                            </h5>
                        </div>
                        <div class="modal-body">
                        
                    
                       

                        
                        
                        <form class="row g-3 needs-validation" id="modificarProyectoForm" novalidate method="POST"  
                        action="{{ route('Proyecto.update', ['id' => $proyecto['COD_PROYECTO'] ]) }}" >
                                @csrf
                                @method('PUT')
                              

                              


    
    

                                <div class="col-md-3">
                                    <label for="modificarNOMBRE" class="form-label">Cod Proyecto</label>
                                    <input type="text" class="form-control" id="modificarCOD_PROYECTO" style="width: 100%; pointer-events: none;" name="COD_PROYECTO">
                                   
                                    <div class="invalid-feedback">
                                        Por favor ingrese el nombre del proyecto.
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <label for="modificarCOD_TIPO_PROYECTO" class="form-label">Codigo Tipo Proyecto</label>
                                    <input type="number" class="form-control" id="modificarcodtipo" style="width: 100%; pointer-events: none;" name="COD_TIPO_PROYECTO" required>
                                </div>

                                <div class="col-md-6">
                                    <label for="modificarNOMBRE" class="form-label"> Tipo Proyecto</label>
                                    <input type="text" class="form-control" id="modificartipo"   maxlength="100" style="width: 100%; pointer-events: none;" name="NOMBREPro" required>
                                    <div class="invalid-feedback">
                                        Por favor Seleccione un Tipo de Proyecto.
                                    </div>
                                </div>


                                
                                <div class="col-md-12">
                                    <label for="modificarNOMBRE" class="form-label">Nombre Proyecto</label>
                                    <input type="text" class="form-control" id="modificarNOMBRE"  maxlength="255" name="NOMBRE" required>
                                    <div class="invalid-feedback">
                                        Por favor ingrese el nombre del proyecto.
                                    </div>
                                </div>
                                
                                
                                <div class="col-md-4">
                                    <label for="modificarFEC_INICIO" class="form-label">Fecha Inicio</label>
                                    <input type="DATE" class="form-control" id="modificarFEC_INICIO" name="FEC_INICIO" required>
                                </div>
                                <div class="col-md-4">
                                    <label for="modificarFEC_FIN" class="form-label">Fecha Finalización</label>
                                    <input type="DATE" class="form-control" id="modificarFEC_FIN" name="FEC_FIN" >
                                </div>

                                
                                <div class="col-md-4">
                                    <label for="ESTADO" class="form-label">Estado</label>
                                    <select class="form-select" id="modificarESTADO" name="ESTADO" required>
                            <option selected disabled value="">Seleccione un estado</option>
                            <option value="PLANIFICADO">PLANIFICADO</option>
                            <option value="EN_PROGRESO">PROCESO</option>
                            <option value="FINALIZADO">FINALIZADO</option>
                            
                        </select>
                                    <div class="invalid-feedback">
                                        Por favor seleccione un estado.
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <label for="modificarRECURSOS_NECESARIOS" class="form-label">Recursos Necesarios</label>
                                    <textarea class="form-control" id="modificarRECURSOS_NECESARIOS"   maxlength="500" name="RECURSOS_NECESARIOS"></textarea>
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="modificarOBSERVACIONES" class="form-label">Observaciones</label>
                                    <textarea class="form-control" id="modificarOBSERVACIONES"  maxlength="1500" name="OBSERVACIONES"></textarea>
                                </div>

                                <div class="col-12 text-center">
                                    <button id="btnModificar" class="btn btn-success text-white" type="submit">
                                        <i class="fas fa-save me-2"></i> Guardar Cambios
                                    </button>
                                    <a href="/Proyectos" class="btn btn-danger" >
    <i class="fas fa-times"></i> Cancelar
</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>




<!-- Modal para seleccionar Tipo Proyecto -->



   <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function() {
        $('#proyectosTable').DataTable({
            "search": {
                "caseInsensitive": true
            },
            "language": {
                "sEmptyTable": "No hay datos disponibles en la tabla",
                "sInfo": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "sInfoEmpty": "Mostrando 0 a 0 de 0 entradas",
                "sInfoFiltered": "(filtrado de _MAX_ entradas totales)",
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
                    "sSortAscending": ": activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": activar para ordenar la columna de manera descendente"
                }
            }
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const inputs = document.querySelectorAll('input[type="text"], input[type="number"]');
    
    inputs.forEach(input => {
        // Evitar el pegado y copiar
        input.addEventListener('paste', (e) => e.preventDefault());
        input.addEventListener('copy', (e) => e.preventDefault());
        input.addEventListener('cut', (e) => e.preventDefault());

        // Restringir los caracteres permitidos
        input.addEventListener('input', function(e) {
            let value = e.target.value;
            // Permitir solo caracteres alfanuméricos y espacios
            e.target.value = value.replace(/[^a-zA-Z0-9ñÑ\s]/g, '');
        });
    });
});
</script>

<script>



document.addEventListener('DOMContentLoaded', function() {
  var btnGuardar = document.getElementById('btnModificar');
  if (btnGuardar) {
    btnGuardar.addEventListener('click', function(event) {
      var form = document.getElementById('modificarProyectoForm');
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
  var btnGuardar = document.getElementById('btnGuardar');
  if (btnGuardar) {
    btnGuardar.addEventListener('click', function(event) {
      var form = document.getElementById('nuevoProyectoForm');
      if (form.checkValidity() === false) {
        event.preventDefault(); // Evitar que se envíe el formulario si no es válido
        event.stopPropagation(); // Detener la propagación del evento
      }
      form.classList.add('was-validated'); // Agregar la clase para activar los estilos de validación
    });
  }
});




</script>






    <!-- Custom Script -->
    

<script>

document.addEventListener('DOMContentLoaded', function() {
    const tipoProyectoTable = $('#tipoProyectoTable').DataTable({
        processing: true,
        serverSide: false,
        ajax: {
            url: '/buscar_proyecto',
            dataSrc: 'data'
        },
        columns: [
            { 
                data: 'COD_TIPO_PROYECTO',
                
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

    $('#tipoProyectoTable tbody').on('click', 'button', function() {
        const data = tipoProyectoTable.row($(this).parents('tr')).data();
        
        document.getElementById('COD_TIPO_PROYECTO').value = data.COD_TIPO_PROYECTO;
        document.getElementById('NOM_TIPO').value = data.NOMBRE;

        $('#tipoProyectoModal').modal('hide');
        $('#nuevoProyectoModal').modal('show');
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
   



            function mostrarDetalles(codigo, nombre, codtipo, tipo, observaciones, fec_inicio, fec_fin, recursos, estado) {
                document.getElementById('detalleCodigo').innerText = codigo;
                document.getElementById('detalleNombre').innerText = nombre;
                document.getElementById('detallecodtipo').innerText = codtipo;
                document.getElementById('detalletipo').innerText = tipo;
                
                
                document.getElementById('detalleObservaciones').innerText = observaciones;
                document.getElementById('detalleFechaInicio').innerText = formatDate(fec_inicio);
                document.getElementById('detalleFechaFin').innerText = formatDate(fec_fin);
                document.getElementById('detalleRecursosNecesarios').innerText = recursos;
                document.getElementById('detalleEstado').innerText = estado;
                new bootstrap.Modal(document.getElementById('verDetallesModal')).show();
            }

            function mostrarModificar(codigo, nombre, codtipo, tipo, observaciones, fec_inicio, fec_fin, recursos, estado) {
                document.getElementById('modificarCOD_PROYECTO').value = codigo;
                document.getElementById('modificarNOMBRE').value = nombre;
                document.getElementById('modificarcodtipo').value = codtipo;
                document.getElementById('modificartipo').value = tipo;

                document.getElementById('modificarOBSERVACIONES').value = observaciones;
                document.getElementById('modificarFEC_INICIO').value = formatDate2(fec_inicio);
                document.getElementById('modificarFEC_FIN').value = formatDate2(fec_fin);
                document.getElementById('modificarRECURSOS_NECESARIOS').value = recursos;
                document.getElementById('modificarESTADO').value = estado;
                new bootstrap.Modal(document.getElementById('modificarProyectoModal')).show();
            }

            function formatDate(dateStr) {
                let date = new Date(dateStr);
                let day = ("0" + date.getDate()).slice(-2);
                let month = ("0" + (date.getMonth() + 1)).slice(-2);
                let year = date.getFullYear();
                return day + "/" + month + "/" + year;
            }

            function formatDate2(dateStr) {
    let date = new Date(dateStr);
    let year = date.getFullYear();
    let month = ("0" + (date.getMonth() + 1)).slice(-2);
    let day = ("0" + date.getDate()).slice(-2);
    return year + "-" + month + "-" + day;
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
