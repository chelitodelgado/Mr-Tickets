@extends('adminlte::page')

@section('title', 'Proyectos')

@section('content_header')
    <div class="card mb-4 wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
        <div class="card-body d-sm-flex justify-content-between">
            <h4 class="mb-2 mb-sm-0 pt-1">
                <a href="/home">Inicio</a>
                <span>/</span>
                <span>Proyectos</span>
            </h4>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12">

            <div class="card-body bg bg-light">
                <button id="addProject" class="btn btn-primary">Crear un proyecto</button>
                <hr>
                <table id="tableProject" class="table ">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 30%">Nombre</th>
                            <th style="width: 50%">Descripción</th>
                            <th style="width: 20%">Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>

        <div class="clearfix hidden-md-up"></div>

    </div>
@stop

@section('css')
    <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}">
@stop

@section('js')
    <script>
        $(document).ready( function(){

            // Rellenar la tabla de proyectos
            $("#tableProject").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('proyectos.index') }}",
                "columns":[
                    { "data": "name" },
                    { "data": "description" },
                    { "data": "action" }
                ]
            });

            /* Abrir ventana modal */
            $('#addProject').click(function(){
                $('#projectForm')[0].reset();
                $('.modal-title').text("Agregar un nuevo proyecto");
                $('#action_button').val("Agregar");
                $('#action').val("Agregar");
                $('#projectModal').modal('show');
            });

            // Agregar nuevo empleado y actualizar
            $('#projectForm').on('submit', function(event){
                event.preventDefault();

                if($('#action').val() == 'Agregar'){
                    $.ajax({
                        url:"{{ route('proyectos.store' )}}",
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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Proyecto agregado correctamente.',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#projectForm')[0].reset();
                                $('#tableProject').DataTable().ajax.reload();
                            }
                        }
                    })
                }
                if($('#action').val() == "Editar"){
                    $.ajax({
                        url:"{{ route('proyectos.update') }}",
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
                                    title: 'Proyecto actualizado correctamente.',
                                })
                                $('#projectForm')[0].reset();
                                $('#projectModal').modal('hide');
                                $('#tableProject').DataTable().ajax.reload();
                            }
                        }
                    });
                }

            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                // console.log(id);
                $.ajax({
                    url:"proyectos/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#name').val(html.data.name);
                        $('#description').val(html.data.description);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Editar proyecto");
                        $('#action_button').val("Editar");
                        $('#action').val("Editar");
                        $('#projectModal').modal('show');
                    }
                })
            });

            var project_id;
            $(document).on('click', '.delete', function(){

                project_id = $(this).attr('id');

                Swal.fire({
                    title: 'Estas seguro de eliminar este proyecto?',
                    showCancelButton: true,
                    confirmButtonText: `Si`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'proyectos/destroy/'+project_id,
                            success:function(data){
                                $('#tableProject').DataTable().ajax.reload();
                                Swal.fire('Proyecto eliminado', '', 'success');
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

<div id="projectModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg bg-light">
                <h5 class="modal-title">Agregar un nuevo proyecto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="projectForm" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <label class="m-0">Nombre del proyecto:</label>
                            <input id="name" type="text" class="form-control m-1"
                                 name="name" placeholder="Nombre:" autofocus required />
                        </div>

                        <div class="col-md-12">
                            <label class="m-0">Descripción del proyecto:</label>
                            <textarea name="description" id="description" class="form-control m-1"
                            rows="3" placeholder="Descripción:" required></textarea>
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <input type="hidden" name="action" id="action" />
                            <input type="hidden" name="hidden_id" id="hidden_id" />
                            <input type="submit" name="action_button"
                                id="action_button" class="btn btn-warning" value="Agregar" />
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
