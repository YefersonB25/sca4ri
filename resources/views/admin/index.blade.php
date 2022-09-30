@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="container">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-info">
                        <div class="inner">
                            <h3>{{ $cantidadUser }}</h3>
                            <p>Usuarios</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('usuarios.index') }}" class="small-box-footer">Mas Información
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-primary">
                        <div class="inner">
                            <h3>{{ $cantidadProfesores }}</h3>
                            <p>Profesores</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-bag"></i>
                        </div>
                        <a href="{{ route('profesores.index') }}" class="small-box-footer">Mas Información 
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-success">
                        <div class="inner">
                            <h3>{{ $cantidadSemi }}</h3>
                            <p>Semilleros</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-stats-bars"></i>
                        </div>
                        <a href="{{ route('semilleros.index') }}" class="small-box-footer">Mas Información
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-warning">
                        <div class="inner">
                            <h3>{{ $cantidadGruestu }}</h3>
                            <p>Grupos de estudiantes</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-person-add"></i>
                        </div>
                        <a href="{{ route('estudiantes.asignados') }}" class="small-box-footer">Mas Información
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
                <div class="col-lg-3 col-6">
                    <div class="small-box bg-danger">
                        <div class="inner">
                            <h3>{{ $cantidadGruuni }}</h3>
                            <p>Grupos de monitores</p>
                        </div>
                        <div class="icon">
                            <i class="ion ion-pie-graph"></i>
                        </div>
                        <a href="{{ route('universitarios.asignados') }}" class="small-box-footer">Mas Información
                            <i class="fas fa-arrow-circle-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div id="chartdiv"></div>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="card">
        <div class="card-body">
            <div class="container-fluid">
                <div class="row">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div> --}}
@stop

@include('shared.footer')

@section('css')
    <style>
        #chartdiv {
        width: 100%;
        height: 500px;
        }
        .sidebar-dark-white{
            background-color: #0b5cb3 !important;
            color: white !important;
        }

    </style>
@endsection

@section('js')
    <script src="//cdn.amcharts.com/lib/5/index.js"></script>
    <script src="//cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="//cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    
    <!-- Chart code -->
    <script>
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chartdiv");


        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);


        // Create chart
        // https://www.amcharts.com/docs/v5/charts/xy-chart/
        var chart = root.container.children.push(am5xy.XYChart.new(root, {
            panX: true,
            panY: true,
            wheelX: "panX",
            wheelY: "zoomX",
            pinchZoomX:true
        }));

        // Add cursor
        // https://www.amcharts.com/docs/v5/charts/xy-chart/cursor/
        var cursor = chart.set("cursor", am5xy.XYCursor.new(root, {}));
        cursor.lineY.set("visible", false);


        // Create axes
        // https://www.amcharts.com/docs/v5/charts/xy-chart/axes/
        var xRenderer = am5xy.AxisRendererX.new(root, { minGridDistance: 30 });
        xRenderer.labels.template.setAll({
            rotation: -90,
            centerY: am5.p50,
            centerX: am5.p100,
            paddingRight: 15
        });

        var xAxis = chart.xAxes.push(am5xy.CategoryAxis.new(root, {
            maxDeviation: 0.3,
            categoryField: "country",
            renderer: xRenderer,
            tooltip: am5.Tooltip.new(root, {})
        }));

        var yAxis = chart.yAxes.push(am5xy.ValueAxis.new(root, {
                min: 0,
                max: 100,
            renderer: am5xy.AxisRendererY.new(root, {})
        }));


        // Create series
        // https://www.amcharts.com/docs/v5/charts/xy-chart/series/
        var series = chart.series.push(am5xy.ColumnSeries.new(root, {
            name: "Series 1",
            xAxis: xAxis,
            yAxis: yAxis,
            valueYField: "value",
            sequencedInterpolation: true,
            categoryXField: "country",
            tooltip: am5.Tooltip.new(root, {
                labelText:"{valueY}"
            })
        }));

        series.columns.template.setAll({ cornerRadiusTL: 5, cornerRadiusTR: 5 });
        series.columns.template.adapters.add("fill", function(fill, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        series.columns.template.adapters.add("stroke", function(stroke, target) {
            return chart.get("colors").getIndex(series.columns.indexOf(target));
        });

        function random(min, max) {
            return Math.floor((Math.random() * (max - min + 1)) + min);
        }

        $.ajax({
            url: 'api/semilleros',
            method: 'GET',
            success:function(response){
                let data = []

                response.forEach(semillero => {
                    let cantidadObjetivo = semillero.sem_objetivo.length
                    let objetivoCumplido = 0

                    semillero.sem_objetivo.forEach(objetivo => {
                        if(objetivo.supervisor == true && objetivo.estado == "Cumplido")
                        {
                            objetivoCumplido++
                        }
                    })

                    data.push({
                        country: semillero.sem_nombre,
                        value: Math.round((objetivoCumplido / cantidadObjetivo * 100))
                    })

                    xAxis.data.setAll(data);
                    series.data.setAll(data);

                    // Make stuff animate on load
                    // https://www.amcharts.com/docs/v5/concepts/animations/
                    series.appear(1000);
                    chart.appear(1000, 100);
                });

            }
        })

    }); // end am5.ready()
    </script>
@endsection
