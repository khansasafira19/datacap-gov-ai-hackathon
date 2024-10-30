
Highcharts.setOptions({
  chart: {
    backgroundColor: "transparent", // Set background transparent for all charts
  },
  title: {
    style: {
      fontFamily: "Poppins, sans-serif", // Set font to Poppins for chart title
      fontWeight: "600",
    },
  },
  subtitle: {
    style: {
      fontFamily: "Poppins, sans-serif", // Set font to Poppins for chart subtitle
      fontWeight: "500",
    },
  },
  xAxis: {
    visible: false, // Hide the entire x-axis
  },
  yAxis: {
    visible: false, // Hide the entire y-axis
  },
  legend: {
    itemStyle: {
      fontFamily: "Poppins, sans-serif", // Set font to Poppins for legend
      fontWeight: "400",
    },
  },
  tooltip: {
    style: {
      fontFamily: "Poppins, sans-serif", // Set font to Poppins for tooltips
      fontWeight: "400",
    },
    crosshairs: true,
    shared: true,
    useHTML: true, // Allow HTML for styling
    backgroundColor: "#fff", // Set a white background
    borderColor: "#bbb", // Add a light gray border
    borderRadius: 8, // Rounded corners for a smooth look
  },
  credits: {
    enabled: false,
  },
  plotOptions: {
    series: {
      animation: {
        duration: 1500,
      },
      marker: {
        enabled: true,
      },
      lineWidth: 2,
      connectNulls: false, // Don't connect null values in line charts
    },
    column: {
      // Column options also apply to bar chart types
      borderRadius: 100, // Rounded corners for bars/columns
      groupPadding: 0.1,
    },
    bar: {
      borderRadius: "50%",
      dataLabels: {
        enabled: false,
      },
      groupPadding: 0.1,
    },
    line: {
      marker: {
        enabled: true, // Ensure markers are visible even if there are nulls
      }
    },
  },
});

// Function to add annotation to the highest or latest value
function addAnnotations(chart, data, annotationType) {
  let point;

  if (annotationType === "highest") {
    // Find the highest value in the data
    let maxIndex = data.indexOf(Math.max(...data));
    point = chart.series[0].data[maxIndex];
  } else if (annotationType === "latest") {
    // Use the latest value in the series
    point = chart.series[0].data[data.length - 1];
  }
  ("");
  if (point) {
    chart.addAnnotation({
      labels: [
        {
          point: point,
          // text: annotationType === 'highest' ? 'Highest Value' : 'Latest Value',
          // backgroundColor: '#ffcccc',
          // borderColor: '#ff0000',
          style: {
            fontSize: "12px",
            fontFamily: "Poppins, sans-serif",
          },
        },
      ],
    });
  }
}

function loadChartDataSingleVar(variable, chartType, chartId, colorTheme) {
  $.ajax({
    url: window.location.href + "/../../featured/getdata",
    data: { variable: variable },
    success: function (response) {
      if (response.length > 0) {
        var title = response[0].title; // Assuming the title is the same for all rows
        var unit = response[0].unit; // Unit for the data values

        // If it's a pie chart, structure the data differently
        var seriesData =
          chartType === "pie"
            ? response.map((item) => ({
              name: item.fk_dimension_province,
              y: parseFloat(item.tables_value),
            }))
            : response.map((item) => parseFloat(item.tables_value));

        var categories = response.map((item) => item.year); // For non-pie charts

        Highcharts.chart(
          chartId,
          {
            chart: {
              type: chartType,
            },
            title: {
              text: title, // Set the dynamic title
              align: "left",
            },
            xAxis:
              chartType !== "pie"
                ? {
                  categories: categories,
                  title: {
                    text: title, // Example label for x-axis
                  },
                }
                : undefined, // xAxis is not used for pie charts
            yAxis:
              chartType !== "pie"
                ? {
                  title: {
                    text: unit || "", // Set the y-axis label to the unit (or 'Values' if no unit is available)
                  },
                }
                : undefined, // yAxis is not used for pie charts
            series: [
              {
                name: title, // Name for the series, could be title or something else
                data: seriesData, // Use the structured data for pie or regular chart
                color: colorTheme, // Set the color theme for the series
              },
            ],
            tooltip: {
              useHTML: true, // Enable HTML in the tooltip
              formatter: function () {
                var pointName = this.point.name || this.x; // Use point.name for pie charts, x for others
                var pointValue = this.point.value || this.y; // Use point.value for pie charts, y for others
                var displayUnit = unit ? " " + unit : ""; // Only add unit if it's not null or empty

                return (
                  '<span style="font-size: 12px;">' +
                  '<i class="fas fa-check-circle text-primary"></i> ' + // FontAwesome icon
                  '<span style="font-size: smaller;">' +
                  pointName +
                  "</span><br>" +
                  '<i class="far fa-circle text-success"></i> ' +
                  this.series.name + // Use the adjusted pointName
                  ": <strong>" +
                  pointValue + // Use the adjusted pointValue
                  "</strong>" +
                  displayUnit // Only show unit if it's available
                );
              },
            },
            annotations: [],
            plotOptions: {
              area: {
                marker: {
                  enabled: false,
                  symbol: "circle",
                  radius: 2,
                  states: {
                    hover: {
                      enabled: true,
                    },
                  },
                },
                color: {
                  linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 1,
                    y2: 1,
                  },
                  stops: [
                    [0, "#FFFFFF"], // Almost white
                    [1, colorTheme], // The color theme passed to the function
                  ],
                },
              },
              scatter: {
                tooltip: {
                  pointFormatter: function () {
                    // Customize the tooltip for scatter points
                    return (
                      "Year: <b>" +
                      this.category +
                      "</b><br>" +
                      "Value: <b>" +
                      this.y +
                      "</b>"
                    );
                  },
                },
                lineWidth: 0, // Remove any connecting lines for the scatter plot
                marker: {
                  radius: 5, // You can adjust the marker size here
                  fillColor: colorTheme, // Apply the color theme to scatter points
                },
              },
            },
          },
          function (chart) {
            // Add annotations after the chart is created
            const data = chart.series[0].data.map((point) => point.y);
            addAnnotations(chart, data, "highest"); // Annotate highest value
            addAnnotations(chart, data, "latest"); // Annotate latest value
          }
        );
        $(document).ready(function () {
          Highcharts.mapChart('poverty-chart', { /* options */ });
          Highcharts.mapChart('inflation-chart', { /* options */ });
        });
      }
    },
  });
}

function loadChartDataSingleVarPie(variable, chartType, chartId, colorTheme, year) {
  $.ajax({
    url: window.location.href + "/../../featured/getdatapie",
    data: {
      variable: variable,
      year: year
    },
    success: function (response) {
      if (response.length > 0) {
        var title = response[0].title; // Assuming the title is the same for all rows
        var unit = response[0].unit; // Unit for the data values

        // If it's a pie chart, structure the data differently
        var seriesData =
          chartType === "pie"
            ? response.map((item) => ({
              name: item.province_name,
              y: parseFloat(item.tables_value),
            }))
            : response.map((item) => parseFloat(item.tables_value));

        var categories = response.map((item) => item.year); // For non-pie charts

        Highcharts.chart(
          chartId,
          {
            chart: {
              type: chartType,
            },
            title: {
              text: title, // Set the dynamic title
              align: "left",
            },
            xAxis:
              chartType !== "pie"
                ? {
                  categories: categories,
                  title: {
                    text: title, // Example label for x-axis
                  },
                }
                : undefined, // xAxis is not used for pie charts
            yAxis:
              chartType !== "pie"
                ? {
                  title: {
                    text: unit || "", // Set the y-axis label to the unit (or 'Values' if no unit is available)
                  },
                }
                : undefined, // yAxis is not used for pie charts
            series: [
              {
                name: title, // Name for the series, could be title or something else
                data: seriesData, // Use the structured data for pie or regular chart
                color: colorTheme, // Set the color theme for the series
              },
            ],
            tooltip: {
              useHTML: true, // Enable HTML in the tooltip
              formatter: function () {
                var pointName = this.point.name || this.x; // Use point.name for pie charts, x for others
                var pointValue = this.point.value || this.y; // Use point.value for pie charts, y for others
                var displayUnit = unit ? " " + unit : ""; // Only add unit if it's not null or empty

                return (
                  '<span style="font-size: 12px;">' +
                  '<i class="fas fa-check-circle text-primary"></i> ' + // FontAwesome icon
                  '<span style="font-size: smaller;">' +
                  pointName +
                  "</span><br>" +
                  '<i class="far fa-circle text-success"></i> ' +
                  this.series.name + // Use the adjusted pointName
                  ": <strong>" +
                  pointValue + // Use the adjusted pointValue
                  "</strong>" +
                  displayUnit // Only show unit if it's available
                );
              },
            },
            annotations: [],
            plotOptions: {
              area: {
                marker: {
                  enabled: false,
                  symbol: "circle",
                  radius: 2,
                  states: {
                    hover: {
                      enabled: true,
                    },
                  },
                },
                color: {
                  linearGradient: {
                    x1: 0,
                    y1: 0,
                    x2: 1,
                    y2: 1,
                  },
                  stops: [
                    [0, "#FFFFFF"], // Almost white
                    [1, colorTheme], // The color theme passed to the function
                  ],
                },
              },
              scatter: {
                tooltip: {
                  pointFormatter: function () {
                    // Customize the tooltip for scatter points
                    return (
                      "Year: <b>" +
                      this.category +
                      "</b><br>" +
                      "Value: <b>" +
                      this.y +
                      "</b>"
                    );
                  },
                },
                lineWidth: 0, // Remove any connecting lines for the scatter plot
                marker: {
                  radius: 5, // You can adjust the marker size here
                  fillColor: colorTheme, // Apply the color theme to scatter points
                },
              },
            },
          },
          function (chart) {
            // Add annotations after the chart is created
            const data = chart.series[0].data.map((point) => point.y);
            addAnnotations(chart, data, "highest"); // Annotate highest value
            addAnnotations(chart, data, "latest"); // Annotate latest value
          }
        );
      }
    },
  });
}

function loadChartDataMultiVar(variables, chartType, chartId) {
  $.ajax({
    url: window.location.href + "/../../featured/getdatamulti",
    data: { variable: variables }, // Pass comma-separated variables
    success: function (response) {
      if (Object.keys(response).length > 0) {
        var series = [];
        var categories = Object.keys(response); // Extract years for x-axis
        var titles = [];

        if (chartType === "pie") {
          // For pie charts, format the series differently
          series.push({
            name: "Data", // Generic name for the pie chart
            colorByPoint: true,
            data: categories.map((year) => {
              return {
                name: year, // Use year or any relevant label for each slice
                y: response[year][Object.keys(response[year])[0]].value || 0, // Use value for each slice, default to 0 if missing
              };
            }),
          });

          // Collect titles for pie chart
          titles.push(
            response[categories[0]][Object.keys(response[categories[0]])[0]]
              .title
          );
        } else {
          // For other chart types (e.g., line, bar), create a series for each variable
          for (const variable of Object.keys(response[categories[0]])) {
            const data = categories.map((year) => {
              return response[year][variable]
                ? response[year][variable].value
                : 0; // Default to 0 if not available
            });

            series.push({
              name: variable, // Use the variable name for the series
              data: data,
            });

            // Collect titles for each variable
            if (
              response[categories[0]][variable] &&
              response[categories[0]][variable].title
            ) {
              titles.push(response[categories[0]][variable].title);
            }
          }
        }

        Highcharts.chart(
          chartId,
          {
            chart: {
              type: chartType,
            },
            title: {
              text: titles.join(",<br>"), // Combine all variable titles with a comma
              align: "left",
            },
            xAxis:
              chartType !== "pie"
                ? {
                  categories: categories,
                  title: {
                    text: "Year", // Example label for x-axis
                  },
                }
                : undefined, // xAxis is not used for pie charts
            yAxis:
              chartType !== "pie"
                ? {
                  title: {
                    text:
                      response[categories[0]][
                        Object.keys(response[categories[0]])[0]
                      ].unit || "",
                  },
                }
                : undefined, // yAxis is not used for pie charts
            series: series, // Pass the constructed series (formatted for pie or other charts)
            annotations: [],
            plotOptions: {
              area: {
                marker: {
                  enabled: false,
                  symbol: "circle",
                  radius: 2,
                  states: {
                    hover: {
                      enabled: true,
                    },
                  },
                },
              },
              scatter: {
                tooltip: {
                  pointFormatter: function () {
                    // Customize the tooltip for scatter points
                    return (
                      "Year: <b>" +
                      this.category +
                      "</b><br>" +
                      "Value: <b>" +
                      this.y +
                      "</b>"
                    );
                  },
                },
                lineWidth: 0, // Remove any connecting lines for the scatter plot
                marker: {
                  radius: 5, // You can adjust the marker size here
                },
              },
            },
          },
          function (chart) {
            // Add annotations after the chart is created
            const data = chart.series[0].data.map((point) => point.y);
            addAnnotations(chart, data, "highest"); // Annotate highest value
            addAnnotations(chart, data, "latest"); // Annotate latest value
          }
        );
      }
    },
  });
}

function loadChartDataMultiViz(variables, chartTypes, chartId) {
  $.ajax({
    url: window.location.href + "/../../featured/getdatamulti",
    data: { variable: variables }, // Pass comma-separated variables
    success: function (response) {
      if (Object.keys(response).length > 0) {
        var series = [];
        var categories = Object.keys(response); // Extract years for x-axis
        var titles = [];
        chartTypes = chartTypes.split(",").map((type) => type.trim());
        variables = variables.split(",").map((variable) => variable.trim()); // Ensure variables are treated as an array

        // Loop through variables and assign the correct chart type
        for (let i = 0; i < variables.length; i++) {
          const variable = variables[i];
          const chartType = chartTypes[i] || "line"; // Default to 'line' if no chartType is provided

          if (chartType === "pie") {
            // For pie charts, format the series differently
            series.push({
              type: chartType,
              name: "Data", // Generic name for the pie chart
              colorByPoint: true,
              data: categories.map((year) => {
                return {
                  name: year, // Use year or any relevant label for each slice
                  y: response[year][Object.keys(response[year])[0]].value || 0, // Use value for each slice, default to 0 if missing
                };
              }),
            });

            // Collect titles for pie chart
            titles.push(
              response[categories[0]][Object.keys(response[categories[0]])[0]]
                .title
            );
          } else {
            // For other chart types (e.g., line, bar), create a series for each variable
            // const data = categories.map(year => {
            //     return response[year][variable] ? response[year][variable].value : 0; // Default to 0 if not available
            // });
            const data = categories.map((year) => {
              // If the response value is null, let it stay as null
              return response[year][Object.keys(response[year])[i]].value !== null
                ? response[year][Object.keys(response[year])[i]].value
                : null; // Leave as null if no value
            });

            series.push({
              type: chartType,
              name: response[categories[0]][
                Object.keys(response[categories[0]])[i]
              ].title,
              // name: variable, // Use the variable name for the series
              data: data,
            });

            // Collect titles for each variable
            // titles.push(response[categories[0]][Object.keys(response[categories[0]])[0]].title);
            titles.push(
              response[categories[0]][Object.keys(response[categories[0]])[i]]
                .title
            );
          }
        }

        Highcharts.chart(
          chartId,
          {
            chart: {
              type: "container", // Use a container chart to hold multiple series
            },
            title: {
              text: titles.join(",<br>"), // Combine all variable titles with a comma
              align: "left",
            },
            xAxis: {
              categories: categories,
              title: {
                text: "Year", // Example label for x-axis
              },
            },
            yAxis: {
              title: {
                text:
                  response[categories[0]][
                    Object.keys(response[categories[0]])[0]
                  ].unit || "",
              },
            },
            series: series, // Pass the constructed series (formatted for pie or other charts)
            annotations: [],
            plotOptions: {
              area: {
                marker: {
                  enabled: false,
                  symbol: "circle",
                  radius: 2,
                  states: {
                    hover: {
                      enabled: true,
                    },
                  },
                },
              },
              scatter: {
                tooltip: {
                  pointFormatter: function () {
                    // Customize the tooltip for scatter points
                    return (
                      "Year: <b>" +
                      this.category +
                      "</b><br>" +
                      "Value: <b>" +
                      this.y +
                      "</b>"
                    );
                  },
                },
                lineWidth: 0, // Remove any connecting lines for the scatter plot
                marker: {
                  radius: 5, // You can adjust the marker size here
                },
              },
            },
          },
          function (chart) {
            // Add annotations after the chart is created
            const data = chart.series[0].data.map((point) => point.y);
            addAnnotations(chart, data, "highest"); // Annotate highest value
            addAnnotations(chart, data, "latest"); // Annotate latest value
          }
        );
      }
    },
  });
}

// function loadChartDataMap(variable, year, chartId, colorTheme) {
//   $.ajax({
//     url: window.location.href + "/../../featured/getdatamap",
//     data: { variable: variable, year: year }, // Pass the year as a parameter
//     success: function (response) {
//       if (response.length > 0) {
//         var title = response[0].title + " Tahun " + response[0].year; // Assuming the title is the same for all rows
//         var unit = response[0].unit; // Unit for the data values

//         // Map-specific data structure
//         var seriesData = response.map((item) => ({
//           "hc-key": item.province_highchart_code.toLowerCase(), // Ensure the province code matches map file
//           value: parseFloat(item.tables_value), // Parse the value as float
//         }));

//         // Load the map data from GeoJSON using jQuery's getJSON
//         $.getJSON("../library/json/id-all.topo.json", function (geojson) {
//           Highcharts.mapChart(chartId, {
//             chart: {
//               map: geojson,
//             },
//             title: {
//               text: title, // Set the dynamic title
//               align: "left",
//             },
//             colorAxis: {
//               min: 0,
//               stops: [
//                 [0, "#FFFFFF"], // Almost white (light shade)
//                 [1, colorTheme], // Custom color passed to the function (almost red in this case)
//               ],
//             },
//             tooltip: {
//               useHTML: true, // Enable HTML in the tooltip
//               formatter: function () {
//                 var displayUnit = unit ? " " + unit : ""; // Only add unit if it's not null or empty
//                 return (
//                   '<span style="font-size: 12px;">' +
//                   '<i class="fas fa-check-circle text-primary"></i> ' + // FontAwesome icon
//                   '<span style="font-size: smaller;">' +
//                   this.series.name +
//                   "</span><br>" + '<i class="far fa-circle text-success"></i> ' +
//                   this.point.name +
//                   ": <strong>" +
//                   this.point.value +
//                   "</strong> " +
//                   displayUnit
//                 );
//               },
//             },
//             series: [
//               {
//                 data: seriesData,
//                 mapData: geojson,
//                 joinBy: "hc-key", // Join by 'hc-key' in the GeoJSON data
//                 name: title,
//                 states: {
//                   hover: {
//                     color: "#FF3333",
//                   },
//                 },
//                 dataLabels: {
//                   enabled: true,
//                   format: "{point.name}",
//                 },
//               },
//             ],
//           });
//         });
//       }
//     },
//   });
// }

// function loadChartDataMap(variable, year, chartId, colorTheme) {
//   $.ajax({
//     url: window.location.href + "/../../featured/getdatamap",
//     data: { variable: variable, year: year },
//     success: function (response) {
//       if (response.length > 0) {
//         var title = response[0].title + " Tahun " + response[0].year;
//         var unit = response[0].unit;

//         var seriesData = response.map((item) => ({
//           kdprov: item.fk_dimension_province,
//           value: parseFloat(item.tables_value),
//           name: item.province_name
//         }));

//         $.getJSON("../../datacap-maps/prov_000_2023_2.json", function (geojson) {
//           Highcharts.mapChart(chartId, {
//             chart: {
//               map: geojson,
//               panning: true,
//               panKey: 'shift'
//             },
//             mapNavigation: {
//               enabled: true,
//               enableDoubleClickZoom: true,
//               enableMouseWheelZoom: true,
//               enableTouchZoom: true
//             },
//             title: {
//               text: title,
//               align: "left",
//               verticalAlign: "top",
//             },
//             colorAxis: {
//               min: 0,
//               stops: [
//                 [0, "#FFFFFF"],
//                 [1, colorTheme],
//               ],
//             },
//             tooltip: {
//               useHTML: true,
//               formatter: function () {
//                 var displayUnit = unit ? " " + unit : "";
//                 return (
//                   '<span style="font-size: 12px;">' +
//                   '<i class="fas fa-check-circle text-primary"></i> ' +
//                   '<span style="font-size: smaller;">' +
//                   this.series.name +
//                   "</span><br>" +
//                   '<i class="far fa-circle text-success"></i> ' +
//                   this.point.name +
//                   ": <strong>" +
//                   this.point.value +
//                   "</strong> " +
//                   displayUnit
//                 );
//               },
//             },
//             series: [
//               {
//                 data: seriesData,
//                 mapData: geojson,
//                 joinBy: "kdprov",
//                 name: title,
//                 states: {
//                   hover: {
//                     color: "#FF3333",
//                   },
//                 },
//                 dataLabels: {
//                   enabled: true,
//                   format: "{point.properties.nmprov}",
//                 },
//                 point: {
//                   events: {
//                     click: function () {
//                       var kdprov = this.kdprov;

//                       $('#' + chartId).fadeOut(300, function () {
//                         loadProvinceMap(kdprov, variable, year, chartId, colorTheme);
//                         $('#' + chartId).fadeIn(1000);
//                         // Show the button to return to Indonesia map
//                         document.getElementById("back-to-indonesia-btn").style.display = "block";
//                       });
//                     },
//                   },
//                 },
//               },
//             ],
//           });
//         });
//       }
//     },
//   });
// }

function loadProvinceMap(kdprov, variable, year, chartId, colorTheme) {
  $.getJSON("../library/maps/kdprov_" + kdprov + ".json", function (geoJsonData) {
    $.ajax({
      url: window.location.href + "/../../featured/getdatamapprovince",
      data: {
        kdprov: kdprov,
        variable: variable,
        year: year
      },
      success: function (response) {
        if (response.length > 0) {
          var title = response[0].title;
          var unit = response[0].unit;

          var seriesData = response.map((item) => ({
            idkab: item.fk_dimension_regency,
            value: parseFloat(item.tables_value),
            name: item.regency_name
          }));

          Highcharts.mapChart(chartId, {
            chart: {
              map: geoJsonData,
              panning: true,            // Enable panning (dragging)
              panKey: 'shift'           // Optional: Require Shift key for panning
            },
            mapNavigation: {
              enabled: true,             // Enables map navigation controls
              enableDoubleClickZoom: true, // Allows double-click to zoom
              enableMouseWheelZoom: true,  // Allows zooming with mouse wheel
              enableTouchZoom: true        // Allows zooming with touch (mobile)
            },
            title: {
              text: 'Map of ' + title,
              align: "left",
            },
            colorAxis: {
              min: 0,
              stops: [
                [0, "#FFFFFF"],
                [1, colorTheme],
              ],
            },
            tooltip: {
              useHTML: true,
              formatter: function () {
                var displayUnit = unit ? " " + unit : "";
                return (
                  '<span style="font-size: 12px;">' +
                  '<i class="fas fa-check-circle text-primary"></i> ' +
                  '<span style="font-size: smaller;">' +
                  this.series.name +
                  "</span><br>" +
                  '<i class="far fa-circle text-success"></i> ' +
                  this.point.name +
                  ": <strong>" +
                  this.point.value +
                  "</strong> " +
                  displayUnit
                );
              },
            },
            series: [
              {
                data: seriesData,
                mapData: geoJsonData,
                joinBy: "idkab",
                name: title,
                states: {
                  hover: {
                    color: "#FF3333",
                  },
                },
                dataLabels: {
                  enabled: true,
                  format: "{point.name}",
                },
              },
            ],
          });
        }
      },
    });
  });
}

const defaultVariable = "4";  // Replace with your actual default variable
const defaultYear = "2024";          // Replace with your actual default year
const defaultColorTheme = "#FF0000";  // Replace with your actual default color theme

// Initialize a variable to hold the current chartId
let currentChartId = "";
let currentVariable = "";
let currentYear = "";
let currentColorTheme = "";

// Button functionality to return to Indonesia map
document.getElementById("back-to-indonesia-btn").onclick = function () {
  loadChartDataMap(currentVariable, currentYear, currentChartId, currentColorTheme);
  document.getElementById("back-to-indonesia-btn").style.display = "none";
};

function loadChartDataMap(variable, year, chartId, colorTheme) {
  // Update the current chartId whenever this function is called
  currentChartId = chartId;
  currentVariable = variable;
  currentYear = year;
  currentColorTheme = colorTheme;

  $.ajax({
    url: window.location.href + "/../../featured/getdatamap",
    data: { variable: variable, year: year },
    success: function (response) {
      if (response.length > 0) {
        var title = response[0].title + " Tahun " + response[0].year;
        var unit = response[0].unit;

        var seriesData = response.map((item) => ({
          kdprov: item.fk_dimension_province,
          value: parseFloat(item.tables_value),
          name: item.province_name
        }));

        $.getJSON("../library/maps/prov_000_2023_2.json", function (geojson) {
          Highcharts.mapChart(chartId, {
            chart: {
              map: geojson,
              panning: true,
              panKey: 'shift'
            },
            mapNavigation: {
              enabled: true,
              enableDoubleClickZoom: true,
              enableMouseWheelZoom: true,
              enableTouchZoom: true
            },
            title: {
              text: title,
              align: "left",
              verticalAlign: "top",
            },
            colorAxis: {
              min: 0,
              stops: [
                [0, "#FFFFFF"],
                [1, colorTheme],
              ],
            },
            tooltip: {
              useHTML: true,
              formatter: function () {
                var displayUnit = unit ? " " + unit : "";
                return (
                  '<span style="font-size: 12px;">' +
                  '<i class="fas fa-check-circle text-primary"></i> ' +
                  '<span style="font-size: smaller;">' +
                  this.series.name +
                  "</span><br>" +
                  '<i class="far fa-circle text-success"></i> ' +
                  this.point.name +
                  ": <strong>" +
                  this.point.value +
                  "</strong> " +
                  displayUnit
                );
              },
            },
            series: [
              {
                data: seriesData,
                mapData: geojson,
                joinBy: "kdprov",
                name: title,
                states: {
                  hover: {
                    color: "#FF3333",
                  },
                },
                dataLabels: {
                  enabled: true,
                  format: "{point.properties.nmprov}",
                },
                point: {
                  events: {
                    click: function () {
                      var kdprov = this.kdprov;

                      $('#' + chartId).fadeOut(300, function () {
                        loadProvinceMap(kdprov, variable, year, chartId, colorTheme);
                        $('#' + chartId).fadeIn(1000);
                        // Show the button to return to Indonesia map
                        document.getElementById("back-to-indonesia-btn").style.display = "block";
                      });
                    },
                  },
                },
              },
            ],
          });
        });
      }
    },
  });
}

document.getElementById('send-btn').onclick = function () {
  const userInput = document.getElementById('user-input').value.trim();
  if (!userInput) return;

  // Append user's message with formatted layout
  document.getElementById('chat-log').innerHTML += `
    <div class="message user-message">
      <div class="message-label">You:</div>
      <div class="message-text">${userInput}</div>
    </div>`;

  fetch(window.location.origin + "/datacap/chatbot/ask", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-Token": "<?= Yii::$app->request->csrfToken ?>",
    },
    body: JSON.stringify({ question: userInput })
  })
    .then(response => response.json())
    .then(data => {
      // Append AI response with formatted layout
      document.getElementById('chat-log').innerHTML += `
        <div class="message ai-message">
          <div class="message-label">AI:</div>
          <div class="message-text">${data.response}</div>
        </div>`;
      document.getElementById('user-input').value = '';
    })
    .catch(error => console.error('Error:', error));
};

document.getElementById('send-btn').onclick = function () {
  const userInput = document.getElementById('user-input').value.trim();
  if (!userInput) return;

  // Append user's message with formatted layout
  document.getElementById('chat-log').innerHTML += `
    <div class="message user-message">
      <div class="message-label">You:</div>
      <div class="message-text">${userInput}</div>
    </div>`;

  fetch(window.location.origin + "/datacap/chatbot/ask", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "X-CSRF-Token": "<?= Yii::$app->request->csrfToken ?>",
    },
    body: JSON.stringify({ question: userInput })
  })
    .then(response => response.json())
    .then(data => {
      // Append AI response with formatted layout
      document.getElementById('chat-log').innerHTML += `
        <div class="message ai-message">
          <div class="message-label">AI:</div>
          <div class="message-text">${data.response}</div>
        </div>`;
      document.getElementById('user-input').value = '';
    })
    .catch(error => console.error('Error:', error));
};

// Handle Enter and Shift+Enter for input
document.getElementById('user-input').addEventListener('keydown', function (event) {
  if (event.key === "Enter") {
    if (event.shiftKey) {
      // Allow new line if Shift is pressed
      return; 
    } else {
      // Prevent new line and send the message
      event.preventDefault();
      document.getElementById('send-btn').click(); 
    }
  }
});
