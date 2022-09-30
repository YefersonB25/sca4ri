@extends('adminlte::page')

@section('title', 'Universitarios')

@section('content_header')
    <h1 class="text-center">{{ $nombreUniversidad }}</h1>
    <h4 class="text-center">SEDE - {{ $nombreSede }}</h4>
    <h5 class="text-center">SEMESTRE {{ $semestreNombre }}°</h4>
@stop

@section('content')

<div class="row">
    <div class="col-md-3">
        <button class="btn btn-primary mb-3" target="" id="disparador-crear">
            Agregar  <i class="fas fa-plus"></i>
        </button>
    </div>
</div>


<div class="card" id="oculto-crear" style="display: none">
    <h3 style="text-align: center; text-decoration: underline ;" >Agregar usuarios</h3>
    <div class="card-body">
        <form  method="post" action="{{route('universitarios.store')}}" class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="col-md-3">
                <label for="validationCustom01" class="form-label">Nombre 1</label>
                <div class="input-group has-validation">
                <input type="text" placeholder="nombre..." name="nombre1" class="form-control" id="validationCustom01" value=""  onkeyup="mayus(this);" required>
                <div class="invalid-feedback">
                    Ingrese nombre 1.
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="validationCustom02" class="form-label">Nombre 2</label>
                <input type="text" placeholder="nombre..." name="nombre2" class="form-control" id="validationCustom02" value=""  onkeyup="mayus(this);">
                <div class="invalid-feedback">
                    Ingrese nombre 2.
                </div>
            </div>
            <div class="col-md-3">
                <label for="validationCustom03" class="form-label">Apellido 1</label>
                <div class="input-group has-validation">
                <input type="text" placeholder="apellido..." name="apellido1" class="form-control" id="validationCustom03" value=""  onkeyup="mayus(this);" required>
                <div class="invalid-feedback">
                    Ingrese apellido 1.
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Apellido 2</label>
                <input type="text" placeholder="apellido..." name="apellido2" class="form-control" id="validationCustom04" value=""  onkeyup="mayus(this);">
                <div class="invalid-feedback">
                    Ingrese apellido 2.
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Tipo de documento</label>
                <div class="input-group has-validation">
                <select name="tipodoc" class="form-control" id="validationCustom05" value="" required>
                    <option value="">Seleccione...</option>
                    @foreach ($tipodocumento as $tipodoc)
                    <option value="{{$tipodoc->tipodoc_nombre}}">{{$tipodoc->tipodoc_nombre}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                   Ingrese tipo de documento.
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom06" class="form-label">N° de documento</label>
                <div class="input-group has-validation">
                <input type="text" placeholder="0000000000" name="numerodoc" onkeypress="return valideKey(event);" class="form-control" id="validationCustom06" required>
                <div class="invalid-feedback">
                    Ingrese N° de documento.
                </div>
                </div>
            </div>
            
            <input type="hidden" name="uni_carreraid" value="{{ $uni->uni_carreraid }}">
            <input type="hidden" name="uni_semestreid" value="{{ $uni->uni_semestreid }}">
            
            <div class="col-md-12">
                <br>
                <button class="btn btn-success" type="submit">Guardar <i class="fas fa-save"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body"> 
        <h5>Universitarios</h5>
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
                @foreach ($universitarios as $universitario)
                    <tr>
                        <td class="loop">{{ $loop->iteration }}</td>
                        <td>{{ $universitario->uni_nombre_1}} {{ $universitario->uni_nombre_2 }}</td>
                        <td>{{ $universitario->uni_tipodoc }}</td>
                        <td>{{ $universitario->uni_numerodoc }}</td>
                        <td>
                            <a href="{{ route('universitarios.edit',$universitario->id) }}" class="btn-editar">
                                <img class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-edit-interface-kiranshastry-lineal-color-kiranshastry-2.png"/>
                            </a>
                            <a onclick="deleteItem(this)" class="btn-eliminar" data-id="{{ $universitario->id }}">
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
        .btn-ver{
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
    

    @if(session('new') == 'ok')
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
                title: 'Universitario creado correctamente'
            })
        </script>

    @endif

    @if(session('mensajedit') == 'ok')
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
                title: 'Objetivo Editado correctamente'
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

            form.classList.add('was-validated')
        }, false)
        })
        })()

    </script>

    <script type="text/javascript">
        function valideKey(evt){
            
            // code is the decimal ASCII representation of the pressed key.
            var code = (evt.which) ? evt.which : evt.keyCode;
            
            if(code==8) { // backspace.
            return true;
            } else if(code>=48 && code<=57) { // is a number.
            return true;
            } else{ // other keys.
            return false;
            }
        };
        $('input[name=operador_nombre]').bind('keypress', function(event) {
            var regex = new RegExp("^[a-zA-Z ]+$");
            var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
            if (!regex.test(key)) {
            event.preventDefault();
            return false;
            }
        });
    </script>


    <script>
        $("#disparador-crear").click(function() {
            if( $("#oculto-crear").css("display") == 'none' )
            $("#oculto-crear").show("slow");
            else
            $("#oculto-crear").hide("slow");

        });

        $("#disparador-nav").click(function() {
            if( $("#nav-oculta").css("display") == 'none' )
            $("#nav-oculta").show("slow");
            else
            $("#nav-oculta").hide("slow");

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
                            url:'{{url("/Universidades/delete")}}/' +id,
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
                                    title: 'Universitario eliminado correctamente'
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