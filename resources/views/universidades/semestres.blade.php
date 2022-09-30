@extends('adminlte::page')

@section('title', 'Semestres')

@section('content_header')
    <h1 class="text-center">{{ $nombreUniversidad }}</h1>
    <h4 class="text-center">SEDE - {{ $nombreSede }}</h4>
    <h5 class="text-center">CARRERA {{ $carreraNombre }}</h4>
@stop

@section('content')

<div class="card">
    <div class="card-body"> 
        <h5>Grupos</h5>
        <table id="example" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Semestre</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($semestres as $semestre)
                    <tr>
                        <td class="loop">{{ $loop->iteration }}</td>
                        <td>{{ $semestre->semestre_nombre }}°</td>
                        <td>
                            <a href="{{ route('universitarios.index', $semestre->id) }}?nombreSede={{ $nombreSede }}&nombreUniversidad={{$nombreUniversidad}}&carreraNombre={{$carreraNombre}}" class="btn btn-primary"><i class="fa fa-fw fa-users"></i></a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Grupo</th>
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
    
    <script>
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
    </script>
@stop