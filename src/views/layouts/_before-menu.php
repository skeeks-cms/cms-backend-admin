<?php
/**
 * Administration-only mobile schedule shortcut.
 *
 * @var yii\web\View $this
 */
?>
<?php if (\Yii::$app->mobileDetect->isMobile) : ?>
    <div class="sx-mobile-schedule-sidebar">
        <?= \skeeks\cms\widgets\admin\CmsUserScheduleBtnWidget::widget([
            'pjaxId' => 'sx-schedule-pjax-mobile-sidebar',
            'layout' => 'mobile-sidebar',
        ]) ?>
    </div>
<?php endif; ?>
