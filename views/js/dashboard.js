$(document).ready(function () {
    if ($('#ChartOrdersxMonth').length > 0) {
            /* ===================================================
               TOTAL ORDERS DELIVERED BY MONTH
            ===================================================*/
            var datos = new FormData();
            datos.append('OrdenesxMes', "ok");
            $.ajax({
                type: 'post',
                url: 'ajax/dashboard.ajax.php',
                data: datos,
                dataType: 'json',
                cache: false,
                contentType: false,
                processData: false,
                success: function (response) {
                    console.log(response);
                    var labelsfromJson = Array();
                    var datafromJson = Array();
                    for (let index = 0; index < response.length; index++) {
                        labelsfromJson.push(response[index].mes);
                        datafromJson.push(parseInt(response[index].Cantidad, 10));
                    }

                    // Get context with jQuery - using jQuery's .get() method.
                    var ordersChartCanvas = $('#ChartOrdersxMonth').get(0).getContext('2d');

                    var ordersChartData = {
                        labels: labelsfromJson,
                        datasets: [
                            {
                                label: 'Orders Delivered',
                                backgroundColor: '#6c757d',
                                borderColor: '#5bc0de',
                                data: datafromJson
                            },
                        ]
                    }

                    var ordersChartOptions = {
                        maintainAspectRatio: false,
                        responsive: true,
                        legend: {
                            display: false
                        },
                        scales: {
                            yAxes: [
                                {
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }
                            ]
                        },
                        plugins: {
                            datalabels: {
                                align: "center",
                                anchor: "end",
                                color: "black",
                                labels: {
                                    title: {
                                        font: {
                                            weight: "bold"
                                        }
                                    },
                                    value: {
                                        color: "green"
                                    }
                                }
                            }
                        }
                    }

                    // This will get the first returned node in the jQuery collection.
                    new Chart(ordersChartCanvas, {
                        type: 'bar',
                        data: ordersChartData,
                        options: ordersChartOptions
                    }
                    )


                }
            });
    }
});