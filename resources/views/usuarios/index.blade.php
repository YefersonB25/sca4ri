@extends('adminlte::page')

@section('title', 'Usuarios')

@section('content_header')
    <h1 style="text-align: center; text-decoration: underline ;" >Usuarios</h1>
@stop
{{-- @if (Auth::user()->usuario_rolid == 1) --}}
@section('content')

<div class="row">
    <div class="col-md-3">
        <button class="btn btn-primary mb-3" target="" id="disparador-crear">
            Nuevo usuario  <i class="fas fa-plus"></i>
        </button>
        <a href="{{ route('admin.log') }}" class="btn btn-info mb-3"><i class="fas fa-file-alt"></i> Log</a>
    </div>
</div>


<div class="card" id="oculto-crear" style="display: none">
    <h3 style="text-align: center; text-decoration: underline ;" >Agregar usuarios</h3>
    <div class="card-body">
        <form  method="post" action="{{route('usuarios')}}" class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Nombre</label>
                <input type="text" placeholder="nombre..." name="name" class="form-control" id="validationCustom01" value="" required>
                <div class="invalid-feedback">
                    Ingrese nombre.
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom03" class="form-label">Tipo de documento</label>
                <select name="tipodoc" class="form-control" id="validationCustom01" value="" required>
                    <option value="">Seleccione...</option>
                    @foreach ($tipodocumento as $tipodoc)
                    <option value="{{$tipodoc->id}}">{{$tipodoc->tipodoc_nombre}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                   Ingrese tipo de documento.
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
                <label for="validationCustom03" class="form-label">Telefono</label>
                <input type="text" placeholder="0000000000" name="usuario_telefono" class="form-control" id="validationCustom03" required>
                <div class="invalid-feedback">
                    Ingrese Telefono.
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Rol</label>
                <select name="rol" class="form-control" id="validationCustom01" value="" required>
                    <option value="">Seleccione...</option>
                    @foreach ($roles as $rol)
                    <option value="{{$rol->id}}">{{$rol->name}}</option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Ingrese rol.
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustomUsername" class="form-label">Correo</label>
                <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="email" placeholder="user@ejemplo.com" name="email" class="form-control" id="validationCustomUsername" aria-describedby="inputGroupPrepend" required>
                <div class="invalid-feedback">
                    Ingrese un correo valido de operador.
                </div>
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom05" class="form-label">Contraseña</label>
                <input type="password" placeholder="**********" minlength="8" name="password" class="form-control" id="validationCustom05" required>
                <div class="invalid-feedback">
                    La contraseña debe tener al menos 8 caracteres.
                </div>
            </div>
            <div class="col-md-12">
                <br>
                <button class="btn btn-success" type="submit">Guardar <i class="fas fa-save"></i></button>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table id="example" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Tipo documento</th>
                    <th>N° documento</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $usu)
                    <tr>
                        <td class="loop" >{{$loop->iteration}}</td>
                        <td>{{$usu->name}}</td>
                        <td>{{$usu->usuario_telefono}}</td>
                        <td>{{$usu->email}}</td>
                        <td>{{ !empty($usu->tipodocc->tipodoc_nombre) ? $usu->tipodocc->tipodoc_nombre : ''}}</td>
                        <td>{{$usu->numerodoc}}</td>
                        <td>{{$usu->role->name}}</td>
                        <td>{{$usu->estado == 1 ? 'Activo' : 'Inactivo'}}</td>
                        <td>
                            <a href="{{ route('usuarios.users.edit',$usu) }}" class="btn-editar" id="">
                                <img class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-edit-interface-kiranshastry-lineal-color-kiranshastry-2.png"/>
                            </a>
                            <a onclick="deleteItem(this)" class="btn-eliminar" data-id="{{ $usu->id }}">
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
                    <th>Celular</th>
                    <th>Correo</th>
                    <th>Tipo documento</th>
                    <th>N° documento</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th></th>
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
        .btn-eliminar{
            border: transparent;
        }

        .sidebar-dark-white{
            background-color: #0b5cb3 !important;
            color: white !important;
        }

        [data-title]:hover:after {
            opacity: 1;
            transition: all 0.1s ease 0.5s;
            visibility: visible;
        }
        [data-title]:after {
            content: attr(data-title);
            background-color: #333;
            color: #fff;
            font-size: 14px;
            font-family: Raleway;
            position: absolute;
            padding: 3px 20px;
            /* bottom: -0.5em; */
            /* left: 80%; */
            white-space: nowrap;
            box-shadow: 1px 1px 3px #222222;
            opacity: 0;
            border: 1px solid #111111;
            z-index: 99999;
            visibility: hidden;
            border-radius: 6px;
            cursor: help;

        }
        [data-title] {
            position: relative;
        }

        :root {
            --color-green: #06b600;
            --color-red: #c01d00;
            --color-button: #fdffff;
            --color-black: #000;
        }
        .switch-button {
            display: inline-block;
        }
        .switch-button .switch-button__checkbox {
            display: none;
        }
        .switch-button .switch-button__label {
            background-color: var(--color-red);
            width: 4rem;
            height: 2.5rem;
            border-radius: 1.3rem;
            display: inline-block;
            position: relative;
            top: 1.4rem;
            cursor:pointer

        }
        .switch-button .switch-button__label:before {
            transition: .2s;
            display: block;
            position: absolute;
            width: 2.5rem;
            height: 2.5rem;
            background-color: var(--color-button);
            content: '';
            border-radius: 50%;
            box-shadow: inset 0px 0px 0px 1px var(--color-black);
        }
        .switch-button .switch-button__checkbox:checked + .switch-button__label {
            background-color: var(--color-green);
        }
        .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
            transform: translateX(2rem);
        }

        .modal{
            background-color: opacity(2.5) !important;
        }

        .bgimg-modal{
            background-image: url('https://images3.alphacoders.com/260/thumb-1920-260789.jpg')
        }
    </style>

@stop

@section('js')

    @if(session('mensajeOk') == 'ok')
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
                title: 'Usuario creado correctamente'
            })
        </script>
    @endif

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
        $('input[type="checkbox"]').change(function(){
            $(this).val(Number(this.checked));
            console.log($(this).val());
        });
    </script>

    @if(session('eliminar') == 'ok')
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Perfecto...',
            text: 'Registro eliminado Correctamente.',
            showConfirmButton: false,
            timer: 2600
        })
    </script>
    @endif

    @if(session('update') == 'ok')
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Perfecto...',
            text: 'Registro editado Correctamente.',
            showConfirmButton: false,
            timer: 2600
        })
    </script>

    @endif

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

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
                            url:'{{url("/usuarios/delete")}}/' +id,
                            data:{
                                "_token": "{{ csrf_token() }}",
                            },
                            success:function(data) {
                                if (data.success){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Perfecto...',
                                        text: 'Usuario eliminado Correctamente.',
                                        showConfirmButton: false,
                                        // timer: 2600
                                    })
                                    $("#"+id+"").remove(); // you can add name div to remove
                                }

                            }
                        });
                        window.setTimeout(function(){location.reload()},2200)
                    }
                }
            });
        }
    </script>

    {{-- modal editar --}}
    <script>


    </script>
@stop
