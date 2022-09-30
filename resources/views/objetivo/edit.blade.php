@extends('adminlte::page')

@section('title', 'Editar objetivos')

{{-- @section('content_header')
    <h1 class="text-center">Objetivos</h1>
@stop --}}

@section('content')

<div class="card">
    <h3 class="text-center">Editar modulo</h3>
    <div class="card-body"> 
        <form  method="post" action="{{ route('objetivos.update', $objetivo->id) }}" class="needs-validation" novalidate>
            @csrf
            {{ method_field('PUT') }}

            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="col-md-3">
                            <label for="">Categoria</label>
                            <input type="text" name="categoria" class="form-control" value=" {{$objetivo->objetivo_categoria}} ">
                            @error('categoria')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-7">
                            <label for="">Nombre</label>
                            <input type="text" name="nombreObj" class="form-control" value=" {{$objetivo->objetivo_nombre}} " required>
                        </div>
                        <div class="col-md-7">
                            <label for="">Descripcion</label>
                            <textarea name="descripcionObj" rows="6" class="form-control"  required> {{$objetivo->objetivo_descripcion}} </textarea>
                        </div>
                    </div>
                </div>
            </div>
                
            <div class="mb-3 col-md-3 px-0">
                <button type="submit" class="btn btn-success" id="btnGuardarLista">
                    Guardar <i class="fa fa-fw fa-save"></i>
                </button>
                <a href="{{ route('objetivos.index') }}" class="btn btn-danger" id="btnGuardarLista">
                    Cancelar <i class="fa fa-fw fa-times-circle"></i>
                </a>
            </div>
        </form>
    </div>
</div>

@endsection

@include('shared.footer')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .sidebar-dark-white{
            background-color: #0b5cb3 !important;
            color: white !important;
        }
        .loop{
            font-weight: bold;
        }
   </style>

@stop
@section('js')
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

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

    {{-- @if(session('mensajDelete') == 'ok')
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
                title: 'Objetivo eliminado correctamente'
            })
        </script>
    @endif --}}

    <script>
        let contidadObj = 0
        // activar tooltip
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

        $('.badge').on('click', function(e){
            e.preventDefault()
        })

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

        // $('#agregarObj').on('click', function(){
        //     let cardObjetivo = 
        //     `
        //         <div class="col-md-3">
        //             <div class="card">
        //                 <div class="card-body">
        //                     <div class="mb-3">
        //                         <label for="">Nombre objetivo</label>
        //                         <input type="text" name="nombreObj[]" class="form-control" required>
        //                     </div>
        //                     <div class="mb-3">
        //                         <label for="">Descripcion objetivo</label>
        //                         <textarea name="descripcionObj[]" rows="3" class="form-control" required></textarea>
        //                     </div>
                            
        //                     <button type="button" name="eliminarObj" onclick="eliminarElemento(event)" class="btn btn-danger">
        //                         Eliminar <i class="fas fa-times"></i>
        //                     </button>
        //                 </div>
        //             </div>
        //         </div>
        //     ` 
        //     if(contidadObj == 0)
        //     {
        //         $('#fsObj').animate({height: "331px"})
        //     }

        //     $('#fsObj').append(cardObjetivo)
        //     contidadObj++
        // })

        function eliminarElemento(event){
            let divObjetivos = event.originalTarget.parentNode.parentNode.parentNode.parentNode
            let card = event.originalTarget.parentNode.parentNode.parentNode

            if(card.classList[0] == 'card')
            {
                card.parentNode.outerHTML = ""
            }
            else
            {
                divObjetivos.removeChild(card)
            }
            contidadObj--

            if(contidadObj == 0)
            {
                $('#fsObj').animate({height: "0px"})
            }
        }

        document.getElementsByName('objetivos').forEach(element => {
            element.addEventListener('click', function(){
                let idObjetivo = this.id
                
                $.ajax({
                    url: 'api/objetivo/objetivoCategoria',
                    method: 'POST',
                    data: {idObjetivo},
                    success: function(response) {
                        let titulo = response.objetivos[0].objetivo_categoria
                        // console.log(response.objetivos[0]);
                        let objetivos = response.objetivos[0]

                        $('#modalBody')[0].innerHTML = ""
                        
                        let plantillaObjetivo = 
                        `
                            <h5 class="font-weight-bold">${response.objetivos[0].objetivo_nombre}</h5>
                            <p>${response.objetivos[0].objetivo_descripcion}</p>
                        `

                        $('#modalBody').append(plantillaObjetivo)
                        $('#modalTitle').text(titulo)
                    }
                })
            })
        })
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