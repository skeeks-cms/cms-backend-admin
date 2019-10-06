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

$logoutUrl = \skeeks\cms\helpers\UrlHelper::construct("admin/admin-auth/logout")->enableAdmin()->setCurrentRef();

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
                        'id'                            => 'blocked-form',
                        'validationUrl'                 => (string) \skeeks\cms\helpers\UrlHelper::constructCurrent()->enableAjaxValidateForm(),
                        'options'       => [
                            'class' => 'reg-page',
                        ],
                    ]); ?>
                    <header class="text-center mb-4">
                        <h2 class="h2 g-font-weight-600">Блокировка</h2>
                    </header>


                    <div class="text-center">
                        <img src="<?= \skeeks\cms\helpers\Image::getSrc(\Yii::$app->user->identity->image ? \Yii::$app->user->identity->image->src : null); ?>"
                        style="border-radius: 50%;"
                        />
                    </div>

                    <?= $form->field($model, 'password')->passwordInput([
                        'placeholder' => 'Пароль',
                        'autocomplete' => 'off',
                        'class' => 'form-control g-color-black g-bg-white g-bg-white--focus g-brd-gray-light-v4 g-brd-primary--hover rounded g-py-15 g-px-15',
                    ])->label(\Yii::$app->user->identity->displayName) ?>


                    <?/*= Html::submitButton("<i class='glyphicon glyphicon-lock'></i> Разблокировать", ['class' => 'btn btn-primary', 'name' => 'login-button']) */?>



                    <div class="mb-4">
                        <button class="btn btn-md btn-block u-btn-primary g-py-13" type="submit">
                            <i class="fas fa-unlock-alt"></i>
                            Разблокировать</button>
                    </div>
                    <div class="text-center">

                    </div>
                    <hr />
                    <div class="text-center g-color-gray-dark-v5 g-font-size-13 mb-0">

                        <?=\Yii::t('skeeks/cms','You have successfully logged in, but not for too long been active in the control panel site.')?>
                        <?=\Yii::t('skeeks/cms','Please confirm that it is you, and enter your password.')?>
                        <p>

                            <?= \yii\helpers\Html::a('<i class="fas fa-sign-out-alt"></i> Выход', $logoutUrl, [
                                "data-method" => "post",
                                "data-pjax" => "0",
                                "class" => "btn btn-danger btn-xs pull-right",
                            ]); ?>
                        </p>

                    </div>
                    <?php $form::end(); ?>
                </div>
            </div>
        </div>
    </div>
</section>



