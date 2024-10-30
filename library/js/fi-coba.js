// $.getJSON("../library/map/kdprov_17.geojson", function (geoJsonData) {
//     Highcharts.mapChart('container', {
//         chart: {
//             map: geoJsonData
//         },
//         title: {
//             text: 'Map of Bengkulu'
//         },
//         mapNavigation: {
//             enabled: true,
//             buttonOptions: {
//                 verticalAlign: 'bottom'
//             }
//         },
//         colorAxis: {
//             min: 0
//         },
//         series: [{
//             data: [
//                 { 'idkab': '1701', value: 10 }, // Bengkulu Selatan
//                 { 'idkab': '1702', value: 20 }, // Another region
//                 { 'idkab': '1703', value: 25 }, // Another region
//                 { 'idkab': '1704', value: 26 }, // Another region
//                 { 'idkab': '1705', value: 27 }, // Another region
//                 { 'idkab': '1706', value: 28 }, // Another region
//                 { 'idkab': '1707', value: 28 }, // Another region
//                 { 'idkab': '1708', value: 31 }, // Another region
//                 { 'idkab': '1709', value: 8 }, // Another region
//                 { 'idkab': '1771', value: 12 }, // Another region
//                 // Add more regions as needed
//             ],
//             mapData: geoJsonData,
//             joinBy: 'idkab', // This is the key from your geojson
//             name: 'Population Density',
//             states: {
//                 hover: {
//                     color: '#BADA55'
//                 }
//             },
//             dataLabels: {
//                 enabled: true,
//                 format: '{point.properties.nmkab}' // Display region name from geojson
//             }
//         }]
//     });
// });
var hcKeyToKdProv = {
    "id-ac": 11,  // Aceh
    "id-su": 12,  // Sumatera Utara
    "id-sb": 13,  // Sumatera Barat
    "id-ri": 14,  // Riau
    "id-ja": 15,  // Jambi
    "id-sl": 16,  // Sumatera Selatan
    "id-be": 17,  // Bengkulu
    "id-la": 18,  // Lampung
    "id-bb": 19,  // Kepulauan Bangka Belitung
    "id-kr": 21,  // Kepulauan Riau
    "id-jk": 31,  // DKI Jakarta
    "id-jr": 32,  // Jawa Barat
    "id-jt": 33,  // Jawa Tengah
    "id-yo": 34,  // DI Yogyakarta
    "id-ji": 35,  // Jawa Timur
    "id-bt": 36,  // Banten
    "id-ba": 51,  // Bali
    "id-nb": 52,  // Nusa Tenggara Barat
    "id-nt": 53,  // Nusa Tenggara Timur
    "id-kb": 61,  // Kalimantan Barat
    "id-kt": 62,  // Kalimantan Tengah
    "id-ks": 63,  // Kalimantan Selatan
    "id-ki": 64,  // Kalimantan Timur
    "id-ku": 65,  // Kalimantan Utara
    "id-sw": 71,  // Sulawesi Utara
    "id-st": 72,  // Sulawesi Tengah
    "id-se": 73,  // Sulawesi Selatan
    "id-sg": 74,  // Sulawesi Tenggara
    "id-go": 75,  // Gorontalo
    "id-sr": 76,  // Sulawesi Barat
    "id-ma": 81,  // Maluku
    "id-mu": 82,  // Maluku Utara
    "id-ib": 91,  // Papua Barat
    "id-ps": 92,  // Papua Barat Daya
    "id-pa": 94,  // Papua
    "id-ps": 95,  // Papua Selatan
    "id-pt": 96,  // Papua Tengah
    "id-pp": 97   // Papua Pegunungan
};

function loadChartDataMap(variable, year, chartId, colorTheme) {
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

                $.getJSON("../../datacap-maps/prov_000_2023_2.json", function (geojson) {
                    Highcharts.mapChart(chartId, {
                        chart: {
                            map: geojson,
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
                                            
                                            // Apply fade-out effect on Indonesia map
                                            $('#' + chartId).fadeOut(300, function () {
                                                // After fade-out, load the province map with fade-in effect
                                                loadProvinceMap(kdprov, variable, year, chartId, colorTheme);
                                                $('#' + chartId).fadeIn(1000); // Fade-in effect for province map
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

function loadProvinceMap(kdprov, variable, year, chartId, colorTheme) {
    $.getJSON("../library/map/kdprov_" + kdprov + ".geojson", function (geoJsonData) {
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


loadChartDataMap("4", "2024", "container", "#FF0000");
