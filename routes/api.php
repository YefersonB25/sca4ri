<?php

use App\Http\Controllers\ColegioCursosController;
use App\Http\Controllers\ColegioGruposController;
use App\Http\Controllers\ColegioSedesController;
use App\Http\Controllers\EstudiantesAsignadosController;
use App\Http\Controllers\EstudiantesController;
use App\Http\Controllers\ObjetivosController;
use App\Http\Controllers\SemillerosController;
use App\Http\Controllers\UniversidadCarrerasController;
use App\Http\Controllers\UniversidadSedesController;
use App\Http\Controllers\UniversidadSemestresController;
use App\Http\Controllers\UniversitariosAsignadosController;
use App\Http\Controllers\UniversitariosController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/** API DASHBOARD */
Route::get('/semilleros', [SemillerosController::class, 'apiSemilleros']);
/** FIN */

/** API ESTUDIANTES */
Route::post('/colegioSedes', [ColegioSedesController::class, 'apiObtenerSedes']);
Route::post('/estudiantes', [EstudiantesController::class, 'apiObtenerEstudiantes']);
Route::post('/nombreGrupoAsignado', [EstudiantesAsignadosController::class, 'apiObtenerNombreGrupos']);
Route::post('/sedeCursos', [ColegioCursosController::class, 'apiObtenerCursos']);
Route::post('/cursosGrupos', [ColegioGruposController::class, 'apiObtenerGrupos']);
/** FIN */

/** API UNIVERSITARIOS */
Route::post('/universidad/universidadSedes', [UniversidadSedesController::class, 'apiObtenerSedes']);
Route::post('/universidad/universitarios', [UniversitariosController::class, 'apiObtenerUniversitarios']);
Route::post('/universidad/nombreGrupoAsignado', [UniversitariosAsignadosController::class, 'apiObtenerNombreGrupos']);
Route::post('/universidad/sedeCarrera', [UniversidadCarrerasController::class, 'apiObtenerCarreras']);
Route::post('/universidad/semestreCarrera', [UniversidadSemestresController::class, 'apiObtenerSemestres']);
/** FIN */

/** API OBJETIVOS */
Route::post('/objetivo/objetivoCategoria', [ObjetivosController::class, 'apiObtenerObjetivos']);
/** FIN */
