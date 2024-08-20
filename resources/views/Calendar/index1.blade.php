<!DOCTYPE html>
<html lang="en">
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

    <style>
        th {
            background-color: #48C9B0 !important;
            color: black !important;
            font-size: 1.20rem; /* Tamaño de fuente para los encabezados */
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
    </style>
</head>
<body>

@extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content_header')
@stop

@section('content')
<body>
<div class="container">
    <h1>Lista de Eventos</h1>

    <a href="{{ route('Calendar.create') }}" class="btn btn-primary mb-3">Agregar Evento</a>

    <h2>Tipos de Eventos</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Código</th>
                <th>Nombre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tiposEventos as $tipo)
            <tr>
                <td>{{ $tipo->COD_TIP_EVENTO }}</td>
                <td>{{ $tipo->NOMBRE }}</td>
                <td><a href="{{ route('Calendar.show', $tipo->id) }}" class="btn btn-info">Ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Agenda</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Fecha y Hora</th>
                <th>Duración</th>
                <th>Lugar</th>
                <th>Descripción</th>
                <th>Responsable</th>
                <th>Estado</th>
                <th>Observaciones</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agendas as $agenda)
            <tr>
                <td>{{ $agenda->FEC_HRS_EVENTO }}</td>
                <td>{{ $agenda->DURACION_EVENTO }}</td>
                <td>{{ $agenda->LUGAR }}</td>
                <td>{{ $agenda->DESCRIPCION }}</td>
                <td>{{ $agenda->RESPONSABLE }}</td>
                <td>{{ $agenda->ESTADO }}</td>
                <td>{{ $agenda->OBSERVACIONES }}</td>
                <td><a href="{{ route('Calendar.show', $agenda->id) }}" class="btn btn-info">Ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <h2>Solicitudes de Servicio</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Descripción del Evento</th>
                <th>Nombre del Solicitante</th>
                <th>Teléfono del Solicitante</th>
                <th>Fecha y Hora del Servicio</th>
                <th>Lugar</th>
                <th>Observación</th>
                <th>Fecha de Registro</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($solicitudes as $solicitud)
            <tr>
                <td>{{ $solicitud->DESC_EVENTO }}</td>
                <td>{{ $solicitud->NOM_SOLICITANTE }}</td>
                <td>{{ $solicitud->TEL_SOLICITANTE }}</td>
                <td>{{ $solicitud->FEC_HRS_SERVICIO }}</td>
                <td>{{ $solicitud->LUGAR }}</td>
                <td>{{ $solicitud->OBSERVACION }}</td>
                <td>{{ $solicitud->FEC_REGISTRO }}</td>
                <td><a href="{{ route('Calendar.show', $solicitud->id) }}" class="btn btn-info">Ver</a></td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>