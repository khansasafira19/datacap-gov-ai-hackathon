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
                <!-- <img src="assets/img/logo.png" alt=""> -->
                <h1 class="sitename">BPS</h1>
            </a>
            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="<?= Yii::$app->request->baseUrl ?>/#hero" class="active">Home</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl ?>/#fitur">Fitur</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl ?>/#featured">Topik Pilihan</a></li>
                    <li><a href="<?= Yii::$app->request->baseUrl ?>/#cta">Buat Visualisasi</a></li>
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
                                <li><a href="https://wa.me/6285664991937?text=Salam+Senyum,+Developer+Portal+Pintar%0ASaya+ingin+berdiskusi+terkait+Sistem+Portal+Pintar" target="_blank">Hubungi Developer</a></li>
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
            <a href="<?= \yii\helpers\Url::to(['site/makeyourown']) ?>" class="btn btn-danger btn-heartbeat">
                <i class="fas fa-folder-plus"></i>
            </a>
        </div>

        <!-- Hero Section -->
        <section id="hero" class="hero section dark-background" style="padding: 5px 0 120px 0!important; min-height: 5vh">
            <svg class="hero-waves" style="height: 30px" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 24 150 28 " preserveAspectRatio="none">
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

        <?= $content ?>
    </main>

    <footer id="footer" class="footer dark-background">

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