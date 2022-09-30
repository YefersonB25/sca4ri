@extends('adminlte::page')

@section('title', 'Estudiantes')

@section('content_header')
    <h1 class="text-center">{{ $nombreColegio }}</h1>
    <h4 class="text-center">SEDE - {{ $nombreSede }}</h4>
    <h5 class="text-center">CURSO {{ $cursoNombre }}</h4>
@stop

@section('content')
<button class="btn btn-primary mb-3" target="" id="disparador-crear">
    Registrar nuevo estudiante <i class="fas fa-user-plus"></i>
</button> 

<div class="card" id="oculto-crear" @if (count($errors) == 0) style="display: none" @endif>
    <h3 class="text-center"></h3>
    <div class="card-body"> 
        <form  method="post" action="{{ route('estudiantes.guardar') }}" class="needs-validation" novalidate>
            @csrf
            <div hidden>
                <input type="text" name="grupo" value="{{ $idGrupo }}">
            </div>

            @php
                if(count($errors) > 0)
                {
                    print_r($errors);
                }
            @endphp
            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="">Primer nombre</label>
                    <input type="text" name="primer_nombre" class="form-control" @error('primer_nombre') value="{{ old('primer_nombre') }}" @enderror required>
                    @error('primer_nombre')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="">Segundo nombre</label>
                    <input type="text" name="segundo_nombre" class="form-control" @error('segundo_nombre') value="{{ old('segundo_nombre') }}" @enderror>
                </div>
                <div class="col-md-3">
                    <label for="">Primer apellido</label>
                    <input type="text" name="primer_apellido" class="form-control" @error('primer_apellido') value="{{ old('primer_apellido') }}" @enderror required>
                    @error('primer_apellido')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="">Segundo apellido</label>
                    <input type="text" name="segundo_apellido" class="form-control" @error('segundo_apellido') value="{{ old('segundo_apellido') }}" @enderror>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-auto">
                    <label for="">Tipo de documento</label>
                    <select class="custom-select" name="tipo_documento" @error('tipo_documento') value="{{ old('tipo_documento') }}" @enderror required>
                        <option value="">Seleccione una opcion</option>
                        @foreach ($tiposDocumentos as $tipoDocumento)                            
                            <option value="{{ $tipoDocumento->tipodoc_nombre }}">{{ $tipoDocumento->tipodoc_nombre }}</option>
                        @endforeach
                    </select>
                    @error('tipo_documento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-auto">
                    <label for="">Numero documento</label>
                    <input type="text" name="numero_documento" pattern="[0-9]+" class="form-control" @error('numero_documento') value="{{ old('numero_documento') }}" @enderror required>
                    @error('numero_documento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3 px-0">
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body"> 
        <h5>Estudiantes</h5>
        <table id="example" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Tipo de documento</th>
                    <th>Numero de documento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estudiantes as $estudiante)
                    <tr>
                        <td class="loop">{{ $loop->iteration }}</td>
                        <td>{{ $estudiante->est_nombre_1 }} {{ $estudiante->est_apellido_1 }}</td>
                        <td>{{ $estudiante->est_tipodoc }}</td>
                        <td>{{ $estudiante->est_numerodoc }}</td>
                        <td>
                            <a href="{{ route('estudiantes.editar', $estudiante->id) }}" class="btn-editar">
                                <img class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-edit-interface-kiranshastry-lineal-color-kiranshastry-2.png"/>
                            </a>
                            <a onclick="deleteItem(this)" class="btn-eliminar" data-id="{{ $estudiante->id }}">
                                <img  class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-delete-multimedia-kiranshastry-lineal-color-kiranshastry.png"/>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Tipo de documento</th>
                    <th>Numero de documento</th>
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
        .sidebar-dark-white{
            background-color: #0b5cb3 !important;
            color: white !important;
        }
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
        .btn-eliminar{
            border: transparent;
        }
   </style>

@stop

@section('js')    

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

    @if(session('guardar') == 'guardado')
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
                title: 'El estudiante ha sido creado'
            })
        </script>
    @endif

    @if(session('eliminar') == 'eliminado')
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
                title: 'El estudiante ha sido eliminado'
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

        $("#disparador-crear").click(function() {
            if( $("#oculto-crear").css("display") == 'none' ) 
            $("#oculto-crear").show("slow");
            else
            $("#oculto-crear").hide("slow");
            
        });

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

                form.classList.add('was-validated')
            }, false)
            })
        })()

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
                            url:'{{url("estudiante/eliminar/")}}/' +id,
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
                                    title: 'Estudiante eliminado correctamente'
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