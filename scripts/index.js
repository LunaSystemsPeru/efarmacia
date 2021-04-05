$(function () {

    $.getJSON("data/data_datos_index.php?tipo=1", function (result) {
        var periodo = Array();
        var cantidad = Array();

        $.each(result, function (key, val) {
            periodo.push(val.anio_vcto + "-" + val.mes_vcto);
            cantidad.push(val.stock_vence);
        })

        for (let i = 0; i < cantidad.length; i++) {
            console.log(periodo[i]);
            $("#table-cantidades tbody").append('<tr>' +
                '<td>' +
                    '<a href="javascript:void(0);" onclick="verVencidos(\'' + periodo[i] + '\')">' +
                        'VENCIMIENTO AL ' + periodo[i] +
                    '</a>' +
                '</td>' +
                '<td class="text-right">' + cantidad[i] + '</td>' +
                '</tr>');
        }
    });


});