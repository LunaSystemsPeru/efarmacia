function validarDocumento () {

    var parametros = {
        "documento": $("#input_documento_cliente").val()
    };

    $.ajax({
        data: parametros,
        url: './procesos/verificar_documento_cliente.php',
        type: 'get',
        beforeSend: function () {
            $.toast({
                heading: 'Validacion de Documento',
                text: 'Estamos buscando los datos de este cliente',
                position: 'top-right',
                loaderBg: '#fff',
                icon: 'info',
                hideAfter: 3000,
                stack: 1
            });
        },
        success: function (response) {
            var json = JSON.parse(response);

            var success = json.success;
            console.log(json);

            if (success === "nuevo" || success === "existe") {
               // $("#btn_guardar").prop('disabled', false);
                $("#input_documento_cliente").prop('readonly', true);
                $("#btn_comprueba").prop('disabled', true);
                $("#input_datos_cliente").prop('readonly', true);
                $("#input_cliente").val(json.datos);
                $("#input_direccion").val(json.direccion);
            }
            if (success === "existe") {
               // $("#btn_guardar").prop('disabled', true);
              //  alertarClienteExiste();

            }
            if (success === "error") {
               // $("#btn_guardar").prop('disabled', true);
                alertarErrorDocumento();
            }


        },
        error: function () {
            alert("error al procesar");
        }
    });
}

function alertarClienteExiste () {
    $.toast({
        heading: 'Validacion de Documento',
        text: 'Este cliente ya existe!!.',
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'error',
        hideAfter: 3000,
        stack: 1
    });
}
function alertarErrorDocumento () {
    $.toast({
        heading: 'Validacion de Documento',
        text: 'Error al ingresar el Documento!',
        position: 'top-right',
        loaderBg: '#fff',
        icon: 'error',
        hideAfter: 3000,
        stack: 1
    });
}