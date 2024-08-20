<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @extends('adminlte::page')

@section('plugins.Datatables', true)

@section('content_header')
@stop
    
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    
    

    @section('content')
    <div class="content">
        <h1 class="fw-bold text-center">Datos de Finanzas</h1>
    
        <!-- Mostrar mensaje de error si existe -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
    
        <div class="table-responsive">
            <table id="finanzaTable" class="table table-striped">
                <thead>
                    <tr>
                        <th class="col-mes">Mes</th>
                        <th class="col-anio">Año</th>
                        <th class="col-ingresos">Ingresos</th>
                        <th class="col-egresos">Egresos</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ResultadosFinanza as $finanza)
                        <tr>
                            <td>{{ $finanza['MES'] }}</td>
                            <td>{{ $finanza['ANIO'] }}</td>
                            <td>{{ $finanza['INGRESOS'] }}</td>
                            <td>{{ $finanza['EGRESOS'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @stop

    @section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    @stop

    @section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
    <script>
        $(document).ready(function() {
            $('#finanzaTable').DataTable({
                "language": {
                    "search": "Buscar",
                    "lengthMenu": "Mostrar _MENU_ registros por página",
                    "info": "Mostrando página _PAGE_ de _PAGES_",
                    "paginate": { 
                        "previous": "Anterior",
                        "next" : "Siguiente",
                        "first": "Primero",
                        "last": "Último"
                    }
                }
            });

            // Form validation
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
                        }, false)
                    })
            })();
        });
    </script>
    @stop
</head>
<body>
</body>
</html>
