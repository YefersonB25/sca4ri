@extends('adminlte::page')

@section('title', 'Semillero')

@section('content_header')
    <h1 class="text-center">Cursos</h1>
@stop

@section('content')

@if (in_array(Auth::user()->usuario_rolid, $rolesPermitidos))

    <button class="btn btn-primary mb-3" target="" id="disparador-crear">
        Crear curso <i class="fas fa-plus"></i>
    </button>
   
    <div class="card" id="oculto-crear" @if (count($errors) == 0)
        style="display: none"
        @endif>
        <h3 class="text-center" style="text-decoration: underline">Crear curso</h3>
        <div class="card-body"> 
            <form  method="post" action="{{ route('semilleros.guardar') }}" class="needs-validation" novalidate>
                @csrf
                <div class="col-md-3 pl-0">
                    <div class="mb-3">
                        <label for="">Nombre curso</label>
                        <input type="text" name="sem_nombre" class="form-control" value="{{ old('sem_nombre') }}">
                        @error('sem_nombre')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="">Seleccionar profesor</label>
                            <select class="custom-select" name="sem_profeid">
                                <option value="">Seleccionar profesor</option>
                                @foreach ($profesores as $profesor)
                                    <option value="{{ $profesor->id }}" @if(old('sem_profeid') == $profesor->id) selected @endif>
                                        {{ $profesor->profe_nombre }} - @if ($profesor->empresa == 1) Colegio @else Universidad @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('sem_profeid')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="">Fecha de inicio</label>
                            <input type="date" name="sem_fechainicio" class="form-control" value="{{ old('sem_fechainicio') }}" min="{{ date('Y-m-d') }}">
                            @error('sem_fechainicio')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="">Fecha de finalizacion</label>
                            <input type="date" name="sem_fechafin" class="form-control" value="{{ old('sem_fechafin') }}" min="{{ date('Y-m-d') }}">
                            @error('sem_fechafin')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="mb-3">
                            <label for="">Seleccionar grupo estudiantes</label>
                            <select class="custom-select" name="sem_grupo_est">
                                <option value="">Seleccionar grupo estudiantes</option>
                                @foreach ($grupoEstudiantesAsig as $grupo)
                                    <option value="{{ $grupo->id }}" @if(old('sem_grupo_est') == $grupo->id) selected @endif>
                                        {{ $grupo->est_asig_nombre_grupo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sem_grupo_est')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="mb-3">
                            <label for="">Seleccionar grupo de monitores</label>
                            <select class="custom-select" name="sem_grupo_uni">
                                <option value="">Seleccionar grupo universitarios</option>
                                @foreach ($grupoUniversitariosAsig as $grupo)
                                    <option value="{{ $grupo->id }}" @if(old('sem_grupo_uni') == $grupo->id) selected @endif>
                                        {{ $grupo->uni_asig_nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('sem_grupo_uni')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                            <input type="hidden" name="listaObjetivosAsignados" value="{{ old('listaObjetivosAsignados') }}" id="listaObjetivosAsignados">
                        </div>
                    </div>
                    
                </div>
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="">Descripcion del curso</label>
                        <textarea name="sem_descripcion" id="" cols="30" rows="3" class="form-control">{{ old('sem_descripcion') }}</textarea>
                        @error('sem_descripcion')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="row">
                    <div class="mb-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Modulo</h5>
                                <table class="dt table table-striped table-hover dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Categoria</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Asignar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($objetivos as $objetivo)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $objetivo->objetivo_categoria }}</td>
                                                <td>{{ $objetivo->objetivo_nombre }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info py-0" data-toggle="tooltip" data-placement="top" title="{{ $objetivo->objetivo_descripcion }}">...</button>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="objetivos" id="{{ $objetivo->id }}" value="{{ $objetivo->id }}">
                                                        <label class="custom-control-label" for="{{ $objetivo->id }}"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Categoria</th>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Asignar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 col-md-6">
                        <div class="card">
                            <div class="card-body">
                                @error('listaObjetivosAsignados')
                                    <small class="text-danger">Debe seleccionar 1 o mas objetivos</small>
                                @enderror
                                <h5>Modulos seleccionados</h5>
                                <table class="dt table table-striped table-hover dt-responsive" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Asignar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($objetivos as $objetivo)
                                            <tr hidden>
                                                <td>{{ $objetivo->objetivo_nombre }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-info py-0" data-toggle="tooltip" data-placement="top" title="{{ $objetivo->objetivo_descripcion }}">...</button>
                                                </td>
                                                <td>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" name="objetivos-asignados" id="obj-{{ $objetivo->id }}" value="{{ $objetivo->id }}">
                                                        <label class="custom-control-label" for="obj-{{ $objetivo->id }}"></label>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th scope="col">Nombre</th>
                                            <th scope="col">Descripcion</th>
                                            <th scope="col">Asignar</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 col-md-3">
                    <button type="submit" class="btn btn-success" id="btnGuardarLista">
                        Crear <i class="fa fa-fw fa-plus"></i>
                    </button>
                </div>
            </form>
        </div>
    </div> 
@endif

<div class="card">
    <div class="card-body"> 
        <h5>Cursos</h5>
        <table class="dt table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de finalizacion</th>
                    <th>Estado</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($semilleros as $semillero)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $semillero->sem_nombre }}</td>
                        <td>{{ $semillero->sem_fechainicio }}</td>
                        @if ($semillero->sem_fechafin == date('Y-m-d'))
                            
                            <td class="fecha" onclick="myFunction()" id="fecha">{{ $semillero->sem_fechafin }}</td>
                        @else
                            <td>{{ $semillero->sem_fechafin }}</td>
                        @endif
                        <td>
                            @if ($semillero->sem_estado === 'Activo' )
                                <span class="badge badge-info">Activo</span>
                            @elseif ($semillero->sem_estado === 'En espera')
                                <span class="badge badge-warning">En espera</span>
                            @else
                                <span class="badge badge-success">Finalizado</span>    
                            @endif
                        <td>
                            <a href="{{ route('semilleros.ver', $semillero->id) }}" class="btn-ver">
                                <img class="opciones" src="https://img.icons8.com/color/27/000000/visible--v1.png"/>
                            </a>
                            @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == $semillero->sem_grupo_profe)
                                <a href="{{ route('semilleros.edit', $semillero->id) }}" class="btn-editar">
                                    <img class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-edit-interface-kiranshastry-lineal-color-kiranshastry-2.png"/>
                                </a>
                                <a onclick="deleteItem(this)" class="btn-eliminar" data-id="{{ $semillero->id }}">
                                    <img  class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-delete-multimedia-kiranshastry-lineal-color-kiranshastry.png"/>
                                </a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Fecha de inicio</th>
                    <th>Fecha de finalizacion</th>
                    <th>Estado</th>
                    <th>Ver</th>
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
        .btn-ver{
            border: transparent;
        }
        .btn-eliminar{
            border: transparent;
        }
        .sidebar-dark-white{
            background-color: #0b5cb3 !important;
            color: white !important;
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
                title: 'Semillero creado correctamente'
            })
             
        </script>
    @endif
    {{-- <script>
        document.getElementById('.card').contentWindow.location.reload();
    </script> --}}

   

    <script>
        let idObjetivosSeleccionados = []

        $('#btnGuardarLista').on('click', function(e){
            $('#listaObjetivosAsignados').val(idObjetivosSeleccionados)
        })
        // activar tooltip 
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
        // tablas
        $('.dt').DataTable({
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

        $("#disparador-crear").click(function() {
            if( $("#oculto-crear").css("display") == 'none' ) 
            $("#oculto-crear").show("slow");
            else
            $("#oculto-crear").hide("slow");
            
        });

        function remove(arr, item) {
            for(var i = arr.length; i--;) {
                if(arr[i] === item) {
                    arr.splice(i, 1);
                }
            }
        }

        $('#sem_objetivo').change(function(){
            if(this.value != '')
            {
                let idObjetivo = this.value

                $.ajax({
                    url: 'api/objetivo/objetivoCategoria',
                    method: 'POST',
                    data: {idObjetivo},
                    success: function(response) {
                        let objetivos = JSON.parse(response.objetivos[0].objetivos)
                        let i = 1

                        $('#tbodyObjetivos').html('')
                        objetivos.forEach(objetivo => {
                            let plantillaObjetivo = 
                            `
                            <tr>
                                <td>${i}</td>
                                <td>${objetivo.nombre}</td>
                            </tr>
                            `
                            $('#tbodyObjetivos').append(plantillaObjetivo)
                            i++
                        })
                    }
                })
            }
        })

        /** obtenemos todos los input checkBox name=objetivos */
        document.getElementsByName("objetivos").forEach(checkBox => {

            /** asignamos el evento click al input checkBox name=objetivos */
            checkBox.addEventListener('click', function (){

                if(this.checked)
                {
                    let trObjAsig = document.getElementById(`obj-${this.id}`).parentNode.parentNode.parentNode
                    let checkBoxObjAsig = document.getElementById(`obj-${this.id}`)

                    checkBoxObjAsig.checked = true
                    trObjAsig.hidden = false                                   


                    document.getElementsByName("objetivos-asignados").forEach(checkBox => {

                        /** asignamos el evento click al input checkBox name=asignados */
                        checkBox.addEventListener('click', function (){

                            if(this.checked == false)
                            {
                                let idCheckBox = this.id.split('-')[1]
                                document.getElementById(idCheckBox).checked = false

                                let trObjAsig = document.getElementById(this.id).parentNode.parentNode.parentNode                                                
                                trObjAsig.hidden = true                                  

                                remove(idObjetivosSeleccionados, this.value)                          
                            }
                        })
                    })

                    idObjetivosSeleccionados.push(this.value)
                }
                else
                {
                    let idCheckBox = `obj-${this.id}`
                    document.getElementById(idCheckBox).checked = false
                    document.getElementById(idCheckBox).parentNode.parentNode.parentNode.hidden = true

                    remove(idObjetivosSeleccionados, this.value)                                   
                }

                console.log(idObjetivosSeleccionados);
            })
        })
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
                            url:'{{url("/semilleros/delete")}}/' +id,
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
                                    title: 'Semillero eliminado correctamente'
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

    <script>

        $(document).ready(function(){
            $(".fecha").click();
        });
        function myFunction(){

            Swal.fire({
                icon: 'info',
                title: 'Oops...',
                text: '¡Uno o más semilleros finalizan el día de hoy según la fecha establecida!',
                footer: 'De un vistaso'
            })

        }
        
    </script>

@stop