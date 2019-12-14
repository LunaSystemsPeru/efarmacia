$(function () {

    $.getJSON("data/data_ventas_utilidad.php?tipo=1", function (result) {
        var meses = Array();
        var ventas = Array();
        var utilidad = Array();

        $.each(result, function (key, val) {
            meses.push(val.nombre);
            ventas.push(val.venta);
            utilidad.push(val.utilidad);
        })

        new Chart(document.getElementById("lineOptions"),
            {
                "type": "bar",
                "data": {
                    "labels": meses,
                    "datasets": [{
                        "label": "Ventas",
                        "data": ventas,
                        "borderColor": "rgb(255, 99, 132)",
                        "backgroundColor": "rgba(255, 99, 132, 0.4)"
                    }, {
                        "label": "Utilidad",
                        "data": utilidad,
                        "type": "line",
                        "fill": false,
                        "borderColor": "rgb(54, 162, 235)"
                    }]
                },
                "options": {
                    "scales": {
                        "yAxes": [{
                            "ticks": {"beginAtZero": true}
                        }]
                    }
                }
            });
    });

    $.getJSON("data/data_ventas_utilidad.php?tipo=2", function (result) {
        var dias = daysInThisMonth();
        var labels = Array();
        var ventas = Array();
        var utilidad = Array();

        ventas[0] = 0;
        utilidad[0] = 0;

        for (let i = 0; i < dias; i++) {
            labels[i+1] = i+1;
            ventas[i+1] = 0;
            utilidad[i+1] = 0;
        }

        $.each(result, function (key, val) {
            ventas[val.dia] = val.venta;
            utilidad[val.dia] = val.utilidad;
        })

        //console.log(dias);

        new Chart(document.getElementById("grafica_diaria_ventas"),
            {
                "type": "bar",
                "data": {
                    "labels": labels,
                    "datasets": [{
                        "label": "Ventas",
                        "data": ventas,
                        "borderColor": "rgb(255, 99, 132)",
                        "backgroundColor": "rgba(255, 99, 132, 0.4)"
                    }, {
                        "label": "Utilidad",
                        "data": utilidad,
                        "type": "line",
                        "fill": false,
                        "borderColor": "rgb(54, 162, 235)"
                    }]
                },
                "options": {
                    "scales": {
                        "yAxes": [{
                            "ticks": {"beginAtZero": false}
                        }]
                    }
                }
            });
    });


    $.getJSON("data/data_ventas_laboratorio.php?tipo=1", function (result) {
        var laboratorio = Array();
        var ventas = Array();
        var existe = Array();

        $.each(result, function (key, val) {
            laboratorio.push(val.nomlaboratorio);
            ventas.push(val.venta);
            existe.push(val.existe);
        })

        new Chart(document.getElementById("grafica_laboratorio_anio"),
            {
                "type": "bar",
                "data": {
                    "labels": laboratorio,
                    "datasets": [{
                        "label": "Ventas",
                        "data": ventas,
                        "borderColor": "rgb(255, 99, 132)",
                        "backgroundColor": "rgba(255, 99, 132, 0.4)"
                    }, {
                        "label": "Existe",
                        "data": existe,
                        "type": "line",
                        "fill": false,
                        "borderColor": "rgb(54, 162, 235)"
                    }]
                },
                "options": {
                    "scales": {
                        "yAxes": [{
                            "ticks": {"beginAtZero": true}
                        }]
                    }
                }
            });
    });

    $.getJSON("data/data_ventas_laboratorio.php?tipo=2", function (result) {
        var laboratorio = Array();
        var ventas = Array();

        $.each(result, function (key, val) {
            laboratorio.push(val.nomlaboratorio);
            ventas.push(val.venta);
        })

        new Chart(document.getElementById("grafica_laboratorio_mes"),
            {
                "type": "bar",
                "data": {
                    "labels": laboratorio,
                    "datasets": [{
                        "label": "Ventas",
                        "data": ventas,
                        "borderColor": "rgb(54, 162, 235)",
                        "backgroundColor": "rgba(54, 162, 235, 0.4)"
                    }]
                },
                "options": {
                    "scales": {
                        "yAxes": [{
                            "ticks": {
                                "beginAtZero": true,
                                "autoSkip": false,
                                "maxRotation": 90,
                                "minRotation": 90
                            }
                        }]
                    }
                }
            });
    });

});


function daysInThisMonth() {
    var now = new Date();
    return new Date(now.getFullYear(), now.getMonth()+1, 0).getDate();
}