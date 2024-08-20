<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registros de Comunidades</title>
    <link rel="icon" href="{{ asset('vendor/adminlte/dist/img/iglesia.png') }}" type="image/x-icon">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    
    <style>
    .table.no-borders {
        border-collapse: collapse; /* Asegura que no haya espaciado entre celdas */
    }

    .table.no-borders th, .table.no-borders td {
        border: none; /* Elimina los bordes de las celdas */
        padding: 0; /* Elimina el espaciado dentro de las celdas */
    }

    .table.no-borders th {
        text-align: left; /* Alinea el texto a la izquierda en los encabezados */
    }
</style>

@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content_header')
@stop
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
                <!-- Título -->
                <div class="col text-center">
                    <h1 class="fw-bold" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 60px; text-shadow: 2px 2px rgba(72, 201, 176, 0.8); letter-spacing: 1px;">
                        Registros de Comunidades
                    </h1>
                </div>
                <!-- Botón Nuevo -->
                <div class="col-auto">
                <?php
            session_start();
            $permisos = $_SESSION['user_permisos'] ?? [];
            $objetos = 14; // Ajusta esto según tu lógica
            ?>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_INSERT', 1)->isNotEmpty())
                    <button type="button" class="btn btn-lg" style="background-color: #48C9B0; color: white;" data-bs-toggle="modal" data-bs-target="#nuevoComunidadModal">
                        <i class="fas fa-plus"></i> Nuevo Registro
                    </button>
                    @endif
                </div>
            </div>
            @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_SELECT', 1)->isNotEmpty())
            <table id="comunidadesTable" class="table table-bordered">
                <thead>
                    <tr>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">CODIGO HOGAR</th>
                        <th class="d-none">COD_COMUNIDAD</th>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">NOMBRE COMUNIDAD</th>
                        <th class="d-none">COD_PERSONAS</th>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">NOMBRE PERSONA</th>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">NUMEROFAMILIARES</th>
                        <th class="d-none">TIP_VIVIENDA</th>
                        <th class="d-none">PROFESION_OFICIO</th>
                        <th class="d-none">RELIGION</th>
                        <th class="d-none">CANT_MATRIMONIO</th>
                        <th class="d-none">CANT_BAUTISMO</th>
                        <th class="d-none" >CANT_COMUNION</th>
                        <th class="d-none">CANT_CONFRIMACION</th>
                        <th class="d-none">MISA</th>
                        <th class="d-none">GRUP_PARROQUIAL</th>
                        <th class="d-none">ESTRATO_FAMILIAR</th>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($registros as $registro)
                        <tr>
                            <td style=" text-align: center">{{ $registro['COD_HOGAR'] }}</td>
                            <td class="d-none">{{ $registro['COD_COMUNIDAD'] }}</td>
                            <td style=" text-align: center">{{ $registro['NOM_COMUNIDAD'] }}</td>
                            <td class="d-none">{{ $registro['COD_PERSONAS'] }}</td>
                            <td>{{ $registro['NOMBRE_PERSONA'] }}</td>
                            <td style=" text-align: center">{{ $registro['NUM_FAMILIARES'] }}</td>
                            <td class="d-none">{{ $registro['TIP_VIVIENDA'] }}</td>
                            <td class="d-none">{{ $registro['PROFESION_OFICIO'] }}</td>
                            <td class="d-none">{{ $registro['RELIGION'] }}</td>
                            <td class="d-none">{{ $registro['CANT_MATRIMONIO'] }}</td>
                            <td class="d-none">{{ $registro['CANT_BAUTISMO'] }}</td>
                            <td class="d-none">{{ $registro['CANT_COMUNION'] }}</td>
                            <td class="d-none">{{ $registro['CANT_CONFRIMACION'] }}</td>
                            <td class="d-none">{{ $registro['MISA'] }}</td>
                            <td class="d-none">{{ $registro['GRUP_PARROQUIAL'] }}</td>
                            <td class="d-none">{{ $registro['ESTRATO_FAMILIAR'] }}</td>
                            <td style=" text-align: center">
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#detallesRegistroModal" data-registro="{{ json_encode($registro) }}">
                                    <i class="fas fa-info-circle"></i> Detalles
                                </button>
                                @if (collect($permisos)->where('COD_OBJETO', $objetos)->where('IND_UPDATE', 1)->isNotEmpty())
                                <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modificarRegistroModal" data-registro="{{ json_encode($registro) }}">
                                    <i class="fas fa-edit"></i> Modificar
                                </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            @endif
        </div>

        <!-- Modal para Nuevo Registro -->
        <div class="modal fade" id="nuevoComunidadModal" tabindex="-1" aria-labelledby="nuevoComunidadModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
        <div class="modal-content border-warning">
            <!-- Encabezado del Modal -->
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="nuevoComunidadModalLabel">
                    <i class="fas fa-plus me-2"></i> NUEVO REGISTRO
                </h5>
                <a href="/comunidadReg" class="btn-close"  ></a>

            </div>
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="nuevoRegistroForm" novalidate method="POST" action="{{ url('/Rcomunidad_INS') }}">
                    @csrf
                    <!-- Campos del Formulario -->
                    

                    <div class="col-md-3">
        <label for="COD_COMUNIDAD" class="form-label">Código Comunidad</label>
        <input type="text" class="form-control" id="COD_COMUNIDAD" name="COD_COMUNIDAD" style="width: 100%; pointer-events: none;" maxlength="10" required>
        <div class="invalid-feedback"></div>
    </div>
    <div class="col-md-5">
        <label for="Nom_COMUNIDAD" class="form-label">Nombre Comunidad</label>
        <input type="text" class="form-control" id="Nom_COMUNIDAD" name="Nom_COMUNIDAD" maxlength="10" style="width: 100%; pointer-events: none;" required>
        <div class="invalid-feedback">Por favor, seleccione la  comunidad.</div>
    </div>
    <div class="col-md-4 d-flex align-items-end">
    <button type="button" class="btn btn-warning w-100" style="background-color: gold; border-color: gold; color: black;" data-bs-toggle="modal" data-bs-target="#selectComunidadModal">
    <i class="fas fa-search"></i> Seleccionar Comunidad
</button>

    </div>


                 
                    <div class="col-md-3">
                        <label for="COD_HOGAR" class="form-label">Código Persona</label>
                        <input type="text" class="form-control" id="COD_PERSONA" name="COD_PERSONA" style="width: 100%; pointer-events: none;" maxlength="10" required >
                        <div class="invalid-feedback"></div>
                    </div>
                   
                    <div class="col-md-5">
                        <label for="COD_HOGAR" class="form-label">NOMBRE PERSONA</label>
                        <input type="text" class="form-control" id="NOMBREP" name="NOMBREP" style="width: 100%; pointer-events: none;" maxlength="100" required >
                        <div class="invalid-feedback">Por favor, seleccione una perosna .</div>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
    <a href="#" class="btn btn-success btn-sm d-flex align-items-center" id="btnMostrarModal1" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; line-height: 1; width: 100%; display: flex; justify-content: center; align-items: center; height: 2.5rem;">
        <i class="fas fa-user me-1" style="font-size: 1rem;"></i>
        <span style="font-size: 0.7rem;">Seleccionar Persona</span>
    </a>
</div>

.
                    
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <label for="PROFESION_OFICIO" class="form-label">Profesión/Oficio</label>
            <input type="text" class="form-control" id="PROFESION_OFICIO" name="PROFESION_OFICIO" maxlength="50" required>
            <div class="invalid-feedback">Por favor, ingrese la profesión o oficio.</div>
        </div>
        
        <div class="col-md-4">
            <label for="TIP_VIVIENDA" class="form-label">Tipo Vivienda</label>
            <select class="form-select" id="TIP_VIVIENDA" name="TIP_VIVIENDA" required>
                <option value="" disabled selected>Seleccione el tipo de vivienda</option>
                <option value="PROPIA">Propia</option>
                <option value="ALQUILADA">Alquilada</option>
            </select>
            <div class="invalid-feedback">Por favor, seleccione el tipo de vivienda.</div>
        </div>
        
        <div class="col-md-4">
            <label for="NUM_FAMILIARES" class="form-label">Número Familiares</label>
            <input type="number" class="form-control" id="NUM_FAMILIARES" name="NUM_FAMILIARES" required>
            <div class="invalid-feedback">Por favor, ingrese el número de familiares.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label for="ESTRATO_FAMILIAR" class="form-label">Estrato Familiar</label>
            <select class="form-select" id="ESTRATO_FAMILIAR" name="ESTRATO_FAMILIAR" required>
                <option value="" disabled selected>Seleccione el estrato familiar</option>
                <option value="BAJA">Baja</option>
                <option value="MEDIA-BAJA">Media-Baja</option>
                <option value="MEDIA">Media</option>
            </select>
            <div class="invalid-feedback">Por favor, seleccione el estrato familiar.</div>
        </div>
        
        <div class="col-md-4">
            <label for="RELIGION" class="form-label">Religión</label>
            <select class="form-select" id="RELIGION" name="RELIGION" required>
            <option value="" disabled selected>Seleccione la religión</option>
                            <option value="CATOLICA">Católica</option>
                            <option value="EVANGELICA">Evangélica</option>
                            <option value="TESTIGO DE JEHOVA">Testigo de Jehová</option>
                            <option value="MORMONA">Mormona</option>
                            <option value="OTRA">Otra</option>
                <!-- Agregar otras opciones si es necesario -->
            </select>
            <div class="invalid-feedback">Por favor, seleccione la religión.</div>
        </div>
        
        <div class="col-md-4">
            <label for="CANT_MATRIMONIO" class="form-label">Matrimonio</label>
            <select class="form-select" id="CANT_MATRIMONIO" name="CANT_MATRIMONIO" required>
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="SI">Sí</option>
                <option value="NO">No</option>
            </select>
            <div class="invalid-feedback">Por favor, seleccione la cantidad de matrimonio.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label for="CANT_BAUTISMO" class="form-label">Cantidad Bautismo</label>
            <input type="number" class="form-control" id="CANT_BAUTISMO" name="CANT_BAUTISMO" required>
            <div class="invalid-feedback">Por favor, ingrese la cantidad de bautismos.</div>
        </div>
        
        <div class="col-md-4">
            <label for="CANT_COMUNION" class="form-label">Cantidad Comunión</label>
            <input type="number" class="form-control" id="CANT_COMUNION" name="CANT_COMUNION" required>
            <div class="invalid-feedback">Por favor, ingrese la cantidad de comuniones.</div>
        </div>
        
        <div class="col-md-4">
            <label for="CANT_CONFRIMACION" class="form-label">Cantidad Confirmación</label>
            <input type="number" class="form-control" id="CANT_CONFRIMACION" name="CANT_CONFRIMACION" required>
            <div class="invalid-feedback">Por favor, ingrese la cantidad de confirmaciones.</div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <label for="MISA" class="form-label">Misa</label>
            <select class="form-select" id="MISA" name="MISA" required>
                <option value="" disabled selected>Seleccione una opción</option>
                <option value="SEMANAL">Semanal</option>
                <option value="TRIMESTRAL">Trimestral</option>
                <option value="SEMESTRAL">Semestral</option>
                <option value="ANUAL">Anual</option>
            </select>
            <div class="invalid-feedback">Por favor, seleccione la frecuencia de misa.</div>
        </div>
        
        <div class="col-md-4">
            <label for="GRUP_PARROQUIAL" class="form-label">Grupo Parroquial</label>
            <select class="form-select" id="GRUP_PARROQUIAL" name="GRUP_PARROQUIAL" required>
            <option value="" disabled selected>Seleccione el grupo parroquial</option>
                            <option value="PASTORAL SOCIAL">Pastoral Social</option>
                            <option value="PASTORAL JUVENIL">Pastoral Juvenil</option>
                            <option value="PASTORAL DE LA SALUD">Pastoral Familiar</option>
                            <option value="PASTORAL HUMANA COMUNITARIA">Pastoral Humana Comunitaria</option>
                            <option value="PASTORAL LITURGICA">Pastoral Liturgica</option>
                            <option value="PASTORAL PROFETICA">Pastoral Profetica</option>
                            <option value="NINGUNO">Ninguna</option>
                <!-- Agregar otras opciones si es necesario -->
            </select>
            <div class="invalid-feedback">Por favor, seleccione el grupo parroquial.</div>
        </div>
    </div>
</div>

                   
                    <div class="col-md-12 text-end">
                        <button type="submit" id="btnGuardar"class="btn btn-success">
                            <i class="fas fa-save"></i> Guardar
                        </button>
                        <a href="/comunidadReg" class="btn btn-danger ms-2">
    <i class="fas fa-times"></i> Cancelar
</a>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

        <!-- Modal para Detalles del Registro -->
        <div class="modal fade" id="detallesRegistroModal" tabindex="-1" aria-labelledby="detallesRegistroModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #48C9B0; color: white;">
                        <h5 class="modal-title" id="detallesRegistroModalLabel">
                            <i class="fas fa-info-circle me-2"></i> Detalles del Registro
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div id="registroDetalles"></div>
                    </div>
                </div>
            </div>
        </div>

       <!-- Modal para Modificar Registro -->
       <div class="modal fade" id="modificarRegistroModal" tabindex="-1" aria-labelledby="modificarRegistroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="max-width: 50%;">
        <div class="modal-content border-warning">
            <!-- Encabezado del Modal -->
            <div class="modal-header" style="background-color: #48C9B0; color: white;">
                <h5 class="modal-title d-flex align-items-center fw-bold" id="modificarRegistroModalLabel">
                    <i class="fas fa-edit me-2"></i> MODIFICAR REGISTRO
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Cuerpo del Modal -->
            <div class="modal-body">
                <form class="row g-3 needs-validation" id="modificarRegistroForm" novalidate method="POST" action="{{ route('rcomunidad.update', ['id' => $registro['COD_HOGAR']]) }}">
                    @csrf
                    @method('PUT')
                    <!-- Campos del Formulario -->
                    <div class="col-md-3">
                        <label for="MOD_COD_HOGAR" class="form-label">Código Hogar</label>
                        <input type="text" class="form-control" id="MOD_COD_HOGAR" name="COD_HOGAR" maxlength="10" style="width: 80%; pointer-events: none;"  required readonly>
                        <div class="invalid-feedback">Por favor, ingrese el código del hogar.</div>
                    </div>

                    <div class="col-md-5">
                        <label for="MOD_NOMBRE_PERSONA" class="form-label">Nombre Persona</label>
                        <input type="text" class="form-control" id="MOD_NOMBRE_PERSONA" name="NOMBRE_PERSONA" style="width: 80%; pointer-events: none;"  maxlength="100" required>
                        <div class="invalid-feedback">Por favor, ingrese el nombre de la persona.</div>
                    </div>

                    <div class="col-md-4">
                        <label for="MOD_PROFESION_OFICIO" class="form-label">Profesión/Oficio</label>
                        <input type="text" class="form-control" id="MOD_PROFESION_OFICIO" name="PROFESION_OFICIO" maxlength="50" required>
                        <div class="invalid-feedback">Por favor, ingrese la profesión o oficio.</div>
                    </div>

                    <div class="col-md-3">
                        <label for="MOD_COD_COMUNIDAD" class="form-label">Código Comunidad</label>
                        <input type="text" class="form-control" id="MOD_COD_COMUNIDAD" name="COD_COMUNIDAD" style="width: 80%; pointer-events: none;"  maxlength="10" required>
                        <div class="invalid-feedback">Por favor, ingrese el código de la comunidad.</div>
                    </div>

                    <div class="col-md-5">
                        <label for="MOD_NOM_COMUNIDAD" class="form-label">Nombre Comunidad</label>
                        <input type="text" class="form-control" id="MOD_NOM_COMUNIDAD" name="NOM_COMUNIDAD" style="width: 80%; pointer-events: none;"  maxlength="100" required>
                        <div class="invalid-feedback">Por favor, ingrese el nombre de la comunidad.</div>
                    </div>
                    <!--  <div class="col-md-4 d-flex align-items-end">
                      <a href="#" class="btn btn-warning btn-sm d-flex align-items-center" id="btnMostrarModal2" style="padding: 0.25rem 0.5rem; font-size: 0.7rem; line-height: 1; width: 100%; display: flex; justify-content: center; align-items: center; height: 2.5rem; background-color: gold; border-color: gold; color: black;" >
    <i class="fas fa-search me-1" style="font-size: 1rem;"></i>
    <span style="font-size: 0.7rem;">Seleccionar Comunidad</span>
</a>

</div> -->

                    <div class="col-md-4">
                        <label for="MOD_TIP_VIVIENDA" class="form-label">Tipo Vivienda</label>
                        <select class="form-select" id="MOD_TIP_VIVIENDA" name="TIP_VIVIENDA" required>
                            <option value="" disabled selected>Seleccione el tipo de vivienda</option>
                            <option value="PROPIA">Propia</option>
                            <option value="ALQUILADA">Alquilada</option>
                        </select>
                        <div class="invalid-feedback">Por favor, seleccione el tipo de vivienda.</div>
                    </div>

                    <div class="col-md-3">
                        <label for="MOD_NUM_FAMILIARES" class="form-label">Número Familiares</label>
                        <input type="number" class="form-control" id="MOD_NUM_FAMILIARES" name="NUM_FAMILIARES" required>
                        <div class="invalid-feedback">Por favor, ingrese el número de familiares.</div>
                    </div>

                    <div class="col-md-5">
                        <label for="MOD_ESTRATO_FAMILIAR" class="form-label">Estrato Familiar</label>
                        <select class="form-select" id="MOD_ESTRATO_FAMILIAR" name="ESTRATO_FAMILIAR" required>
                            <option value="" disabled selected>Seleccione el estrato familiar</option>
                            <option value="BAJA">Baja</option>
                            <option value="MEDIA-BAJA">Media-Baja</option>
                            <option value="MEDIA">Media</option>
                        </select>
                        <div class="invalid-feedback">Por favor, seleccione el estrato familiar.</div>
                    </div>
                    
                    <div class="col-md-4">
                        <label for="MOD_RELIGION" class="form-label">Religión</label>
                        <select class="form-select" id="MOD_RELIGION" name="RELIGION" required>
                            <option value="" disabled selected>Seleccione la religión</option>
                            <option value="CATOLICA">Católica</option>
                            <option value="EVANGELICA">Evangélica</option>
                            <option value="TESTIGO DE JEHOVA">Testigo de Jehová</option>
                            <option value="MORMONA">Mormona</option>
                            <option value="OTRA">Otra</option>
                        </select>
                        <div class="invalid-feedback">Por favor, seleccione la religión.</div>
                    </div>

              

                    <div class="col-md-4">
                        <label for="MOD_CANT_MATRIMONIO" class="form-label">Matrimonio</label>
                        <select class="form-select" id="MOD_CANT_MATRIMONIO" name="CANT_MATRIMONIO" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="SI">Sí</option>
                            <option value="NO">No</option>
                        </select>
                        <div class="invalid-feedback">Por favor, seleccione la cantidad de matrimonio.</div>
                    </div>

                    <div class="col-md-4">
                        <label for="MOD_CANT_BAUTISMO" class="form-label">Cantidad Bautismo</label>
                        <input type="number" class="form-control" id="MOD_CANT_BAUTISMO" name="CANT_BAUTISMO" required>
                        <div class="invalid-feedback">Por favor, ingrese la cantidad de bautismos.</div>
                    </div>

                    <div class="col-md-4">
                        <label for="MOD_CANT_COMUNION" class="form-label">Cantidad Comunión</label>
                        <input type="number" class="form-control" id="MOD_CANT_COMUNION" name="CANT_COMUNION" required>
                        <div class="invalid-feedback">Por favor, ingrese la cantidad de comuniones.</div>
                    </div>

                    <div class="col-md-4">
                        <label for="MOD_CANT_CONFRIMACION" class="form-label">Cantidad Confirmación</label>
                        <input type="number" class="form-control" id="MOD_CANT_CONFRIMACION" name="CANT_CONFRIMACION" required>
                        <div class="invalid-feedback">Por favor, ingrese la cantidad de confirmaciones.</div>
                    </div>

                    <div class="col-md-4">
                        <label for="MOD_MISA" class="form-label">Misa</label>
                        <select class="form-select" id="MOD_MISA" name="MISA" required>
                            <option value="" disabled selected>Seleccione una opción</option>
                            <option value="SEMANAL">Semanal</option>
                            <option value="TRIMESTRAL">Trimestral</option>
                            <option value="SEMESTRAL">Semestral</option>
                            <option value="ANUAL">Anual</option>
                            <option value="NUNCAL">Nunca</option>
                        </select>
                        <div class="invalid-feedback">Por favor, seleccione la frecuencia de misa.</div>
                    </div>

                  


                    <div class="col-md-4">
                        <label for="MOD_GRUP_PARROQUIAL" class="form-label">Grupo Parroquial</label>
                        <select class="form-select" id="MOD_GRUP_PARROQUIAL" name="GRUP_PARROQUIAL" required>
                            <option value="" disabled selected>Seleccione el grupo parroquial</option>
                            <option value="PASTORAL SOCIAL">Pastoral Social</option>
                            <option value="PASTORAL JUVENIL">Pastoral Juvenil</option>
                            <option value="PASTORAL DE LA SALUD">Pastoral Familiar</option>
                            <option value="PASTORAL HUMANA COMUNITARIA">Pastoral Humana Comunitaria</option>
                            <option value="PASTORAL LITURGICA">Pastoral Liturgica</option>
                            <option value="PASTORAL PROFETICA">Pastoral Profetica</option>
                            <option value="NINGUNO">Ninguna</option>
                        </select>
                        <div class="invalid-feedback">Por favor, seleccione el grupo parroquial.</div>
                    </div>


                    <div class="col-md-12 text-end">
                        <button type="submit"  id="btnGuardarm" class="btn btn-success">
                            <i class="fas fa-save"></i> Guardar Cambios
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



<!-- Modal -->






<!-- Modal 2: selectComunidadModal -->
<div class="modal fade" id="selectComunidadModal" tabindex="-1" aria-labelledby="selectComunidadModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-ml">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="selectComunidadModalLabel">Comunidad</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closeSelectComunidadModal"></button>
            </div>
            <div class="modal-body">
                <!-- Botón Nuevo Proyecto -->
                <a href="/comunidad" class="btn btn-success mb-3" id="nuevoProyectoBtn">
                    <i class="fas fa-plus"></i> Nuevo Comunidad
                </a>
                <table id="comunidadTable" class="table table-striped table-bordered" style="width:100%">
                    <!-- La tabla se llenará dinámicamente con DataTables -->
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="closeSelectComunidadFooter">Cerrar</button>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="resultadosModal1" tabindex="-1" aria-labelledby="resultadosModalLabel1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" style="max-width: 45%;">
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




    @stop

    <!-- jQuery y DataTables JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

 

       





    <script>
    $(document).ready(function() {
        $('#btnMostrarModal2').click(function() {
            $('#selectComunidadModal2').modal('show'); // Mostrar modal al hacer clic en el botón
            cargarTablaComunidad(); // Cargar los datos en la tabla
        });

        function cargarTablaComunidad() {
            // Destruir instancia existente de DataTable si existe
            if ($.fn.DataTable.isDataTable('#comunidadTable2')) {
                $('#comunidadTable2').DataTable().clear().destroy();
            }

            $('#comunidadTable2').DataTable({
                "processing": false, // Mostrar mensaje "Cargando..." durante la carga
                "serverSide": true, // Habilitar procesamiento del lado del servidor
                "searching": true, // Habilitar búsqueda
                "paging": true, // Habilitar paginación
                "lengthChange": false, // Deshabilitar el control de cambiar la cantidad de registros por página
                "pageLength": 1, // Mostrar 5 registros por página
                "info": false, // Deshabilitar información de cantidad de registros
                "language": { // Configuración de idioma
                    "search": "Buscar:",
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
                    "url": "{{ route('comunidad.buscar') }}",
                    "type": "GET",
                    "dataSrc": "data" // Asegúrate de que DataTables use la propiedad 'data' de la respuesta
                },
                "columns": [
                    { "data": "COD_COMUNIDAD", "title": "Código Comunidad" },
                    { "data": "NOM_COMUNIDAD", "title": "Nombre Comunidad" },
                    {
                        "data": null,
                        "render": function(data, type, row) {
                            return '<button class="btn btn-success btn-select rounded-circle" style="width: 30px; height: 30px; display: flex; justify-content: center; align-items: center;" data-codigo="' + row.COD_COMUNIDAD + '">' +
                                '<i class="fas fa-check text-white"></i>' +
                                '</button>';
                        },
                        "title": "Acciones",
                        "orderable": false
                    }
                ]
            });

            // Cambiar tamaño de letra de la tabla
            $('#comunidadTable2').css('font-size', '0.8em');

            // Acción al hacer clic en el botón de seleccionar comunidad
            $('#comunidadTable2').on('click', '.btn-select', function() {
                var codigoComunidad = $(this).data('codigo');
                var nombreComunidad = $(this).closest('tr').find('td:nth-child(2)').text(); // Obtener el nombre desde la columna correspondiente

                // Actualizar los campos con los datos de la comunidad seleccionada
                $('#MOD_COD_COMUNIDAD').val(codigoComunidad);
                $('#MOD_NOM_COMUNIDAD').val(nombreComunidad);

                // Cerrar modal opcionalmente
                $('#selectComunidadModal2').modal('hide');
            });
        }
    });
</script>



    <script>
    $(document).ready(function() {
        var table = $('#comunidadesTable').DataTable({
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

    
<!-- Incluye el script al final del archivo -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    var selectComunidadModal = new bootstrap.Modal(document.getElementById('selectComunidadModal'));
    var nuevoComunidadModal = new bootstrap.Modal(document.getElementById('nuevoComunidadModal'));

    // Cuando la segunda modal se oculta, vuelve a mostrar la primera modal
    document.getElementById('closeSelectComunidadModal').addEventListener('click', function() {
        nuevoComunidadModal.show();
    });

    document.getElementById('closeSelectComunidadFooter').addEventListener('click', function() {
        nuevoComunidadModal.show();
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
    $(document).ready(function() {
        $('#selectComunidadModal').on('show.bs.modal', function (e) {
            // Carga los datos de la comunidad en la modal
            $.ajax({
                url: '{{ route('comunidad.buscar') }}', // La ruta que devuelve los datos en JSON
                method: 'GET',
                success: function(response) {
                    // Inicializa DataTable con los datos obtenidos
                    $('#comunidadTable').DataTable({
                        data: response.data, // Utiliza 'data' como la propiedad correcta
                        destroy: true, // Permite reinicializar la tabla si se abre la modal varias veces
                        columns: [
                            { data: 'COD_COMUNIDAD', title: 'Código Comunidad' },
                            { data: 'NOM_COMUNIDAD', title: 'Nombre Comunidad' },
                            {
                                data: null,
                                defaultContent: '<button class="btn btn-success btn-select"><i class="fas fa-check"></i></button>',
                                orderable: false,
                                title: 'Acciones'
                            }
                        ],
                        language: {
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
                                "sFirst": "Primero",
                                "sLast": "Último",
                                "sNext": "Siguiente",
                                "sPrevious": "Anterior"
                            },
                            "oAria": {
                                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                            }
                        },
                        pageLength: 5, // Configura el número de registros por página
                        info: false, // Oculta la información de la tabla (e.g., "Mostrando 1 a 5 de 10 entradas")
                        paging: true, // Si quieres ocultar la paginación, pon esto como false
                        lengthChange: false // Oculta la opción para cambiar el número de entradas mostradas
                    });

                    // Manejador de clic en el botón de selección
                    $('#comunidadTable tbody').on('click', 'button.btn-select', function () {
                        var data = $('#comunidadTable').DataTable().row($(this).parents('tr')).data();
                        $('#COD_COMUNIDAD').val(data.COD_COMUNIDAD);
                        $('#Nom_COMUNIDAD').val(data.NOM_COMUNIDAD);
                        // Cierra la modal de selección y muestra la modal de nuevo registro
                        $('#selectComunidadModal').modal('hide');
                        $('#nuevoComunidadModal').modal('show');
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error al obtener los datos:', error);
                }
            });
        });
    });
</script>


    <script>


document.addEventListener('DOMContentLoaded', function() {
  var btnGuardar = document.getElementById('btnGuardar');
  if (btnGuardar) {
    btnGuardar.addEventListener('click', function(event) {
      var form = document.getElementById('nuevoRegistroForm');
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
  var btnGuardar = document.getElementById('btnGuardarm');
  if (btnGuardar) {
    btnGuardar.addEventListener('click', function(event) {
      var form = document.getElementById('modificarRegistroForm');
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
        $(document).ready(function() {
            // Inicialización de DataTables
            $('#comunidadesTable').DataTable();

            // Mostrar detalles del registro en el modal
            $('#detallesRegistroModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Botón que activó el modal
                var registro = button.data('registro'); // Datos del registro

                var modal = $(this);
                modal.find('#registroDetalles').html(`
    <table class="table no-borders">
        <tbody>
            <tr>
                <th>Código Hogar</th>
                <td>${registro.COD_HOGAR}</td>
            </tr>
            <tr>
                <th>Código Comunidad</th>
                <td>${registro.COD_COMUNIDAD}</td>
            </tr>
            <tr>
                <th>Nombre Comunidad</th>
                <td>${registro.NOM_COMUNIDAD}</td>
            </tr>
            <tr>
                <th>Código Persona</th>
                <td>${registro.COD_PERSONAS}</td>
            </tr>
            <tr>
                <th>Nombre Persona</th>
                <td>${registro.NOMBRE_PERSONA}</td>
            </tr>
            <tr>
                <th>Número Familiares</th>
                <td>${registro.NUM_FAMILIARES}</td>
            </tr>
            <tr>
                <th>Tipo Vivienda</th>
                <td>${registro.TIP_VIVIENDA}</td>
            </tr>
            <tr>
                <th>Profesión/Oficio</th>
                <td>${registro.PROFESION_OFICIO}</td>
            </tr>
            <tr>
                <th>Religión</th>
                <td>${registro.RELIGION}</td>
            </tr>
            <tr>
                <th>Cantidad Matrimonio</th>
                <td>${registro.CANT_MATRIMONIO}</td>
            </tr>
            <tr>
                <th>Cantidad Bautismo</th>
                <td>${registro.CANT_BAUTISMO}</td>
            </tr>
            <tr>
                <th>Cantidad Comunión</th>
                <td>${registro.CANT_COMUNION}</td>
            </tr>
            <tr>
                <th>Cantidad Confirmación</th>
                <td>${registro.CANT_CONFRIMACION}</td>
            </tr>
            <tr>
                <th>Misa</th>
                <td>${registro.MISA}</td>
            </tr>
            <tr>
                <th>Grupo Parroquial</th>
                <td>${registro.GRUP_PARROQUIAL}</td>
            </tr>
            <tr>
                <th>Estrato Familiar</th>
                <td>${registro.ESTRATO_FAMILIAR}</td>
            </tr>
        </tbody>
    </table>
`);


            });

           





            $('#modificarRegistroModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget); // Botón que activó el modal
    var registro = button.data('registro'); // Datos del registro

    var modal = $(this);
    modal.find('#MOD_COD_HOGAR').val(registro.COD_HOGAR);
    modal.find('#MOD_COD_COMUNIDAD').val(registro.COD_COMUNIDAD);
    modal.find('#MOD_NOM_COMUNIDAD').val(registro.NOM_COMUNIDAD);
    modal.find('#MOD_COD_PERSONAS').val(registro.COD_PERSONAS);
    modal.find('#MOD_NOMBRE_PERSONA').val(registro.NOMBRE_PERSONA);
    modal.find('#MOD_NUM_FAMILIARES').val(registro.NUM_FAMILIARES);
    modal.find('#MOD_TIP_VIVIENDA').val(registro.TIP_VIVIENDA);
    modal.find('#MOD_PROFESION_OFICIO').val(registro.PROFESION_OFICIO);
    modal.find('#MOD_RELIGION').val(registro.RELIGION);
    modal.find('#MOD_CANT_MATRIMONIO').val(registro.CANT_MATRIMONIO);
    modal.find('#MOD_CANT_BAUTISMO').val(registro.CANT_BAUTISMO);
    modal.find('#MOD_CANT_COMUNION').val(registro.CANT_COMUNION);
    modal.find('#MOD_CANT_CONFRIMACION').val(registro.CANT_CONFRIMACION);
    modal.find('#MOD_MISA').val(registro.MISA);
    modal.find('#MOD_GRUP_PARROQUIAL').val(registro.GRUP_PARROQUIAL);
    modal.find('#MOD_ESTRATO_FAMILIAR').val(registro.ESTRATO_FAMILIAR);
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
                $('#COD_PERSONA').val(codigoPersona);
                $('#NOMBREP').val(nombrePersona);
               

                // Cerrar modal opcionalmente si así lo deseas
                $('#resultadosModal1').modal('hide');
            });
        }
    });
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
