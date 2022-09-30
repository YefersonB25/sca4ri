@extends('adminlte::page')

@section('title', 'Estudiantes')

@section('content_header')
    <div></div>
@stop

@section('content')

<div class="card">
    <h3 class="text-center">Actualizar datos del estudiante</h3>
    <div class="card-body"> 
        <form  method="post" action="{{ route('estudiantes.actualizar') }}" class="needs-validation" novalidate>
            @csrf
            {{ method_field('PUT') }}
            <div hidden>
                <input type="text" name="estudiante" value="{{ $estudiante->id }}" required>
            </div>

            <div class="row mb-3">
                <div class="col-md-3">
                    <label for="">Primer nombre</label>
                    <input type="text" name="primer_nombre" class="form-control" value="{{ (old('primer_nombre') != null) ? old('primer_nombre') : $estudiante->est_nombre_1 }}"  required>
                    @error('primer_nombre')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="">Segundo nombre</label>
                    <input type="text" name="segundo_nombre" class="form-control" value="{{ (old('segundo_nombre') != null) ? old('segundo_nombre') : $estudiante->est_nombre_2 }}" >
                </div>
                <div class="col-md-3">
                    <label for="">Primer apellido</label>
                    <input type="text" name="primer_apellido" class="form-control" value="{{ (old('primer_apellido') != null) ? old('primer_apellido') : $estudiante->est_apellido_1 }}"  required>
                    @error('primer_apellido')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
                <div class="col-md-3">
                    <label for="">Segundo apellido</label>
                    <input type="text" name="segundo_apellido" class="form-control" value="{{ (old('segundo_apellido') != null) ? old('segundo_apellido') : $estudiante->est_apellido_2 }}">
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-md-auto">
                    <label for="">Tipo de documento</label>
                    <select class="custom-select" name="tipo_documento" required>
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
                    <input type="text" name="numero_documento" pattern="[0-9]+" class="form-control" value="{{ (old('numero_documento') != null) ? old('numero_documento') : $estudiante->est_numerodoc }}" required>
                    @error('numero_documento')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>
            </div>
            <div class="col-md-3 px-0">
                <button type="submit" class="btn btn-success">Guardar</button>
                <a href="javascript:history.go(-1)" class="btn btn-danger">Cancelar</a>
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
    @if(session('editar') == 'editado')
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
            title: 'Los datos del estudiante han sido editados'
        })
        window.setTimeout(function(){history.go(-1)},3000)
    </script>
    @endif

    <script>
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
@endsection