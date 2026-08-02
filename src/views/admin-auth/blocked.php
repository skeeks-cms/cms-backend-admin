<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

use skeeks\cms\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use skeeks\cms\helpers\Image;
use skeeks\cms\helpers\UrlHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\forms\BlockedUserForm */

$logoutUrl = UrlHelper::construct('/admin/admin-auth/logout')->enableAdmin()->setCurrentRef();
$identity = \Yii::$app->user->identity;
?>
<section class="sx-auth-page">
    <div class="sx-auth-card">
        <h1 class="sx-auth-card__title"><?= \Yii::t('skeeks/cms', 'Режим блокировки') ?></h1>
        <img
            class="sx-auth-card__avatar"
            src="<?= Html::encode($identity->image ? $identity->avatarSrc : Image::getCapSrc()) ?>"
            alt=""
        >
        <?php $form = ActiveForm::begin([
            'id' => 'blocked-form',
            'validationUrl' => (string) UrlHelper::constructCurrent()->enableAjaxValidateForm(),
        ]); ?>
        <?= $form->field($model, 'password')->passwordInput([
            'placeholder' => \Yii::t('skeeks/cms', 'Password'),
            'autocomplete' => 'current-password',
            'class' => 'form-control',
        ])->label($identity->displayName) ?>
        <div class="sx-auth-card__actions">
            <button class="btn btn-primary btn-block" type="submit">
                <i class="fas fa-unlock-alt" aria-hidden="true"></i>
                <?= \Yii::t('skeeks/cms', 'Разблокировать') ?>
            </button>
        </div>
        <?php ActiveForm::end(); ?>

        <p class="sx-auth-card__description">
            <?= \Yii::t('skeeks/cms', 'You have successfully logged in, but not for too long been active in the control panel site.') ?>
            <?= \Yii::t('skeeks/cms', 'Please confirm that it is you, and enter your password.') ?>
        </p>
        <div class="sx-auth-card__secondary-action">
            <?= Html::a(
                '<i class="fas fa-sign-out-alt" aria-hidden="true"></i> '
                    . Html::encode(\Yii::t('skeeks/cms', 'Выйти из аккаунта')),
                $logoutUrl,
                [
                    'data-method' => 'post',
                    'data-pjax' => '0',
                    'class' => 'btn btn-danger btn-sm',
                ]
            ) ?>
        </div>
    </div>
</section>
