@extends('Layouts.pantilla')
@section('title', 'Cliente')
@section('css')
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet" />
@endsection
@section('contenido')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h4>
                        <i class="fas fa-chart-line"> Mas Consultas</i>
                    </h4>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">GRAFICOS</h3>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Ventas mes por año actual</h2>
                                <div class="chart-responsive">
                                    <canvas id="Grafico1"
                                        style="min-height:250px;height:250px;max-height:250px;max-width:100%;">
                                    </canvas>
                                </div>
                        </div>

                        <div class="col-md-12">
                            <h4>Top 3 vendedores del Mes</h2>
                                <div class="chart-responsive">
                                    <canvas id="Grafico2"
                                        style="min-height:250px;height:250px;max-height:250px;max-width:100%;">
                                    </canvas>
                                </div>
                        </div>

                        <div class="col-md-12">
                            <h4>Comparativa de Meses con el año anterior</h2>
                                <div class="chart-responsive">
                                    <canvas id="Grafico3"
                                        style="min-height:250px;height:250px;max-height:250px;max-width:100%;">
                                    </canvas>
                                </div>
                        </div>

                        <div class="col-md-12">
                            <h4>Los 5 productos mas vendidos en el mes</h2>
                                <div class="chart-responsive">
                                    <canvas id="Grafico4"
                                        style="min-height:250px;height:250px;max-height:250px;max-width:100%;">
                                    </canvas>
                                </div>
                        </div>

                        <div class="col-md-12">
                            <h4>Top 3 clientes del mes</h2>
                            <div class="chart-responsive">
                                <canvas id="Grafico5"
                                    style="min-height:250px;height:250px;max-height:250px;max-width:100%;">
                                </canvas>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">

                </div>
            </div>
        </div>
    </section>
@endsection

@section('js')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.3/datatables.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        $(document).ready(function() {
            venta_mes();
            vendedor_mes();
            ventas_anual();
            producto_mas_vendido();
            cliente_mes();








            async function venta_mes() {
                try {
                    let url =
                        "{{ route('venta_mes') }}"; // Asegúrate de que la ruta está bien definida en Laravel

                    const response = await fetch(url, {
                        method: 'GET', // Cambiado a GET ya que solo obtenemos datos
                        headers: {
                            'content-type': 'application/json'
                        }
                    });

                    const meses = await response.json();
                    console.log("📊 Datos de ventas por mes:", meses);

                    // Inicializar array con valores por defecto
                    let array = new Array(12).fill({
                        cantidad: 0
                    });

                    // Asignar valores reales donde existan
                    meses.forEach(mes => {
                        let index = mes.mes - 1; // Convertir mes (1-12) a índice (0-11)
                        array[index] = mes;
                    });

                    let ctx = document.getElementById('Grafico1').getContext('2d');

                    // Destruir gráfica anterior si existe
                    if (window.grafico1) {
                        window.grafico1.destroy();
                    }

                    let datos = {
                        labels: [
                            'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio',
                            'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                        ],
                        datasets: [{
                            data: array.map(mes => mes.cantidad), // Extraer solo cantidades
                            backgroundColor: [
                                '#ff0003', '#0cff00', '#001bff', '#00fffb', '#a200ff',
                                '#ff8f00',
                                '#9bff00', '#000000', '#009eff', '#108304', '#ff00ff', '#ffcc00'
                            ]
                        }]
                    };

                    let opciones = {
                        maintainAspectRatio: false, // Corregido
                        responsive: true
                    };

                    // Crear gráfico de pastel
                    window.grafico1 = new Chart(ctx, {
                        type: 'pie',
                        data: datos,
                        options: opciones
                    });

                } catch (error) {
                    console.error("🚨 Error al obtener ventas por mes:", error);
                }
            }

            // Variable global para almacenar el gráfico y evitar duplicados
            let G2;

            async function vendedor_mes() {
                try {
                    var url = "{{ route('vendedormes') }}";

                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'content-type': 'application/json'
                        }
                    });

                    const vendedores = await response.json();
                    console.log("Datos recibidos:", vendedores);

                    // Verifica si hay datos, si no hay, solo muestra un mensaje en la consola y no detiene la ejecución
                    if (vendedores.length === 0) {
                        console.warn("No hay vendedores para mostrar.");
                    }

                    let CanvasG2 = $('#Grafico2').get(0).getContext('2d');

                    // Colores predefinidos para hasta 3 vendedores (se pueden agregar más si se requiere)
                    let colores = [{
                            bg: 'rgba(60,141,188,0.9)',
                            border: 'rgba(60,141,188,0.8)'
                        }, // Azul
                        {
                            bg: 'rgba(255,0,0,1)',
                            border: 'rgba(255,0,0,1)'
                        }, // Rojo
                        {
                            bg: 'rgba(0,255,0,1)',
                            border: 'rgba(60,141,0,1)'
                        } // Verde
                    ];

                    let datos = {
                        labels: ['Mes Actual'],
                        datasets: vendedores.map((vendedor, index) => ({
                            label: vendedor.vendedor_nombre,
                            backgroundColor: colores[index]?.bg ||
                                'rgba(100,100,100,0.9)', // Gris si hay más de 3
                            borderColor: colores[index]?.border || 'rgba(100,100,100,0.8)',
                            data: [vendedor.cantidad]
                        }))
                    };

                    let opciones = {
                        maintainAspectRatio: false,
                        responsive: true
                    };

                    // 🔥 Si ya hay un gráfico, lo destruimos antes de crear uno nuevo
                    if (G2) {
                        G2.destroy();
                    }

                    G2 = new Chart(CanvasG2, {
                        type: 'bar',
                        data: datos,
                        options: opciones
                    });

                } catch (error) {
                    console.error("Error al obtener datos de los vendedores:", error);
                }
            }

            async function ventas_anual() {
                // URLS de las rutas
                const url_anual = "{{ route('ventas_anual') }}"; // Año actual y anterior

                // Obtener los datos de la API
                async function obtenerVentas() {
                    try {
                        const response = await fetch(url_anual, {
                            method: 'GET',
                            headers: {
                                'content-type': 'application/json'
                            }
                        });
                        const data = await response.json();
                        console.log("Datos obtenidos:", data);

                        // Crear arrays con 12 meses, llenos con cantidad 0
                        let ventasActual = new Array(12).fill(0);
                        let ventasAnterior = new Array(12).fill(0);

                        // Asignar datos en sus posiciones correctas
                        if (data.actual) {
                            data.actual.forEach(mes => {
                                if (mes.mes >= 1 && mes.mes <= 12) {
                                    ventasActual[mes.mes - 1] = mes.cantidad;
                                }
                            });
                        }

                        if (data.anterior) {
                            data.anterior.forEach(mes => {
                                if (mes.mes >= 1 && mes.mes <= 12) {
                                    ventasAnterior[mes.mes - 1] = mes.cantidad;
                                }
                            });
                        }

                        return {
                            ventasActual,
                            ventasAnterior
                        };
                    } catch (error) {
                        console.error("Error obteniendo datos:", error);
                        return {
                            ventasActual: new Array(12).fill(0),
                            ventasAnterior: new Array(12).fill(0)
                        };
                    }
                }

                // Obtener datos
                const {
                    ventasActual,
                    ventasAnterior
                } = await obtenerVentas();

                // Configuración del gráfico
                let CanvasG3 = $('#Grafico3').get(0).getContext('2d');

                let datos = {
                    labels: [
                        'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto',
                        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    datasets: [{
                            label: 'Año Actual',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            data: ventasActual
                        },
                        {
                            label: 'Año Anterior',
                            backgroundColor: 'rgba(210,214,222,1)',
                            borderColor: 'rgba(210,214,222,1)',
                            data: ventasAnterior
                        },
                    ]
                };

                let opciones = {
                    maintainAspectRatio: false,
                    responsive: true,
                    datasetsFill: false,
                };

                // Destruir gráfico anterior si existe
                if (window.miGrafico) {
                    window.miGrafico.destroy();
                }

                // Crear nuevo gráfico
                window.miGrafico = new Chart(CanvasG3, {
                    type: 'bar',
                    data: datos,
                    options: opciones
                });
            }

            async function producto_mas_vendido() {
                var url = "{{ route('producto_mas_vendido') }}";
                try {
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json'
                        }
                    });

                    const productos = await response.json();
                    console.log(productos);

                    // Inicializar lista con objetos vacíos para evitar errores si hay menos de 5 productos
                    let lista3 = Array.from({
                        length: 5
                    }, () => ({
                        nombre: '',
                        concentracion: '',
                        adicional: '',
                        total: 0
                    }));

                    // Llenar lista con los productos obtenidos
                    productos.forEach((producto, i) => {
                        if (i < 5) lista3[i] = producto;
                    });

                    let CanvasG4 = $('#Grafico4').get(0).getContext('2d');

                    let datos = {
                        labels: ['Mes Actual'],
                        datasets: lista3.map((producto, index) => ({
                            label: `${producto.nombre} ${producto.concentracion} ${producto.adicional}`,
                            backgroundColor: ['rgba(60,141,188,0.9)', 'rgba(255,0,0,1)',
                                'rgba(0,255,0,1)', 'rgba(255,255,0,1)', 'rgba(0,0,255,1)'
                            ][index],
                            borderColor: ['rgba(60,141,188,0.8)', 'rgba(255,0,0,1)',
                                'rgba(60,141,0,1)', 'rgba(255,255,0,1)', 'rgba(0,0,255,1)'
                            ][index],
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: ['rgba(60,141,188,1)', 'rgba(255,0,0,1)',
                                'rgba(0,255,1)', 'rgba(255,255,0,1)', 'rgba(0,0,255,1)'
                            ][index],
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: ['rgba(60,141,188,1)', 'rgba(255,0,0,1)',
                                'rgba(0,255,1)', 'rgba(255,255,0,1)', 'rgba(0,0,255,1)'
                            ][index],
                            data: [producto.total]
                        }))
                    };

                    let opciones = {
                        maintainAspectRatio: false,
                        responsive: true
                    };

                    new Chart(CanvasG4, {
                        type: 'bar',
                        data: datos,
                        options: opciones,
                    });

                } catch (error) {
                    console.error("Error obteniendo productos más vendidos:", error);
                }
            }



            async function cliente_mes() {
                var url = "{{ route('cliente_mes') }}";
                try {
                    const response = await fetch(url, {
                        method: 'GET',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .getAttribute('content')
                        }
                    });

                    const clientes = await response.json();

                    if (clientes.length === 0) {
                        console.warn("No hay clientes este mes.");
                        return;
                    }

                    let lista = clientes.map(cliente => ({
                        nombre: cliente.cliente_nombre,
                        cantidad: cliente.cantidad
                    }));

                    // **Si hay menos de 3 clientes, agregamos datos vacíos**
                    while (lista.length < 3) {
                        lista.push({
                            nombre: "N/A",
                            cantidad: 0
                        });
                    }

                    let CanvasG2 = document.getElementById('Grafico5').getContext('2d');

                    let datos = {
                        labels: ['Mes Actual'],
                        datasets: lista.map((cliente, index) => ({
                            label: cliente.nombre,
                            backgroundColor: ['rgba(60,141,188,0.9)', 'rgba(255,0,0,1)',
                                'rgba(0,255,0,1)'
                            ][index],
                            borderColor: ['rgba(60,141,188,0.8)', 'rgba(255,0,0,1)',
                                'rgba(0,255,0,1)'
                            ][index],
                            data: [cliente.cantidad]
                        }))
                    };

                    let opciones = {
                        maintainAspectRatio: false,
                        responsive: true
                    };

                    new Chart(CanvasG2, {
                        type: 'bar',
                        data: datos,
                        options: opciones
                    });

                } catch (error) {
                    console.error("Error al obtener los clientes del mes:", error);
                }
            }

            document.addEventListener("DOMContentLoaded", cliente_mes);









        });
    </script>



@endsection
