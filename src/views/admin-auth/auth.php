<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 25.03.2015
 */
/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\forms\LoginFormUsernameOrEmail */

use skeeks\cms\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use skeeks\cms\helpers\UrlHelper;

$this->registerCss(<<<CSS
.auth-clients {
    padding-left: 0px;
}
CSS
);
?>
<section class="sx-auth-wrapper">
    <div class="container g-py-100">
        <div class="row justify-content-center">
            <div class="col-sm-8 col-lg-5">
                <div class="u-shadow-v21 sx-bg-auth rounded g-py-40 g-px-30 sx-bg-block">
                    <?php $form = ActiveForm::begin([
                        //'validationUrl' => UrlHelper::construct('cms/auth/login')->setSystemParam(\skeeks\cms\helpers\RequestResponse::VALIDATION_AJAX_FORM_SYSTEM_NAME)->toString(),
                        'id' => 'login-form',
                        'enableAjaxValidation' => false,
                        'options'       => [
                            'class' => 'reg-page',
                        ],
                    ]); ?>
                    <header class="text-center mb-4">
                        <h2 class="h2 g-font-weight-600">Авторизация</h2>
                    </header>
                    <?= $form->field($loginModel, 'identifier')->textInput([
                        'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15',
                    ]); ?>
                    <div class="g-mb-20">
                        <?= $form->field($loginModel, 'password')->passwordInput([
                            'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15',
                        ]); ?>
                        <div class="row justify-content-between">
                            <div class="col align-self-center">

                            </div>
                            <div class="col align-self-center text-right">
                                <a class="g-font-size-12" href="<?= UrlHelper::constructCurrent()->setRoute('admin/admin-auth/forget')->toString(); ?>">Забыли пароль?</a>
                            </div>
                        </div>
                    </div>
                    <div class="mb-4">
                        <button class="btn btn-md btn-block u-btn-primary g-py-13" type="submit">Войти</button>
                    </div>
                    <?php $form::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>






