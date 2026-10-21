<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.03.2015
 */
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model \skeeks\cms\models\WidgetConfig */
?>


<? $fieldSet = $form->fieldSet(\Yii::t('skeeks/cms', 'Main')); ?>
    <?= $form->field($model, 'logoTitle'); ?>

<?= $form->fieldSelect($model, 'languageCode', \yii\helpers\ArrayHelper::map(
        \skeeks\cms\models\CmsLang::find()->active()->all(),
        'code',
        'name'
    )); ?>
<? $fieldSet::end(); ?>

<? $form->fieldSet(\Yii::t('skeeks/admin','Setting tables')); ?>
    <?= $form->field($model, 'enabledPjaxPagination')->listBox(\Yii::$app->cms->booleanFormat(), ['size' => 1]); ?>
    <?= $form->field($model, 'pageSize'); ?>
    <?= $form->field($model, 'pageSizeLimitMin'); ?>
    <?= $form->field($model, 'pageSizeLimitMax'); ?>
    <?= $form->field($model, 'pageParamName')->textInput(); ?>
<? $fieldSet::end(); ?>

<? $form->fieldSet(\Yii::t('skeeks/admin','Security')); ?>
    <?= $form->field($model, 'blockedTime')->hint(\Yii::t('skeeks/admin','If a user, for a specified time, not active in the admin panel, it will be prompted for a password.')); ?>
<? $fieldSet::end(); ?>





