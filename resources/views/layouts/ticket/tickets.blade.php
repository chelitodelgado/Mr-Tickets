@extends('adminlte::page')

@section('title', 'Reportes')

@section('content_header')
    <div class="card mb-4 wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
        <div class="card-body d-sm-flex justify-content-between">
            <h4 class="mb-2 mb-sm-0 pt-1">
                <a href="/home">Inicio</a>
                <span>/</span>
                <span>Reportes</span>
            </h4>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12">

            <div class="card-body bg bg-light">
                <button id="addTicket" class="btn btn-primary">Crear un reporte</button>
                <hr>
                <table id="tableTicket" class="table ">
                    <thead class="thead-light">
                        <tr>
                            <th>Titulo</th>
                            <th>Descripción</th>
                            <th>Tipo</th>
                            <th>Usuario</th>
                            <th>Proyecto</th>
                            <th>Categoria</th>
                            <th>Prioridad</th>
                            <th>Status</th>
                            <th>Acción</th>
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

            // TODO: Render para limitar el numero de caracteres de un campo en espesifico.
            $.fn.dataTable.render.ellipsis = function ( cutoff ) {
                return function ( data, type, row ) {
                    if ( type === 'display' ) {
                        var str = data.toString(); // cast numbers

                        return str.length < cutoff ?
                            str :
                            str.substr(0, cutoff-1) +'&#8230;';
                    }

                    // Search, order and type can use the original data
                    return data;
                };
            };

            $("#tableTicket").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('tickets.index') }}",
                "columns":[
                    { "data": "title" },
                    { "data": "description", "render": $.fn.dataTable.render.ellipsis( 35 ) },
                    { "data": "kind" },
                    { "data": "nombre" },
                    { "data": "project" },
                    { "data": "category" },
                    { "data": "priority" },
                    { "data": "status" },
                    { "data": "action" }
                ]
            });

            /* Abrir ventana modal */
            $('#addTicket').click(function(){
                $('#ticketForm')[0].reset();
                $('.modal-title').text("Agregar un nuevo reporte");
                $('#action_button').val("Agregar");
                $('#action').val("Agregar");
                $('#ticketModal').modal('show');
            });

            $('#ticketForm').on('submit', function(event){
                event.preventDefault();

                if($('#action').val() == 'Agregar'){
                    $.ajax({
                        url:"{{ route('tickets.store' )}}",
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
                                    title: 'Ticket agregado correctamente.',
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                $('#ticketForm')[0].reset();
                                $('#tableTicket').DataTable().ajax.reload();
                            }
                        }
                    })
                }
                if($('#action').val() == "Editar"){
                    $.ajax({
                        url:"{{ route('tickets.update') }}",
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
                                    title: 'Ticket actualizado correctamente.',
                                })
                                $('#ticketForm')[0].reset();
                                $('#ticketModal').modal('hide');
                                $('#tableTicket').DataTable().ajax.reload();
                            }
                        }
                    });
                }

            });

            $(document).on('click', '.edit', function(){
                var id = $(this).attr('id');
                // console.log(id);
                $.ajax({
                    url:"tickets/"+id+"/edit",
                    dataType:"json",
                    success:function(html){
                        $('#title').val(html.data.title);
                        $('#description').val(html.data.description);
                        $('#kind_id').val(html.data.kind_id);
                        $('#user_id').val(html.data.user_id);
                        $('#project_id').val(html.data.project_id);
                        $('#category_id').val(html.data.category_id);
                        $('#priority_id').val(html.data.priority_id);
                        $('#status_id').val(html.data.status_id);
                        $('#hidden_id').val(html.data.id);
                        $('.modal-title').text("Editar reporte");
                        $('#action_button').val("Editar");
                        $('#action').val("Editar");
                        $('#ticketModal').modal('show');
                    }
                })
            });

            var ticket_id;
            $(document).on('click', '.delete', function(){

                ticket_id = $(this).attr('id');

                Swal.fire({
                    title: 'Estas seguro de eliminar este reporte?',
                    showCancelButton: true,
                    confirmButtonText: `Si`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'tickets/destroy/'+ticket_id,
                            success:function(data){
                                $('#tableTicket').DataTable().ajax.reload();
                                Swal.fire('Reporte eliminado', '', 'success');
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Estas seguro?', '', 'info')
                    }
                })
            });

        });
    </script>
@stop

<div id="ticketModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg bg-light">
                <h5 class="modal-title">Agregar un nuevo reporte</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" id="ticketForm" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-12">
                            <label class="m-0">Titulo</label>
                            <input id="title" type="text" class="form-control m-1 @error('title') is-invalid @enderror"
                                 name="title" value="{{ old('title') }}" placeholder="Titulo" autofocus required />
                                 @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="m-0">Descripción:</label>
                            <textarea name="description" id="description" class="form-control m-1 @error('description') is-invalid @enderror"
                            rows="2" value="{{ old('description') }}" placeholder="Descripción:" required></textarea>
                            @error('description')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="m-0 @error('user_id') is-invalid @enderror">Asignar a un usuario:</label>
                            <select class="form-control" name="user_id" id="user_id" required>
                                <option>Asignar a un usuario</option>
                                @foreach ($users as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                              @error('user_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label class="m-0">Asignar proyecto:</label>
                            <select class="form-control" name="project_id" id="project_id" required>
                                <option>Asignar proyecto</option>
                                @foreach ($project as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="col-md-6">
                            <label class="m-0">Tipo de reporte:</label>
                            <select class="form-control" name="kind_id" id="kind_id" required>
                                <option>Seleccione un tipo</option>
                                @foreach ($kind as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="col-md-6">
                            <label class="m-0">Categoria:</label>
                            <select class="form-control" name="category_id" id="category_id" required>
                                <option>Seleccione una categoria</option>
                                @foreach ($category as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="col-md-6">
                            <label class="m-0">Prioridad:</label>
                            <select class="form-control" name="priority_id" id="priority_id" required>
                                <option>Seleccione la prioridad</option>
                                @foreach ($priority as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="col-md-6">
                            <label class="m-0">Status:</label>
                            <select class="form-control" name="status_id" id="status_id" required>
                                <option>Seleccione el status</option>
                                @foreach ($status as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                        </div>

                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
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
