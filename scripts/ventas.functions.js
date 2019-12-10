function obtenerDatos() {
    var datoSelect=$("#select_documento").val();

    if (datoSelect!=1){
        $('#input_documento_cliente').prop("readonly", false);
        $('#input_cliente').prop("readonly", false);
        $('#input_direccion').prop("disabled", false);
        $('#button_comprobar').prop("disabled", false);
        $('#input_cliente').val("");
        $('#input_documento_cliente').val("");
    }else{
        $('#input_documento_cliente').val("0");
        $('#input_documento_cliente').prop("readonly", true);
        $('#input_cliente').val("CLIENTE NO ESPECIFADO");
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
function isJsonStructure(str) {
    if (typeof str !== 'string') return false;
    try {
        const result = JSON.parse(str);
        const type = Object.prototype.toString.call(result);
        return type === '[object Object]'
            || type === '[object Array]';
    } catch (err) {
        return false;
    }
}
function enviar_formulario() {
    var total = $("#hidden_total").val();
    var contar_filas = $("#tabla-detalle tr").length;
    var selectOption= $("#select_documento").val();
    var num_documento= $("#input_documento_cliente").val();
    var direccion= $("#input_direccion").val();
    var nombreCliente= $("#input_cliente").val();
    var condicion=true;
   // console.log(contar_filas);
    //enviar form
    //console.log(num_documento.length + "<>" + direccion.length+ "<>" +nombreCliente);
    if (selectOption==3){
        condicion=(num_documento.length==11&&direccion.length>0&&nombreCliente.length>2);
    }
    if (total > 0 && contar_filas > 1 && condicion) {
        console.log(num_documento);
        $.ajax({
            type: "POST",
            url: "procesos/reg_venta.php",
            data: $("#frm_venta").serialize(),
            success: function(data)
            {
                console.log(data);
                if (isJsonStructure(data)){
                    var obj = JSON.parse(data);
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

                            window.location.href = 'ver_preimpresion_venta.php?id_venta=' + obj.venta+ "&periodo="+obj.periodo;
                        }
                    });
                }else{
                    swal("Error en el servidor,  contacte con soporte");
                }
            }
        });
        //document.frm_venta.submit();
    } else {
        alert("FALTA COMPLETAR DATOS");
    }
}

function cargar_editar_proveedor() {
    window.open("mod_proveedor.php?id=" + $("#input_id_proveedor").val());
}

