@extends('adminlte::page')

@section('title', 'CGE')

@section('content_header')
    <h1 class="text-center" style="text-decoration: underline">Estudiantes</h1>
@stop

@section('content')

<button class="btn btn-primary mb-3" target="" id="disparador-crear">
    añadir estudiantes <i class="fas fa-plus"></i>
</button>

<div class="card" id="oculto-crear" style="display: none">
    <h3 class="text-center">añadir estudiantes</h3>
    <div class="card-body"> 
        <form  method="post" action="{{ route('estudiantes.actualizarLista') }}" class="needs-validation" id="faeSemillero" novalidate>
            @csrf
            <div class="row">
                <input type="hidden" name="idGrupo" value="{{ $grupoEstudiantes->id }}">
            </div>
            <div class="row">
                <div class="col-md 3">
                    <div class="mb-3">
                        <label for="">Institucion</label>
                        <select class="custom-select" id="colegio" value="{{ old('colegio') }}">
                            <option value="">Seleccionar colegio</option>
                            @foreach ($colegios as $colegio)
                                <option value="{{ $colegio->id }}">{{ $colegio->col_nombre }}</option>
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
                    <label for="">Curso</label>
                    <select class="custom-select" id="curso">
                    </select>
                </div>
                <div class="col-md 3">
                    <label for="">Grado</label>
                    <select class="custom-select" id="grupo">
                    </select>
                </div>

                <input type="hidden" id="listaEstudiantesAsignados" name="listaEstudiantesAsignados" value="{{ old('listaEstudiantesAsignados') }}">
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
                        <h5>Estudiantes</h5>
                        <table class="dt table table-striped table-hover dt-responsive">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Tipo identificacion</th>
                                <th scope="col">Identificacion</th>
                                <th scope="col">asignar</th>
                                </tr>
                            </thead>
                            <tbody id="tablaEstudiantes">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        @error('listaEstudiantesAsignados')
                            <small class="text-danger">Debe seleccionar 1 o mas estudiantes</small>
                        @enderror
                        <table class="table table-striped table-hover dt-responsive">
                            <h5>Estudiantes asignados</h5>
                            <thead>
                                <tr>
                                <th scope="col">Nombre</th>
                                <th scope="col">Tipo identificacion</th>
                                <th scope="col">Identificacion</th>
                                <th scope="col">Asignado</th>
                                </tr>
                            </thead>
                            <tbody id="estudiantesAsignados">
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h5>Estudiantes</h5>
        <table class="dt table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th scope="col">Nombre del estudiante</th>
                    <th scope="col">Tipo de documento</th>
                    <th scope="col">Documento</th>
                    <th scope="col">Retirar</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($estudiantes as $estudiante)
                    <tr>
                        <td>{{ $estudiante->est_nombre_1 }} {{ $estudiante->est_apellido_1 }}</td>
                        <td>{{ $estudiante->est_tipodoc }}</td>
                        <td>{{ $estudiante->est_numerodoc }}</td>
                        @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                            <td>
                                <a onclick="deleteItem(event)" href="{{ route('semilleros.expulsarEstudiante', ['idGrupo' => $grupoEstudiantes->id, 'idEstudiante' => $estudiante->id]) }}" class="btn btn-danger">Retirar</a>
                            </td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">Nombre del estudiante</th>
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
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

    <style>
        .loop{
            font-weight: bold;
        }
        .opciones:hover {
        transform: scale(1.11);
        transform: rotate(360deg);
        transition: all 0.3s ease-in-out;
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
    @if(session('estudianteAñadido') == 'estudiante agregado')
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
                title: 'Se ha añanido un nuevo estudiante al grupo'
            })
        </script>
    @endif
    @if(session('mensajeOk') == 'Expulsado')
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
                title: 'El estudiante ha sido expulsado del grupo'
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

        let idEstudiantesSeleccionados = []
        let iEstudiantesAsignados = 0

        $(document).ready(resetearFormulario());

        function resetearFormulario() 
        {
            document.getElementById('faeSemillero').reset();    
        }

        $('#colegio').on('change', function(){

            $('#sede').html('')
            $('#curso').html('')
            $('#grupo').html('')
            $('#tablaEstudiantes').html('')
            let id = this.value

            $.ajax({
                url: `http://${document.domain}:8000/api/colegioSedes`,
                data: {colegioId: id},
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
        
                    $('#sede').html(opcionesSedes)
                }
            })

        })

        $('#sede').on('change', function(){
            let opcionesCursos = []
            let sedeId = this.value

            $('#curso').html('')
            $('#grupo').html('')
            $('#tablaEstudiantes').html('')

            if(sedeId != '')
            {
                $.ajax({
                    url: `http://${document.domain}:8000/api/sedeCursos`,
                    data: {sedeId},
                    method: 'post',
                    success: (response) => {

                        let cursos = response.cursos
                        let option = document.createElement("option");
        
                        option.value = ''
                        option.innerText = 'Selecionar curso'
        
                        opcionesCursos.push(option)
        
                        cursos.forEach(curso => {
                            let option = document.createElement("option");
        
                            option.value = curso.id
                            option.innerText = curso.curso_nombre
        
                            opcionesCursos.push(option)
                        });
        
                        $('#curso').html(opcionesCursos)
                    }
                })
            }
        })

        $('#curso').on('change', function(){
            let cursoId = this.value
            let opcionesGrupos = []

            $('#grupo').html('')
            $('#tablaEstudiantes').html('')

            if(cursoId != '')
            {
                $.ajax({
                    url: `http://${document.domain}:8000/api/cursosGrupos`,
                    data: {cursoId},
                    method: 'post',
                    success: (response) => {
                        
                        let grupos = response.grupos
                        let option = document.createElement("option");
        
                        option.value = ''
                        option.innerText = 'Selecionar grupo'
        
                        opcionesGrupos.push(option)
        
                        grupos.forEach(grupo => {
                            let option = document.createElement("option");
                            
                            option.value = grupo.id
                            option.innerText = grupo.grupo_nombre
        
                            opcionesGrupos.push(option)
                        });
        
                        $('#grupo').html(opcionesGrupos)
                    }
                })
            }
        })

        $('#grupo').on('change', function(){
            let grupoId = this.value
            let plantillaTablaEstudiantes = ''
            let plantillaTablaEstudiantesAsignados = ''
            $('#tablaEstudiantes').html('')

            if(grupoId != '')
            {
                $.ajax({
                    url: `http://${document.domain}:8000/api/estudiantes`,
                    data: {grupoId},
                    method: 'post',
                    success: (response) => {
                        
                        let estudiantes = response.estudiantes
                        let i = 0
                        
                        estudiantes.forEach(estudiante => {
                
                            if(grupoId == estudiante.est_grupoid)
                            {
                                i++
                                /** creamos el contenido de la etiqueta tbody */
                                plantillaTablaEstudiantes = 
                                `
                                <tr>
                                    <td>${i}</td>
                                    <td>${estudiante.est_nombre_1} ${estudiante.est_apellido_1}</td>
                                    <td>${estudiante.est_tipodoc}</td>
                                    <td>${estudiante.est_numerodoc}</td>
                                    <td>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" name="asignados" value="${estudiante.id}" id="${estudiante.est_numerodoc}">
                                            <label class="custom-control-label" for="${estudiante.est_numerodoc}"></label>
                                        </div>
                                    </td>
                                </tr>
                                `
                                    
                                /** insertamos el html dentro de la etiqueta */
                                $('#tablaEstudiantes').append(plantillaTablaEstudiantes)
                            }
                        });
        
        
                        /** obtenemos todos los input checkBox name=asignados */
                        document.getElementsByName("asignados").forEach(checkBox => {
        
                            /** asignamos el evento click al input checkBox name=asignados */
                            checkBox.addEventListener('click', function (){
        
                                if(this.checked)
                                {
                                    let trEstAsig = document.getElementById(`${this.id}`).parentNode.parentNode.parentNode
                                    let checkBoxVal = document.getElementById(`${this.id}`).value
        
                                    plantillaTablaEstudiantesAsignados = 
                                    `
                                    <tr>
                                        <td>${trEstAsig.cells[1].innerText}</td>
                                        <td>${trEstAsig.cells[2].innerText}</td>
                                        <td>${trEstAsig.cells[3].innerText}</td>
                                        <td>
                                            <div class="custom-control custom-checkbox">
                                                <input type="checkbox" class="custom-control-input" checked name="EstAsignados" value="${checkBoxVal}" checked id="est-${trEstAsig.cells[3].innerText}">
                                                <label class="custom-control-label" for="est-${trEstAsig.cells[3].innerText}"></label>
                                            </div>
                                        </td>
                                    </tr>
                                    `
                                    $('#estudiantesAsignados').append(plantillaTablaEstudiantesAsignados)                                  
        
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
                                                remove(idEstudiantesSeleccionados, this.value)  
                                            }
                                        })
                                    })
        
                                    idEstudiantesSeleccionados.push(this.value)
                                }
                                else
                                {
                                    let idCheckBox = `est-${this.id}`
                                    let trEstAsig = document.getElementById(idCheckBox).parentNode.parentNode.parentNode
                                    let tablaAsignados = trEstAsig.parentNode
                                    tablaAsignados.removeChild(trEstAsig)
        
                                    remove(idEstudiantesSeleccionados, this.value)                                   
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
                $('#tablaEstudiantes').html('')
            }
        })

        $('#btnGuardarLista').on('click', function(e){
            $('#listaEstudiantesAsignados').val(idEstudiantesSeleccionados)
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