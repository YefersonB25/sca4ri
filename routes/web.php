<?php

use App\Http\Controllers\AvancesController;
use App\Http\Controllers\SendMailController;
use App\Http\Controllers\ColegioCursosController;
use App\Http\Controllers\ColegioGruposController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\homeController;
use App\Http\Controllers\ColegiosController;
use App\Http\Controllers\ColegioSedesController;
use App\Http\Controllers\EstudiantesAsignadosController;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ObjetivosController;
use App\Http\Controllers\ProfesoresController;
use App\Http\Controllers\SemillerosController;
use App\Http\Controllers\UniversidadCarrerasController;
use App\Http\Controllers\UniversidadesController;
use App\Http\Controllers\UniversidadSedesController;
use App\Http\Controllers\UniversidadSemestresController;
use App\Http\Controllers\UniversitariosAsignadosController;
use App\Http\Controllers\UniversitariosController;
use App\Http\Controllers\UsuariosController;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Auth::routes();

Route::get('/', function () {
    return view('auth/login');
});

Route::get('', [homeController::class, 'index'])->name('home')->middleware('verificacionUsuario');
Route::get('listado-universidades', [homeController::class, 'universidades'])->name('universidadesListado')->middleware('auth');

/** PROFESORES */
Route::get('listado-profesores', [ProfesoresController::class, 'index'])->name('profesores.index')->middleware('auth');
Route::post('listado/nuevo-profesor', [ProfesoresController::class, 'store'])->name('profesores.store')->middleware('auth');
Route::get('listado-profesores/edit/{id}', [ProfesoresController::class, 'edit'])->name('profesores.edit')->middleware('auth');
Route::put('listado-profesores/{id}', [ProfesoresController::class, 'update'])->name('profesores.update')->middleware('auth');
Route::delete('profesor/delete/{id}', [ProfesoresController::class, 'destroy'])->name('profesor.destroy')->middleware('auth');

/** FIN */

/** USUARIOS */
Route::get('listado-usuarios', [UsuariosController::class, 'index'])->name('usuarios.index')->middleware('auth');
Route::post('listado-usuarios', [UsuariosController::class, 'create'])->name('usuarios')->middleware('auth');
Route::resource('users', UsuariosController::class)->names('usuarios.users')->middleware('auth');
Route::put('listado-usuarios', [UsuariosController::class, 'edit'])->name('usuarios.editar')->middleware('auth');
Route::delete('usuarios/delete/{id}', [UsuariosController::class, 'destroy'])->name('usuarios.destroy')->middleware('auth');

/** FIN */

/** COLEGIOS */
Route::get('listado-colegios', [ColegiosController::class, 'index'])->name('colegios.index')->middleware('auth');
Route::get('listado-sedes/{id}', [ColegioSedesController::class, 'index'])->name('sedes.index')->middleware('auth');
Route::get('listado-cursos/{id}', [ColegioCursosController::class, 'index'])->name('cursos.index')->middleware('auth');
Route::get('listado-grupos/{id}', [ColegioGruposController::class, 'index'])->name('grupos.index')->middleware('auth');
Route::get('listado-estudiantes/{id}', [EstudiantesController::class, 'index'])->name('estudiantes.index')->middleware('auth');
/** FIN */

/** ESTUDIANTES */
Route::post('estudiante/guardar', [EstudiantesController::class, 'store'])->name('estudiantes.guardar')->middleware('auth');
Route::get('estudiante/editar/{id}', [EstudiantesController::class, 'edit'])->name('estudiantes.editar')->middleware('auth');
Route::put('estudiante/actualizar', [EstudiantesController::class, 'update'])->name('estudiantes.actualizar')->middleware('auth');
Route::delete('estudiante/eliminar/{id}', [EstudiantesController::class, 'destroy'])->name('estudiantes.eliminar')->middleware('auth');
/** FIN */

/** UNIVERSITARIOS */
Route::post('Universidades/nuevo-estudiante', [UniversitariosController::class, 'store'])->name('universitarios.store')->middleware('auth');
Route::get('Universidades/editar-estudiante/{id}', [UniversitariosController::class, 'edit'])->name('universitarios.edit')->middleware('auth');
Route::delete('Universidades/delete/{id}', [UniversitariosController::class, 'destroy'])->name('universitarios.destroy')->middleware('auth');
Route::put('Universidades/{id}', [UniversitariosController::class, 'update'])->name('universitarios.update')->middleware('auth');

/** FIN */

/** UNIVERSIDADES */
Route::get('Universidades/listado-universidades', [UniversidadesController::class, 'index'])->name('universidades.index')->middleware('auth');
Route::get('Universidades/listado-sedes/{id}', [UniversidadSedesController::class, 'index'])->name('sedesUniversidad.index')->middleware('auth');
Route::get('Universidades/listado-carreras/{id}', [UniversidadCarrerasController::class, 'index'])->name('carrerasUniversidad.index')->middleware('auth');
Route::get('Universidades/listado-semestres/{id}', [UniversidadSemestresController::class, 'index'])->name('semestresUniversidad.index')->middleware('auth');
Route::get('Universidades/listado-estudiantes/{id}', [UniversitariosController::class, 'index'])->name('universitarios.index')->middleware('auth');
/** FIN */

/** ESTUDIANTES ASIGNADOS */
Route::get('asignar-estudiantes', [EstudiantesAsignadosController::class, 'index'])->name('estudiantes.asignados')->middleware('auth');
Route::get('grupo-estudiantes/ver/{id}', [EstudiantesAsignadosController::class, 'ver'])->name('estudiantes.asignados.ver')->middleware('auth');
Route::post('guardar-estudiantes-asignados', [EstudiantesAsignadosController::class, 'GuardarLista'])->name('estudiantes.guardarAsignados')->middleware('auth');
Route::post('actualizar-estudiantes-asignados', [EstudiantesAsignadosController::class, 'actualizarLista'])->name('estudiantes.actualizarLista')->middleware('auth');
Route::delete('estudiantes/delete/{id}', [EstudiantesAsignadosController::class, 'destroy'])->name('estudiantes.destroy')->middleware('auth');
/** FIN */

/** UNIVERSITARIOS ASIGNADOS */
Route::get('asignar-universitarios', [UniversitariosAsignadosController::class, 'index'])->name('universitarios.asignados')->middleware('auth');
Route::get('grupo-universitarios/ver/{id}', [UniversitariosAsignadosController::class, 'ver'])->name('universitarios.asignados.ver')->middleware('auth');
Route::post('guardar-universitarios-asignados', [UniversitariosAsignadosController::class, 'GuardarLista'])->name('universitarios.guardarAsignados')->middleware('auth');
Route::post('actualizar-universitarios-asignados', [UniversitariosAsignadosController::class, 'actualizarLista'])->name('universitarios.actualizarLista')->middleware('auth');
Route::delete('universitarios/delete/{id}', [UniversitariosAsignadosController::class, 'destroy'])->name('universitarios.destroy')->middleware('auth');
/** FIN */

/** OBJETIVOS */
Route::get('lista-objetivos', [ObjetivosController::class, 'index'])->name('objetivos.index')->middleware('auth');
Route::post('crear-objetivos', [ObjetivosController::class, 'crearObjetivo'])->name('objetivos.crear')->middleware('auth');
Route::get('objetivos/edit/{id}', [ObjetivosController::class, 'edit'])->name('objetivos.edit')->middleware('auth');
Route::put('objetivos/{id}', [ObjetivosController::class, 'update'])->name('objetivos.update')->middleware('auth');
Route::delete('objetivos/delete/{id}', [ObjetivosController::class, 'destroy'])->name('objetivos.destroy')->middleware('auth');
/** FIN */

/** SEMILLEROS */
Route::get('crear-semilleros', [SemillerosController::class, 'index'])->name('semilleros.index')->middleware('auth');
Route::post('guardar-semilleros', [SemillerosController::class, 'guardarSemillero'])->name('semilleros.guardar')->middleware('auth');
Route::get('semillero/{id}', [SemillerosController::class, 'ver'])->name('semilleros.ver')->middleware('auth');
Route::get('semillero/edit/{id}', [SemillerosController::class, 'edit'])->name('semilleros.edit')->middleware('auth');
Route::put('semillero/{id}', [SemillerosController::class, 'update'])->name('semilleros.update')->middleware('auth');
Route::delete('semilleros/delete/{id}', [SemillerosController::class, 'destroy'])->name('semilleros.destroy')->middleware('auth');
Route::post('semillero/habilitar-evidencia', [SemillerosController::class, 'hablilitarEvidencia'])->name('semilleros.hablilitarEvidencia')->middleware('auth');
Route::get('semillero/descargar/{ubicacion_archivo}', [SemillerosController::class, 'descargarArchivo'])->name('semilleros.descargarArchivo')->middleware('auth');
Route::post('semillero/subir-material-apoyo', [SemillerosController::class, 'subirMaterialApoyo'])->name('semilleros.subirMaterialApoyo')->middleware('auth');
Route::get('semillero/descargar-material-apoyo/{ubicacion_archivo}', [SemillerosController::class, 'descargarMaterialApoyo'])->name('semilleros.descargarMaterialApoyo')->middleware('auth');
Route::get('semillero/eliminar-archivo-evidencia/{ubicacion_archivo}/{id}/{model}', [SemillerosController::class, 'eliminarArchivo'])->name('semilleros.eliminarArchivo')->middleware('auth');
Route::get('semillero/expulsar-estudiante/{idGrupo}/{idEstudiante}/{idSemillero?}', [SemillerosController::class, 'expulsarEstudiante'])->name('semilleros.expulsarEstudiante')->middleware('auth');
Route::get('semillero/expulsar-monitor/{idGrupo}/{idUniversitario}/{idSemillero?}', [SemillerosController::class, 'expulsarMonitor'])->name('semilleros.expulsarMonitor')->middleware('auth');
Route::post('semillero/agregar-estudiante', [SemillerosController::class, 'añadirEstudiante'])->name('semilleros.agregarEstuduante')->middleware('auth');
Route::post('semillero/agregar-monitor', [SemillerosController::class, 'añadirMonitor'])->name('semilleros.agregarMonitor')->middleware('auth');
/** FIN */

/** ENVIAR MAIL */
Route::get('enviar-email', [SendMailController::class, 'index'])->middleware('auth');
/** FIN */

/** LOG */
Route::get('log', [LogController::class, 'index'])->name('admin.log')->middleware('auth');
/** FIN */

/** AVANCE */
Route::get('avances/', [AvancesController::class, 'index'])->name('avances.index')->middleware('auth');
/** FIN */

/** EXPORTAR E IMPORTAR */
Route::post('universidades-import', [UniversidadesController::class, 'import'])->name('universidadesImport')->middleware('auth');
Route::post('import', [ColegiosController::class, 'import'])->name('import')->middleware('auth');
Route::post('import-profesorC', [ProfesoresController::class, 'importProfesoresColegio'])->name('import.profesorC')->middleware('auth');
Route::post('import-profesorU', [ProfesoresController::class, 'importProfesoresUniversidad'])->name('import.profesorU')->middleware('auth');
Route::get('export', [ColegiosController::class, 'export'])->name('export');
/** FIN */

/** DEV */
Route::get('devs-only/truncate-all-table', [homeController::class, 'vaciarTodo'])->middleware('auth');
/** FIN */
