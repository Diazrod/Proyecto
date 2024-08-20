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
    <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 65px; text-shadow: 2px 2px rgba(72, 201, 176, 0.8); letter-spacing: 1px;">
    Inventario de Bienes
</h1>


    </div>
    <!-- Botón Nuevo -->
    <div class="col-auto">
    <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 23; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
    <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white; border: none; padding: 10px 20px; font-size: 18px;" data-bs-toggle="modal" data-bs-target="#nuevoBienModal">
        <i class="fas fa-plus"></i> Nuevo Registro
    </button>
    @endif
</div>

</div>



            <!-- Tabla de Bienes -->
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
            <table id="bienesTable" class="table table-striped table-bordered">
    <thead>
        <tr>
            <th style="background-color:#48C9B0; color: black; text-align: center;">Código</th>
            <th style="background-color: #48C9B0; color: black; text-align: center;">Tipo</th>
            <th style="background-color: #48C9B0; color: black; text-align: center;">Descripcion</th>
            <th style="background-color:#48C9B0; color: black; text-align: center;">Estado</th>
            <th style="background-color: #48C9B0; color: black; text-align: center;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($bienes as $bien)
        <tr style="text-align: center;">
            <td  style=" text-align: center">{{ $bien->COD_BIEN }}</td>
            <td>{{ $bien->TIP_BIEN }}</td>
            <td>{{ $bien->DES_OBJETO }}</td>
            <td>{{ $bien->EST_OBJETO }}</td>
            <td>
                <!-- Botones de Acciones -->
                <a href="#" class="btn btn-info btn-sm" onclick="mostrarDetalles(
                    '{{ $bien->COD_BIEN }}',
                    '{{ $bien->TIP_BIEN }}',
                    '{{ $bien->DES_OBJETO }}',
                    '{{ $bien->CANT_BIEN }}',
                    '{{ $bien->COSTO_ADQUISICION }}',
                    '{{ \Carbon\Carbon::parse($bien->FECH_ADQUISICION)->format('Y-m-d') }}',
                    
                    '{{ $bien->EST_OBJETO }}',
                    '{{ $bien->OBSERVACIONES }}'
                )" title="Ver Detalles">
                    <i class="fas fa-info-circle"></i> Detalles
                </a>

                <!-- Botón Modificar -->
                @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                <a href="#" class="btn btn-warning btn-sm" onclick="mostrarModificar(
                    '{{ $bien->COD_BIEN }}',
                    '{{ $bien->TIP_BIEN }}',
                    '{{ $bien->DES_OBJETO }}',
                    '{{ $bien->CANT_BIEN }}',
                    '{{ $bien->COSTO_ADQUISICION }}',
                    '{{ $bien->FECH_ADQUISICION }}',
                    '{{ $bien->EST_OBJETO }}',
                    '{{ $bien->OBSERVACIONES }}'
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

        <!-- Modal Nuevo Bien -->

        <div class="modal fade" id="nuevoBienModal" tabindex="-1" aria-labelledby="nuevoBienModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 1px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarModalLabel">
                    <!-- Ícono -->
                    <i class="fas fa-edit me-2"></i>
                    REGISTRO NUEVO DE BIENES
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="nuevoBienForm" novalidate method="POST" action="{{ url('/insertarBien') }}">
                    @csrf
                    <div class="col-md-6">
                        <label for="TIP_BIEN" class="form-label">Tipo</label>
                        <select class="form-select" id="TIP_BIEN" name="TIP_BIEN" required style="border-color: #48C9B0;">
                            <option selected disabled value="">Seleccione un tipo</option>
                            <option value="VEHICULO">VEHICULO</option>
                            <option value="MOBILIARIO">MOBILIARIO</option>
                            <option value="MATERIAL">MATERIAL</option>
                            <option value="ALIMENTOS">ALIMENTO</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un tipo de bien.
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label for="DES_OBJETO" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="DES_OBJETO" name="DES_OBJETO" placeholder="Ingrese una breve descripción del bien" required pattern="[a-zA-Z0-9 ]*" maxlength="100" style="border-color: #48C9B0;">
                        <div class="invalid-feedback">
                            Por favor ingrese una descripción del bien.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="CANT_BIEN" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="CANT_BIEN" name="CANT_BIEN" placeholder="Ingrese la cantidad" required min="0" oninput="limitDigits(this, 10)" style="border-color: #48C9B0;">
                        <div class="invalid-feedback">
                        Por favor ingrese una Cantidad del bien.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="COSTO_ADQUISICION" class="form-label">Costo</label>
                        <input type="number" class="form-control" id="COSTO_ADQUISICION" name="COSTO_ADQUISICION" placeholder="Ingrese el costo de adquisición" required min="0" oninput="limitDigits(this, 10)" style="border-color: #48C9B0;">
                        <div class="invalid-feedback">
                            Por favor ingrese un costo válido con hasta 10 dígitos.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="FECH_ADQUISICION" class="form-label">Fecha de Adquisición</label>
                        <input type="date" class="form-control" id="FECH_ADQUISICION" name="FECH_ADQUISICION" required style="border-color: #48C9B0;">
                        <div class="invalid-feedback">
                            Por favor ingrese la fecha de adquisición.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="EST_OBJETO" class="form-label">Estado</label>
                        <select class="form-select" id="EST_OBJETO" name="EST_OBJETO" required style="border-color: #48C9B0;">
                            <option selected disabled value="">Seleccione un estado</option>
                            <option value="BUENO">BUENO</option>
                            <option value="REGULAR">REGULAR</option>
                            <option value="MALO">MALO</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un estado.
                        </div>
                    </div>
                    <div class="col-12">
                        <label for="OBSERVACIONES" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="OBSERVACIONES" name="OBSERVACIONES" rows="3" value="" placeholder="Ingrese observaciones adicionales"  maxlength="100" style="border-color: #48C9B0;"></textarea>
                        <div class="invalid-feedback">
                            Por INGRESE LAS OBSERVACIONES 
                        </div>
                    </div>
                    <br>
                    <div class="col-12 text-center">
                        <!-- Botón Guardar -->
                        <button class="btn btn-success text-white" type="submit">
                            <i class="fas fa-save me-2"></i> Guardar
                        </button>
                        <!-- Botón Cancelar -->
                        <button class="btn btn-danger text-white ms-2" type="button" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i> Cancelar
                        </button>
                    </div>
                    <br>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Scripts para validación -->


<!-- CSS para los bordes -->

         <!-- Modal para Detalles -->
         <div class="modal fade" id="detallesModal" tabindex="-1" aria-labelledby="detallesModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content" style="border: 1px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
   <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarModalLabel">
       <!-- Ícono -->
       <i class="fas fa-file-alt me-2"></i> <span class="text-gold">DETALLES DE REGISTRO DE BIENES</span>
         
   </h5>
   <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> 
   

</div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tbody>
                        <tr>
                            <th scope="row">CODIGO REGISTRO</th>
                            <td id="detalleCodBien"></td>
                        </tr>
                        <tr>
                            <th scope="row">TIPO</th>
                            <td id="detalleTipBien"></td>
                        </tr>
                        <tr>
                            <th scope="row">DESCRIPCION</th>
                            <td id="detalleDesObjeto"></td>
                        </tr>
                        <tr>
                            <th scope="row">CANTIDAD</th>
                            <td id="detalleCantBien"></td>
                        </tr>
                        <tr>
                            <th scope="row">COSTO ADQUISICION</th>
                            <td id="detalleCostoAdquisicion"></td>
                        </tr>
                        <tr>
                            <th scope="row">FECHA ADQUISICION</th>
                            <td id="detalleFechAdquisicion"></td>
                        </tr>
                        <tr>
                            <th scope="row">ESTADO</th>
                            <td id="detalleEstObjeto"></td>
                        </tr>
                        <tr>
                            <th scope="row">OBSERVACIONES</th>
                            <td id="detalleObservaciones"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<!-- Agregar CSS para el color dorado -->
<style>
   
    .btn-danger {
        background-color: #dc3545; /* Color rojo */
        border-color: #dc3545;
    }
    .btn-danger:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }
    .table-borderless td, .table-borderless th {
        border: none;
    }
</style>


   <!-- Modal para Modificar -->
<div class="modal fade" id="modificarModal" tabindex="-1" aria-labelledby="modificarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border: 1px solid #48C9B0;">
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarModalLabel">
                    <!-- Ícono -->
                    <i class="fas fa-edit me-2"></i>
                    MODIFICAR REGISTRO DE BIENES

                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="modificarForm" method="POST" action="{{ route('updateBien', ['id' => $bien->COD_BIEN]) }}" class="row g-3 needs-validation" novalidate>
                    @csrf
                    @method('PUT')
                    <!-- Fila para Código y Tipo -->
                    <div class="row g-3">
                        <!-- Campo para el código del bien -->
                        <div class="col-md-6">
                            <label for="modificarCodBien" class="form-label">Código</label>
                            <input type="text" class="form-control" id="modificarCodBien" name="modificarCodBien" placeholder="Ingrese el código del bien" style="pointer-events: none; border-color: #48C9B0;" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el código del bien.
                            </div>
                        </div>

                        <!-- Campo para el tipo de bien -->
                        <div class="col-md-6">
                            <label for="modificarTipBien" class="form-label">Tipo</label>
                            <select class="form-select" id="modificarTipBien" name="modificarTipBien" required style="border-color: #48C9B0;">
                                <option value="VEHICULO">VEHICULO</option>
                                <option value="MOBILIARIO">MOBILIARIO</option>
                                <option value="MATERIAL">MATERIAL</option>
                                <option value="ALIMENTOS">ALIMENTO</option>
                                <!-- Agrega más opciones según sea necesario -->
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione un tipo de bien.
                            </div>
                        </div>
                    </div>

                    <!-- Campo para la descripción del bien -->
                    <div class="col-md-12">
                        <label for="modificarDesObjeto" class="form-label">Descripción</label>
                        <input type="text" class="form-control" id="modificarDesObjeto" name="modificarDesObjeto" placeholder="Ingrese una breve descripción del bien" pattern="[a-zA-Z0-9\s]*" maxlength="100" required style="border-color: #48C9B0;">
                        <div class="invalid-feedback">
                            Por favor ingrese una descripción del bien sin caracteres especiales.
                        </div>
                    </div>

                    <!-- Campo para la cantidad -->
                    <div class="col-md-6">
                        <label for="modificarCantBien" class="form-label">Cantidad</label>
                        <input type="number" class="form-control" id="modificarCantBien"  name="modificarCantBien" placeholder="Ingrese la cantidad" required oninput="limitDigits(this, 10)" min="0" style="border-color: #48C9B0;">
                        <div class="invalid-feedback">
                            Por favor ingrese la cantidad.
                        </div>
                    </div>

                    <!-- Campo para el costo de adquisición -->
                    <div class="col-md-6">
                        <label for="modificarCostoAdquisicion" class="form-label">Costo</label>
                        <input type="number" class="form-control" id="modificarCostoAdquisicion" name="modificarCostoAdquisicion" placeholder="Ingrese el costo de adquisición" required oninput="limitDigits(this, 10)" min="0" style="border-color: #48C9B0;">
                        <div class="invalid-feedback">
                            Por favor ingrese el costo de adquisición.
                        </div>
                    </div>

                    <!-- Campo para la fecha de adquisición -->
                    <div class="col-md-6">
                        <label for="modificarFechAdquisicion" class="form-label">Fecha de Adquisición</label>
                        <input type="date" class="form-control" id="modificarFechAdquisicion" name="modificarFechAdquisicion" required style="border-color: #48C9B0;">
                        <div class="invalid-feedback">
                            Por favor ingrese la fecha de adquisición.
                        </div>
                    </div>

                    <!-- Campo para el estado del objeto -->
                    <div class="col-md-6">
                        <label for="modificarEstObjeto" class="form-label">Estado</label>
                        <select class="form-select" id="modificarEstObjeto" name="modificarEstObjeto" required style="border-color: #48C9B0;">
                            <option selected disabled value="">Seleccione un estado</option>
                            <option value="BUENO">BUENO</option>
                            <option value="REGULAR">REGULAR</option>
                            <option value="MALO">MALO</option>
                        </select>
                        <div class="invalid-feedback">
                            Por favor seleccione un estado.
                        </div>
                    </div>

                    <!-- Campo para las observaciones -->
                    <div class="col-12">
                        <label for="modificarObservaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="modificarObservaciones" name="modificarObservaciones" rows="3" vakue="" maxlength="100" placeholder="Ingrese observaciones sin caracteres especiales" pattern="[a-zA-Z0-9\s]*" style="border-color: #48C9B0;"></textarea>
                        <div class="invalid-feedback">
                            Por favor ingrese las observaciones sin caracteres especiales.
                        </div>
                    </div>

                    <script>
                        function limitDigits(input, maxDigits) {
                            // Convertir el valor del input en un número entero
                            let value = input.value;
                            // Convertir a string y limitar a maxDigits caracteres
                            if (value.length > maxDigits) {
                                input.value = value.slice(0, maxDigits);
                            }
                        }
                    </script>

                    <div class="col-12">
                        <div class="d-flex justify-content-end">
                            <!-- Botón Guardar -->
                            <button class="btn btn-success text-white me-2" type="submit">
                                <i class="fas fa-save me-2"></i> Guardar Cambios
                            </button>

                            <!-- Botón Cancelar -->
                            <button class="btn btn-danger text-white" type="button" data-bs-dismiss="modal">
                                <i class="fas fa-times me-2"></i> Cancelar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>

    @stop

    @section('css')
        <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
        {{-- Add here extra stylesheets --}}
        {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}





        <style>
    .border-success {
        border-color: #28a745 !important; /* Verde */
    }
    .border-danger {
        border-color: #dc3545 !important; /* Rojo */
    }

    .form-control,
.form-select {
    border: 2px solid #FFD700; /* Color oro para el borde */
    border-radius: .375rem; /* Bordes redondeados */
    width: 100%; /* Ocupa el 100% del ancho del contenedor */
    padding: .375rem .75rem; /* Ajusta el padding interno para un diseño uniforme */
    box-sizing: border-box; /* Asegura que el padding y el borde se incluyan en el ancho total */
}

.bg-48C9B0 {
    background-color: #48C9B0 !important;
}
.border-48C9B0 {
    border-color: #48C9B0 !important;
}

</style>












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
document.getElementById('modificarDesObjeto').addEventListener('input', function(e) {
    // Permitir letras, números, comas y espacios
    this.value = this.value.replace(/[^A-Za-zñÑ, \s]/g, '');
});

document.getElementById('DES_OBJETO').addEventListener('input', function(e) {
    // Permitir letras, comas y espacios
    this.value = this.value.replace(/[^A-Za-zñÑ, \s]/g, '');
});


</script>

   

<script>
    function limitDigits(input, maxDigits) {
        const value = input.value;
        // Limitar la entrada a maxDigits dígitos
        if (value.length > maxDigits) {
            input.value = value.slice(0, maxDigits);
        }
    }
</script>

<script>
$(document).ready(function() {
    $('#bienesTable').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "pageLength": 10, // Mostrar 10 registros por página
        "language": {
            "search": "Buscar:", // Cambia el texto de "Search:" a "Buscar:"
        }
    });
});

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
        function mostrarDetalles(codBien, tipBien, desObjeto, cantBien, costoAdquisicion, fechAdquisicion, estObjeto, observaciones) {
            document.getElementById('detalleCodBien').innerText = codBien;
            document.getElementById('detalleTipBien').innerText = tipBien;
            document.getElementById('detalleDesObjeto').innerText = desObjeto;
            document.getElementById('detalleCantBien').innerText = cantBien;
            document.getElementById('detalleCostoAdquisicion').innerText = costoAdquisicion;
            document.getElementById('detalleFechAdquisicion').innerText = fechAdquisicion;
            document.getElementById('detalleEstObjeto').innerText = estObjeto;
            document.getElementById('detalleObservaciones').innerText = observaciones;

            var detallesModal = new bootstrap.Modal(document.getElementById('detallesModal'));
            detallesModal.show();
        }

        function mostrarModificar(codBien, tipBien, desObjeto, cantBien, costoAdquisicion, fechAdquisicion, estObjeto, observaciones) {
          
            var fechaSolo = fechAdquisicion.split('T')[0];

          
            document.getElementById('modificarCodBien').value = codBien;
            document.getElementById('modificarTipBien').value = tipBien;
            document.getElementById('modificarDesObjeto').value = desObjeto;
            document.getElementById('modificarCantBien').value = cantBien;
            document.getElementById('modificarCostoAdquisicion').value = costoAdquisicion;
            document.getElementById('modificarFechAdquisicion').value = fechaSolo;
            document.getElementById('modificarEstObjeto').value = estObjeto;
            document.getElementById('modificarObservaciones').value = observaciones;

            var modificarModal = new bootstrap.Modal(document.getElementById('modificarModal'));
            modificarModal.show();
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






