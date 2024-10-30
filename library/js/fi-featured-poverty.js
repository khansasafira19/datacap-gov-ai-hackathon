// Example call to load data for the first chart
loadChartDataMap("4", "2024", "d1-chart1", "#FF0000");
loadChartDataSingleVar("5", "line", "d1-chart2", "#1acc8d");
loadChartDataSingleVarPie("5", "pie", "d1-chart3", "#1acc8d", "2023");
loadChartDataSingleVar("7", "spline", "d1-chart4", "#1acc8d");
loadChartDataSingleVar("4", "scatter", "d1-chart5", "#1acc8d");

$(document).ready(function () {
    $('#create-ai-insight').on('click', function () {
        // Step 1: Fade out the button
        $('#button-container').fadeOut(600, function () {
            // Step 2: Show the loading bar once button has faded out
            $('#loading-bar').fadeIn(300);

            // Step 3: Fetch data and replace content after loading
            $.ajax({
                url: window.location.href + "/../../featured/insight",
                type: 'GET',
                data: { variable: '4,5,7' },
                timeout: 60000,  // 10 seconds
                success: function (response) {
                    $('#loading-bar').fadeOut(300, function () {
                        $('#insight-content').html(response).fadeIn(600);
                    });
                },
                error: function (xhr, status, error) {
                    console.error('Failed to load AI insights:', error);
                }
            });
        });
    });
});