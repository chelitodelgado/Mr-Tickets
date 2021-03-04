@extends('adminlte::page')

@section('title', 'Tickets')

@section('content_header')
    <div class="card mb-4 wow fadeIn animated" style="visibility: visible; animation-name: fadeIn;">
        <div class="card-body d-sm-flex justify-content-between">
            <h4 class="mb-2 mb-sm-0 pt-1">
                <a href="/home">Inicio</a>
                <span>/</span>
                <span>Tickets</span>
            </h4>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12 col-sm-12">

            <div class="card-body bg bg-light">
                <button id="addTicket" class="btn btn-primary">Crear un ticket</button>
                <hr>
                <table id="tableTicket" class="table ">
                    <thead class="thead-light">
                        <tr>
                            <th>Titulo</th>
                            <th>Descripción</th>
                            <th>kind_id</th>
                            <th>user_id</th>
                            <th>project_id</th>
                            <th>category_id</th>
                            <th>priority_id</th>
                            <th>status_id</th>
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

            $("#tableTicket").DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('tickets.index') }}",
                "columns":[
                    { "data": "title" },
                    { "data": "description" },
                    { "data": "kind_id" },
                    { "data": "user_id" },
                    { "data": "project_id" },
                    { "data": "category_id" },
                    { "data": "priority_id" },
                    { "data": "status_id" },
                    { "data": "action" }
                ]
            });

            /* Abrir ventana modal */
            $('#addTicket').click(function(){
                $('#ticketForm')[0].reset();
                $('.modal-title').text("Agregar un nuevo ticket");
                $('#action_button').val("Agregar");
                $('#action').val("Agregar");
                $('#ticketModal').modal('show');
            });

            // Agregar nuevo empleado y actualizar
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
                        $('.modal-title').text("Editar proyecto");
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
                    title: 'Estas seguro de eliminar este ticket?',
                    showCancelButton: true,
                    confirmButtonText: `Si`,
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: 'tickets/destroy/'+ticket_id,
                            success:function(data){
                                $('#tableTicket').DataTable().ajax.reload();
                                Swal.fire('Ticket eliminado', '', 'success');
                            }
                        });
                    } else if (result.isDenied) {
                        Swal.fire('Estas seguro de no guardar', '', 'info')
                    }
                })
            });

            $('#kind_id').select2({
                placeholder: "Selecciona el tipo",
                allowClear: true,
                width: "100%",
                dropdownParent: $('#ticketModal'),
                tags: "true",
                allowClear: true
            });
            $('#project_id').select2({
                placeholder: "Asignar proyecto",
                allowClear: true,
                width: "100%"
            });
            $('#category_id').select2({
                placeholder: "Selecciona categoria",
                allowClear: true,
                width: "100%"
            });
            $('#priority_id').select2({
                placeholder: "Prioridad",
                allowClear: true,
                width: "100%"
            });
            $('#status_id').select2({
                placeholder: "Estado",
                allowClear: true,
                width: "100%"
            });

        });
    </script>
@stop

<div id="ticketModal" class="modal fade"tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg bg-light">
                <h5 class="modal-title">Agregar un nuevo ticket</h5>
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
                            <input id="title" type="text" class="form-control m-1"
                                 name="title" placeholder="Titulo" autofocus required />
                        </div>

                        <div class="col-md-12">
                            <label class="m-0">Descripción:</label>
                            <textarea name="description" id="description" class="form-control m-1"
                            rows="2" placeholder="Descripción:" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <select class="form-control" name="kind_id" id="kind_id" required>
                                <option></option>
                                @foreach ($kind as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="project_id" id="project_id" required>
                                <option></option>
                                @foreach ($project as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="category_id" id="category_id" required>
                                <option></option>
                                @foreach ($category as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="priority_id" id="priority_id" required>
                                <option></option>
                                @foreach ($priority as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
                        </div>
                        <div class="col-md-6">
                            <select class="form-control" name="status_id" id="status_id" required>
                                <option></option>
                                @foreach ($status as $item)
                                <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                              </select>
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
