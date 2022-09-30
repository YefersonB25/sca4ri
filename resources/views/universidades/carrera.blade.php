@extends('adminlte::page')

@section('title', 'Carreras')

@section('content_header')
    <h1 class="text-center">{{ $nombreUniversidad }}</h1>
    <h4 class="text-center">SEDE - {{ $nombreSede }}</h4>
@stop

@section('content')

<div class="card">
    <div class="card-body"> 
        <h5>CURSOS</h5>
        <table id="example" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Carrera</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($carreras as $carrera)
                    <tr>
                        <td class="loop">{{ $loop->iteration }}</td>
                        <td>{{ $carrera->carrera_nombre }}</td>
                        <td>
                            <a href="{{ route('semestresUniversidad.index', $carrera->id) }}?nombreSede={{ $nombreSede }}&nombreUniversidad={{$nombreUniversidad}}" class="btn btn-primary">
                                <i class="fa fa-fw fa-users"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Carrera</th>
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