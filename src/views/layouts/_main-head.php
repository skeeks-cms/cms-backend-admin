<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 12.04.2016
 */
?>

<div class="col-md-12 sx-empty-hide">

    <div class="row sx-main-head sx-bg-glass sx-bg-glass-hover">
        <div class="col-md-11 pull-left">
            <? $controller = \Yii::$app->controller; ?>
            <? if ($controller && $controller instanceof \skeeks\cms\backend\IHasBreadcrumbs) : ?>
                <?= \yii\widgets\Breadcrumbs::widget([
                    'homeLink' => ['label' => \Yii::t("yii", "Home"), 'url' =>
                        \yii\helpers\Url::to(['/admin/index'])
                    ],
                    'links' => $controller->breadcrumbsData,
                ]) ?>
            <? endif; ?>
        </div>
        <div class="col-md-1">
            <div class="pull-right">

                <? if (\Yii::$app->user->can('rbac/admin-permission') && \Yii::$app->controller instanceof \skeeks\cms\IHasPermissions) : ?>
                    <?= \skeeks\cms\backend\widgets\ModalPermissionWidget::widget([
                        'controller' => \Yii::$app->controller
                    ]); ?>
                <? endif; ?>

            </div>
        </div>
    </div>
</div>
