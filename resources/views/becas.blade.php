<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parroquia SMP</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">

    @vite(['resources/sass/app.scss','resources/js/app.js'])

    @extends('adminlte::page')

    @section('title', 'Parroquia SMP')

    @section('plugins.Datatables', true)

    @section('content_header')
        
    @stop

    <style>

</style>

    @section('content')
        <div class="container mt-4">
            <div class="d-flex justify-content-between mb-3 align-items-center">
                <!-- Título -->
                <div class="col text-center">
                <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 65px; text-shadow: 2px 2px rgba(48, 201, 176, 0.8); letter-spacing: 1px;">
    Registro de Becados
</h1>

                </div>
                <!-- Botón Nuevo -->
                <div class="col-auto">
                <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 19; // Ajusta esto según tu lógica el id del objeto
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
    <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white; border: 2px solid white; box-shadow: 0 0 10px rgba(255, 255, 255, 0.5);" data-bs-toggle="modal" data-bs-target="#nuevaBecaModal">
        <i class="fas fa-plus"></i> Nuevo Registro
    </button>
    @endif
</div>

            </div>

            <!-- Tabla de Becas -->
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
            <table id="becasTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th style="background-color: #48C9B0; color: black; text-align: center;">Código</th>
                       
                        <th style="background-color: #48C9B0; color: black; text-align: center;">Estado</th>
                        <th style="background-color: #48C9B0; color: black; text-align: center;">Nombre Completo</th>
                        <th style="background-color: #48C9B0; color: black; text-align: center;">DNI Persona</th>
                        <th style="background-color: #48C9B0; color: black; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($becas as $beca)
                    <tr style="text-align: center;">
                        <td>{{ $beca->COD_BECA }}</td>
                       
                        <td>{{ $beca->ESTADO }}</td>
                        <td>{{ $beca->NOMBRE_COMPLETO }}</td>
                        <td>{{ $beca->DNI_PERSONA }}</td>
                        <td>
                            <!-- Botones de Acciones -->
                            <a href="#" class="btn btn-info btn-sm" onclick="mostrarDetalles(
                                '{{ $beca->COD_BECA }}',
                                '{{ $beca->COD_PERSONAS }}',
                                '{{ $beca->CARRERA }}',
                                '{{ $beca->DURACION }}',
                                '{{ $beca->AYUDA }}',
                                '{{ $beca->HORAS_TRABAJO_PASTORAL }}',
                                '{{ $beca->REGISTRO_AVANCE }}',
                                '{{ $beca->ESTADO }}',
                                '{{ $beca->FECHA_INICIO }}',
                                '{{ $beca->FECHA_FIN }}',
                                '{{ $beca->OBSERVACIONES }}',
                                '{{ $beca->NOMBRE_COMPLETO }}',
                                '{{ $beca->DNI_PERSONA }}'
                            )" title="Ver Detalles">
                                <i class="fas fa-info-circle"></i> Detalles
                            </a>
                            <!-- Botón Modificar -->
   @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                            <a href="#" class="btn btn-warning btn-sm" onclick="mostrarModificar(
    '{{ $beca->COD_BECA }}',
    '{{ $beca->COD_PERSONAS }}',
    '{{ $beca->CARRERA }}',
    '{{ $beca->DURACION }}',
    '{{ $beca->AYUDA }}',
    '{{ $beca->HORAS_TRABAJO_PASTORAL }}',
    '{{ $beca->REGISTRO_AVANCE }}',
    '{{ $beca->ESTADO }}',
    '{{ \Carbon\Carbon::parse($beca->FECHA_INICIO)->format('Y-m-d') }}',
    '{{ \Carbon\Carbon::parse($beca->FECHA_FIN)->format('Y-m-d') }}',
    '{{ $beca->OBSERVACIONES }}',
    '{{ $beca->NOMBRE_COMPLETO }}',
    '{{ $beca->DNI_PERSONA }}'
)" title="Modificar">
    <i class="fas fa-edit"></i> Modificar
</a>
@endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
            <!-- Modal Nueva Beca -->
            <div class="modal fade" id="nuevaBecaModal" tabindex="-1" aria-labelledby="nuevaBecaModalLabel" aria-hidden="true">
    <div class="modal-dialog" style="max-width: 70%;">
    <div class="modal-content"
     style="
         border: 4px solid #48C9B0; /* Borde grueso con el color deseado */
         box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); /* Reflexión blanca */
     ">
            <div class="modal-header ">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="nuevaBecaModalLabel">
                    <i class="fas fa-plus me-2"></i>
                    REGISTRO NUEVO DE BECA
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form class="row g-3 needs-validation" id="nuevaBecaForm" novalidate method="POST" action="{{ url('/insertarBeca') }}">
                    @csrf

                    <div class="col-md-3">
                        <label for="COD_PERSONAS" class="form-label">Código de Persona</label>
                        <input type="text" class="form-control" id="COD_PERSONAS" name="COD_PERSONAS" 
                               required oninput="this.value = this.value.replace(/[^0-9]/g, '');" 
                               onpaste="return false;">
                        <div class="invalid-feedback">
                           +
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="NOMBRE_PERSONA" class="form-label">Nombre de Persona</label>
                        <input type="text" class="form-control" id="NOMBRE_PERSONA" name="NOMBRE_PERSONA" 
                               required oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                               onpaste="return false;">
                        <div class="invalid-feedback">
                            Por favor Seleccione una  persona.
                        </div>
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
    <a href="#" class="btn btn-success btn-sm d-flex align-items-center" id="btnMostrarModal1" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; line-height: 1; width: 100%; display: flex; justify-content: center; align-items: center; height: 2.5rem;">
        <i class="fas fa-user me-1" style="font-size: 1rem;"></i>
        <span style="font-size: 0.7rem;">Seleccionar Persona</span>
    </a>
</div>

                    <div class="col-md-4">
                        <label for="CARRERA" class="form-label">Carrera</label>
                        <input type="text" class="form-control" id="CARRERA" name="CARRERA" 
                               placeholder="Ingrese la carrera" required maxlength="100" 
                               oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                               onpaste="return false;">
                        <div class="invalid-feedback">
                            Por favor ingrese la carrera.
                        </div>
                    </div>
                    <div class="col-md-4">
    <label for="DURACION" class="form-label">Duración años</label>
    <select class="form-select" id="DURACION" name="DURACION" required>
        <option value="" disabled selected>Seleccione una duración</option>
        <option value="1">1 año</option>
        <option value="2">2 años</option>
        <option value="3">3 años</option>
        <option value="4">4 años</option>
        <option value="5">5 años</option>
        <option value="6">6 años</option>
        <option value="7">7 años</option>
        <option value="8">8 años</option>
    </select>
    <div class="invalid-feedback">
        Por favor seleccione una duración.
    </div>
</div>

                    <div class="col-md-4">
                    <label for="AYUDA" class="form-label">Tipo Ayuda</label>
<select class="form-control" id="AYUDA" name="AYUDA" required>
<option value="" disabled selected>Seleccione Tipo Ayuda</option>

    <option value="Económica">Económica</option>
    <option value="Material">Material</option>
    <option value="Otra">Otra</option>
</select>
<div class="invalid-feedback">
    Por favor seleccione un tipo de ayuda.
</div>
                    </div>
                    <div class="col-md-4">
                        <label for="HORAS_TRABAJO_PASTORAL" class="form-label">Horas de Trabajo Pastoral</label>
                        <input type="number" class="form-control" id="HORAS_TRABAJO_PASTORAL" 
                               name="HORAS_TRABAJO_PASTORAL" placeholder="Ingrese las horas de trabajo pastoral" 
                               required min="0" oninput="limitDigits(this, 10); this.value = this.value.replace(/[^0-9]/g, '');" 
                               onpaste="return false;">
                        <div class="invalid-feedback">
                            Por favor ingrese un número válido de horas de trabajo pastoral.
                        </div>
                    </div>
                    <div class="col-md-8">
                        <label for="REGISTRO_AVANCE" class="form-label">Registro de Avance</label>
                        <input type="text" class="form-control" id="REGISTRO_AVANCE" name="REGISTRO_AVANCE" 
                               placeholder="Ingrese el registro de avance" maxlength="100" 
                               oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                               onpaste="return false;">
                        <div class="invalid-feedback">
                            Por favor ingrese el registro de avance.
                        </div>
                    </div>
                    <div class="col-md-4">
                    <label for="ESTADO" class="form-label">Estado</label>
<select class="form-control" id="ESTADO" name="ESTADO" required>
<option value="" disabled selected>Seleccione el Estado</option>

    <option value="Activa">Activa</option>
    <option value="Completada">Completada</option>
    <option value="Cancelada">Cancelada</option>
</select>
<div class="invalid-feedback">
    Por favor seleccione un estado.
</div>
                    </div>
                    <div class="col-md-4">
                        <label for="FECHA_INICIO" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="FECHA_INICIO" name="FECHA_INICIO" required>
                        <div class="invalid-feedback">
                            Por favor ingrese la fecha de inicio.
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="FECHA_FIN" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="FECHA_FIN" name="FECHA_FIN" required>
                        <div class="invalid-feedback">
                            Por favor ingrese la fecha de fin.
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="OBSERVACIONES" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="OBSERVACIONES" name="OBSERVACIONES" rows="3" 
                                  placeholder="Ingrese observaciones" maxlength="500" 
                                  oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                                  onpaste="return false;"></textarea>
                    </div>
                    <div class="col-12 text-center">
    <button type="submit" class="btn btn-success btn-lg">Guardar</button>
    <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Cancelar</button>
</div>

                </form>
            </div>
        </div>
    </div>
</div>



            <!-- Modal Detalle -->
            <div class="modal fade" id="detalleBecaModal" tabindex="-1" aria-labelledby="detalleBecaModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content"
     style="
         border: 4px solid #48C9B0; /* Borde grueso con el color deseado */
         box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); /* Reflexión blanca */
     ">
            <div class="modal-header ">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="detalleBecaModalLabel">
                    <i class="fas fa-info-circle me-2"></i>
                    DETALLE REGISTRO DE BECA
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            
            </div>
            <div class="modal-body">
                <table class="table" style="border-collapse: collapse; border: none;">
                    <tbody>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Código</th>
                            <td id="detalleCodigo" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Código Persona</th>
                            <td id="detalleCodigoPersona" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Carrera</th>
                            <td id="detalleCarrera" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Duración</th>
                            <td id="detalleDuracion" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Ayuda</th>
                            <td id="detalleAyuda" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Horas de Trabajo Pastoral</th>
                            <td id="detalleHorasTrabajoPastoral" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Registro Avance</th>
                            <td id="detalleRegistroAvance" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Estado</th>
                            <td id="detalleEstado" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Fecha de Inicio</th>
                            <td id="detalleFechaInicio" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Fecha de Fin</th>
                            <td id="detalleFechaFin" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Observaciones</th>
                            <td id="detalleObservaciones" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">Nombre Completo</th>
                            <td id="detalleNombreCompleto" style="border: none; padding: 4px;"></td>
                        </tr>
                        <tr style="border: none;">
                            <th scope="row" style="border: none; padding: 4px;">DNI Persona</th>
                            <td id="detalleDniPersona" style="border: none; padding: 4px;"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>



            <!-- Modal Modificar -->
            <div class="modal fade" id="modificarBecaModal" tabindex="-1" aria-labelledby="modificarBecaModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
            <div class="modal-content"
     style="
         border: 4px solid #48C9B0; /* Borde grueso con el color deseado */
         box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); /* Reflexión blanca */
     ">
            <div class="modal-header"
    
        
     >
                <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarBecaModalLabel">
                    <i class="fas fa-edit me-2"></i>
                    MODIFICAR REGISTRO BECA
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form class="row g-3 needs-validation" id="modificarBecaForm" novalidate method="POST" action="{{ route('updateBeca', ['id' => $beca->COD_BECA]) }}">
    @csrf
    @method('PUT')


                    <div class="col-md-3">
                        <label for="modificarNombreBeca" class="form-label">Codigo Beca</label>
                        <input class="form-control" type="text" id="modificarCodigoBeca" style="pointer-events: none; "  name="p_cod_beca">

                        <div class="invalid-feedback">
                            Por favor ingrese el nombre de la beca.
                        </div>
                    </div>


                    <div class="col-md-3">
    <label for="modificarCodigoPersona" class="form-label">Código Persona</label>
    <input class="form-control" type="text" id="modificarCodigoPersona" style="pointer-events: none; "  name="p_cod_Persona">
    <div class="invalid-feedback">
        Por favor ingrese el código de la persona.
    </div>
</div>


                   

                    <div class="col-md-6">
                        <label for="modificarNombreBeca" class="form-label">Nombre de la Persona</label>
                        <input type="text" class="form-control" id="modificarNombreBeca" name="NOMBRE_BECA" style="pointer-events: none; "  required maxlength="100"
                               onpaste="return false;" oncopy="return false;" oncut="return false;" 
                               onkeypress="return /[a-zA-Z\s]/i.test(event.key)">
                        <div class="invalid-feedback">
                            Por favor ingrese el nombre de la beca.
                        </div>
                    </div>

                    

                    <div class="col-md-4">
                        <label for="modificarFechaInicio" class="form-label">Fecha de Inicio</label>
                        <input type="date" class="form-control" id="modificarFechaInicio" name="p_fecha_inicio" required>
                        <div class="invalid-feedback">
                            Por favor ingrese la fecha de inicio.
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="modificarFechaFin" class="form-label">Fecha de Fin</label>
                        <input type="date" class="form-control" id="modificarFechaFin" name="p_fecha_fin" required>
                        <div class="invalid-feedback">
                            Por favor ingrese la fecha de fin.
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="modificarCarrera" class="form-label">Carrera</label>
                        <input type="text" class="form-control" id="modificarCarrera" name="CARRERA" placeholder="Ingrese la carrera" required maxlength="100" 
                               oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                               onpaste="return false;">
                        <div class="invalid-feedback">
                            Por favor ingrese la carrera.
                        </div>
                    </div>

                    <div class="col-md-4">
    <label for="modificarDuracion" class="form-label">Duración años</label>
    <select class="form-control" id="modificarDuracion" name="DURACION" required>
        <option value="" disabled selected>Seleccione la duración</option>
        @for ($i = 1; $i <= 8; $i++)
            <option value="{{ $i }}">{{ $i }}</option>
        @endfor
    </select>
    <div class="invalid-feedback">
        Por favor seleccione la duración.
    </div>
</div>


                    <div class="col-md-4">
                        <label for="modificarAyuda" class="form-label">Ayuda</label>
                        <select class="form-control" id="modificarAyuda" name="p_ayuda" required>
                        <option value="" disabled selected>Seleccione una ayuda</option>
                          
                            <option value="Económica">Económica</option>
                            <option value="Material">Material</option>
                            <option value="Otra">Otra</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un tipo de ayuda.
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label for="modificarHorasTrabajoPastoral" class="form-label">Horas de Trabajo Pastoral</label>
                        <input type="number" class="form-control" id="modificarHorasTrabajoPastoral" name="HORAS_TRABAJO_PASTORAL" placeholder="Ingrese las horas de trabajo pastoral" required min="0" 
                               oninput="limitDigits(this, 10); this.value = this.value.replace(/[^0-9]/g, '');" 
                               onpaste="return false;">
                        <div class="invalid-feedback">
                            Por favor ingrese las horas de trabajo pastoral.
                        </div>
                    </div>

                    <div class="col-md-8">
                        <label for="modificarRegistroAvance" class="form-label">Registro de Avance</label>
                        <input type="text" class="form-control" id="modificarRegistroAvance" name="REGISTRO_AVANCE" placeholder="Ingrese el registro de avance" maxlength="100" 
                               oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                               onpaste="return false;">
                    </div>

                    <div class="col-md-4">
                        <label for="modificarEstado" class="form-label">Estado</label>
                        <select class="form-control" id="modificarEstado" name="p_estado" required>
                        <option value="" disabled selected>Seleccione un estado</option>
                            
                            <option value="Activa">Activa</option>
                            <option value="Completada">Completada</option>
                            <option value="Cancelada">Cancelada</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un estado.
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="modificarObservaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="modificarObservaciones" name="OBSERVACIONES" rows="3" placeholder="Ingrese observaciones" maxlength="500" 
                                  oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '');" 
                                  onpaste="return false;"></textarea>
                    </div>

                    <div class="col-12 text-center">
    <button type="submit" class="btn btn-success btn-lg">Guardar Cambios</button>
    <button type="button" class="btn btn-danger btn-lg" data-bs-dismiss="modal">Cancelar</button>
</div>


                </form>
            </div>
        </div>
    </div>
</div>



        <!-- Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>
        <!-- SweetAlert JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
       

        <script>
    $(document).ready(function() {
        var table = $('#becasTable').DataTable({
            "language": {
                "sProcessing": "Procesando...",
                "sLengthMenu": "Mostrar _MENU_ registros",
                "sZeroRecords": "No se encontraron resultados",
                "sEmptyTable": "Ningún dato disponible en esta tabla",
                "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
                "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
                "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
                "sSearch": "Buscar:",
                "sUrl": "",
                "sInfoThousands": ",",
                "sLoadingRecords": "Cargando...",
                "oPaginate": {
                    "sFirst": "Primero",
                    "sLast": "Último",
                    "sNext": "Siguiente",
                    "sPrevious": "Anterior"
                },
                "oAria": {
                    "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                    "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                }
            }
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

        <script>
            $(document).ready(function () {
                $('#becasTable').DataTable();

                window.mostrarDetalles = function (codigo, codigoPersona, carrera, duracion, ayuda, horasTrabajoPastoral, registroAvance, estado, fechaInicio, fechaFin, observaciones, nombreCompleto, dniPersona) {
    // Formatear las fechas para mostrar solo la fecha sin la hora
    const opcionesFecha = { year: 'numeric', month: '2-digit', day: '2-digit' };
    const fechaInicioFormateada = new Date(fechaInicio).toLocaleDateString('es-ES', opcionesFecha);
    const fechaFinFormateada = new Date(fechaFin).toLocaleDateString('es-ES', opcionesFecha);
    
    $('#detalleCodigo').text(codigo);
    $('#detalleCodigoPersona').text(codigoPersona);
    $('#detalleCarrera').text(carrera);
    $('#detalleDuracion').text(duracion);
    $('#detalleAyuda').text(ayuda);
    $('#detalleHorasTrabajoPastoral').text(horasTrabajoPastoral);
    $('#detalleRegistroAvance').text(registroAvance);
    $('#detalleEstado').text(estado);
    $('#detalleFechaInicio').text(fechaInicioFormateada);
    $('#detalleFechaFin').text(fechaFinFormateada);
    $('#detalleObservaciones').text(observaciones);
    $('#detalleNombreCompleto').text(nombreCompleto);
    $('#detalleDniPersona').text(dniPersona);
    $('#detalleBecaModal').modal('show');
};


                // Mostrar modal de modificar con datos
                window.mostrarModificar = function (codigo, codigoPersona, carrera, duracion, ayuda, horasTrabajoPastoral, registroAvance, estado, fechaInicio, fechaFin, observaciones, nombreCompleto, dniPersona) {
    $('#modificarCodigoBeca').val(codigo);
    $('#modificarCodigoPersona').val(codigoPersona);
    $('#modificarNombreBeca').val(nombreCompleto); // Ajuste según el campo que deseas mostrar
    $('#modificarMontoBeca').val(ayuda);
    $('#modificarCarrera').val(carrera);
    $('#modificarDuracion').val(duracion);
    $('#modificarAyuda').val(ayuda);
    $('#modificarHorasTrabajoPastoral').val(horasTrabajoPastoral);
    $('#modificarRegistroAvance').val(registroAvance);
    $('#modificarEstado').val(estado);
    $('#modificarFechaInicio').val(fechaInicio);
    $('#modificarFechaFin').val(fechaFin);
    $('#modificarObservaciones').val(observaciones);
    $('#modificarBecaModal').modal('show');
};





            });
            
            // Función para limitar dígitos del monto
            function limitDigits(input, maxDigits) {
                const value = input.value;
                if (value.length > maxDigits) {
                    input.value = value.slice(0, maxDigits);
                }
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
                    "pageLength": 3, // Mostrar 3 registros por página
                    "info": false, // Deshabilitar información de cantidad de registros
                    "language": { // Configuración de idioma
                        "search": "Buscar por DNI:",
                        "paginate": {
                            "previous": "Anterior",
                            "next": "Siguiente"
                        },
                        "zeroRecords": "No se encontraron registros",
                        "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                        "emptyTable": "No hay datos disponibles en la tabla",
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "infoFiltered": "(filtrado de _MAX_ registros totales)"
                    },
                    "ajax": {
                        "url": "{{ route('personas.obtener') }}",
                        "type": "GET",
                        "dataSrc": "data", // Ajusta esto según la estructura de tu respuesta del servidor
                        
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

                // Ajustar el tamaño del campo de búsqueda
                $('#tablaResultados_filter input').attr('style', 'width: 120px; height: 30px; font-size: 0.8em;');

                $('#tablaResultados').css('font-size', '0.8em');

                $('#tablaResultados').on('click', '.btnCopiarParroco', function() {
                    var codigoPersona = $(this).data('codigo');
                    var nombrePersona = $(this).closest('tr').find('td:nth-child(3)').text(); // Obtener el nombre desde la columna correspondiente
                    var dniPersona = $(this).closest('tr').find('td:nth-child(4)').text(); // Obtener el DNI desde la columna correspondiente

                    $('#COD_PERSONAS').val(codigoPersona);
                    $('#NOMBRE_PERSONA').val(nombrePersona);
                    

                    $('#resultadosModal').modal('hide');
                });
            }
        }); 
        </script>



    @stop
</body>
</html>
