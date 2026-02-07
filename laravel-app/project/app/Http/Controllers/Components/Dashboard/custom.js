$(document).ready(function() {
    let chart = null;

    function generateMonthlyEarning() {
        // Destroy the existing chart if it exists
        if (chart) {
            chart.destroy();
        }
        var data = $('.data-filter').serialize();
        var url = getRunURL('lineChart');
        var request = main.form_ajax(url, data, 'POST', function(xhr) {
           main.block_ui('#activities-chart-monthly');
        });
        request.done(function(response) {
            console.log(response.data_pending)
            var options = {
                series: [
                    // {
                    //     name: "Pendings",
                    //     data: response.data_pending.data
                    // },
                    {
                        name: "Completed",
                        data: response.data_paid
                    }
                ],
                chart: {
                    height: 300,
                    type: 'line',
                    zoom: {
                        enabled: false,
                    },
                    dropShadow: {
                        enabled: true,
                        color: '#000',
                        top: 18,
                        left: 7,
                        blur: 16,
                        opacity: 0.2
                    },
                    toolbar: {
                        show: false
                    }
                },
                colors: ['#f0746c', '#255cd3'],
                dataLabels: {
                    enabled: false,
                },
                stroke: {
                    width: [3, 3],
                    curve: 'smooth'
                },
                grid: {
                    show: false,
                },
                markers: {
                    colors: ['#f0746c', '#255cd3'],
                    size: 5,
                    strokeColors: '#ffffff',
                    strokeWidth: 2,
                    hover: {
                        sizeOffset: 2
                    }
                },
                xaxis: {
                    categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    labels: {
                        style: {
                            colors: '#8c9094'
                        }
                    }
                },
                yaxis: {
                    min: 0,
                    max: response.total_paid,
                    labels: {
                        style: {
                            colors: '#8c9094'
                        }
                    }
                },
                legend: {
                    position: 'top',
                    horizontalAlign: 'right',
                    floating: true,
                    offsetY: 0,
                    labels: {
                        useSeriesColors: true
                    },
                    markers: {
                        width: 10,
                        height: 10,
                    }
                }
            };
        
            // Create a new chart instance and render it
            chart = new ApexCharts(document.querySelector("#activities-chart-monthly"), options);
            chart.render();

            $('#activities-chart-monthly').unblock();

        });


    }
    generateMonthlyEarning();
    // Initial call to generate the chart
    $(document).on('change', '#selectYearFilter', function() {
        generateMonthlyEarning();

    });



});
