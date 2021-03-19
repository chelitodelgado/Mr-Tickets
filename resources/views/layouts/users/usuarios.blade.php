@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <div class="card mb-4 wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
        <div class="card-body d-sm-flex justify-content-between">
            <h4 class="mb-2 mb-sm-0 pt-1">
                <a href="/home">Inicio</a>
                <span>/</span>
                <span>Usuarios</span>
            </h4>
        </div>
    </div>
@stop

@section('content')
    <div class="row">

        <div class="col-12 col-sm-12">

            <div class="card-body bg bg-light">
                <button id="addUsers" class="btn btn-primary">Agregar un usuario</button>
            </div>

        </div>

        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title">Usuarios registrados</h3>
                </div>
                <div class="box-body no-padding" id="users">
                    <table id="tableUsers" class="table ">
                        <thead class="thead-light">
                            <tr>
                                <th style="width: 10%">Fotografia</th>
                                <th style="width: 30%">Nombre</th>
                                <th style="width: 20%">Status</th>
                                <th style="width: 40%">Rol</th>
                                <th style="width: 10%;" class="text-center">Acción</th>
                            </tr>
                        </thead>
                    </table>
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

            // Rellenar la tabla de usuarios
            $("#tableUsers").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('usuarios.index') }}",
                "columns":[
                    {
                        "data": "profile_pic",
                        render: function(data, type, full, meta){
                           return "<img src={{asset('fotos/')}}/"+data+" width='70' class='img-thumbnail' />"
                        },
                        orderable: false
                    },
                    { "data": "name" },
                    { "data": "status" },
                    { "data": "role" },
                    { "data": "action" }
                ]
            });

            /* Abrir ventana modal */
            $('#addUsers').click(function(){
                $('#usersForm')[0].reset();
                $('.modal-title').text("Agregar un nuevo usuario");
                $('#action_button').val("Agregar");
                $('#action').val("Agregar");
                $('#usersModal').modal('show');
            });

            // Agregar nuevo usuario y actualizar
            $('#usersForm').on('submit', function(event){
                event.preventDefault();

                if($('#action').val() == 'Agregar'){
                    $.ajax({
                        url:"{{ route('usuarios.store' )}}",
                        method:"POST",
                        data:new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: "json",
                        success:function(data){

                            if(data.errors){

                                for(var count = 0; count < data.errors.length; count++){
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops...',
                                        footer: '<p>'+data.errors[count]+'</p>'
                                    })
                                }
                            }
                            if(data.success){
                                console.log(data.success);
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Usuario agregada correctamente.',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#usersForm')[0].reset();
                                $('#tableUsers').DataTable().ajax.reload();
                            }
                        }
                    })
                }
                if($('#action').val() == "Editar"){
                    $.ajax({
                        url:"{{ route('usuarios.update') }}",
                        method:"POST",
                        data:new FormData(this),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType:"json",
                        success:function(data){

                            if(data.errors){
                                for(var count = 0; count < data.errors.length; count++){
                                    Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Comprueba la información'
                                    })
                                }

                            }
                            if(data.success){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Usuario actualizado correctamente.',
                                })
                                $('#usersForm')[0].reset();
                                $('#usersModal').modal('hide');
                                $('#tableUsers').DataTable().ajax.reload();
                            }
                        }
                    });
                }

            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $.ajax({
                    url:"usuarios/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#name').val(html.data.name);
                        $('#username').val(html.data.username);
                        $('#email').val(html.data.email);
                        $('#password').val(html.data.password);
                        $('#status').val(html.data.status);
                        $('#role').val(html.data.role);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Editar categoria");
                        $('#action_button').val("Editar");
                        $('#action').val("Editar");
                        $('#usersModal').modal('show');
                    }
                })
            });

            var users_id;
            $(document).on('click', '.delete', function(){

                users_id = $(this).attr('id');

                Swal.fire({
                    title: 'Estas seguro de eliminar a este usuario?',
                    showCancelButton: true,
                    confirmButtonText: `Si`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'usuarios/destroy/'+users_id,
                            success:function(data){
                                $('#tableUsers').DataTable().ajax.reload();
                                Swal.fire('Usuario eliminada', '', 'success');
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Estas seguro de no guardar', '', 'info')
                    }
                })
            });

        });
    </script>
@stop

<div id="usersModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg bg-light">
                <h5 class="modal-title">Agregar un nuevo usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="usersForm" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-6">
                            <label class="m-0">* Nombre:</label>
                            <input id="name" type="text" class="form-control m-1"
                                 name="name" placeholder="Nombre:" autofocus required />
                        </div>

                        <div class="col-md-6">
                            <label class="m-0">* Username:</label>
                            <input id="username" type="text" class="form-control m-1"
                                 name="username" placeholder="Username:" required />
                        </div>

                        <div class="col-md-6">
                            <label class="m-0">* Email:</label>
                            <input id="email" type="text" class="form-control m-1"
                                 name="email" placeholder="Email:" required />
                        </div>

                        <div class="col-md-6">
                            <label class="m-0">* Contraseña:</label>
                            <input id="password" type="password" class="form-control m-1"
                                 name="password" placeholder="Contraseña:" required />
                        </div>

                        <div class="col-md-6">
                            <label class="m-0">* Estatus:</label>
                            <select name="status" id="status" class="form-control m-1">
                                <option value="Habilitada">Habilitada</option>
                                <option value="Desabilitada">Desabilitada</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="m-0">* Rol:</label>
                            <select name="role" id="role" class="form-control m-1">
                                <option value="Usuario">Usuario</option>
                                <option value="Administrador">Administrador</option>
                            </select>
                        </div>

                        <div class="col-md-12" id="fotografia">
                            <label class="m-0">Imagen de perfil:</label>
                            <input type="file" name="profile_pic" id="profile_pic" class="form-control m-1">
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <br>
                            <input type="hidden" name="action" id="action" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="submit" name="action_button"
                                id="action_button" class="btn btn-block btn-primary" value="Agregar" />
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
