@extends('adminlte::page')

@section('title', 'editar')

@section('content')

<div class="card" id="oculto-crear">
    <h3 style="text-align: center; text-decoration: underline ;" >Editar curso</h3>
    <div class="card-body">
        <form  method="post" action="{{route('semilleros.update', $semillero->id)}}" class="row g-3 needs-validation" novalidate>
            @csrf
            {{ method_field('PUT') }}
            <div class="col-md-3">
                <label for="validationCustom01" class="form-label">Nombre</label>
                <div class="input-group has-validation">
                <input type="text" placeholder="nombre..." name="sem_nombre" class="form-control" id="validationCustom01" value="{{ $semillero->sem_nombre }}" required>
                <div class="invalid-feedback">
                    Ingrese nombre.
                </div>
                </div>
            </div>
            <div class="col-md-3">
                <label for="">Profesor</label>
                <select class="custom-select" name="sem_profeid" required>
                    <option value="">Seleccionar...</option>
                    @foreach ($profesores as $profesor)
                        <option value="{{ $profesor->id }}" @if(old('sem_profeid') == $profesor->id || $profesor->id == $semillero->sem_grupo_profe) selected @endif>
                            {{ $profesor->profe_nombre }} - @if ($profesor->empresa == 1) Colegio @else Universidad @endif
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Debe selecionar el profesor.
                </div>
            </div>
            <div class="col-md-3">
                <label for="">Grupo de estudiantes</label>
                <select class="custom-select" name="sem_grupo_est" required>
                    <option value="">Seleccionar...</option>
                    @foreach ($gruposest as $est)
                        <option value="{{ $est->id }}" @if(old('sem_grupo_est') == $est->id || $est->id == $semillero->sem_grupo_est) selected @endif>
                            {{ $est->est_asig_nombre_grupo }} 
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Debe selecionar el grupo.
                </div>
            </div>
            <div class="col-md-3">
                <label for="">Grupo de ayudantes universitarios</label>
                <select class="custom-select" name="sem_grupo_uni" required>
                    <option value="">Seleccionar...</option>
                    @foreach ($gruposuni as $uni)
                        <option value="{{ $uni->id }}" @if(old('sem_grupo_uni') == $uni->id || $uni->id == $semillero->sem_grupo_uni) selected @endif>
                            {{ $uni->uni_asig_nombre }} 
                        </option>
                    @endforeach
                </select>
                <div class="invalid-feedback">
                    Debe selecionar el grupo.
                </div>
            </div>
            
            <div class="col-md-3 mt-3">
                <div class="mb-3">
                    <label for="">Fecha de inicio</label>
                    <input type="date" name="sem_fechainicio" class="form-control" id="validationCustom01" value="{{ $semillero->sem_fechainicio }}" min="{{ $semillero->sem_fechainicio }}" required>
                    <div class="invalid-feedback">
                        Ingrese fecha de inicio.
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-3">
                <div class="mb-3">
                    <label for="">Fecha de finalización</label>
                    <input type="date" name="sem_fechafin" class="form-control" id="validationCustom01" value="{{ $semillero->sem_fechafin }}" min="{{ $semillero->sem_fechainicio }}" required>
                    <div class="invalid-feedback">
                        Ingrese fecha de fin mayor a la de inicio.
                    </div>
                </div>
            </div>
            <div class="col-md-3 mt-3">
                <label for="">Estado</label>
                <select class="custom-select" name="sem_estado" required>
                    <option value="">Seleccionar...</option>
                    {{-- <option value="Activo" @if(old('sem_estado') == Activo || Activo == $semillero->sem_estado) selected @endif> Activo </option> --}}
                    <option value="Activo" {{($semillero->sem_estado === 'Activo') ? 'Selected' : ''}}> Activo </option>
                    <option value="En espera" {{($semillero->sem_estado === 'En espera') ? 'Selected' : ''}}> En espera </option>
                    <option value="Finalizado" {{($semillero->sem_estado === 'Finalizado') ? 'Selected' : ''}}> Finalizado </option>
                </select>
                <div class="invalid-feedback">
                    Debe selecionar el estado.
                </div>
            </div>
            <div class="col-md-12 mt-3">
                <label for="">Descripcion del semillero</label>
                <textarea name="sem_descripcion" id="" rows="2" class="form-control" required>{{ $semillero->sem_descripcion }}</textarea>
                <div class="invalid-feedback">
                    Ingrese descripción del semillero.
                </div>
            </div>
            <div class="col-md-12">
                <br>
                <button class="btn btn-success" type="submit">Guardar <i class="fas fa-save"></i></button>
                <a class="btn btn-danger" onclick="window.location.href = document.referrer">Cancelar</a>
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
                title: 'Semillero Editado correctamente'
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