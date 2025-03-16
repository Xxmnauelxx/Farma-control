$(document).ready(function () {
    $("#cat-carrito").show();
    setTimeout(function () {
        $("#lote").DataTable();
    }, 500);
    setTimeout(function () {
        $("#tabla-compra").DataTable();
    }, 500);
    $(".select2").select2();
    var funcion;
    // Llamamos a la función 'buscar_producto' al cargar la página para mostrar todos los productos inicialmente.
    buscar_producto();
    mostrar_lotes_riesgo();
    contar_producto();
    RecuperarLS_carrito();
    RecuperarLS_carrito_compra();
    // Función para buscar productos usando la consulta proporcionada
    function buscar_producto(consulta = "") {
        var url = urlBuscarProducto;
        $.ajax({
            type: "GET", // Método HTTP: GET
            url: url, // URL del endpoint para buscar productos
            data: {
                consulta: consulta,
            }, // Pasamos la consulta de búsqueda al servidor
            success: function (data) {
                //console.log(data)
                let template = ""; // Inicializamos una variable para almacenar el HTML de los productos

                // Iteramos sobre cada producto recibido
                data.forEach((prod) => {
                    // Construimos una tarjeta (card) para cada producto con sus detalles
                    template += `
                        <div prodStock="${prod.stock}" prodId="${prod.id}" prodNomb="${prod.nombre}" prodPrecio="${prod.precio}" prodConcent="${prod.concentracion}" prodAdicional="${prod.adicional}" prodLab="${prod.laboratorio_id}" prodTip="${prod.tipo_id}" prodPrese="${prod.presentacion_id}" prodAvatar="${prod.avatar}" class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                            <div class="card bg-light d-flex flex-fill">
                                <div class="card-header text-muted border-bottom-0">
                                    <i class="fas fa-lg fa-cubes mr-1"></i> ${prod.stock}
                                </div>
                                <div class="card-body pt-0">
                                    <div class="row">
                                        <div class="col-7">
                                            <h2 class="lead"><b>${prod.nombre}</b></h2>
                                            <h4 class="lead"><b><i class="fas fa-lg fa-dollar-sign mr-1"></i>${prod.precio}</b></h4>
                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                <li class="small"><span class="fa-li  mr-1"><i class="fas fa-lg fa-mortar-pestle"></i></span><b>Concentración:</b> ${prod.concentracion}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-prescription-bottle-alt"></i></span><b> Adicional:</b>${prod.adicional}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-flask"></i></span><b>Laboratorio:</b>${prod.laboratorio}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-copyright"></i></span><b>Tipo:</b>${prod.tipo}</li>
                                                <li class="small"><span class="fa-li"><i class="fas fa-lg fa-pills"></i></span><b>Presentación:</b>${prod.presentacion}</li>
                                            </ul>
                                        </div>
                                        <div class="col-5 text-center">
                                            <img src="${prod.avatar}" alt="user-avatar" class="img-circle img-fluid">
                                        </div>
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <div class="text-right">
                                        <button class="agregar-carrito btn btn-sm btn-secondary" >
                                          <i class="fas fa-plus-square mr-2">  Agregar al Carrito</i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                });

                // Insertamos el HTML generado en el contenedor con id 'productos'
                $("#productos").html(template);
            },
            error: function (xhr, status, error) {
                // Si ocurre un error, mostramos los detalles en consola
                console.error("Error details:");
                console.error("Status: " + status);
                console.error("Error: " + error);
                console.error("Response Text: " + xhr.responseText);
            },
        });
    }

    // Al escribir en el campo de búsqueda, llamamos a la función 'buscar_producto' para filtrar los productos
    $(document).on("keyup", "#busquedaProductos", function () {
        let valor = $(this).val(); // Obtenemos el valor del campo de búsqueda
        if (valor != "") {
            buscar_producto(valor); // Si hay un valor, buscamos productos que coincidan
        } else {
            buscar_producto(); // Si no hay valor, mostramos todos los productos
        }
    });

    function mostrar_lotes_riesgo() {
        var url = urlLoteRiesgo;

        // Realizamos la llamada AJAX
        $.ajax({
            url: url, // URL de la ruta en Laravel
            type: "GET",
            data: {
                _token: "{{ csrf_token() }}", // Token CSRF para la seguridad
            },
            success: function (response) {
                // Inicializamos el DataTable solo si no está inicializado previamente
                if ($.fn.dataTable.isDataTable("#lote")) {
                    $("#lote").DataTable().clear().destroy(); // Destruir la tabla existente si ya estaba cargada
                }

                // Inicializamos el DataTable con los nuevos datos
                $("#lote").DataTable({
                    data: response, // Los datos que se retornan del servidor
                    columns: [
                        {
                            data: "id",
                        },
                        {
                            data: "nombre",
                        },
                        {
                            data: "stock",
                        },
                        {
                            data: "estado",
                        },
                        {
                            data: "laboratorio",
                        },
                        {
                            data: "presentacion",
                        },
                        {
                            data: "proveedor",
                        },
                        {
                            data: "mes",
                        },
                        {
                            data: "dia",
                        },
                        {
                            data: "hora",
                        },
                    ],
                    columnDefs: [
                        {
                            targets: [3], // Columna de 'estado'
                            render: function (data, type, row) {
                                let campo = "";
                                // Mostrar los badges según el estado
                                if (row.estado === "danger") {
                                    campo = `<span class="badge badge-danger">Vencido</span>`;
                                }
                                if (row.estado === "warning") {
                                    campo = `<span class="badge badge-warning">Próximo a vencer</span>`;
                                }
                                return campo; // Devuelve el badge adecuado
                            },
                        },
                    ],
                    destroy: true, // Permite destruir y volver a inicializar la tabla
                });
            },
            error: function (xhr, status, error) {
                console.log("Hubo un error: " + error); // Mensaje en caso de error
            },
        });
    }

    //procesos para usar el carrito de compras
    //1
    function contar_producto() {
        let productos;
        let contador = 0;
        productos = RecuperarLS();
        productos.forEach((producto) => {
            contador++;
        });

        $("#contador").html(contador);
    }

    //2
    $(document).on("click", ".agregar-carrito", (e) => {
        const elemento =
            $(this)[0].activeElement.parentElement.parentElement.parentElement
                .parentElement;
        console.log(elemento);
        const id = $(elemento).attr("prodId");
        const nombre = $(elemento).attr("prodNomb");
        const concentracion = $(elemento).attr("prodConcent");
        const adicional = $(elemento).attr("prodAdicional");
        const precio = $(elemento).attr("prodPrecio");
        const laboratorio = $(elemento).attr("prodLab");
        const tipo = $(elemento).attr("prodTip");
        const presentacion = $(elemento).attr("prodPrese");
        const avatar = $(elemento).attr("prodAvatar");
        let stock = $(elemento).attr("prodStock");

        // Si el stock es "Sin lotes", lo tratamos como 0
        if (stock === "Sin lotes") {
            stock = 0;
        } else {
            stock = parseInt(stock, 10); // Convertir a número entero si no es "Sin lotes"
        }

        // Verificar si hay stock disponible
        if (stock <= 0) {
            Swal.fire({
                icon: "error",
                title: "Sin Stock",
                text: "El producto no está disponible en este momento.",
            });
            return; // Detener la ejecución si no hay stock
        }

        const producto = {
            id: id,
            nombre: nombre,
            concentracion: concentracion,
            adicional: adicional,
            precio: precio,
            laboratorio: laboratorio,
            tipo: tipo,
            presentacion: presentacion,
            avatar: avatar,
            stock: stock,
            cantidad: 1,
        };

        let id_producto;
        let productos;
        productos = RecuperarLS();
        productos.forEach((prod) => {
            if (prod.id === producto.id) {
                id_producto = prod.id;
            }
        });

        if (id_producto === producto.id) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "El Producto Ya Existe!",
            });
        } else {
            template = `
                   <tr prodId="${producto.id}">
                       <td>${producto.id}</td>
                       <td>${producto.nombre}</td>
                       <td>${producto.concentracion}</td>
                       <td>${producto.adicional}</td>
                       <td>${producto.precio}</td>
                       <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
                   </tr>
               `;
            $("#lista-carrito").append(template);
            // agregar localstore
            AgregarLS(producto);
            let contador;
            contar_producto();
            // Mostrar Toastr de éxito
            toastr.success("Producto agregado al carrito", "Éxito");
        }
    });

    //7
    $(document).on("click", ".borrar-producto", (e) => {
        const elemento = $(this)[0].activeElement.parentElement.parentElement;
        console.log(elemento);
        const id = $(elemento).attr("prodId");
        elemento.remove();
        eliminar_producto_LS(id);
        contar_producto();
        calculartotal();
    });

    //3
    function RecuperarLS() {
        let productos;

        if (localStorage.getItem("productos") === null) {
            productos = [];
        } else {
            productos = JSON.parse(localStorage.getItem("productos"));
        }
        return productos;
    }

    //4
    function AgregarLS(producto) {
        let productos;
        productos = RecuperarLS();
        productos.push(producto);
        localStorage.setItem("productos", JSON.stringify(productos));
    }

    //5
    function RecuperarLS_carrito() {
        let productos, id_producto;
        productos = RecuperarLS(); // Supongo que esta función obtiene los productos almacenados en LocalStorage

        productos.forEach((producto) => {
            id_producto = producto.id;
            var url = rutaProdCompra.replace(":id", id_producto);
            $.ajax({
                url: url,
                method: "GET",
                data: {
                    id_producto: id_producto,
                    _token: $('meta[name="csrf-token"]').attr("content"), // CSRF token para Laravel
                },
                success: function (response) {
                    template_carrito = `
                           <tr prodId="${response.id}">
                           <td>${response.id}</td>
                           <td>${response.nombre}</td>
                           <td>${response.concentracion}</td>
                           <td>${response.adicional}</td>
                           <td>${response.precio}</td>
                           <td><button class="borrar-producto btn btn-danger"><i class="fas fa-times-circle"></i></button></td>
                           </tr>
                          `;
                    $("#lista-carrito").append(template_carrito);
                },
                error: function (xhr, status, error) {
                    console.log("Error al obtener el producto:", error);
                },
            });
        });
    }

    //6
    function eliminar_producto_LS(id) {
        let productos = RecuperarLS();

        // Filtrar los productos y guardar solo los que no coincidan con el ID
        productos = productos.filter((producto) => producto.id !== id);

        localStorage.setItem("productos", JSON.stringify(productos));
    }

    //8
    function eliminarLS() {
        localStorage.clear();
    }

    //9
    $(document).on("click", "#vaciar-carrito", (e) => {
        $("#lista-carrito").empty();
        eliminarLS();
        contar_producto();
    });

    //10
    // procesar pedido
    $(document).on("click", "#procesar-pedido", (e) => {
        procesar_pedido();
    });

    function procesar_pedido() {
        let productos;
        productos = RecuperarLS();
        if (productos.length === 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "El Carrito Esta Vacio!",
            });
        } else {
            location.href = rutaBuscarProdCompra;
        }
    }

    async function RecuperarLS_carrito_compra() {
        let productos = RecuperarLS(); // Recuperamos los productos desde el almacenamiento loca
        // Iteramos sobre los productos para procesarlos
        productos.forEach((producto) => {
            var url = rutaProdComprabuscar;

            // Hacemos la solicitud AJAX al backend para obtener los detalles del producto usando solo el ID
            fetch(url, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    Accept: "application/json", // Asegúrate de incluir esta línea
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
                body: JSON.stringify({
                    id: producto.id, // Solo mandamos el ID del producto
                }),
            })
                .then((response) => response.json()) // Esperamos una respuesta JSON del backend
                .then((data) => {
                    // Ahora tenemos los datos del producto, generamos la fila de la tabla
                    let stock = data.stock; // Supongo que el stock viene del backend

                    // Insertamos la fila con los datos necesarios
                    $("#listacompra").append(`
                    <tr prodId="${data.id}" prodPrecio="${data.precio}">
                    <td>${data.nombre}</td>
                     <td>${data.stock}</td>
                     <td class="precio">${data.precio}</td>
                     <td>${data.concentracion}</td>
                     <td>${data.adicional}</td>
                     <td>${data.laboratorio}</td>
                     <td>${data.presentacion}</td>
                     <td>
                        <input type="number" min="1" class="form-control cantidad_producto" value="${data.cantidad}">
                     </td>
                     <td class="subtotales">
                           <h5>${data.subtotal}</h5>
                     </td>
                      <td>
                           <button class="borrar-producto btn btn-danger">
                             <i class="fas fa-times-circle"></i>
                         </button>
                     </td>
                 </tr>
                `);
                })
                .catch((error) => {
                    console.error("Error al obtener el producto:", error);
                });
        });
    }

    $(document).on("click", "#act", (e) => {
        let productos, precios;

        precios = document.querySelectorAll(".precio");

        productos = RecuperarLS();

        productos.forEach(function (producto, indice) {
            producto.precio = precios[indice].textContent;
        });

        localStorage.setItem("productos", JSON.stringify(productos));
        calculartotal();
    });

    $("#cp").on("keyup", ".cantidad_producto", function (e) {
        let producto, id, cantidad, productos, montos, precio, stock;

        // Encuentra la fila donde se hizo la edición
        producto = $(e.target).closest("tr");

        // Obtiene los valores necesarios
        id = producto.attr("prodId");
        precio = parseFloat(producto.attr("prodPrecio"));
        cantidad = parseInt(producto.find(".cantidad_producto").val()) || 0; // Si está vacío, se asume 0

        // Recupera productos del LocalStorage
        productos = RecuperarLS();

        // Encuentra el producto correspondiente
        let productoActual = productos.find((prod) => prod.id === id);

        if (productoActual) {
            stock = productoActual.stock; // Asumiendo que cada producto tiene un campo 'stock'

            // Verifica si la cantidad es mayor que el stock
            if (cantidad > stock) {
                // Muestra un SweetAlert si no hay suficiente stock
                Swal.fire({
                    icon: "error",
                    title: "¡Cantidad excede el stock!",
                    text: `Solo hay ${stock} unidades disponibles.`,
                });

                // Restablece la cantidad a la cantidad máxima en stock
                producto.find(".cantidad_producto").val(stock);
                cantidad = stock; // Actualiza la cantidad a la cantidad máxima
            }

            // Actualiza los valores
            productoActual.cantidad = cantidad;
            productoActual.precio = precio;
            let subtotal = cantidad * precio;
            montos = producto.find(".subtotales h5");
            montos.text(subtotal.toFixed(2)); // Actualiza el subtotal en la tabla

            // Guarda la actualización en LocalStorage
            localStorage.setItem("productos", JSON.stringify(productos));

            // Recalcula el total
            calculartotal();
        }
    });

    $("#pago, #descuento").on("change keyup", function () {
        calculartotal();
    });

    // Función que recalcula el total
    function calculartotal() {
        let productos,
            subtotal,
            con_igv,
            total_sin_descuento,
            pago,
            vuelto,
            descuento;

        let total = 0,
            igv = 0.18;

        productos = RecuperarLS();

        productos.forEach((producto) => {
            let subtotal_producto = Number(producto.precio * producto.cantidad);
            total += subtotal_producto;
        });

        // Captura el valor del pago y descuento
        pago = parseFloat($("#pago").val()) || 0; // Verifica que se obtenga el valor del input
        descuento = parseFloat($("#descuento").val()) || 0;

        console.log(pago, descuento); // Verifica si los valores son correctos

        total_sin_descuento = total.toFixed(2);
        con_igv = parseFloat(total * igv).toFixed(2);

        subtotal = parseFloat(total - con_igv).toFixed(2);

        total = total - descuento;
        vuelto = pago - total;

        // Actualiza los valores en el DOM
        $("#subtotal").html(subtotal);
        $("#con_igv").html(con_igv);
        $("#total_sin_descuento").html(total_sin_descuento);
        $("#total").html(total.toFixed(2));
        $("#vuelto").html(vuelto.toFixed(2));
    }

    //11
    // procesar compra
    $(document).on("click", "#procesar-compra", (e) => {
        procesar_compra();
    });

    function procesar_compra() {
        let clienteRegistrado = $("#cliente_registrado").val();
        let clienteNoRegistrado = $("#cliente_no_registrado").val();

        // Si ambos están vacíos, se envía la venta sin cliente
        let clientereg = clienteRegistrado;
        let clienteNore = clienteNoRegistrado;

        if (RecuperarLS().length == 0) {
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "No hay productos, seleccione algunos",
            }).then(() => {
                location.href = home;
            });
        } else {
            registrar_compra(clientereg, clienteNore);

            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Se Realizo La Compra",
                showConfirmButton: false,
                timer: 1500,
            }).then(function () {
                eliminarLS();
            });
        }
    }

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    function registrar_compra(clientereg, clienteNore) {
        let total = $("#total").text().trim();
        let productos = RecuperarLS(); // Debe ser un array

        let url = CrearVenta;

        $.ajax({
            url: url,
            type: "POST",
            data: {
                total: total,
                cliente: clientereg, // Solo uno de los dos
                cliente1: clienteNore, // Solo uno de los dos
                productos: productos, // Enviar como array, no como JSON string
            },
            dataType: "json", // Asegura que el servidor reciba JSON correctamente
            success: function (response) {
                console.log(response);

                if (response.id) {
                    eliminarLS(); // Primero limpiar el LocalStorage
                    generarBoucher(response.id);
                }
            },
            error: function (xhr, status, error) {
                console.error("Error en la venta:", error);
                console.error("Estado:", status);
                console.error("Respuesta del servidor:", xhr.responseText);

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "Hubo un problema al registrar la venta.",
                });
            },
        });
    }

    function generarBoucher(id) {
        let urlBoucher = generarBoucherURL.replace("__ID__", id);

        // Abrir el PDF en una nueva pestaña
        let nuevaVentana = window.open(urlBoucher, "_blank");

        // Esperar 3 segundos y redirigir al home
        setTimeout(function () {
            window.location.href = home; // Cambia esto por la ruta correcta de tu home location.href = home;
        }, 1000);
    }
});
