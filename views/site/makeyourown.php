<?php
$this->registerJsFile('https://code.highcharts.com/maps/highmaps.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('datacap/library/js/fi-makeyourown.js', ['depends' => [\yii\web\JqueryAsset::className()]]);

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'DataCap';
?>
<section id="makeyourown" class="team section" data-aos="fade-up" data-aos-delay="100">
    <!-- HTML Form Example -->
    <div class="container" data-aos="fade-up">
        <form id="variableForm">
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <label for="variables">Pilih Variabel</label>
                        <select name="variables" class="form-control" id="variables" multiple>
                            <?php foreach ($variables as $variable): ?>
                                <option value="<?= $variable->id_dimension_title ?>"><?= $variable->title ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group" id="year-group">
                        <label for="year">Pilih Tahun</label>
                        <select name="year" class="form-control" id="year" multiple>
                            <?php foreach ($years as $year): ?>
                                <option value="<?= $year->year ?>"><?= $year->year ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="semester">Pilih Semester</label>
                        <select name="semester" class="form-control" id="semester" multiple>
                            <?php foreach ($semesters as $semester): ?>
                                <option value="<?= $semester->semester ?>"><?= $semester->semester ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group" id="month-group">
                        <label for="month">Pilih Bulan</label>
                        <select name="month" class="form-control" id="month" multiple>
                            <?php foreach ($months as $month): ?>
                                <option value="<?= $month->semester ?>"><?= $month->month ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="chartType">Pilih Visualisasi</label>
                        <select name="chartType" class="form-control" id="chartType" multiple>
                            <option value="line">Line</option>
                            <option value="column">Column</option>
                            <option value="pie">Pie</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label for="color">Pilih Warna</label>
                        <select name="color" class="form-control" id="color" multiple>
                            <option value="#1acc8d">Green</option>
                            <option value="#ff0000">Red</option>
                        </select>
                    </div>
                </div>

            </div>
            <div class="d-flex justify-content-end">
                <div class="p-2 t-2">
                    <button type="button" onclick="handleChartRequest()" class="btn btn-primary">Load Chart</button>
                </div>
            </div>
        </form>
        <!-- <form id="variableForm">
            <label for="variables">Choose Variables:</label>
            <select id="variables" name="variables" multiple>                
                <option value="1">Variable 1</option>
                <option value="2">Variable 2</option>
                <option value="3">Variable 3</option>
                <option value="4">Variable 4</option>
                <option value="5">Variable 5</option>
            </select>

            <label for="year">Choose Year:</label>
            <select id="year" name="year">                
                <option value="21">2020</option>
                <option value="22">2021</option>
                <option value="23">2022</option>
            </select>

            <label for="chartTypeSingle">Choose Visualization Type (Single Variable):</label>
            <select id="chartTypeSingle" name="chartTypeSingle">
                <option value="line">Line</option>
                <option value="column">Column</option>
                <option value="pie">Pie</option>
            </select>

            <label for="chartTypesMultiple">Choose Visualization Types (Multiple Variables):</label>
            <input type="text" id="chartTypesMultiple" name="chartTypesMultiple" placeholder="e.g., line,column,pie">

            <button type="button" onclick="handleChartRequest()">Load Chart</button>
        </form> -->
    </div>

    <!-- Section Title -->
    <div class="container section-title" data-aos="fade-up">
        <h2>Make Your Own</h2>
        <div><span>Custom DataCap Dashboard</div>
    </div><!-- End Section Title -->
    <div class="container card" id="makeyourown-chart" style="width:100%; height:500px;">

    </div>
</section>
<?php
// Highcharts global options
$script = <<< JS
    // Example call to load data for a chart with multiple series
    // loadChartDataMultiViz('4', 'area,spline,column', 'makeyourown-chart'); // Example for multiple viz
    loadChartDataMultiViz('8,12', 'area,column', 'makeyourown-chart', '2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023');

JS;

$this->registerJs($script);
?>