@extends('adminlte::page')
@section('title', 'Categorias')
@section('content_header')
    <div class="card mb-4 wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
        <div class="card-body d-sm-flex justify-content-between">
            <h4 class="mb-2 mb-sm-0 pt-1">
                <a href="/home">Inicio</a>
                <span>/</span>
                <span>Categorias</span>
            </h4>
        </div>
    </div>
@stop
@section('content')
    <div class="row">
        <div class="col-12 col-sm-12">

            <div class="card-body bg bg-light">
                <button id="addCategory" class="btn btn-primary">Crear categoria</button>
                <hr>
                <table id="tableCategory" class="table ">
                    <thead class="thead-light">
                        <tr>
                            <th style="width: 40%">Nombre</th>
                            <th style="width: 50%">Descripción</th>
                            <th style="width: 10%;" class="text-center">Acción</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>

        <div class="clearfix hidden-md-up"></div>

    </div>
@stop
@section('css')
    {{-- <link rel="stylesheet" href="{{ asset('css/admin_custom.css') }}"> --}}
@stop
@section('js')
    <script>
        $(document).ready( function(){

            // Rellenar la tabla de categorias
            $("#tableCategory").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('categorias.index') }}",
                "columns":[
                    { "data": "name" },
                    { "data": "description" },
                    { "data": "action" }
                ]
            });

            /* Abrir ventana modal */
            $('#addCategory').click(function(){
                $('#categoryForm')[0].reset();
                $('.modal-title').text("Agregar una nueva categoria");
                $('#action_button').val("Agregar");
                $('#action').val("Agregar");
                $('#categoryModal').modal('show');
            });

            // Agregar nuevo empleado y actualizar
            $('#categoryForm').on('submit', function(event){
                event.preventDefault();

                if($('#action').val() == 'Agregar'){
                    $.ajax({
                        url:"{{ route('categorias.store' )}}",
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
                                    title: 'Categoria agregada correctamente.',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#categoryForm')[0].reset();
                                $('#tableCategory').DataTable().ajax.reload();
                            }
                        }
                    })
                }
                if($('#action').val() == "Editar"){
                    $.ajax({
                        url:"{{ route('categorias.update') }}",
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
                                    title: 'Categoria actualizada correctamente.',
                                })
                                $('#categoryForm')[0].reset();
                                $('#categoryModal').modal('hide');
                                $('#tableCategory').DataTable().ajax.reload();
                            }
                        }
                    });
                }

            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                $.ajax({
                    url:"categorias/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#name').val(html.data.name);
                        $('#description').val(html.data.description);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Editar categoria");
                        $('#action_button').val("Editar");
                        $('#action').val("Editar");
                        $('#categoryModal').modal('show');
                    }
                })
            });

            var category_id;
            $(document).on('click', '.delete', function(){

                category_id = $(this).attr('id');

                Swal.fire({
                    title: 'Estas seguro de eliminar esta categoria?',
                    showCancelButton: true,
                    confirmButtonText: `Si`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'categorias/destroy/'+category_id,
                            success:function(data){
                                $('#tableCategory').DataTable().ajax.reload();
                                Swal.fire('Categoria eliminada', '', 'success');
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

<div id="categoryModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg bg-light">
                <h5 class="modal-title">Agregar una nueva categoria</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="categoryForm" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <label class="m-0">Nombre de la categoria:</label>
                            <input id="name" type="text" class="form-control m-1"
                            name="name" placeholder="Nombre:" value="{{old('name')}}" autofocus required/>
                            @error('name')
                                <div class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
                        </div>

                        <div class="col-md-12">
                            <label class="m-0">Descripción de la categoria:</label>
                            <textarea name="description" id="description" value="{{old('description')}}" class="form-control m-1"
                            rows="3" placeholder="Descripción:" required></textarea>
                            @error('description')
                                <div class="invalid-feedback">
                                    <strong>{{$message}}</strong>
                                </div>
                            @enderror
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
