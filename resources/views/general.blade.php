<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parroquia SMP - SACRAMENTOS</title>
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
                <img src="{{ asset('vendor/adminlte/dist/img/general2.png') }}" style="width: 190px; height: 190px;">
            </div>
            <div class="col">
                <!-- Ajusta el estilo y contenido del encabezado según tus necesidades -->
                <h1 class="fw-bold text-center" style="font-style: italic; font-family: 'Algerian', sans-serif; color: black; font-size: 60px; text-shadow: 4px 4px #48C9B0;"> REGISTROS EN SACRAMENTOS</h1>
            </div>
        </div>
        <div class="table-responsive">
       
            <table id="example" class="table table-striped shadow-lg mt-4" style="width:100%; border: 2px solid #dee2e6;">
                <thead>
                    <tr>
                        <th>#</th> <!-- Columna para el índice -->
                        <th style="background-color:#48C9B0; color: black; text-align: center;">DNI</th>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">Nombre</th>
                        <th style="background-color:#48C9B0; color: black; text-align: center;">Nombre Sacramento</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ResulSacramentos as $index => $sacramento)
                        <tr>
                            <td>{{ $index + 1 }}</td> <!-- Muestra el índice -->
                            <td>{{ $sacramento['DNI_PERSONA'] ?? 'N/A' }}</td>
                            <td>{{ $sacramento['NOMBRE_COMPLETO'] ?? 'N/A' }}</td>
                            <td>{{ $sacramento['NOMBRE_SACRAMENTO'] ?? 'N/A' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
          
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
