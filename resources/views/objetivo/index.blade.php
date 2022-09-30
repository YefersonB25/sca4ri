@extends('adminlte::page')

@section('title', 'Objetivos')

@section('content_header')
    <h1 class="text-center" style="text-decoration: underline">Modulos</h1>
@stop

@section('content')

<div class="card">
    <h3 class="text-center">Crear modulo</h3>
    <div class="card-body"> 
        <form  method="post" action="{{ route('objetivos.crear') }}" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3 px-0 col-md-3">
                <label for="">Categoria</label>
                <input type="text" name="categoria" class="form-control" value="{{ old('categoria') }}">
                @error('categoria')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-3 px-0 mb-3">
                <button type="button" id="agregarObj" class="btn btn-primary">
                    agregar <i class="fas fa-plus"></i>
                </button>
            </div>
            <div id="fsObj" class="row mb-3 pt-1" style="overflow: auto;">
                
            </div>
            <div class="mb-3 col-md-3 px-0">
                <button type="submit" class="btn btn-success" id="btnGuardarLista">
                    Crear <i class="fa fa-fw fa-plus"></i>
                </button>
            </div>
        </form>
        <div class="card">
            <div class="card-body">
                <h5>Modulos</h5>
                <table id="example" class="table table-striped table-hover dt-responsive">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($objetivos as $objetivo)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $objetivo->objetivo_categoria }}</td>
                                <td>{{ $objetivo->objetivo_nombre }}</td>
                                <td>
                                    <a href="{{ route('objetivos.edit',$objetivo->id) }}" class="btn-editar">
                                        <img class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-edit-interface-kiranshastry-lineal-color-kiranshastry-2.png"/>
                                    </a>
                                    <a onclick="deleteItem(this)" class="btn-eliminar" data-id="{{ $objetivo->id }}">
                                        <img  class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-delete-multimedia-kiranshastry-lineal-color-kiranshastry.png"/>
                                    </a>
                                    <a type="button" name="objetivos" id="{{ $objetivo->id }}" class="btn-ver" data-toggle="modal" data-target="#exampleModal">
                                        <img class="opciones" src="https://img.icons8.com/color/27/000000/visible--v1.png"/>
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Categoria</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-capitalize" id="modalTitle"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="modalBody" class="modal-body">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@include('shared.footer')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .loop{
            font-weight: bold;
        }
        .sidebar-dark-white{
            background-color: #0b5cb3 !important;
            color: white !important;
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
                title: 'Objetivo creado correctamente'
            })
        </script>
    @endif

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

        $('#agregarObj').on('click', function(){
            let cardObjetivo = 
            `
                <div class="col-md-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="">Nombre</label>
                                <input type="text" name="nombreObj[]" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="">Descripcion</label>
                                <textarea name="descripcionObj[]" rows="3" class="form-control" required></textarea>
                            </div>
                            
                            <button type="button" name="eliminarObj" onclick="eliminarElemento(event)" class="btn btn-danger">
                                Eliminar <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                </div>
            ` 
            if(contidadObj == 0)
            {
                $('#fsObj').animate({height: "331px"})
            }

            $('#fsObj').append(cardObjetivo)
            contidadObj++
        })

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
                            url:'{{url("/objetivos/delete")}}/' +id,
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
                                    title: 'Objetivo eliminado correctamente'
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