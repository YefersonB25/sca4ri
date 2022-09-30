@extends('adminlte::page')

@section('title', 'Universidades')

@section('content_header')
    <h1 class="text-center" style="text-decoration: underline">Universidades</h1>
@stop

@section('content')

<button class="btn btn-primary mb-3" target="" id="disparador-crear">
    Importar datos <i class="fas fa-plus"></i>
</button>

<div class="card" id="oculto-crear" style="display: none">
    <h3 class="text-center" style="text-decoration: underline">Importar universidades</h3>
    <div class="card-body"> 
        <form  method="post" action="{{ route('universidadesImport') }}" class="needs-validation" novalidate enctype="multipart/form-data">
            @csrf
            <div class="mb-3 col-md-3">
                <input type="file" class="form-control" accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" name="file" required>
                <div class="invalid-feedback">
                    Seleccione un documento excel
                </div>
            </div>
            <div class="mb-3 col-md-3">
                <button type="submit" id="btnImportar" class="btn btn-success">
                    Importar
                </button>
            </div>
        </form>
    </div>
</div> 

<div class="card">
    <div class="card-body"> 
        <table id="example" class="table table-striped table-hover dt-responsive" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Dane</th>
                    <th>Institucion</th>
                    <th>Ver</th>
                </tr>
            </thead>
            <tbody> 
                @foreach ($universidades as $universidad)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $universidad->uni_codigo }}</td>
                        <td>{{ $universidad->uni_nombre }}</td>
                        <td>
                            <a href="{{ route('sedesUniversidad.index', $universidad->id) }}" class="btn btn-primary">
                                <i class="fa fa-fw fa-hotel"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>#</th>
                    <th>Dane</th>
                    <th>Institucion</th>
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
        .opciones:hover {
        transform: scale(1.11);
        transform: rotate(360deg);
        transition: all 0.3s ease-in-out;
        }
        .btn-editar{
            border: transparent;
        }
        .btn-eliminar{
            border: transparent;
        }

        
        [data-title]:hover:after {
            opacity: 1;
            transition: all 0.1s ease 0.5s;
            visibility: visible;
        }
        [data-title]:after {
            content: attr(data-title);
            background-color: #333;
            color: #fff;
            font-size: 14px;
            font-family: Raleway;
            position: absolute;
            padding: 3px 20px;
            /* bottom: -0.5em; */
            /* left: 80%; */
            white-space: nowrap;
            box-shadow: 1px 1px 3px #222222;
            opacity: 0;
            border: 1px solid #111111;
            z-index: 99999;
            visibility: hidden;
            border-radius: 6px;
            cursor: help;
            
        }
        [data-title] {
            position: relative;
        }

        :root {
            --color-green: #06b600;
            --color-red: #c01d00;
            --color-button: #fdffff;
            --color-black: #000;
        }
        .switch-button {
            display: inline-block;
        }
        .switch-button .switch-button__checkbox {
            display: none;
        }
        .switch-button .switch-button__label {
            background-color: var(--color-red);
            width: 4rem;
            height: 2.5rem;
            border-radius: 1.3rem;
            display: inline-block;
            position: relative;
            top: 1.4rem;
            cursor:pointer

        }
        .switch-button .switch-button__label:before {
            transition: .2s;
            display: block;
            position: absolute;
            width: 2.5rem;
            height: 2.5rem;
            background-color: var(--color-button);
            content: '';
            border-radius: 50%;
            box-shadow: inset 0px 0px 0px 1px var(--color-black);
        }
        .switch-button .switch-button__checkbox:checked + .switch-button__label {
            background-color: var(--color-green);
        }
        .switch-button .switch-button__checkbox:checked + .switch-button__label:before {
            transform: translateX(2rem);
        }

    </style>

@stop

@section('js')

    @if(session('mensageimport') == 'ok')
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
                title: 'Universidades creadas correctamente'
            })
        </script>
    @endif
    
    <script>
        $('input[type="checkbox"]').change(function(){        
            $(this).val(Number(this.checked));
            console.log($(this).val());
        });
    </script>

    @if(session('eliminar') == 'ok')
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: 'Perfecto...',
            text: 'Registro eliminado Correctamente.',
            showConfirmButton: false,
            timer: 2600
        })
    </script>

    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>

        Swal.fire({
        title: '<strong>Agregar <u>universitario</u></strong>',
        icon: 'info',
        html:
            'Para agregar un <b>universitario</b>, diríjase a la universidad, sede, carrera y semestre ' + 
            'en la cual desea hacer el proceso, allí encontrará el formulario ' +
            ' de creación.',
        showCloseButton: true,
        showCancelButton: false,
        focusConfirm: false,
        confirmButtonText:
            '<i class="fa fa-thumbs-up"></i> Entendido!',
        // confirmButtonAriaLabel: 'Thumbs up, entendido!',
        })
    </script>

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
    
    {{-- validacion de creacion --}}
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

            if(form.checkValidity())
            {
                $('#btnImportar').html(
                    `<div class="spinner-border spinner-border-sm" role="status">
                        <span class="sr-only">Loading...</span>
                    </div> Importando...`
                )
            }

            form.classList.add('was-validated')
        }, false)
        })
    })()

    </script>

    <script>
        $("#disparador-crear").click(function() {
            if( $("#oculto-crear").css("display") == 'none' ) 
            $("#oculto-crear").show("slow");
            else
            $("#oculto-crear").hide("slow");
            
        });


        $(document).ready(function () {
        
        $.ajaxSetup({
            headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        
        $('body').on('click', '#submit', function (event) {
            event.preventDefault()
            var id = $("#focalizado_id").val();
            var name = $("#name").val();
        
            $.ajax({
            url: 'focalizado/' + id,
            type: "POST",
            data: {
                id: id,
                name: name,
            },
            dataType: 'json',
            success: function (data) {
                
                $('#companydata').trigger("reset");
                $('#practice_modal').modal('hide');
                window.location.reload(true);
            }
        });
        });
        
        $('body').on('click', '#editCompany', function (event) {
        
            event.preventDefault();
            var id = $(this).data('id');
            console.log(id)
            $.get('focalizado/' + id + '/edit', function (data) {
                $('#userCrudModal').html("Edit focalizado");
                $('#submit').val("Edit focalizado");
                $('#practice_modal').modal('show');
                $('#focalizado_id').val(data.data.id);
                $('#name').val(data.data.name);
            })
        });
        
        }); 
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
                            url:'{{url("/bodegas/delete")}}/' +id,
                            data:{
                                "_token": "{{ csrf_token() }}",
                            },
                            success:function(data) {
                                if (data.success){
                                    Swal.fire({
                                        position: 'top-end',
                                        icon: 'success',
                                        title: 'Perfecto...',
                                        text: 'Registro eliminado Correctamente.',
                                        showConfirmButton: false,
                                        // timer: 2600
                                    })
                                    $("#"+id+"").remove(); // you can add name div to remove
                                }
                                
                            }
                        });
                        window.setTimeout(function(){location.reload()},2200)
                    }
                } 
            });
        }
    </script>

@stop