@extends('adminlte::page')

@section('title', 'Home')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')

  <div class="row">

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box">
          <span class="info-box-icon bg-info elevation-1"><i class="fas fa-tag"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Tikets</span>
            <span class="info-box-number">
              {{$tickets}}
            </span>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-briefcase  "></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Proyectos</span>
            <span class="info-box-number">{{$project}}</span>
          </div>
        </div>
      </div>

      <div class="clearfix hidden-md-up"></div>

      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-success elevation-1"><i class="fas fa-folder"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Categorias</span>
            <span class="info-box-number">{{$category}}</span>
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-md-3">
        <div class="info-box mb-3">
          <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

          <div class="info-box-content">
            <span class="info-box-text">Usuarios</span>
            <span class="info-box-number">{{Auth::user()->count() }}</span>
          </div>
        </div>
      </div>

  </div>

  <div class="row">

    <div class="col-md-8">

        <div class="card">
            <div class="card-header border-transparent">
              <h3 class="card-title">Ultimos reportes</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
                <button type="button" class="btn btn-tool" data-card-widget="remove">
                  <i class="fas fa-times"></i>
                </button>
              </div>

            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table m-0">
                        <thead>
                            <tr>
                                <th>Codigo de reporte</th>
                                <th>Nombre</th>
                                <th>Status</th>
                                <th>Proyecto asignado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($topTickets as $ticket)
                            <tr>
                                <td> <a href="#"> {{ $ticket->code }} </a> </td>
                                <td> <p class="lead"> {{ $ticket->title }} </p> </td>
                                <td>
                                    <p class="lead">
                                        @if ($ticket->status == "En desarrollo")
                                            <span class="badge badge-info">{{ $ticket->status }}</span>
                                        @elseif($ticket->status == "Pendiente")
                                            <span class="badge badge-warning">{{ $ticket->status }}</span>
                                        @elseif($ticket->status == "Terminado")
                                            <span class="badge badge-success">{{ $ticket->status }}</span>
                                        @elseif($ticket->status == "Cancelado")
                                            <span class="badge badge-danger">{{ $ticket->status }}</span>
                                        @endif
                                    </p>
                                </td>
                                <td> <p class="lead"> {{ $ticket->project }} </p> </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

    </div>

    <div class="col-md-4">
      <div class="info-box mb-3 bg-warning">
        <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Reportes pendientes</span>
          <span class="info-box-number">10</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <div class="info-box mb-3 bg-success">
        <span class="info-box-icon"><i class="fa fa-check"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Reportes completados</span>
          <span class="info-box-number">92,050</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <div class="info-box mb-3 bg-danger">
        <span class="info-box-icon"><i class="fas fa-ban"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Reportes cancelados</span>
          <span class="info-box-number">114,381</span>
        </div>
        <!-- /.info-box-content -->
      </div>
      <div class="info-box mb-3 bg-info">
        <span class="info-box-icon"><i class="fa fa-wrench"></i></span>

        <div class="info-box-content">
          <span class="info-box-text">Reportes en desarrollo</span>
          <span class="info-box-number">163,921</span>
        </div>
        <!-- /.info-box-content -->
      </div>
    </div>

  </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    <script>
        console.log("Hola");
    </script>
@stop
