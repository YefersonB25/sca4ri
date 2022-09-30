@extends('adminlte::page')

@section('title', 'editar')

@section('content')

<div class="card" id="oculto-crear">
    <h3 style="text-align: center; text-decoration: underline ;" >Editar </h3>
    <div class="card-body">
        <form  method="post" action="{{route('profesores.update', $profesor->id)}}" class="row g-3 needs-validation" novalidate>
            @csrf
            {{ method_field('PUT') }}
            <div class="col-md-4">
                <label for="validationCustom01" class="form-label">Nombre</label>
                <input type="text" placeholder="nombre..." name="name" class="form-control" id="validationCustom01" value="{{$profesor->profe_nombre}}" required onkeyup="mayus(this);">
                <div class="invalid-feedback">
                    Ingrese nombre.
                </div>
            </div>
            <div class="col-md-4">
                <label for="validationCustom03" class="form-label">N° de documento</label>
                <input type="text" placeholder="0000000000" name="numdoc" class="form-control" onkeypress="return valideKey(event);" id="validationCustom03" value="{{$profesor->profe_numerodoc}}" required>
                <div class="invalid-feedback">
                    Ingrese N° de documento.
                </div>
            </div>

            <div class="col-md-4">
                {{-- {{$profesor->empresa}} --}}
                <label for="validationCustom05" class="form-label">Empresa</label>
                @if ($profesor->empresa == 1)
                <input type="text" placeholder="0000000000" name="empresa" class="form-control" readonly id="validationCustom03" value="Colegio" required>
                @else
                <input type="text" placeholder="0000000000" name="empresa" class="form-control" readonly id="validationCustom03" value="Universidad" required>
                @endif
            </div> 
            
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
                title: 'Profesor Editado correctamente'
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

    <script>

        $('.tipo_destinon').change(function() {
            if($('.tipo_destinon option:selected').val() == 'Colegio') {

                if( $(".n1").css("display") == 'none' ){
                    $(".n0").hide("slow").prop('required', false).attr('disabled','disabled');
                    $(".n2").hide("slow").prop('required', false).attr('disabled','disabled');
                    $(".n1").show("slow").prop('required', true).removeAttr('disabled');
                } else{
                    $(".n1").hide("slow").prop('required', false).attr('disabled','disabled');
                }
                
            }
            if($('.tipo_destinon option:selected').val() == 'Universidad') {

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
        $('input[name=name]').bind('keypress', function(event) {
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