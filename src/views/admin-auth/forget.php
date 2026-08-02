<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

use skeeks\cms\base\widgets\ActiveFormAjaxSubmit as ActiveForm;
use skeeks\cms\helpers\UrlHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\forms\PasswordResetRequestFormEmailOrLogin */
?>
<section class="sx-auth-page">
    <div class="sx-auth-card">
        <h1 class="sx-auth-card__title"><?= \Yii::t('skeeks/cms', 'Password recovery') ?></h1>
        <?php $form = ActiveForm::begin(); ?>
        <?= $form->field($model, 'identifier')->textInput([
            'class' => 'form-control',
            'autocomplete' => 'username',
        ]) ?>
        <div class="sx-auth-card__actions">
            <button class="btn btn-primary btn-block" type="submit">
                <?= \Yii::t('skeeks/cms', 'Send') ?>
            </button>
        </div>
        <div class="sx-auth-card__secondary-action">
            <?= Html::a(
                \Yii::t('skeeks/cms', 'Authorization'),
                UrlHelper::constructCurrent()->setRoute('admin/admin-auth/auth')->toString()
            ) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</section>
