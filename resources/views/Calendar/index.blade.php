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
<html lang='es'>
  <head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js'></script>
    <script>

      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
          initialView: 'dayGridMonth',
          locales:"es",

          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,listWeek'
          },

          defaultView: "month",
          navLinks: true, 
          editable: true,
          eventLimit: true, 
          selectable: true,
          selectHelper: false,

          dateClick:function(info){
            $("#exampleModal").modal("show");
          }

      

        });
        calendar.render(); 
      });

    </script>
  </head>
  <body>
    <div id='calendar'></div>
  </body>
</html>

<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Abrir Modal
</button>

<!-- Modal para Nuevo Tipo de Evento -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" style="max-width: 30%;">
                <div class="modal-content border-warning">
                    <!-- Encabezado del Modal -->
                    <div class="modal-header" style="background-color: #48C9B0; color: white;">
                        <h5 class="modal-title d-flex align-items-center fw-bold" id="exampleModalLabel">
                            <i class="fas fa-plus me-2"></i> NUEVO EVENTO
                    </div>
                    <!-- Cuerpo del Modal -->
                    <div class="modal-body">
                        <form class="row g-3 needs-validation" id="nuevoTipoEventoForm" novalidate method="POST" action="{{ url('/Tipo_INS') }}">
                         
                        @csrf
                            <div class="col-md-12">
                                <label for="NOMBRE" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="NOMBRE" name="NOMBRE" maxlength="50" required>
                                <div class="invalid-feedback">
                                    Por favor ingrese el nombre del evento.
                                </div>
                            </div>

                            <div class="col-12 text-center">
                                <button id="btnGuardar" class="btn btn-success text-white" type="submit">
                                    <i class="fas fa-save me-2"></i> Guardar
                                </button>
                                <a href="/tipo_Evento" class="btn btn-danger" >
                                    <i class="fas fa-times"></i> Cerrar
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


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