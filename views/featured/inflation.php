<?php
$this->registerJsFile('https://code.highcharts.com/maps/highmaps.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('https://code.highcharts.com/modules/annotations.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('datacap/library/js/fi-featured.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
$this->registerJsFile('datacap/library/js/fi-featured-inflation.js', ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
<section id="inflation" class="team section bg-light" data-aos="fade-up" data-aos-delay="100">
    <!-- Section Title -->
    <div class="container-fluid section-title" data-aos="fade-up">
        <h2>Featured Topic 2</h2>
        <div><span>Dashboard Visualisasi Pertumbuhan Ekonomi Indonesia</span></div>
    </div><!-- End Section Title -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-9">
                <div class="row">
                    <div class="col-lg-8 mb-2">
                        <div class="card"> <!-- Reduced padding -->
                            <!-- Chart Container -->
                            <div id="d2-chart1" style="height:500px;"></div>
                            <div id="map-container mb-2">
                                <!-- Button to return to Indonesia Map -->
                                <div class="d-flex justify-content-center">
                                    <button id="back-to-indonesia-btn" class="btn-sm btn btn-primary mb-2" style="display: none;">Back to Indonesia Map</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <div class="card"> <!-- Reduced padding -->
                            <!-- Chart Container -->
                            <div id="d2-chart2" style="height:500px;"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-4 mb-2">
                        <div class="card"> <!-- Reduced padding -->
                            <!-- Chart Container -->
                            <div id="d2-chart3" style="height:300px;"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <div class="card"> <!-- Reduced padding -->
                            <!-- Chart Container -->
                            <div id="d2-chart4" style="height:300px;"></div>
                        </div>
                    </div>
                    <div class="col-lg-4 mb-2">
                        <div class="card"> <!-- Reduced padding -->
                            <!-- Chart Container -->
                            <div id="d2-chart5" style="height:300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <?= $this->render('_lefttabs', []) ?>
            </div>
        </div>
    </div>
</section>