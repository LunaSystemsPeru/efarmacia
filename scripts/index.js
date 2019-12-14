$(function () {

    $.getJSON("data/data_datos_index.php?tipo=2", function (result) {
        console.log(result);
        $.each(result, function (key, val) {

        })


    });

    $.getJSON("data/data_datos_index.php?tipo=1", function (result) {
        var periodo = Array();
        var cantidad = Array();

        $.each(result, function (key, val) {
            periodo.push(val.anio_vcto + "-" + val.mes_vcto);
            cantidad.push(val.stock_vence);
        })

        for (let i = 0; i < cantidad; i++) {
            $("#table-cantidades tbody").append('<tr><td>VENCIMIENTO AL '+periodo[i]+'</td><td class="text-right">"+cantidad[i]+"</td></tr>');
        }
    });
});