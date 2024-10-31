<?php

use app\assets\AppAsset;
use app\assets\AppLightAsset;
use yii\bootstrap5\Html;

if (!Yii::$app->user->isGuest && Yii::$app->user->identity->theme == 1) //light theme
    AppLightAsset::register($this);
else
    AppAsset::register($this); //dark theme, default

$this->registerCsrfMetaTags();
$this->registerMetaTag(['charset' => Yii::$app->charset], 'charset');
$this->registerMetaTag(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1, shrink-to-fit=no']);
$this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['meta_description']]);
$this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['meta_keywords']]);
$this->registerLinkTag(['rel' => 'icon', 'type' => 'image/x-icon', 'href' => Yii::$app->request->baseUrl . '/library/images/favicon.png']);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>" class="h-100">

<head>
    <title><?= Html::encode(Yii::$app->name) ?></title>
    <?php $this->head() ?>
    <!-- =======================================================
  * Coded by: Safira Khansa, a.k.a. Nofriani
  * Started on: August 27th, 2024
  ======================================================== -->
</head>
<!-- <body> -->

<body class="index-page <?php echo Yii::$app->user->isGuest ? '' : Yii::$app->user->identity->themechoice; ?>">
    <?php $this->beginBody() ?>
    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center justify-content-between">

            <a href="<?= Yii::$app->request->baseUrl ?>/" class="logo d-flex align-items-center">
                <!-- Uncomment the line below if you also wish to use an image logo -->
                <img src="<?= Yii::$app->request->baseUrl ?>/library/images/logo.png" alt="">
                <!-- <h1 class="sitename">DATACAP</h1> -->
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#fitur">Fitur</a></li>
                    <li><a href="#featured">Topik Pilihan</a></li>
                    <li><a href="#cta">Buat Visualisasi</a></li>
                    <?php if (!Yii::$app->user->isGuest) : ?>
                        <li class="dropdown"><a href="#"> <?= Yii::$app->user->identity->nama ?> <i class="bi bi-chevron-down"></i></a>
                            <ul>
                                <li>
                                    <a>
                                        <?php
                                        echo Html::beginForm(['/site/logout']) .  Html::submitButton(
                                            'Logout <i class="fas fa-sign-out-alt"></i>',
                                            [
                                                'class' => 'nav-link scrollto tombol-pengguna',
                                                'style' => 'border:0; background-color: transparent'
                                            ]
                                        ) . Html::endForm()  ?>
                                    </a>
                                </li>
                                <li><a href="https://wa.me/6285664991937?text=Salam+Senyum,+Developer+DataCap%0ASaya+ingin+berdiskusi+terkait+Sistem+DataCap" target="_blank">Hubungi Developer</a></li>
                            </ul>
                        </li>
                    <?php else : ?>
                        <li><a href="<?php echo Yii::$app->request->baseUrl; ?>/site/login">Login</a></li>
                    <?php endif; ?>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

        </div>
    </header>

    <main class="main">
        <div class="fixed-button">
            <a href="<?= \yii\helpers\Url::to(['site/makeyourown']) ?>" class="btn btn-danger btn-extra-lg btn-heartbeat">
                <i class="fas fa-folder-plus"></i>
            </a>
        </div>

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background">
            <!-- <img src="<?php // Yii::$app->request->baseUrl 
                            ?>/library/bootslander/assets/img/hero-bg-2.jpg" alt="" class="hero-bg"> -->

            <div class="container">
                <div class="row gy-4 justify-content-between">
                    <div class="col-lg-4 order-lg-last hero-img" data-aos="zoom-out" data-aos-delay="100">
                        <img src="<?= Yii::$app->request->baseUrl ?>/library/images/hero-img.png" class="img-fluid animated" alt="">
                    </div>

                    <div class="col-lg-6  d-flex flex-column justify-content-center" data-aos="fade-in">
                        <h1>Data<span>Cap</span></h1>
                        <p>Kreasikan Visualisasi dan Insight Data Statistik Indonesia untuk Percepatan Pembangunan dan Pemerataan Kecerdasan Bangsa</p>
                        <!-- <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search">
                            <button class="btn btn-success" type="submit">Go</button>
                        </div> -->
                        <div class="d-flex">
                            <a href="<?= Yii::$app->request->baseUrl ?>/site/makeyourown" class="btn-get-started">Buat Visualisasi</a>
                            <a href="https://youtu.be/-cw1OyScXMI" class="glightbox btn-watch-video d-flex align-items-center"><i class="bi bi-play-circle"></i><span>Lihat Tutorial</span></a>
                        </div>
                        <br />
                        <div class="video-container" style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; max-width: 100%; background: #000;">
                            <iframe
                                src="https://www.youtube.com/embed/-cw1OyScXMI?autoplay=1&mute=1&controls=0&showinfo=0"
                                style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
                                frameborder="0"
                                allow="autoplay; encrypted-media"
                                allowfullscreen></iframe>
                        </div>
                    </div>
                </div>
            </div>

            <svg class="hero-waves" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
                <defs>
                    <path id="wave-path" d="M-160 44c30 0 58-18 88-18s 58 18 88 18 58-18 88-18 58 18 88 18 v44h-352z"></path>
                </defs>
                <g class="wave1">
                    <use xlink:href="#wave-path" x="50" y="3"></use>
                </g>
                <g class="wave2">
                    <use xlink:href="#wave-path" x="50" y="0"></use>
                </g>
                <g class="wave3">
                    <use xlink:href="#wave-path" x="50" y="9"></use>
                </g>
            </svg>

        </section><!-- /Hero Section -->

        <!-- Fitur Section -->
        <section id="fitur" class="pricing section">
            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>FITUR</h2>
                <div><span class="description-title">FITUR-FITUR</span> <span>DALAM DATACAP</span></div>
            </div><!-- End Section Title -->
            <div class="container">
                <div class="row gy-4">
                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="100">
                        <div class="pricing-item">
                            <h3>AI-Based Insight</h3>
                            <p class="description">Menyusun insight dengan motor Kecerdasan Buatan (Artificial Intelligence).</p>
                            <h4><sup>$</sup>0<span> / bulan</span></h4>
                            <a href="<?= Yii::$app->request->baseUrl ?>/site/makeyourown" class="cta-btn">Buat Insight</a>
                            <p class="text-center small">Powered by Google Cloud AI</p>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Cetak insight berdasarkan AI</span></li>
                                <li><i class="bi bi-check"></i> <span>Tulis insight sendiri</span></li>
                                <li><i class="bi bi-check"></i> <span>Berbagi insight</span></li>
                                <li><i class="bi bi-check"></i> <span>Otomatisasi laporan</span></li>
                                <li><i class="bi bi-check"></i> <span>Optimisasi strategi bisnis</span></li>
                                <li><i class="bi bi-check"></i> <span>Personalisasi rekomendasi</span></li>
                            </ul>
                        </div>
                    </div><!-- End Pricing Item -->

                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="200">
                        <div class="pricing-item featured">
                            <p class="popular">Featured</p>
                            <h3>Dynamic Visualization</h3>
                            <p class="description">Kreasikan visualisasi sendiri terhadap data yang tersedia.</p>
                            <h4><sup>$</sup>0<span> / bulan</span></h4>
                            <a href="<?= Yii::$app->request->baseUrl ?>/site/makeyourown" class="cta-btn">Buat Visualisasi</a>
                            <p class="text-center small">Powered by Highcharts</p>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Desain visualisasi dinamis</span></li>
                                <li><i class="bi bi-check"></i> <span>Sesuaikan grafik sesuai kebutuhan</span></li>
                                <li><i class="bi bi-check"></i> <span>Ekspor dalam berbagai format</span></li>
                                <li><i class="bi bi-check"></i> <span>Integrasi dengan data real-time</span></li>
                                <li><i class="bi bi-check"></i> <span>Analisis tren data historis</span></li>
                                <li><i class="bi bi-check"></i> <span>Kustomisasi warna dan tema</span></li>
                            </ul>
                        </div>
                    </div><!-- End Pricing Item -->

                    <div class="col-lg-4" data-aos="zoom-in" data-aos-delay="300">
                        <div class="pricing-item">
                            <h3>Collaborative Plan</h3>
                            <p class="description">Kontribusikan usul, data dan kemampuanmu bersama DataCap.</p>
                            <h4><sup>$</sup>0<span> / bulan</span></h4>
                            <a href="<?= Yii::$app->request->baseUrl ?>/site/makeyourown" class="cta-btn">Mulai Kolaborasi</a>
                            <p class="text-center small">Powered by Yii2 Framework</p>
                            <ul>
                                <li><i class="bi bi-check"></i> <span>Bergabung dengan Praktisi dari Seluruh Indonesia</span></li>
                                <li><i class="bi bi-check"></i> <span>Networking dengan pakar industri</span></li>
                                <li><i class="bi bi-check"></i> <span>Berkolaborasi dalam proyek data</span></li>
                                <li><i class="bi bi-check"></i> <span>Berbagi pengetahuan dan pengalaman</span></li>
                                <li><i class="bi bi-check"></i> <span>Partisipasi dalam forum diskusi</span></li>
                                <li><i class="bi bi-check"></i> <span>Akses eksklusif ke pembaruan DataCap</span></li>
                            </ul>
                        </div>
                    </div><!-- End Pricing Item -->
                </div>
            </div>

        </section><!-- /Pricing Section -->

        <!-- About Section -->
        <section id="featured" class="about section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="row align-items-xl-center gy-5">
                    <div class="col-xl-4 content">
                        <h3>Topik-topik Pilihan</h3>
                        <h2>Untuk Inspirasi Kreasi Visualisasimu</h2>
                        <p>Visualisasi data membantu mengubah angka menjadi cerita yang informatif. Inspirasi visualisasi memungkinkan kamu menemukan cara terbaik untuk menyampaikan pesan dari data.</p>
                        <a href="site/makeyourown" class="read-more"><span>Buat Visualisasimu</span><i class="bi bi-arrow-right"></i></a>
                    </div>

                    <div class="col-xl-8">
                        <div class="row gy-4 icon-boxes">
                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                                <div class="icon-box">
                                    <a href="<?= Yii::$app->request->baseUrl ?>/featured/poverty"><i class="bi bi-buildings"></i></a>
                                    <h3>Kemiskinan</h3>
                                    <p>Kemiskinan mempengaruhi banyak orang. Visualisasi data ini dapat menunjukkan tren dan membantu merumuskan kebijakan yang lebih baik.</p>
                                </div>
                            </div> <!-- End Icon Box -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                                <div class="icon-box">
                                    <a href="<?= Yii::$app->request->baseUrl ?>/featured/inflation"><i class="bi bi-clipboard-pulse"></i></a>
                                    <h3>Inflasi</h3>
                                    <p>Inflasi memengaruhi daya beli masyarakat. Visualisasi data inflasi memperlihatkan perubahan harga dan dampaknya pada masyarakat.</p>
                                </div>
                            </div> <!-- End Icon Box -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                                <div class="icon-box">
                                    <a href="<?= Yii::$app->request->baseUrl ?>/featured/economicgrowth"><i class="bi bi-command"></i></a>
                                    <h3>Pertumbuhan Ekonomi</h3>
                                    <p>Pertumbuhan ekonomi menunjukkan kondisi suatu negara. Visualisasi ini membantu memahami perkembangan ekonomi dan tren masa depan.</p>
                                </div>
                            </div> <!-- End Icon Box -->

                            <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                                <div class="icon-box">
                                    <a href="<?= Yii::$app->request->baseUrl ?>/featured/workforce"><i class="bi bi-graph-up-arrow"></i></a>
                                    <h3>Tenaga Kerja</h3>
                                    <p>Tenaga kerja adalah pilar ekonomi. Visualisasi data ini menunjukkan partisipasi angkatan kerja, pengangguran, dan produktivitas.</p>
                                </div>
                            </div> <!-- End Icon Box -->
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <?= $content ?>
        <section id="cta" class="dark-background section">
            <div class="container" data-aos="fade-up" data-aos-delay="100">
                <div class="py-8">
                    <div class="container">
                        <div class="row">
                            <div class="offset-lg-2 col-lg-8 col-md-12 col-12 text-center">
                                <span class="fs-4 text-warning ls-md text-uppercase fw-semibold">Mulai Kreasi Visualisasimu</span>
                                <!-- heading -->
                                <h2 class="display-3 mt-4 mb-3 fw-bold">DataCap: Ubah Data Jadi Kecerdasan</h2>
                                <!-- para -->
                                <p class="lead px-lg-8 mb-6">Jelajahi kekuatan data dengan visualisasi yang informatif dan memukau. Mulai kreasikan visualisasimu sekarang dan temukan wawasan yang tersembunyi di balik angka!</p>
                                <a href="site/makeyourown" class="btn btn-primary">Buat Visualisasi Sekarang</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>

    <footer id="footer" class="footer light-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-6 col-md-6 footer-about">
                    <a href="<?php echo Yii::$app->request->baseUrl; ?>/site/index" class="logo d-flex align-items-center">
                        <span class="sitename">BPS PROVINSI BENGKULU</span>
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jl. Adam Malik Km 8</p>
                        <p>Bengkulu, Indonesia</p>
                        <p class="mt-3"><strong>Phone:</strong> <span>(+62 736) 349119</span></p>
                        <p><strong>Email:</strong> <span>bengkulu@bps.go.id</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href="https://bengkulu.bps.go.id/"><i class="bi bi-globe"></i></a>
                        <a href="https://www.facebook.com/bpsbengkulu"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/bpsprovbengkulu/"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.youtube.com/@BPSProvinsiBengkulu"><i class="bi bi-youtube"></i></a>
                    </div>
                    <div class="container copyright text-left mt-4">
                        <div class="credits">
                            <p>© <span>Copyright</span> <strong class="px-1 sitename">Strong Team of BPS Statistics of Bengkulu Province</strong> <span>All Rights Reserved</span></p>
                            Coded by <a href="https://khansasafira19.github.io/">nofriani@bps.go.id</a> | <a href="https://wa.me/6285664991937?text=Salam+Senyum,+Developer+DataCap%0ASaya+ingin+berdiskusi+terkait+DataCap" target="_blank">Hubungi Developer</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>



    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <?php $this->endBody() ?>
</body>

</html>
<?php $this->endPage() ?>