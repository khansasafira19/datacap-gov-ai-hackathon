<?php

/**
 * @link https://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license https://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Playfair+Display:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i',
        'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css',
        //  <!-- Vendor CSS Files -->
        'library/bootslander/assets/vendor/bootstrap/css/bootstrap.min.css',
        'library/bootslander/assets/vendor/bootstrap-icons/bootstrap-icons.css',
        'library/bootslander/assets/vendor/aos/aos.css',
        'library/bootslander/assets/vendor/glightbox/css/glightbox.min.css',
        'library/bootslander/assets/vendor/swiper/swiper-bundle.min.css',
        //<!-- Main CSS File -->
        // 'library/bootslander/assets/css/main.css',
        'library/css/fi-theme.css',
    ];
    public $js = [
        // Core Highcharts
        'https://code.jquery.com/jquery-3.7.1.min.js',
        // 'https://code.highcharts.com/highcharts.js', // jangan load dua kali dengan highmaps

        // Highcharts Maps
        'https://code.highcharts.com/maps/highmaps.js',  // Load highmaps.js after highcharts.js

        // Other Highcharts modules
        'https://code.highcharts.com/modules/series-label.js',
        'https://code.highcharts.com/modules/exporting.js',
        'https://code.highcharts.com/modules/export-data.js',
        'https://code.highcharts.com/modules/accessibility.js',
        'https://code.highcharts.com/modules/annotations.js',

        // Vendor JS Files
        'library/bootslander/assets/vendor/bootstrap/js/bootstrap.bundle.min.js',
        'library/bootslander/assets/vendor/php-email-form/validate.js',
        'library/bootslander/assets/vendor/aos/aos.js',
        'library/bootslander/assets/vendor/glightbox/js/glightbox.min.js',
        'library/bootslander/assets/vendor/purecounter/purecounter_vanilla.js',
        'library/bootslander/assets/vendor/swiper/swiper-bundle.min.js',

        // Main JS File
        'library/bootslander/assets/js/main.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap5\BootstrapAsset'
    ];
}
