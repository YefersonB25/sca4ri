@extends('adminlte::page')

@section('title', 'editar')

@section('content')

<div class="card" id="oculto-crear">
    <h3 style="text-align: center; text-decoration: underline ;" >Editar </h3>
    <div class="card-body">
        <form  method="post" action="{{route('universitarios.update', $universitario->id)}}" class="row g-3 needs-validation" novalidate>
            @csrf
            {{ method_field('PUT') }}
            <div class="col-md-3">
                <label for="validationCustom01" class="form-label">Nombre 1</label>
                <div class="input-group has-validation">
                <input type="text" placeholder="nombre..." name="nombre1" class="form-control" id="validationCustom01" value="{{ $universitario->uni_nombre_1 }}"  onkeyup="mayus(this);" required>
                <div class="invalid-feedback">
                    Ingrese nombre 1.
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="validationCustom02" class="form-label">Nombre 2</label>
                <input type="text" placeholder="nombre..." name="nombre2" class="form-control" id="validationCustom02" value="{{ $universitario->uni_nombre_2 }}"  onkeyup="mayus(this);">
                <div class="invalid-feedback">
                    Ingrese nombre 2.
                </div>
            </div>
            <div class="col-md-3">
                <label for="validationCustom03" class="form-label">Apellido 1</label>
                <div class="input-group has-validation">
                <input type="text" placeholder="apellido..." name="apellido1" class="form-control" id="validationCustom03" value="{{ $universitario->uni_apellido_1 }}"  onkeyup="mayus(this);" required>
                <div class="invalid-feedback">
                    Ingrese apellido 1.
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="validationCustom04" class="form-label">Apellido 2</label>
                <input type="text" placeholder="apellido..." name="apellido2" class="form-control" id="validationCustom04" value="{{ $universitario->uni_apellido_2 }}"  onkeyup="mayus(this);">
                <div class="invalid-feedback">
                    Ingrese apellido 2.
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <label for="validationCustom05" class="form-label">Tipo de documento</label>
                <div class="input-group has-validation">
                <select name="tipodocumento" class="form-control" id="validationCustom05" value="" required>
                    <option value="">Seleccione...</option>

                    @foreach ($tipodocumento as $tipodoc)
                        <option value="{{ $tipodoc->tipodoc_nombre }}" @if(old('tipodocumento') == $tipodoc->tipodoc_nombre || $tipodoc->tipodoc_nombre == $universitario->uni_tipodoc) selected @endif>{{ $tipodoc->tipodoc_nombre }}</option>
                    @endforeach
                    {{-- @foreach ($tipodocumento as $tipodoc)
                    <option value="{{$tipodoc->tipodoc_nombre}}">{{$tipodoc->tipodoc_nombre}}</option>
                    @endforeach --}}
                </select>
                <div class="invalid-feedback">
                   Ingrese tipo de documento.
                </div>
                </div>
            </div>
            <div class="col-md-4 mt-3">
                <label for="validationCustom06" class="form-label">N° de documento</label>
                <div class="input-group has-validation">
                <input type="text" placeholder="0000000000" value="{{ $universitario->uni_numerodoc }}" name="numerodoc" onkeypress="return valideKey(event);" class="form-control" id="validationCustom06" required>
                <div class="invalid-feedback">
                    Ingrese N° de documento.
                </div>
                </div>
            </div>

            <input type="hidden" name="uni_carreraid" value="{{ $universitario->uni_carreraid }}">
            <input type="hidden" name="uni_semestreid" value="{{ $universitario->uni_semestreid }}">

            <div class="col-md-12">
                <br>
                <button class="btn btn-success" type="submit">Guardar <i class="fas fa-save"></i></button>
                <a class="btn btn-danger" href="javascript: history.go(-1)">Cancelar</a>
            </div>
        </form>
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

   </style>

@stop

@section('js')

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

            window.setTimeout(function(){history.go(-1)},3000)
        </script>
    @endif

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
        function mayus(e) {
            e.value = e.value.toUpperCase();
        }
    </script>

@stop
