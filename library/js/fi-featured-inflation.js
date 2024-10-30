
// Example call to load data for a chart with multiple series
loadChartDataMultiVar("4,5,8", "column", "d2-chart1"); // Example for multiple series
loadChartDataMultiVar("4,5,6", "spline", "d2-chart2"); // Example for multiple series
loadChartDataMultiVar("12,8", "area", "d2-chart3"); // Example for multiple series
loadChartDataMultiVar("4", "pie", "d2-chart4"); // Example for multiple series
loadChartDataMultiVar("7,8,12", "scatter", "d2-chart5"); // Example for multiple series

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
                data: { variable: '6,7,8,12' },
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