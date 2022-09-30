@extends('adminlte::page')

@section('title', 'CGM')

@section('content_header')
    <h1 class="text-center" style="text-decoration: underline">Universitarios</h1>
@stop

@section('content')
<button class="btn btn-primary mb-3" target="" id="disparador-crear">
    Agregar monitores <i class="fas fa-plus"></i>
</button>

<div class="card" id="oculto-crear" style="display: none">
    <h3 class="text-center">Crear grupo de monitores</h3>
    <div class="card-body"> 
        <form  method="post" action="{{ route('universitarios.actualizarLista') }}" class="needs-validation" id="fauSemillero" novalidate>
            @csrf

            <div class="row">
                <input type="hidden" name="idGrupo" value="{{ $grupoUniversitarios->id }}">
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
                    <select class="custom-select" id="sede_universidad">
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
                <button type="submit" class="btn btn-success" id="btnGuardarListaUni">
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
        <h5>Monitores</h5>
        <table class="dt table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Nombre del universitario</th>
                    <th scope="col">Tipo de documento</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Retirar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($universitarios as $universitario)
                    <tr>
                        <td>{{ $universitario->uni_nombre_1 }} {{ $universitario->uni_apellido_1 }}</td>
                        <td>{{ $universitario->uni_tipodoc }}</td>
                        <td>{{ $universitario->uni_numerodoc }}</td>
                        @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                            <td>
                                <a onclick="deleteItem(event)" href="{{ route('semilleros.expulsarMonitor', ['idGrupo' => $grupoUniversitarios->id, 'idUniversitario' => $universitario->id]) }}" class="btn btn-danger">Retirar</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">Nombre del universitario</th>
                    <th scope="col">Tipo de documento</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Retirar</th>
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

    @if(session('universitarioAñadido') == 'monitores agregado')
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
                title: 'Monitores agregados creado correctamente'
            })
        </script>
    @endif
    @if(session('mensajeOk') == 'Expulsado Monitor')
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
                title: 'El monitor ha sido expulsado del grrupo'
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

        $('#universidad').on('change', function(){

            $('#sede_universidad').html('')
            $('#carrera').html('')
            $('#semestre').html('')
            $('#tablaUniversitarios').html('')

            let id = this.value

            $.ajax({
                url: `http://${document.domain}:8000/api/universidad/universidadSedes`,
                data: {universidadId: id},
                method: 'post',
                success: (response) => {

                    let sedes = response.sedes
                    let option = document.createElement("option");
                    let opcionesSedes = []
        
                    option.value = ''
                    option.innerText = 'Selecionar sede'
        
                    opcionesSedes.push(option)
        
                    sedes.forEach(sede => {
                        let option = document.createElement("option");
        
                        option.value = sede.id
                        option.innerText = sede.sede_nombre
        
                        opcionesSedes.push(option)
                    });
        
                    $('#sede_universidad').html(opcionesSedes)
                }
            })
        })

        $('#sede_universidad').on('change', function(){
            let opcionesCarreras = []
            let sedeId = this.value

            $('#carrera').html('')
            $('#curso').html('')
            $('#tablaUniversitarios').html('')

            if(sedeId != '')
            {
                $.ajax({
                    url: `http://${document.domain}:8000/api/universidad/sedeCarrera`,
                    data: {sedeId},
                    method: 'post',
                    success: (response) => {

                        let carreras = response.carreras
                        let option = document.createElement("option");
        
                        option.value = ''
                        option.innerText = 'Selecionar carrera'
        
                        opcionesCarreras.push(option)
        
                        carreras.forEach(carrera => {
                            let option = document.createElement("option");
        
                            option.value = carrera.id
                            option.innerText = carrera.carrera_nombre
        
                            opcionesCarreras.push(option)
                        });
        
                        $('#carrera').html(opcionesCarreras)
                    }
                })
            }
        })

        $('#carrera').on('change', function(){
            let carreraId = this.value
            let opcionesSemestres = []

            $('#semestre').html('')
            $('#tablaUniversitarios').html('')

            if(carreraId != '')
            {
                $.ajax({
                    url: `http://${document.domain}:8000/api/universidad/semestreCarrera`,
                    data: {carreraId},
                    method: 'post',
                    success: (response) => {
                        let semestres = response.semestres
                        let option = document.createElement("option");
        
                        option.value = ''
                        option.innerText = 'Selecionar semestre'
        
                        opcionesSemestres.push(option)
        
                        semestres.forEach(semestre => {
                            let option = document.createElement("option");
                            
                            option.value = semestre.id
                            option.innerText = semestre.semestre_nombre
        
                            opcionesSemestres.push(option)
                        });
        
                        $('#semestre').html(opcionesSemestres)
                    }
                })
            }
        })

        $('#semestre').on('change', function(){
            let semestreId = this.value
            let plantillaTablaUniversitarios = ''
            let plantillaTablaUniversitariosAsignados = ''
            let carreraId = $('#carrera').val()
            
            $('#tablaUniversitarios').html('')
            
            if(semestreId != '')
            {
                $.ajax({
                    url: `http://${document.domain}:8000/api/universidad/universitarios`,
                    data: {semestreId, carreraId},
                    method: 'post',
                    success: (response) => {
                        let universitarios = response.universitarios
                        let i = 0
        
                        universitarios.forEach(universitario => {
                            if(semestreId == universitario.uni_semestreid && carreraId == universitario.uni_carreraid)
                            {
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
                                            <input type="checkbox" class="custom-control-input" name="uni-asignados" value="${universitario.id}" id="${universitario.uni_numerodoc}">
                                            <label class="custom-control-label" for="${universitario.uni_numerodoc}"></label>
                                        </div>
                                    </td>
                                </tr>
                                `
                                    
                                /** insertamos el html dentro de la etiqueta */
                                $('#tablaUniversitarios').append(plantillaTablaUniversitarios)
                            }
                        });
        
        
                        /** obtenemos todos los input checkBox name=uni-asignados */
                        document.getElementsByName("uni-asignados").forEach(checkBox => {
        
                            /** asignamos el evento click al input checkBox name=uni-asignados */
                            checkBox.addEventListener('click', function (){
        
                                if(this.checked)
                                {
                                    let trUniAsig = document.getElementById(`${this.id}`).parentNode.parentNode.parentNode
                                    let checkBoxVal = document.getElementById(`${this.id}`).value
        
                                    plantillaTablaUniversitariosAsignados = 
                                    `
                                    <tr>
                                        <td>${trUniAsig.cells[1].innerText}</td>
                                        <td>${trUniAsig.cells[2].innerText}</td>
                                        <td>${trUniAsig.cells[3].innerText}</td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked name="UniAsignados" value="${checkBoxVal}" checked id="uni-${trUniAsig.cells[3].innerText}">
                                                <label class="custom-control-label" for="uni-${trUniAsig.cells[3].innerText}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    `
                                    $('#universitariosAsignados').append(plantillaTablaUniversitariosAsignados)                                  
        
                                    document.getElementsByName("UniAsignados").forEach(checkBox => {
        
                                        /** asignamos el evento click al input checkBox name=uni-asignados */
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
                                                    let trUniAsig = document.getElementById(this.id).parentNode.parentNode.parentNode                                                
                                                    let tablaAsignados = trUniAsig.parentNode
                                                    tablaAsignados.removeChild(trUniAsig)                
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
                                    let trUniAsig = document.getElementById(idCheckBox).parentNode.parentNode.parentNode
                                    let tablaAsignados = trUniAsig.parentNode
                                    tablaAsignados.removeChild(trUniAsig)
        
                                    remove(idUniversitariosSeleccionados, this.value)                                   
                                }
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

        $('#btnGuardarListaUni').on('click', function(e){
            $('#listaUniversitariosAsignados').val(idUniversitariosSeleccionados)
        })

        function deleteItem(e){
            e.preventDefault()
            let url = e.originalTarget.href
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
                    console.log(result);
                    if (result.isConfirmed)
                    {
                        window.location.href = url
                    }
                } 
            });
        }
    </script>
@stop