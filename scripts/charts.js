$(function () {

    /**
     * Options for Line chart
     */

    var lineData = {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [

            {
                label: "Dt 1",
                backgroundColor: 'rgba(98,203,49, 0.5)',
                pointBorderWidth: 1,
                pointBackgroundColor: "rgba(98,203,49,1)",
                pointRadius: 3,
                pointBorderColor: '#ffffff',
                borderWidth: 1,
                data: [16, 32, 18, 26, 42, 33, 44]
            },
            {
                label: "Dt 2",
                backgroundColor: 'rgba(220,220,220,0.5)',
                borderColor: "rgba(220,220,220,0.7)",
                pointBorderWidth: 1,
                pointBackgroundColor: "rgba(220,220,220,1)",
                pointRadius: 3,
                pointBorderColor: '#ffffff',
                borderWidth: 1,
                data: [22, 44, 67, 43, 76, 45, 12]
            }
        ]
    };

    var lineOptions = {
        responsive: true
    };

    var ctx = document.getElementById("lineOptions").getContext("2d");
    new Chart(ctx, {type: 'line', data: lineData, options:lineOptions});

});

