@extends('adminlte::page')

@section('title', 'Mi perfil')

@section('content_header')
    <div class="card mb-4 wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
        <div class="card-body d-sm-flex justify-content-between">
            <h4 class="mb-2 mb-sm-0 pt-1">
                <a href="/home">Inicio</a>
                <span>/</span>
                <span>Mi perfil</span>
            </h4>
        </div>
    </div>
@stop

@section('content')
<div class="row">

    <div class="col-md-5">
        @if(Auth::user()->profile_pic == "default.png")
        <img class="img-circle" width="100%"  src="{{ asset('img/error.svg') }}" id="avatarImage">
        @else
        <img class="img-circle" width="100%"  src="{{ asset('fotos/'.Auth::user()->profile_pic) }}" id="avatarImage">
        @endif
    </div>

    <div class="col-md-5">

        <div class="box box-primary">

            <div class="box-body box-profile">
                <h3 class="profile-username text-center">{{ Auth::user()->name }}</h3>
                <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>Usuario: </b> <a class="pull-right">{{ Auth::user()->username }}</a>
                </li>
                <li class="list-group-item">
                    <b>Email: </b> <a class="pull-right">{{ Auth::user()->email }}</a>
                </li>
                <li class="list-group-item">
                    @if (Auth::user()->status == "Habilitada")
                        <b>Status: </b> <a class="pull-right"> <span class="badge badge-success">Habilitado</span></a>
                    @else
                        <b>Status: </b> <a class="pull-right"> <span class="badge badge-danger">Desabilitado</span></a>
                    @endif
                </li>
                <li class="list-group-item">
                    @if (Auth::user()->role == 'admin')
                        <b>Rol: </b> <a class="pull-right">Administrador</a>
                    @else
                        <b>Rol: </b> <a class="pull-right">Empleado</a>
                    @endif
                </li>
                <li class="list-group-item">
                    <form method="POST" id="imgForm" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <span class="btn btn-my-button btn-file">
                            Cambiar Imagen de perfil: <input type="file" name="profile_pic" id="profile_pic" required />
                        </span>
                        <hr>
                        <input type="submit" class="update btn btn-block btn-success" id="update" name="update" value="Actualizar fotografia">
                    </form>
                </li>
                </ul>
            </div>

        </div>

    </div>

  </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')

<script>
    $(document).ready( function(){
        $('#imgForm').on('submit', function(event){
            event.preventDefault();

            if($('#update').val() == 'Actualizar fotografia'){
                $.ajax({
                    url:"{{ route('perfil.store' )}}",
                    method:"POST",
                    data:new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: "json",
                    success:function(data){
                        if(data.errors){
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops...',
                                footer: '<p>Compruebe los copos</p>'
                            })
                        }
                        if(data.success){
                            Swal.fire({
                                icon: 'success',
                                title: 'La imagen de actualizo con exito.',
                                showConfirmButton: false,
                                timer: 1500
                            })
                            $('#imgForm')[0].reset();
                            location.reload();
                            // $('#tableCategory').DataTable().ajax.reload();
                        }
                    }
                })
            }

        });
    });
</script>

@stop
