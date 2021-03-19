@extends('adminlte::page')
@section('title', 'Mis reportes')
@section('content_header')
    <div class="card mb-4 wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
        <div class="card-body d-sm-flex justify-content-between">
            <h4 class="mb-2 mb-sm-0 pt-1">
                <a href="/home">Inicio</a>
                <span>/</span>
                <span>Mis reportes</span>
            </h4>
        </div>
    </div>
@stop
@section('content')
    <div class="row">

        <div class="col-md-3">
            <h2 class="text-bold text-center">PENDIENTE</h2>
            @foreach ($pendientes as $item)
            <div class="info-box mb-3 bg-warning">
                <span class="info-box-icon"><i class="fas fa-exclamation-triangle"></i></span>
                <div class="info-box-content">
                    <strong>{{ $item->title}}</strong>
                    <span>{{ $item->description}}</span>
                    <span class="info-box-number">{{ $item->created_at}}</span>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ url('reportes/ver', [$item->id]) }}" class="btn btn-warning" target="_blank"> <span class="fa fa-eye"></span></a>
                        </div>
                        {{-- <div class="col-6">
                            <a href="#" id="addStatus" class="btn btn-warning"> <span class="fa fa-edit"></span></a>
                        </div> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-md-3">
            <h2 class="text-bold text-center">EN DESARROLLO</h2>
            @foreach ($enDesarrollo as $item)
            <div class="info-box mb-3 bg-info">
                <span class="info-box-icon"><i class="far fa-paper-plane"></i></span>
                <div class="info-box-content">
                    <strong>{{ $item->title}}</strong>
                    <span>{{ $item->description}}</span>
                    <span class="info-box-number">{{ $item->created_at}}</span>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ url('reportes/ver', [$item->id]) }}" class="btn btn-info" target="_blank"> <span class="fa fa-eye"></span></a>
                        </div>
                        {{-- <div class="col-6">
                            <a href="#" id="addStatus" class="btn btn-info"> <span class="fa fa-edit"></span></a>
                        </div> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-md-3">
            <h2 class="text-bold text-center">TERMINADO</h2>
            @foreach ($terminado as $item)
            <div class="info-box mb-3 bg-success">
                <span class="info-box-icon"><i class="fa fa-check"></i></span>
                <div class="info-box-content">
                    <strong>{{ $item->title}}</strong>
                    <span>{{ $item->description}}</span>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ url('reportes/ver', [$item->id]) }}" class="btn btn-success" target="_blank"> <span class="fa fa-eye"></span></a>
                        </div>
                        {{-- <div class="col-6">
                            <a href="#" id="addStatus" class="btn btn-success"> <span class="fa fa-edit"></span></a>
                        </div> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="col-md-3">
            <h2 class="text-bold text-center">CANCELADO</h2>
            @foreach ($cancelado as $item)
            <div class="info-box mb-3 bg-danger">
                <span class="info-box-icon"><i class="fas fa-ban"></i></span>
                <div class="info-box-content">
                    <strong>{{ $item->title}}</strong>
                    <span>{{ $item->description}}</span>
                    <span class="info-box-number">{{ $item->created_at}}</span>
                    <div class="row">
                        <div class="col-12">
                            <a href="{{ url('reportes/ver', [$item->id]) }}" class="btn btn-danger" target="_blank"> <span class="fa fa-eye"></span></a>
                        </div>
                        {{-- <div class="col-6">
                            <a href="#" id="addStatus" class="btn btn-danger"> <span class="fa fa-edit"></span></a>
                        </div> --}}
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
@stop
@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop
@section('js')
    <script>
        $(document).ready( function(){
            /* Abrir ventana modal */
            $('#addStatus').click(function(){
                $('#statusForm')[0].reset();
                $('#action_button').val("Actualizar");
                $('#action').val("Actualizar");
                $('#statusModal').modal('show');
            });
        });
    </script>
@stop

<div id="statusModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg bg-light">
                <h5 class="modal-title">Status actual</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <form method="POST" id="statusForm" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <label class="m-0">Nombre de la categoria:</label>
                            <select name="stutus" id="status" class="form-control">
                                @foreach ($status as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <input type="hidden" name="action" id="action" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="submit" name="action_button"
                                id="action_button" class="btn btn-block btn-primary" value="Actualizar" />
                        </div>
                    </div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

