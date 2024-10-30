<?php

/** @var yii\web\View $this */
/** @var yii\bootstrap5\ActiveForm $form */
/** @var app\models\LoginForm $model */

use yii\bootstrap5\ActiveForm;
use yii\bootstrap5\Html;
use yii\web\View;

$this->registerJsFile(Yii::$app->request->baseUrl . '/library/js/fi-sweetalert-popup.js', ['position' => View::POS_END, 'depends' => [\yii\web\JqueryAsset::class]]);
?>
<style>
    .form-control:focus {
        background-color: transparent !important;
    }

    .input-box input {
        color: #fff !important;
    }
</style>
<div class="container">
    <div class="login-box">
        <h2>Login <br /><a href="<?= Yii::$app->request->baseUrl ?>"><?php echo Yii::$app->name ?></a></h2>
        <?php $form = ActiveForm::begin([
            'id' => 'login-form',
            'options' => ['name' => "Form"]
        ]); ?>
        <div class="input-box">
            <?= $form->field($model, 'username')->textInput(['autofocus' => true, 'placeholder' => 'Nomor HP'])->label(false) ?>
        </div>
        <div class="input-box">
            <?= $form->field($model, 'password')->passwordInput(['placeholder' => 'Password'])->label(false) ?>
        </div>
        <div class="row">
            <div class="col-3">

            </div>
            <div class="col-6">
                <?= Html::submitButton('Login', ['class' => 'btn btn-warning w-100', 'name' => 'login-button',  'onclick' => "return IsEmpty();"]) ?>
            </div>
            <div class="col-3">

            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>