function obtenerDatos() {
    var datoSelect=$("#select_documento").val();

    if (datoSelect!=1){
        $('#input_documento_cliente').prop("disabled", false);
        $('#input_cliente').prop("disabled", false);
        $('#input_direccion').prop("disabled", false);
        $('#button_comprobar').prop("disabled", false);

    }else{
        $('#input_documento_cliente').prop("disabled", true);
        $('#input_cliente').prop("disabled", true);
        $('#input_direccion').prop("disabled", true);
        $('#button_comprobar').prop("disabled", true);
    }
    var parametros = {
        "idtido": datoSelect
    };

    $.ajax({
        data: parametros,
        url: './procesos/obtener_documento_sunat.php',
        type: 'get',
        beforeSend: function () {
            $("#input_serie").val("");
            $("#input_numero").val("");
        },
        success: function (response) {
            console.log(response)
            var json = JSON.parse(response);
            $("#input_serie").val(json.serie);
            $("#input_numero").val(json.numero);
        },
        error: function () {
            alert("error al procesar");
        }
    });
}

function comprobarCliente() {
    var documento_venta = $("#select_documento").val();
    var documento_cliente = $("#input_documento_cliente").val();
    if (documento_venta == 2) {
        if (documento_cliente.length == 8) {
            validarDocumento();
        } else {
            swal("SOLO PUEDEN INGRESAR 8 DIGITOS");
        }
    }
    if (documento_venta == 3) {
        if (documento_cliente.length == 11) {
            validarDocumento();
        } else {
            swal("SOLO PUEDEN INGRESAR 11 DIGITOS");
        }
    }
}

function validar_detalle() {
    var permitir = false;
    var cantidad = $('#input_cantidad_producto').val();
    if (cantidad === "") {
        swal("NO HA INGRESADO CANTIDAD DEL PRODUCTO A VENDER!");
        $('#input_cantidad_producto').focus();
    } else {
        permitir = true;
    }
    return permitir;
}

function agregarProducto() {
    var datainput = {
        id_producto: $('#hidden_codigo_producto').val(),
        descripcion: $('#input_descripcion_producto').val(),
        precio: $('#input_precio_producto').val(),
        costo: $('#input_costo_producto').val(),
        cantidad: $('#input_cantidad_producto').val(),
        action: 1
    }
    obtenerDetalle(datainput);
}

function eliminarProducto(idproducto) {
    var datainput = {
        id_producto: idproducto,
        action: 2
    }
    obtenerDetalle(datainput);
}

function addProductos() {
    $.ajax({
        data: {
            input_id_producto: $('#hidden_id_producto').val(),
            input_descripcion_producto: $('#hidden_descripcion_producto').val(),
            input_costo_producto: $('#hidden_costo').val(),
            input_precio_producto: $('#input_precio').val(),
            input_cantidad_producto: $('#input_cventa').val(),
            input_lote_producto: $('#input_lote').val(),
            input_vcto_producto: $('#input_vencimiento').val()
        },
        url: 'ajax_post/add_productos_ventas.php',
        type: 'GET',
        //dataType: 'json',
        beforeSend: function () {
            //$('#body_detalle_pedido').html("");
            $('table tbody').html("");
        },
        success: function (r) {
            //alert(r);
            $('table tbody').append(r);
            clean();
            //$('#body_detalle_pedido').html(r);
        },
        error: function () {
            alert('Ocurrio un error en el servidor ..');
            $('table tbody').html("");
            //$('#body_detalle_pedido').html("");
        }
    });
}

function eliminar_item(id_producto) {
    $.ajax({
        data: {
            input_id_producto: id_producto
        },
        url: 'ajax_post/del_productos_venta.php',
        type: 'GET',
        //dataType: 'json',
        beforeSend: function () {
            //$('#body_detalle_pedido').html("");
            $('table tbody').html("");
        },
        success: function (r) {
            //alert(r);
            $('table tbody').append(r);
            clean();
            //$('#body_detalle_pedido').html(r);
        },
        error: function () {
            alert('Ocurrio un error en el servidor ..');
            $('table tbody').html("");
            //$('#body_detalle_pedido').html("");
        }
    });
}

function obtenerDetalle(datainput) {
    $.ajax({
        data: datainput,
        url: '../controller/ProductosVentaSession.php',
        type: 'POST',
        //dataType: 'json',
        beforeSend: function () {
            $('table tbody').html("");
        },
        success: function (r) {
            //alert(r);
            $('table tbody').append(r);
            clean();
        },
        error: function () {
            alert('Ocurrio un error en el servidor ..');
            $('table tbody').html("");
        }
    });
}

function clean() {
    $('#hidden_id_producto').val('');
    $('#input_producto').val('');
    $('#hidden_costo').val('0.00');
    $('#input_precio').val('0.00');
    $('#input_lote').val('');
    $('#input_vencimiento').val('');
    $('#input_cactual').val('');
    $('#input_cventa').val('');
    $('#hidden_descripcion_producto').val('');
    $('#btn_add_producto').prop("disabled", true);
    $('#btn_guardar_formulario').prop("disabled", false);
    $('#input_cventa').prop("readonly", true);
    $('#input_costo').prop("readonly", true);
    $('#input_precio').prop("readonly", true);
    $('#input_producto').focus();
}

function enviar_formulario() {
    var total = $("#hidden_total").val();
    var contar_filas = $("#tabla-detalle tr").length;
    console.log(contar_filas);
    //enviar form
    if (total > 0 && contar_filas > 1) {
        document.frm_venta.submit();
    } else {
        alert("FALTA COMPLETAR DATOS");
    }
}

function cargar_editar_proveedor() {
    window.open("mod_proveedor.php?id=" + $("#input_id_proveedor").val());
}


function enviar_datos() {
    var parametros = {
        datos_cliente: $('#input_datos_cliente').val(),
        documento_cliente: $('#input_documento_cliente').val(),
        direccion_cliente: $('#input_direccion_cliente').val(),
        total_pedido: $('#input_total_pedido').val(),
        documento_venta: $('#select_documento').val(),
    };
    $.ajax({
        data: parametros, //datos que se envian a traves de ajax
        url: '../controller/reg_venta.php', //archivo que recibe la peticion
        type: 'post', //método de envio
        beforeSend: function () {
            $("#resultado").html("Procesando, espere por favor...");
        },
        success: function (response) { //una vez que el archivo recibe el request lo procesa y lo devuelve
            $("#resultado").html(response);
            var json_response = JSON.parse(response);
            if (response.valor == 0) {
                swal({
                    title: "Error al Registrar",
                    text: response,
                    type: "error",
                    showCancelButton: false,
                    //cancelButtonClass: 'btn-secondary ',
                    confirmButtonColor: "#DD6B55",
                    //confirmButtonText: "Ver Ticket",
                    cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: true,
                    closeOnCancel: true
                });
            } else {
                swal({
                    title: "Venta Registrada",
                    text: "El documento de venta se registro con exito!",
                    type: "success",
                    showCancelButton: false,
                    //cancelButtonClass: 'btn-secondary ',
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Ver Ticket",
                    //cancelButtonText: "No, cancel plx!",
                    closeOnConfirm: false,
                    //closeOnCancel: false
                }, function (isConfirm) {
                    if (isConfirm) {

                        window.location.href = 'ver_preimpresion_venta.php?id_venta=' + json_response.valor;
                    }
                });
            }
        }
    });
}