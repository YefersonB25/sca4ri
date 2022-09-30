@extends('adminlte::page')

@section('title', $semillero[0]->sem_nombre)

@section('content_header')
<div></div>
@stop

@section('content')
    <div class="card" style="height: 85%">
        <div class="card-body">
            <div class="row">
                <div class="col-3">
                    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                        <a class="nav-link active" id="v-pills-semillero-tab" data-toggle="pill" href="#v-pills-semillero" role="tab" aria-controls="v-pills-semillero" aria-selected="true">Curso</a>
                        <a class="nav-link" id="v-pills-estudiantes-tab" data-toggle="pill" href="#v-pills-estudiantes" role="tab" aria-controls="v-pills-estudiantes" aria-selected="false">Estudiantes</a>
                        <a class="nav-link" id="v-pills-monitores-tab" data-toggle="pill" href="#v-pills-monitores" role="tab" aria-controls="v-pills-monitores" aria-selected="false">Monitores</a>
                        <a class="nav-link" id="v-pills-objetivos-tab" data-toggle="pill" href="#v-pills-objetivos" role="tab" aria-controls="v-pills-objetivos" aria-selected="false">Modulos</a>
                        <a class="nav-link" id="v-pills-materialApoyo-tab" data-toggle="pill" href="#v-pills-materialApoyo" role="tab" aria-controls="v-pills-materialApoyo" aria-selected="false">Material de apoyo</a>
                        @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                        <a class="nav-link" id="v-pills-evidencias-tab" data-toggle="pill" href="#v-pills-evidencias" role="tab" aria-controls="v-pills-evidencias" aria-selected="false">Evidencias</a>
                        @endif
                    </div>
                </div>
                <div class="col-9">
                    <div class="tab-content" id="v-pills-tabContent">
                        <div class="tab-pane fade show active" id="v-pills-semillero" role="tabpanel" aria-labelledby="v-pills-semillero-tab">
                            <h1 class="text-center">{{ $semillero[0]->sem_nombre }}</h1>
                            <p class="font-weight-bolder">Profesor</p>
                            <p>{{ $profesor }}</p>
                            <p class="font-weight-bolder">Descripcion</p>
                            <p>{{ $semillero[0]->sem_descripcion }}</p>
                            <div class="row">
                                <div class="col-md-auto">
                                    <p>
                                        <strong>Cantidad de estudiantes:</strong> {{ count($estudiantes) }}
                                    </p>                                            
                                </div>
                                <div class="col-md-auto">
                                    <p>
                                        <strong>Cantidad de monitores:</strong> {{ count($universitarios) }}
                                    </p>                                                
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-estudiantes" role="tabpanel" aria-labelledby="v-pills-estudiantes-tab">
                            <h5>Estudiante</h5>
                            <table class="dt table table-striped table-hover dt-responsive" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre del estudiante</th>
                                        <th scope="col">Tipo documento</th>
                                        <th scope="col">Documento</th>
                                        @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                                            <th scope="col">Retirar</th>
                                        @endif
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
                                                    <a onclick="deleteItem(event)" href="{{ route('semilleros.expulsarEstudiante', ['idGrupo' => $semillero[0]->sem_grupo_est, 'idEstudiante' => $estudiante->id, 'idSemillero' => $semillero[0]->id ]) }}" class="btn btn-danger">Retirar</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">Nombre del estudiante</th>
                                        <th scope="col">Tipo documento</th>
                                        <th scope="col">Documento</th>
                                        @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                                            <th scope="col">Retirar</th>
                                        @endif
                                    </tr>
                                </tfoot>
                            </table>
                            @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == $semillero[0]->sem_grupo_profe)
                                <div class="mt-3">
                                    <button class="btn btn-primary mb-3 disparador-crear" target="" id="">
                                        Añadir estudiante <i class="fas fa-user-plus"></i>
                                    </button>

                                    <div class="card oculto-crear" id="" @if (count($errors) == 0) style="display: none" @endif>
                                        <div class="card-body">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <a class="nav-link active" id="nav-busqueda-rapida-tab" data-toggle="tab" href="#nav-busqueda-rapida" role="tab" aria-controls="nav-busqueda-rapida" aria-selected="true">Busqueda rapida</a>
                                                    <a class="nav-link" id="nav-busqueda-avanzada-tab" data-toggle="tab" href="#nav-busqueda-avanzada" role="tab" aria-controls="nav-busqueda-avanzada" aria-selected="false">Busqueda avanzada</a>
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-busqueda-rapida" role="tabpanel" aria-labelledby="nav-busqueda-rapida-tab">
                                                    <form  method="post" action="{{ route('semilleros.agregarEstuduante') }}" class="needs-validation" novalidate>
                                                        @csrf
                                                        <div hidden>
                                                            <input type="text" name="semillero" value="{{ $semillero[0]->id }}" required>
                                                            <input type="text" name="tipo" value="estudiante" required>
                                                            <input type="text" name="grupoEstudiantes" value="{{ $semillero[0]->sem_grupo_est }}" required>
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label>Buscar estudiante</label>
                                                            <input list="estudiantes" name="estudiante" class="form-control">
                                                            <datalist id="estudiantes">
                                                                @foreach ($estudiantesAll as $estudiante)
                                                                    <option value="{{ $estudiante->est_numerodoc }}">{{ $estudiante->est_numerodoc }} {{ $estudiante->est_nombre_1 }} {{ $estudiante->est_apellido_1 }}</option>
                                                                @endforeach
                                                            </datalist>                                                    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-success">
                                                                Agregar a grupo <i class="fa fa-fw fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="nav-busqueda-avanzada" role="tabpanel" aria-labelledby="nav-busqueda-avanzada-tab">
                                                    <form  method="post" action="{{ route('estudiantes.actualizarLista') }}" class="needs-validation" id="faeSemillero" novalidate>
                                                        @csrf
                                                        <div class="row">
                                                            <input type="hidden" name="idGrupo" value="{{ $semillero[0]->sem_grupo_est }}">
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
                                                                Agregar a grupo <i class="fa fa-fw fa-plus"></i>
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
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="v-pills-monitores" role="tabpanel" aria-labelledby="v-pills-monitores-tab">
                            <h5>Monitores</h5>
                            <table class="dt table table-striped table-hover dt-responsive" style="width:100%">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombre del estudiante</th>
                                        <th scope="col">Tipo documento</th>
                                        <th scope="col">Documento</th>
                                        @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                                            <th scope="col">Retirar</th>
                                        @endif
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
                                                    <a onclick="deleteItem(event)" href="{{ route('semilleros.expulsarMonitor', ['idGrupo' => $semillero[0]->sem_grupo_uni, 'idUniversitario' => $universitario->id, 'idSemillero' => $semillero[0]->id ]) }}" class="btn btn-danger">Retirar</a>
                                                </td>
                                            @endif
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th scope="col">Nombre del estudiante</th>
                                        <th scope="col">Tipo documento</th>
                                        <th scope="col">Documento</th>
                                        @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                                            <th scope="col">Retirar</th>
                                        @endif                                
                                    </tr>
                                </tfoot>
                            </table>
                            
                            @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == $semillero[0]->sem_grupo_profe)
                                <div class="mt-3">
                                    <button class="btn btn-primary mb-3 disparador-crear" target="" id="">
                                        Añadir monitor <i class="fas fa-user-plus"></i>
                                    </button>

                                    <div class="card oculto-crear" id="" @if (count($errors) == 0) style="display: none" @endif>
                                        <div class="card-body">
                                            <nav>
                                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                                    <a class="nav-link active" id="nav-uni-busqueda-rapida-tab" data-toggle="tab" href="#nav-uni-busqueda-rapida" role="tab" aria-controls="nav-uni-busqueda-rapida" aria-selected="true">Busqueda rapida</a>
                                                    <a class="nav-link" id="nav-uni-busqueda-avanzada-tab" data-toggle="tab" href="#nav-uni-busqueda-avanzada" role="tab" aria-controls="nav-uni-busqueda-avanzada" aria-selected="false">Busqueda avanzada</a>
                                                </div>
                                            </nav>
                                            <div class="tab-content" id="nav-tabContent">
                                                <div class="tab-pane fade show active" id="nav-uni-busqueda-rapida" role="tabpanel" aria-labelledby="nav-uni-busqueda-rapida-tab">
                                                    <form  method="post" action="{{ route('semilleros.agregarMonitor') }}" class="needs-validation" novalidate>
                                                        @csrf
                                                        <div hidden>
                                                            <input type="text" name="semillero" value="{{ $semillero[0]->id }}" required>
                                                            <input type="text" name="tipo" value="estudiante" required>
                                                            <input type="text" name="grupoMonitores" value="{{ $semillero[0]->sem_grupo_uni }}" required>
                                                        </div>
                                                        <div class="mb-3 col-md-4">
                                                            <label>Buscar universitario</label>
                                                            <input list="universitarios" name="universitario" class="form-control">
                                                            <datalist id="universitarios">
                                                                @foreach ($universitariosAll as $universitario)
                                                                    <option value="{{ $universitario->uni_numerodoc }}">{{ $universitario->uni_numerodoc }} {{ $universitario->uni_nombre_1 }} {{ $universitario->uni_apellido_1 }}</option>
                                                                @endforeach
                                                            </datalist>                                                    
                                                        </div>
                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-success">
                                                                Agregar a grupo <i class="fa fa-fw fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div class="tab-pane fade" id="nav-uni-busqueda-avanzada" role="tabpanel" aria-labelledby="nav-uni-busqueda-avanzada-tab">
                                                    <form  method="post" action="{{ route('universitarios.actualizarLista') }}" class="needs-validation" id="fauSemillero" novalidate>
                                                        @csrf
                                            
                                                        <div class="row">
                                                            <input type="hidden" name="idGrupo" value="{{ $semillero[0]->sem_grupo_uni }}">
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
                                                                Agregar a grupo <i class="fa fa-fw fa-plus"></i>
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
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="v-pills-objetivos" role="tabpanel" aria-labelledby="v-pills-objetivos-tab">
                            <h4>Modulos</h4>
                            <div style="height: 764px; overflow: auto">
                                <div class="list-group pl-3 pt-1">
                                    @php
                                        $i = 0;
                                    @endphp
                                    @foreach ($objetivos as $objetivo)
                                        <div class="card  col-md-8">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <h5 class="card-title font-weight-bold text-capitalize">{{ $objetivo['nombre'] }}</h5>
                                                    </div>
                                                    @php
                                                        $color = explode('"', $objetivo['estado'])[1] == 'Cumplido' ? 'success' : 'warning'
                                                    @endphp
                                                    <div class="col-md-2">
                                                        <span class="badge badge-{{ $color }}">{{ explode('"', $objetivo['estado'])[1] }}</span>
                                                    </div>
                                                </div>
                                                <p class="card-text">{{ $objetivo['descripcion'] }}</p>
                                                <form action="{{ route('semilleros.hablilitarEvidencia') }}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    <div hidden>
                                                        <input type="text" name="idSemillero" value="{{ $semillero[0]->id }}">
                                                        <input type="text" name="idObjetivo" value="{{ explode('"', $objetivo['idObjetivo'])[1] }}">
                                                        <input type="text" name="nombreObjetivo" value="{{ $objetivo['nombre'] }}">
                                                        <input type="text" name="nombreSemillero" value="{{ $semillero[0]->sem_nombre }}">
                                                        <input type="text" name="indiceObjetivo" value="{{ $i }}">
                                                    </div>
                                                    @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="subirEvidencia" type="checkbox" value="true" {{ $objetivo['subirEvidencia'] == "true" ? 'checked' : '' }} id="evidencia-{{ $i }}">
                                                                    <label class="form-check-label" for="evidencia-{{ $i }}">
                                                                        Habilitar evidencia
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            @if ($objetivo['subirEvidencia'] == "true")
                                                                <div class="col-md-6">
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" name="objCumplido" type="checkbox" value="true" {{ $objetivo['estado'] == '"Cumplido"' ? 'checked' : '' }} id="objCumplido-{{ $i }}">
                                                                        <label class="form-check-label" for="objCumplido-{{ $i }}">
                                                                            Cumplido
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endif
                                                    @php
                                                        $rolPermitido = array(1,2)
                                                    @endphp
                                                    @if (in_array(Auth::user()->usuario_rolid, $rolPermitido) && $objetivo['estado'] == '"Cumplido"')
                                                        <div class="row mb-3">
                                                            <div class="col-md-6">
                                                                <div class="form-check">
                                                                    <input class="form-check-input" name="cumplidoSupervisor" type="checkbox" value="true" {{ $objetivo['supervisor'] == "true" ? 'checked' : '' }} id="cumplidoSupervisor">
                                                                    <label class="form-check-label" for="cumplidoSupervisor">
                                                                        Cumplido
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($objetivo['subirEvidencia'] == "true")
                                                        <div class="form-group mb-3">
                                                            <label class="">Subir evidencia</label>
                                                            <input type="file" id="inputGroupFile02" name="evidencia">
                                                        </div>
                                                    @endif
                                                    @if($objetivo['subirEvidencia'] == "true" || Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                                                        <div class="col-md-3 pl-0">
                                                            <button type="submit" class="btn btn-success btn-sm">Guardar</button>
                                                        </div>
                                                    @endif
                                                </form>
                                            </div>
                                        </div>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="v-pills-evidencias" role="tabpanel" aria-labelledby="v-pills-evidencias-tab">
                            <h5 class="text-center">Evidencias</h5>
                            @if (!empty($evidencias))
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($evidencias as $evidencia)
                                                <div class="card col-md-4">
                                                    <div class="card-body">
                                                        <p class="card-text text-justify font-weight-bold">{{ $evidencia['objetivo_nombre'] }}</p>
                                                        <p class="card-text">
                                                            Subido por: <strong class="font-italic">{{ $evidencia['usuario'] }}</strong>
                                                        </p>
                                                        <div class="row">
                                                            <div class="col-md-auto">
                                                                <a href="{{ route('semilleros.descargarArchivo', ['ubicacion_archivo' => base64_encode($evidencia['ubicacion_archivo'])]) }}" class="btn btn-primary">
                                                                    <i class="fas fa-download"></i> Descargar
                                                                </a>
                                                            </div>
                                                            @if (Auth::user()->usuario_rolid == $evidencia['id_usuario'] || Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                                                                <div class="col-md-auto">
                                                                    <a href="{{ route('semilleros.eliminarArchivo', ['ubicacion_archivo' => base64_encode($evidencia['ubicacion_archivo']), 'id' => $evidencia['id'], 'model' => 'evidencia']) }}" class="btn btn-danger">
                                                                        <i class="fas fa-times"></i> eliminar
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            <div class="col-md-auto">
                                                                <p class="card-text">
                                                                    <small class="text-muted">Subido: {{ explode(' ', $evidencia['creado'])[0] }}</small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                            
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="v-pills-materialApoyo" role="tabpanel" aria-labelledby="v-pills-materialApoyo-tab">
                            <h5 class="text-center">Material de apoyo</h5>
                            @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                                <button class="btn btn-primary mb-3 disparador-crear" target="" id="">
                                    Agregar material de apoyo <i class="fas fa-plus"></i>
                                </button>
                                <div class="card oculto-crear" id="oculto-crear" style="display: none">
                                    <div class="card-body">
                                        <form action="{{ route('semilleros.subirMaterialApoyo') }}" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <div hidden>
                                                <input type="text" name="nombreSemillero" value="{{ $semillero[0]->sem_nombre }}">
                                                <input type="text" name="id_semillero" value="{{ $semillero[0]->id }}">
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-5">
                                                <label for="">Titulo</label>
                                                <input class="form-control" type="text" name="titulo">
                                                @error('titulo')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                                <div class="col-md-5">
                                                    <label for="">Material de apoyo</label>
                                                    <input class="form-control" type="file" name="materialApoyo">
                                                    @error('materialApoyo')
                                                        <small class="text-danger">{{ $message }}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <button type="submit" class="btn btn-success">
                                                    Subir material de apoyo
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            @endif
                            @if (!empty($materialesApoyo))
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            @foreach ($materialesApoyo as $materialApoyo)
                                                <div class="card col-md-4">
                                                    <div class="card-body">
                                                        <p class="card-text text-justify font-weight-bold">{{ $materialApoyo['titulo'] }}</p>
                                                        <p class="card-text">Subido por: <strong class="font-italic">{{ $materialApoyo['usuario'] }}</strong></p>
                                                        <div class="row">
                                                            <div class="col-md-auto">
                                                                <a href="{{ route('semilleros.descargarArchivo', ['ubicacion_archivo' => base64_encode($materialApoyo['ubicacion_archivo'])]) }}" class="btn btn-primary"><i class="fas fa-download"></i> Descargar</a>
                                                            </div>
                                                            @if (Auth::user()->usuario_rolid == 1 || Auth::user()->usuario_rolid == 3)
                                                                <div class="col-md-auto">
                                                                    <a href="{{ route('semilleros.eliminarArchivo', ['ubicacion_archivo' => base64_encode($materialApoyo['ubicacion_archivo']), 'id' => $materialApoyo['id'], 'model' => 'materialApoyo']) }}" class="btn btn-danger">
                                                                        <i class="fas fa-times"></i> eliminar
                                                                    </a>
                                                                </div>
                                                            @endif
                                                            <div class="col-md-6 text-right">
                                                                <p class="card-text">
                                                                    <small class="text-muted">Subido: {{ explode(' ', $materialApoyo['creado'])[0] }}</small>
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                            
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                @foreach ($objetivos as $objetivo)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                @php
                                    if ($objetivo['estado'] == '"Cumplido"' && $objetivo['supervisor'] == "false") 
                                    {
                                        $Por = 50;
                                    }
                
                                    if ($objetivo['estado'] == '"Cumplido"' && $objetivo['supervisor'] == "true") 
                                    {
                                        $Por = 100;
                                    }
                
                                    if ($objetivo['estado'] == '"No cumplido"' && $objetivo['supervisor'] == "false") 
                                    {
                                        $Por = 0;
                                    }
                                @endphp
                                
                                <label for="">{{ $objetivo['nombre'] }}</label>
                                <div class="row">
                                    <div class="col-md-auto">
                                        Aprobado por profesor: <span class="badge badge-{{ $objetivo['estado'] == '"No cumplido"' ? 'warning' : 'success' }}">{{ $objetivo['estado'] == '"No cumplido"' ? 'Pendiente' : 'Ok' }}</span>
                                    </div>
                                    <div class="col-md-auto">
                                        Aprobado por supervisor: <span class="badge badge-{{ $objetivo['supervisor'] == 'false' ? 'warning' : 'success' }}">{{ $objetivo['supervisor'] == 'false' ? 'Pendiente' : 'Ok' }}</span>
                                    </div>
                                </div>
                                <div class="progress">
                                    <div class="progress-bar" style="width: {{$Por}}%" role="progressbar" aria-valuenow="{{ $Por }}" aria-valuemin="0" aria-valuemax="100">{{ $Por }}%</div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

@endsection

@include('shared.footer')

@section('css')
    <style>
        .sidebar-dark-white{
            background-color: #0b5cb3 !important;
            color: white !important;
        }
    </style>
@endsection
@section('js')    

    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap5.min.js"></script>

    @switch(session('mensajeOk'))
        @case('evidencia')
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
                    title: 'Se ha subido la evidencia correctamente'
                })
            </script>
        @break
        @case('habilitar')
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
                    title: 'Se ha habilitado la subida de evidencia correctamente'
                })
            </script>
        @break
        @case('deshabilitar')
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
                    title: 'Se ha deshabilitado la subida de evidencia correctamente'
                })
            </script>
        @break
        @case('marco')
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
                    title: 'Se ha marcado el modulo como cumplido'
                })
            </script>
        @break
        @case('desmarco')
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
                    title: 'Se ha realizado cambio en el modulo'
                })
            </script>
        @break
        @case('confirmo')
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
                    title: 'Se ha confirmado el cumplimiento del modulo'
                })
            </script>
        @break
        @case('desconfirmo')
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
                    title: 'Se ha confirmado el cumplimiento del modulo'
                })
            </script>
        @break    
    @endswitch
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
                title: 'Material de apoyo creado correctamente'
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
                title: 'El estudiante ha sido retirado'
            })
        </script>
    @endif
    
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

    @if(session('eliminarMaterialApoyo') == 'ok')
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
                title: 'Se ha eliminado el material de apoyo correctamente'
            })
        </script>
    @endif

    @if(session('eliminarArchivo') == 'ok')
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
                title: 'Se ha eliminado el archivo de evidencia correctamente'
            })
        </script>
    @endif
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
                title: 'El monitor ha sido retirado'
            })
        </script>
    @endif

    <script>
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
    </script>
    <script>
        $(".disparador-crear").click(function() {
            if( $(".oculto-crear").css("display") == 'none' ) 
            $(".oculto-crear").show("slow");
            else
            $(".oculto-crear").hide("slow");
            
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
    </script>
    <script>
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
    </script>
@stop