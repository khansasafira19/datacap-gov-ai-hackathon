
// Example call to load data for the first chart
loadChartDataMap("6", "2024", "d4-chart1", "#FF0000");
loadChartDataMultiViz("12,8", "spline,spline", "d4-chart2"); // Example for multiple viz
loadChartDataMultiViz("8", "area", "d4-chart3"); // Example for multiple viz
loadChartDataMultiViz("12", "line", "d4-chart4"); // Example for multiple viz
loadChartDataMultiViz("7", "column", "d4-chart5"); // Example for multiple viz

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