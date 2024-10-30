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

function handleChartRequest() {
  // Fetch selected variables, years, chart types, and color
  const variables = document.getElementById("variables").selectedOptions;
  const colors = document.getElementById("color").selectedOptions;
  const years = Array.from(document.getElementById("year").selectedOptions).map(
    (option) => option.value
  ); // Handle multiple years
  const chartTypes = Array.from(
    document.getElementById("chartType").selectedOptions
  ).map((option) => option.value); // Handle multiple chart types
  const selectedVariables = Array.from(variables).map((option) => option.value);

  // Fetch the selected color from the dropdown
  const selectedColor = Array.from(colors).map((option) => option.value);

  // Log selected values for debugging
  console.log("Variable(s): " + selectedVariables.join(","));
  console.log("Year(s): " + years.join(","));
  console.log("Chart Type(s): " + chartTypes.join(","));
  console.log("Selected Color: " + selectedColor.join(","));

  if (selectedVariables.length === 1) {
    console.log("Single variable selected");
    const selectedFilters = {
      variables: [selectedVariables[0]],
      years: years,
      semesters: [],
      months: [],
      chartType: chartTypes[0], // First chart type
      chartId: "makeyourown-chart",
      color: selectedColor[0], // Pass the selected color
    };

    // Load single variable chart
    loadChartDataSingleVar(selectedFilters);
  } else if (selectedVariables.length > 1) {
    console.log("Multiple variables selected");
    loadChartDataMultiViz(
      selectedVariables.join(","),
      chartTypes.join(","),
      "makeyourown-chart",
      years.join(","),
      selectedColor.join(",")
    );
  } else {
    console.log("No variables selected");
  }
}

function loadChartDataSingleVar(selectedFilters) {
  console.log("Selected Filters:", selectedFilters); // Log the entire object

  const variablesStr = selectedFilters.variables
    ? selectedFilters.variables.join(",")
    : "";
  const yearsStr = selectedFilters.years ? selectedFilters.years.join(",") : "";
  const semestersStr = selectedFilters.semesters
    ? selectedFilters.semesters.join(",")
    : "";
  const monthsStr = selectedFilters.months
    ? selectedFilters.months.join(",")
    : "";

  // Debugging logs
  console.log("Variables:", variablesStr);
  console.log("Years:", yearsStr);
  console.log("Semesters:", semestersStr);
  console.log("Months:", monthsStr);
  console.log("Color:", selectedFilters.color);
  console.log("Chart Type:", selectedFilters.chartType);
  console.log("Chart ID:", selectedFilters.chartId);
  console.log(document.getElementById(selectedFilters.chartId)); // Check if the container exists

  if (
    !variablesStr ||
    !yearsStr ||
    !selectedFilters.chartType ||
    !selectedFilters.chartId
  ) {
    console.error("Missing required parameters.");
    return; // Stop execution if required parameters are missing
  }

  $.ajax({
    url: window.location.href + "/../../site/getdata",
    data: {
      variables: variablesStr,
      years: yearsStr,
      semesters: semestersStr,
      months: monthsStr,
      chartType: selectedFilters.chartType,
    },
    success: function (response) {
      if (response.length > 0) {
        // Get the title and unit from the first item in the response array
        var title = response[0].title; // Grab the title from the first item
        var unit = response[0].unit || ""; // Grab the unit from the first item or set a default value if null

        var seriesData =
          selectedFilters.chartType === "pie"
            ? response.map((item) => ({
              name: item.year,
              y: parseFloat(item.tables_value),
            }))
            : response.map((item) => parseFloat(item.tables_value));

        var categories = response.map((item) => item.year);

        console.log("Series Data:", seriesData);
        console.log("Categories:", categories);
        console.log("Title:", title);

        Highcharts.chart(
          selectedFilters.chartId,
          {
            chart: {
              type: selectedFilters.chartType,
            },
            title: {
              text: title, // Use the title from the response
              align: "left",
            },
            xAxis:
              selectedFilters.chartType !== "pie"
                ? {
                  categories: categories,
                  title: {
                    text: title, // Use the title from the response
                  },
                }
                : undefined,
            yAxis:
              selectedFilters.chartType !== "pie"
                ? {
                  title: {
                    text: unit, // Use the unit from the response or default to 'Values'
                  },
                }
                : undefined,
            series: [
              {
                name: title, // Use the title for the series name
                data: seriesData,
                color: selectedFilters.color, // Set the color theme for the series
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
              },
              scatter: {
                tooltip: {
                  pointFormatter: function () {
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
                lineWidth: 0,
                marker: {
                  radius: 5,
                },
              },
            },
          },
          function (chart) {
            console.log("Chart initialized:", chart); // Debugging chart initialization
            const data = chart.series[0].data.map((point) => point.y);
            addAnnotations(chart, data, "highest");
            addAnnotations(chart, data, "latest");
          }
        );
      }
    },

    error: function (xhr, status, error) {
      console.error("Error: ", xhr.responseText);
    },
  });
}

function loadChartDataMultiVar(variables, chartType, chartId) {
  $.ajax({
    url: window.location.href + "/../../site/getdatamulti",
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

function loadChartDataMultiViz(
  variables,
  chartTypes,
  chartId,
  years,
  colorChoice
) {
  // Ensure colorChoice is properly defined
  colorChoice = colorChoice ? colorChoice.split(",").map((type) => type.trim()) : [];

  $.ajax({
    url: window.location.href + "/../../site/getdatamulti",
    data: {
      variable: variables,
      year: years,
    }, // Pass comma-separated variables
    success: function (response) {
      if (Object.keys(response).length > 0) {
        var series = [];
        var categories = Object.keys(response); // Extract years for x-axis
        var titles = [];

        chartTypes = chartTypes.split(",").map((type) => type.trim());
        variables = variables.split(",").map((variable) => variable.trim()); // Ensure variables are treated as an array

        console.log("Variables:", variables);
        console.log("Chart Types:", chartTypes);
        console.log("Colors:", colorChoice);

        // Loop through variables and assign the correct chart type and color
        for (let i = 0; i < variables.length; i++) {
          const variable = variables[i];
          const chartType = chartTypes[i] || "line"; // Default to 'line' if no chartType is provided
          const color = colorChoice[i] || "#0d6efd"; // Default to black if no color is provided

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
            const data = categories.map((year) => {
              return response[year][Object.keys(response[year])[i]].value || 0; // Use value for each slice, default to 0 if missing
            });

            series.push({
              type: chartType,
              name: response[categories[0]][
                Object.keys(response[categories[0]])[i]
              ].title,
              data: data,
              color: color, // Use the selected color for this series
            });

            // Collect titles for each variable
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

function loadChartDataMap(variable, year, chartId, colorTheme) {
  $.ajax({
    url: "/datacap/featured/getdatamap",
    data: { variable: variable, year: year }, // Pass the year as a parameter
    success: function (response) {
      if (response.length > 0) {
        var title = response[0].title + " Tahun " + response[0].year; // Assuming the title is the same for all rows
        var unit = response[0].unit; // Unit for the data values

        // Map-specific data structure
        var seriesData = response.map((item) => ({
          "hc-key": item.province_highchart_code.toLowerCase(), // Ensure the province code matches map file
          value: parseFloat(item.tables_value), // Parse the value as float
        }));

        // Load the map data from GeoJSON using jQuery's getJSON
        $.getJSON("../library/json/id-all.topo.json", function (geojson) {
          Highcharts.mapChart(chartId, {
            chart: {
              map: geojson,
            },
            title: {
              text: title, // Set the dynamic title
              align: "left",
            },
            colorAxis: {
              min: 0,
              stops: [
                [0, "#FFFFFF"], // Almost white (light shade)
                [1, colorTheme], // Custom color passed to the function (almost red in this case)
              ],
            },
            tooltip: {
              useHTML: true, // Enable HTML in the tooltip
              formatter: function () {
                return (
                  '<span style="font-size: 12px;">' +
                  '<i class="fas fa-check-circle text-primary"></i> ' + // FontAwesome icon
                  '<span style="font-size: smaller;">' +
                  this.series.name +
                  "</span><br>" + '<i class="far fa-circle text-success"></i> ' +
                  this.point.name +
                  ": <strong>" +
                  this.point.value +
                  "</strong> " +
                  unit
                );
              },
            },
            series: [
              {
                data: seriesData,
                mapData: geojson,
                joinBy: "hc-key", // Join by 'hc-key' in the GeoJSON data
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
        });
      }
    },
  });
}

$("#variables").change(function () {
  var selectedVariables = $(this).val(); // Get the selected variable IDs as an array
  var selectedYears = $("#year").val(); // Preserve the current selected years

  if (selectedVariables.length > 0) {
    $.ajax({
      url: window.location.href + "/../../site/loadyears", // Adjust the URL based on your routing
      data: { fk_dimension_title: selectedVariables.join(",") }, // Send all selected variables
      success: function (response) {
        var $yearSelect = $("#year");
        var $semesterSelect = $("#semester");
        var $monthSelect = $("#month");

        $yearSelect.empty(); // Clear the current options in the year dropdown
        $semesterSelect.empty(); // Clear semester dropdown
        $monthSelect.empty(); // Clear month dropdown

        // Check if the response contains any data
        if (response.length > 0) {
          // Populate the year, semester, and month dropdowns with the received data
          response.forEach(function (timeData) {
            if (timeData.year) {
              $yearSelect.append(
                $("<option></option>")
                  .attr("value", timeData.year)
                  .text(timeData.year)
              ); // Populate year dropdown
            }

            if (timeData.semester) {
              $semesterSelect.append(
                $("<option></option>")
                  .attr("value", timeData.semester)
                  .text("Semester " + timeData.semester)
              ); // Populate semester dropdown
            }

            if (timeData.month) {
              $monthSelect.append(
                $("<option></option>")
                  .attr("value", timeData.month)
                  .text(timeData.month)
              ); // Populate month dropdown
            }
          });

          // Re-select previously selected years
          if (selectedYears) {
            selectedYears.forEach(function (yearId) {
              $yearSelect
                .find('option[value="' + yearId + '"]')
                .attr("selected", "selected");
            });
          }
        } else {
          $yearSelect.append(
            $("<option></option>").attr("value", "").text("No years available")
          );
          $semesterSelect.append(
            $("<option></option>")
              .attr("value", "")
              .text("No semesters available")
          );
          $monthSelect.append(
            $("<option></option>").attr("value", "").text("No months available")
          );
        }
      },
    });
  }
});

$("#year").change(function () {
  var selectedYears = $(this).val(); // Get the selected year IDs as an array
  var selectedVariables = $("#variables").val(); // Preserve the current selected variables

  if (selectedYears.length > 0) {
    $.ajax({
      url: window.location.href + "/../../site/loadvariables", // Adjust the URL based on your routing
      data: { fk_dimension_time: selectedYears.join(",") }, // Send all selected year(s)
      success: function (response) {
        var $variablesSelect = $("#variables");
        $variablesSelect.empty(); // Clear the current options in the variables dropdown

        // Check if the response contains any data
        if (response.length > 0) {
          // Populate the variables dropdown with the received variables
          response.forEach(function (variableData) {
            if (variableData.title && variableData.id_dimension_title) {
              $variablesSelect.append(
                $("<option></option>")
                  .attr("value", variableData.id_dimension_title) // Use id_dimension_title as the value
                  .text(variableData.title)
              ); // Display the title as the label
            }
          });

          // Re-select previously selected variables
          if (selectedVariables) {
            selectedVariables.forEach(function (variableId) {
              $variablesSelect
                .find('option[value="' + variableId + '"]')
                .attr("selected", "selected");
            });
          }
        } else {
          $variablesSelect.append(
            $("<option></option>")
              .attr("value", "")
              .text("No variables available")
          );
        }
      },
    });
  }
});
