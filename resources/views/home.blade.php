@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <div class="content-header bg-primary text-white p-4 rounded-lg shadow-sm d-flex align-items-center">
        <i class="fas fa-home fa-2x mr-3"></i>
        <h1 class="mb-0">Bienvenido</h1>
    </div>
@stop


@section('content')
    <div class="row">
        <div class="col-lg-3 col-6">
            <!-- Feligreses -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $data['feligreses_count'] }}</h3>
                    <p>Feligreses Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
                <a href="/Feligreses" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- Empleados -->
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $data['empleados_count'] }}</h3>
                    <p>Empleados Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-user-tie"></i>
                </div>
                <a href="/Empleados" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- Bautizos -->
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $data['bautizos'] }}</h3>
                    <p>Bautizos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-tint"></i>
                </div>
                <a href="/sacramentos/bautizo" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- Matrimonios -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $data['matrimonios'] }}</h3>
                    <p>Matrimonios</p>
                </div>
                <div class="icon">
                    <i class="fas fa-ring"></i>
                </div>
                <a href="/sacramentos/matrimonio" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- Primeras Comuniones -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $data['comuniones'] }}</h3>
                    <p>Primera Comunión</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bread-slice"></i>
                </div>
                <a href="/sacramentos/comunion" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- Confirmaciones -->
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $data['confirmaciones'] }}</h3>
                    <p>Confirmaciones</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hands"></i>
                </div>
                <a href="/sacramentos/confirmacion" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- Orden Sacerdotal -->
            <div class="small-box bg-dark">
                <div class="inner">
                    <h3>{{ $data['ordenes'] }}</h3>
                    <p>Orden Sacerdotal</p>
                </div>
                <div class="icon">
                    <i class="fas fa-church"></i>
                </div>
                <a href="/sacramentos/orden" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- Unción de los Enfermos -->
            <div class="small-box bg-light">
                <div class="inner">
                    <h3>{{ $data['unciones'] }}</h3>
                    <p>Unción de los Enfermos</p>
                </div>
                <div class="icon">
                    <i class="fas fa-hands-helping"></i>
                </div>
                <a href="/sacramentos/uncion" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- Reconciliaciones -->
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $data['reconciliaciones'] }}</h3>
                    <p>Reconciliaciones</p>
                </div>
                <div class="icon">
                    <i class="fas fa-praying-hands"></i>
                </div>
                <a href="/sacramentos/reconciliacion" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>


        <div class="col-lg-3 col-6">
            <!-- Comunidades Registradas -->
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $data['comunidades_count'] }}</h3>
                    <p>Comunidades Registradas</p>
                </div>
                <div class="icon">
                    <i class="fas fa-people-carry"></i>
                </div>
                <a href="/comunidadReg" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

        <div class="col-lg-3 col-6">
            <!-- Becarios Registrados -->
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $data['becarios_count'] }}</h3>
                    <p>Becarios Registrados</p>
                </div>
                <div class="icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <a href="/becas" class="small-box-footer">
                    Más información <i class="fas fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>
    </div>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
@stop

@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
