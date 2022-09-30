@extends('adminlte::page')

@section('title', 'Editar usuario')


@section('content')

@if (session('info'))
    <div class="alert alert-success" id="alertrol">
        <strong> {{ session('info') }} </strong>
    </div>
@endif

<h3 style="text-align: center; text-decoration: underline ;" >Agregar Permisos</h3>
<div class="card" id="oculto-crear ">
    <div class="card-body">
        <form  method="post" {{--action="{{ route('bodegas') }}"--}} class="row g-3 needs-validation" novalidate>
            @csrf
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Nombre de operador</label>
                <input type="text" placeholder="nombres y apellidos" name="name" class="form-control" id="validationCustom01" value="{{$user->name}}" readonly required>
                <div class="invalid-feedback">
                    Ingrese nombre de operador.
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom02" class="form-label">Celular</label>
                <input type="text" placeholder="00000000000..." name="usuario_telefono" onkeypress="return valideKey(event);" maxlength="10" class="form-control" readonly id="validationCustom02" value="{{$user->usuario_telefono}}" required>
                <div class="invalid-feedback">
                    Ingrese # de celular de operador.
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustomUsername" class="form-label">Correo de operador</label>
                <div class="input-group has-validation">
                <span class="input-group-text" id="inputGroupPrepend">@</span>
                <input type="email" placeholder="user@ejemplo.com" name="email" class="form-control" id="validationCustomUsername" readonly aria-describedby="inputGroupPrepend" value = "{{$user->email}}" required>
                <div class="invalid-feedback">
                    Ingrese un correo valido de operador.
                </div>
                </div>
            </div>
        </form>
        <br>
            <label for="validationCustomUsername" class="form-label">Permisos</label>
            {!! Form::model($user, ['route' => ['usuarios.users.update', $user], 'method' => 'put']) !!}

            @foreach ($roles as $role)
                <div>
                    <p>
                        {!! Form::checkbox('roles[]', $role->id, null, ['class' => 'mr-1']) !!}
                        @php
                            switch ($role->name) {
                                case 'Monitor universitario':
                                    echo 'Monitor';
                                break;
                                case 'Decano':
                                    echo 'Rector';
                                break;
                                default:
                                    echo $role->name;
                                break;
                            }  
                        @endphp
                    </p>
                </div>
            @endforeach
                <br>
            {!! Form::submit('Asignar', ['class' => 'btn btn-success mt-2 ']) !!}
            <a href="{{ route('usuarios.index') }}" class="btn btn-danger mt-2" >Volver </a>
            {!! Form::close() !!}
    </div>
</div>

@endsection

@include('shared.footer')

@section('css')
    <style>
        .sidebar-dark-white{
            background-color: #0b5cb3 !important;
            color: white !important;
        }
    </style>
@stop

@section('js')


    <script type="text/javascript">
        setTimeout(() => {
            $('#alertrol').hide()
        }, 3500);
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


    {{-- modal de eliminar --}}
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
                            url:'{{url("/bodegas/delete")}}/' +id,
                            data:{
                                "_token": "{{ csrf_token() }}",
                            },
                            success:function(data) {
                                if (data.success){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Perfecto...',
                                        text: 'Registro eliminado Correctamente.',
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

@stop
