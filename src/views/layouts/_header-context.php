<?php
/**
 * @var yii\web\View $this
 */
?>
<?php if (!\Yii::$app->mobileDetect->isMobile) : ?>
    <?= \skeeks\cms\widgets\admin\CmsUserScheduleBtnWidget::widget(); ?>
<?php endif; ?>
