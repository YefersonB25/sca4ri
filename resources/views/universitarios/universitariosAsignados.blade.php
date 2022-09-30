@extends('adminlte::page')

@section('title', 'CGM')

@section('content_header')
    <h1 class="text-center" style="text-decoration: underline">Universitarios</h1>
@stop

@section('content')
<button class="btn btn-primary mb-3" target="" id="disparador-crear">
    Crear grupo de monitores <i class="fas fa-plus"></i>
</button>

<div class="card" id="oculto-crear" style="display: none">
    <h3 class="text-center">Crear grupo de monitores</h3>
    <div class="card-body"> 
        <form  method="post" action="{{ route('universitarios.guardarAsignados') }}" class="needs-validation" id="fauSemillero" novalidate>
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="">Nombre del grupo</label>
                        <input type="text" name="uni_asig_nombre_grupo" id="uni_asig_nombre_grupo" class="form-control" minlength="4" placeholder="Ingrese un nombre de grupo" value="{{ old('uni_asig_nombre_grupo') }}">
                        @error('uni_asig_nombre_grupo')
                            <small class="text-danger" id="error_uni_asig_nombre_grupo2">{{ $message }}</small>
                        @enderror
                        <small class="text-danger" id="error_uni_asig_nombre_grupo"></small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md 3">
                    <div class="mb-3">
                        <label for="">Universidad</label>
                        <select class="custom-select" id="universidad" value="{{ old('universidad') }}">
                            <option value="">Seleccionar universidad</option>
                            @foreach ($universidades as $universidad)
                                <option value="{{ $universidad->id }}">{{ $universidad->uni_nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md 3">
                    <label for="">Sedes</label>
                    <select class="custom-select" id="sede">
                    </select>
                </div>
                <div class="col-md 3">
                    <label for="">Carrera</label>
                    <select class="custom-select" id="carrera">
                    </select>
                </div>
                <div class="col-md 3">
                    <label for="">Semestre</label>
                    <select class="custom-select" id="semestre">
                    </select>
                </div>

                <input type="hidden" id="listaUniversitariosAsignados" name="listaUniversitariosAsignados" value="{{ old('listaUniversitariosAsignados') }}">
            </div>
            <div class="mb-3 col-md-3 px-0">
                <button type="submit" class="btn btn-success" id="btnGuardarLista">
                    Crear <i class="fa fa-fw fa-plus"></i>
                </button>
            </div>
        </form>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <h5>Universitarios</h5>
                            <table class="table">
                                <thead>
                                  <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Tipo identificacion</th>
                                    <th scope="col">Identificacion</th>
                                    <th scope="col">asignar</th>
                                  </tr>
                                </thead>
                                <tbody id="tablaUniversitarios">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @error('listaUniversitariosAsignados')
                            <small class="text-danger">Debe seleccionar 1 o mas universitarios</small>
                        @enderror
                        <div class="table-responsive">
                            <table class="table">
                                <h5>Universitarios asignados</h5>
                                <thead>
                                  <tr>
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Tipo identificacion</th>
                                    <th scope="col">Identificacion</th>
                                  </tr>
                                </thead>
                                <tbody id="universitariosAsignados">
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Grupos de monitores</h5>
        <table class="dt table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Nombre del grupo</th>
                    <th scope="col">Creado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($grupos as $grupo)
                    <tr>
                        <td>{{ $grupo->uni_asig_nombre }}</td>
                        <td>
                            {{ $grupo->created_at }}
                        </td>
                        <td>
                            <a href="{{ route('universitarios.asignados.ver', $grupo->id) }}" class="btn-ver">
                                <img class="opciones" src="https://img.icons8.com/color/27/000000/visible--v1.png"/>
                            </a>
                            <a onclick="deleteItem(this)" class="btn-eliminar" data-id="{{ $grupo->id }}">
                                <img  class="opciones" src="https://img.icons8.com/external-kiranshastry-lineal-color-kiranshastry/27/000000/external-delete-multimedia-kiranshastry-lineal-color-kiranshastry.png"/>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">Nombre del objetivo</th>
                    <th scope="col">Creado</th>
                    <th scope="col">Acciones</th>
                </tr>
            </tfoot>
        </table>
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
        .opciones:hover {
        transform: scale(1.11);
        transform: rotate(360deg);
        transition: all 0.3s ease-in-out;
        }
        .sidebar-dark-white{
            background-color: #0b5cb3 !important;
            color: white !important;
        }
        .btn-eliminar{
            border: transparent;
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
                title: 'Grupo de monitores creado correctamente'
            })
        </script>
    @endif
    <script>
        
        $("#disparador-crear").click(function() {
            if( $("#oculto-crear").css("display") == 'none' ) 
            $("#oculto-crear").show("slow");
            else
            $("#oculto-crear").hide("slow");
            
        });

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

        let idUniversitariosSeleccionados = []
        let iUniversitariosAsignados = 0
        let plantillaTablaUniversitariosAsignados = ''

        $(document).ready(resetearFormulario());

        function resetearFormulario() 
        {
            document.getElementById('fauSemillero').reset();    
        }

        $('#btnGuardarLista').on('click', function(e){
            $('#listaUniversitariosAsignados').val(idUniversitariosSeleccionados)
        })

        $('#uni_asig_nombre_grupo').on('blur', function(e) {

            if(this.value != '' && this.value.length > 4)
            {
                let nombreGrupo = $('#uni_asig_nombre_grupo').val()
                $.ajax({
                    url: 'api/universidad/nombreGrupoAsignado',
                    method: 'POST',
                    data: {nombreGrupo},
                    success: (response) => {
                        let error = response.error

                        if(error == false)
                        {
                            $('#uni_asig_nombre_grupo').addClass('is-valid')
                            $('#uni_asig_nombre_grupo').removeClass('is-invalid')
                            $('#error_uni_asig_nombre_grupo').text('')
                        }
                        else
                        {
                            $('#uni_asig_nombre_grupo').hidden = true
                            $('#uni_asig_nombre_grupo').addClass('is-invalid')
                            $('#uni_asig_nombre_grupo').removeClass('is-valid')
                            $('#error_uni_asig_nombre_grupo').text(response.errorText.nombreGrupo)
                        }
                    }
                })
            }
            else
            {
                $('#uni_asig_nombre_grupo').removeClass('is-valid')
                $('#uni_asig_nombre_grupo').removeClass('is-invalid')
            }
        })

        /** evento select universidads 
        * obtiene sede del universidad seleccionado
        */
        $('#universidad').on('change', function(){
            let universidadId = this.value
            let opcionesSedes = []

            $('#sede').html('')
            $('#carrera').html('')
            $('#semestre').html('')
            $('#tablaUniversitarios').html('')

            if(universidadId != '')
            {
                $.ajax({
                    url: 'api/universidad/universidadSedes',
                    data: {universidadId},
                    method: 'post',
                    success: (response) => {
                        let sedes = response.sedes
                        let option = document.createElement("option");

                        option.value = ''
                        option.innerText = 'Selecionar sede'

                        opcionesSedes.push(option)

                        sedes.forEach(sede => {
                            let option = document.createElement("option");

                            option.value = sede.id
                            option.innerText = sede.sede_nombre

                            opcionesSedes.push(option)
                        });

                        $('#sede').html(opcionesSedes)
                    }
                })
            }
        })

        /** evento select sede 
        * obtiene carreras de la sede seleccionada
        */
        $('#sede').on('change', function(){
            let sedeId = this.value
            let opcionesCarrera = []

            $('#carrera').html('')
            $('#semestre').html('')
            $('#tablaUniversitarios').html('')

            if(sedeId != '')
            {
                $.ajax({
                    url: 'api/universidad/sedeCarrera',
                    data: {sedeId},
                    method: 'post',
                    success: (response) => {
                        let carreras = response.carreras
                        let option = document.createElement("option");

                        option.value = ''
                        option.innerText = 'Selecionar carrera'

                        opcionesCarrera.push(option)

                        carreras.forEach(carrera => {
                            let option = document.createElement("option");

                            option.value = carrera.id
                            option.innerText = carrera.carrera_nombre

                            opcionesCarrera.push(option)
                        });

                        $('#carrera').html(opcionesCarrera)
                    }
                })
            }
        })

        /** evento select carrera 
        * obtiene semestres del carrera seleccionado
        */
        $('#carrera').on('change', function(){
            let carreraId = this.value
            let opcionesSemestre = []

            $('#semestre').html('')
            $('#tablaUniversitarios').html('')

            if(carreraId != '')
            {
                $.ajax({
                    url: 'api/universidad/semestreCarrera',
                    data: {carreraId},
                    method: 'post',
                    success: (response) => {
                        let semestres = response.semestres
                        let option = document.createElement("option");

                        option.value = ''
                        option.innerText = 'Selecionar semestre'

                        opcionesSemestre.push(option)

                        semestres.forEach(semestre => {
                            let option = document.createElement("option");
                            
                            option.value = semestre.id
                            option.innerText = semestre.semestre_nombre

                            opcionesSemestre.push(option)
                        });

                        $('#semestre').html(opcionesSemestre)
                    }
                })
            }
        })

        /** evento select semestre 
        * obtiene universitarios del semestre seleccionado
        */
        $('#semestre').on('change', function(){
            let semestreId = this.value
            let plantillaTablaUniversitarios = ''
            let plantillaTablaUniversitariosAsignados = ''
            let carreraId = $('#carrera').val()
            $('#tablaUniversitarios').html('')

            if(semestreId != '')
            {
                $.ajax({
                    url: 'api/universidad/universitarios',
                    data: {semestreId, carreraId},
                    method: 'post',
                    success: (response) => {
                        let universitarios = response.universitarios
                        let i = 0
                        
                        universitarios.forEach(universitario => {
                            i++
                            /** creamos el contenido de la etiqueta tbody */
                            plantillaTablaUniversitarios = 
                            `
                            <tr>
                                <td>${i}</td>
                                <td>${universitario.uni_nombre_1} ${universitario.uni_apellido_1}</td>
                                <td>${universitario.uni_tipodoc}</td>
                                <td>${universitario.uni_numerodoc}</td>
                                <td>
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" name="asignados" value="${universitario.id}" id="${universitario.uni_numerodoc}">
                                        <label class="custom-control-label" for="${universitario.uni_numerodoc}"></label>
                                    </div>
                                </td>
                            </tr>
                            `

                            /** insertamos el html dentro de la etiqueta */
                            $('#tablaUniversitarios').append(plantillaTablaUniversitarios)
                        });


                        /** obtenemos todos los input checkBox name=asignados */
                        document.getElementsByName("asignados").forEach(checkBox => {

                            /** asignamos el evento click al input checkBox name=asignados */
                            checkBox.addEventListener('click', function (){

                                if(this.checked)
                                {
                                    let trEstAsig = document.getElementById(`${this.id}`).parentNode.parentNode.parentNode
                                    let checkBoxVal = document.getElementById(`${this.id}`).value
                                    
                                    plantillaTablaUniversitariosAsignados = 
                                    `
                                    <tr>
                                        <td>${trEstAsig.cells[1].innerText}</td>
                                        <td>${trEstAsig.cells[2].innerText}</td>
                                        <td>${trEstAsig.cells[3].innerText}</td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked name="EstAsignados" value="${checkBoxVal}" id="uni-${trEstAsig.cells[3].innerText}">
                                                <label class="custom-control-label" for="uni-${trEstAsig.cells[3].innerText}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    `                                   
                                    $('#universitariosAsignados').append(plantillaTablaUniversitariosAsignados)

                                    document.getElementsByName("EstAsignados").forEach(checkBox => {

                                        /** asignamos el evento click al input checkBox name=asignados */
                                        checkBox.addEventListener('click', function (){

                                            if(this.checked == false)
                                            {
                                                let idCheckBox = this.id.split('-')[1]
                                                if(document.getElementById(idCheckBox))
                                                {
                                                    document.getElementById(idCheckBox).checked = false
                                                }

                                                if(document.getElementById(this.id))
                                                {
                                                    let trEstAsig = document.getElementById(this.id).parentNode.parentNode.parentNode                                                
                                                    let tablaAsignados = trEstAsig.parentNode
                                                    tablaAsignados.removeChild(trEstAsig)                
                                                }                                  

                                                remove(idUniversitariosSeleccionados, this.value)                                  
                                            }
                                        })
                                    })

                                    idUniversitariosSeleccionados.push(this.value)
                                }
                                else
                                {
                                    let idCheckBox = `uni-${this.id}`
                                    let trEstAsig = document.getElementById(idCheckBox).parentNode.parentNode.parentNode
                                    let tablaAsignados = trEstAsig.parentNode
                                    tablaAsignados.removeChild(trEstAsig)
        
                                    remove(idUniversitariosSeleccionados, this.value)                                   
                                }

                                // console.log(idUniversitariosSeleccionados);
                            })
                        })

                        function remove(arr, item) {
                            for(var i = arr.length; i--;) {
                                if(arr[i] === item) {
                                    arr.splice(i, 1);
                                }
                            }
                        }
                    }
                })
            }
            else
            {
                $('#tablaUniversitarios').html('')
            }
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
                            url:'{{url("/universitarios/delete")}}/' +id,
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
                                    title: 'Grupo eliminado correctamente'
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