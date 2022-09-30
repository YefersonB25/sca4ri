@extends('adminlte::page')

@section('title', 'Profesores')

@section('content_header')
    <h1 class="text-center" style="text-decoration: underline">Profesores</h1>
@stop

@section('content')


<div class="row">
    <div class="col-md-3">
        <button class="btn btn-primary mb-3" target="" id="disparador-crear">
            Importar datos <i class="fas fa-plus"></i>
        </button>
        <button class="btn btn-warning mb-3" target="" id="disparador-crearpr">
            Nuevo profesor  <i class="fas fa-plus"></i>
        </button>
        {{-- <a href="{{ route('admin.log') }}" class="btn btn-info mb-3"><i class="fas fa-file-alt"></i> Log</a> --}}
    </div>
</div>

<div class="card" id="oculto-crear" style="display: none">
    <h3 class="text-center" style="text-decoration: underline">Importar datos</h3>
    <div class="card-body"> 
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">Profesores colegio</a>
            </li>
            <li class="nav-item" role="presentation">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profesores universidades</a>
            </li>
        </ul>

        <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <form  method="post" action="{{ route('import.profesorC') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 col-md-3">
                        <input type="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file" required>
                        <div class="invalid-feedback">
                            Seleccione un documento excel
                        </div>
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" id="btnImportar" class="btn btn-success">
                            Importar
                        </button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                <form  method="post" action="{{ route('import.profesorU') }}" class="needs-validation" novalidate enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3 col-md-3">
                        <input type="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file" required>
                        <div class="invalid-feedback">
                            Seleccione un documento excel
                        </div>
                        <div id="progressbar" class="progress mt-3" hidden>
                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-3 col-md-3">
                        <button type="submit" id="btnImportar" class="btn btn-success">
                            Importar
                        </button>
                    </div>
                </form>
            </div>
        </div>
          
    </div>
</div> 

<div class="card" id="oculto-crearform" style="display: none">
    <h3 class="text-center" style="text-decoration: underline">Crear Profesor</h3>
    <div class="card-body">         
        <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                <div class="card-body">
                    <form  method="post" action="{{route('profesores.store')}}" class="row g-3 needs-validation" novalidate>
                        @csrf
                        <div class="col-md-4">
                            <label for="validationCustom01" class="form-label">Nombre</label>
                            <input type="text" placeholder="nombre..." name="name" class="form-control" id="validationCustom01" value="" required onkeyup="mayus(this);">
                            <div class="invalid-feedback">
                                Ingrese nombre.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="validationCustom03" class="form-label">N° de documento</label>
                            <input type="text" placeholder="0000000000" name="numdoc" class="form-control" id="validationCustom03" required>
                            <div class="invalid-feedback">
                                Ingrese N° de documento.
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label for="validationCustom05" class="form-label">Empresa</label>
                            <select name="empresa" class="form-control tipo_destinon" id="validationCustom01" value="" required>
                                <option value="">Seleccione...</option>
                                <option value="1">Colegio</option>
                                <option value="2">Universidad</option>
                            </select>
                            <div class="invalid-feedback">
                                Seleccione empresa.
                            </div>
                        </div>
                    
                        <div class="col-md-6" style="margin-top:20px">
                            <label for="validationCustom01" class="form-label nn">Establecimiento</label>
                            <select name="" class="form-control n0" id="validationCustom01" value="" required>
                                <option value="" placeholder="seleccione..."></option> 
                            </select> 

                            <select name="dane_empresa" style="display: none" class="form-control n1" id="validationCustom04" value="" required>
                                <option value="">Seleccione...</option>
                                @foreach ($colegios as $col)
                                    <option value="{{$col->col_dane_colegio}}">{{$col->col_nombre}}</option>
                                @endforeach
                            </select> 

                            <select name="dane_empresa" style="display: none" class="form-control n2" id="validationCustom05" value="" required>
                                <option value="">Seleccione...</option>
                                @foreach ($universidades as $uni)
                                    <option value="{{$uni->uni_codigo}}">{{$uni->uni_nombre}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-12">
                            <br>
                            <button class="btn btn-success" type="submit">Guardar<i class="fas fa-save"></i></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> 
<div class="card">
    <div class="card-body"> 
        <table id="example" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre profesor</th>
                    <th>Documento</th>
                    <th>Institución</th>
                    <th>Tipo de profesor</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($profesores as $profesor)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $profesor->profe_nombre }}</td>
                        <td>{{ $profesor->profe_numerodoc }}</td>
                        @if ($profesor->empresa == 1)
                            <td>{{ $profesor->empresanombre->col_dane_colegio }}</td>
                        @else
                            <td>{{ $profesor->empresanombre->uni_codigo }}</td>
                        @endif
                        @if ($profesor->empresa == 1)
                            <td>Colegio</td>
                        @else
                            <td>Universidad</td>
                        @endif
                        <td>
                            <a href="{{ route('profesores.edit',$profesor->id) }}" class="btn-editar">
                                <img class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-edit-interface-kiranshastry-lineal-color-kiranshastry-2.png"/>
                            </a>
                            <a onclick="deleteItem(this)" class="btn-eliminar" data-id="{{ $profesor->id }}">
                                <img  class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-delete-multimedia-kiranshastry-lineal-color-kiranshastry.png"/>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Nombre profesor</th>
                    <th>Documento</th>
                    <th>Dane institucion</th>
                    <th>Tipo de profesor</th>
                    <th>Acciones</th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>        

@endsection

@include('shared.footer')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
    <style>
        .loop{
            font-weight: bold;
        }
        .opciones:hover {
        transform: scale(1.11);
        transform: rotate(360deg);
        transition: all 0.3s ease-in-out;
        }
        .btn-editar{
            border: transparent;
        }
        .btn-ver{
            border: transparent;
        }
        .btn-eliminar{
            border: transparent;
        }
        .sidebar-dark-white{
            background-color: #0b5cb3 !important;
            color: white !important;
        }
   </style>

@stop

@section('js')
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>   
    
    @if(session('mensageimport') == 'ok')
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: 'Profesores creado correctamente'
            })
        </script>
    @endif

    <script>
        // tablas
        $('#example').DataTable({
            responsive: true,
            autoWidth: true,

            "language": {
                "lengthMenu": "Mostrando _MENU_ registros por página",
                "zeroRecords": "No hay registro - disculpa",
                "info": "Mostrando la página _PAGE_ de _PAGES_",
                "infoEmpty": "No hay coincidencias",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                'search': "Buscar:",
                'paginate': {
                    'next': "Siguiente",
                    'previous': "Anterior"
                } 
            }

        });
    </script>
    
    {{-- validacion de creacion --}}
    <script>

        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
                }

                if(form.checkValidity())
                {
                    $('#btnImportar').html(
                        `<div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                        </div> Importando...`
                    )
                }

                form.classList.add('was-validated')
            }, false)
            })
        })()

    </script>

    <script>
        $("#disparador-crear").click(function() {
            if( $("#oculto-crear").css("display") == 'none' ) 
            $("#oculto-crear").show("slow");
            else
            $("#oculto-crear").hide("slow");
            
        });
    </script>

    <script>
        $("#disparador-crearpr").click(function() {
            if( $("#oculto-crearform").css("display") == 'none' )
            $("#oculto-crearform").show("slow");
            else
            $("#oculto-crearform").hide("slow");

        });

    </script>

    <script>

        $('.tipo_destinon').change(function() {
                if($('.tipo_destinon option:selected').val() == 1) {

                    if( $(".n1").css("display") == 'none' ){
                        $(".n0").hide("slow").prop('required', false).attr('disabled','disabled');
                        $(".n2").hide("slow").prop('required', false).attr('disabled','disabled');
                        $(".n1").show("slow").prop('required', true).removeAttr('disabled');
                    } else{
                        $(".n1").hide("slow").prop('required', false).attr('disabled','disabled');
                    }
                    
                }
                if($('.tipo_destinon option:selected').val() == 2) {

                    if( $(".n2").css("display") == 'none' ){ 
                        $(".n0").hide("slow").prop('required', false).attr('disabled','disabled');
                        $(".n1").hide("slow").prop('required', false).attr('disabled','disabled');
                        $(".n2").show("slow").prop('required', true).removeAttr('disabled');
                    } else{
                        $(".n2").hide("slow").prop('required', false).attr('disabled','disabled');
                    }

                }
                if($('.tipo_destinon option:selected').val() == '') {

                    if( $(".n0").css("display")){
                        $(".n0").show("slow").prop('required', true).removeAttr('disabled');
                        $(".n1").hide("slow").prop('required', false).attr('disabled','disabled');
                        $(".n2").hide("slow").prop('required', false).attr('disabled','disabled');
                    } else{
                        $(".n0").hide("slow").prop('required', false).attr('disabled','disabled');
                    }

                }
        
        });


    </script>

    <script>
        function mayus(e) {
            e.value = e.value.toUpperCase();
        }
    </script>

    <script>
        function deleteItem(e){

            let id = e.getAttribute('data-id');

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: '¿Está seguro?',
                text: "Este registro se eliminará definitivamente",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, eliminalo!',
                cancelButtonText: 'No, cancelar!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    if (result.isConfirmed){

                        $.ajax({
                            type:'DELETE',
                            url:'{{url("/profesor/delete")}}/' +id,
                            data:{
                                "_token": "{{ csrf_token() }}",
                            },
                            success:function(data) {
                                if (data.success){
                                    const Toast = Swal.mixin({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    didOpen: (toast) => {
                                        toast.addEventListener('mouseenter', Swal.stopTimer)
                                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                                    }
                                })

                                Toast.fire({
                                    icon: 'success',
                                    title: 'Profesor eliminado correctamente'
                                })
                                    $("#"+id+"").remove(); // you can add name div to remove
                                }
                                
                            }
                        });
                        window.setTimeout(function(){location.reload()},3000)
                    }
                } 
            });
        }
    </script>
@stop