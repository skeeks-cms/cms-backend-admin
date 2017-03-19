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

                <? if (\Yii::$app->user->can('admin/admin-role') && \Yii::$app->controller instanceof \skeeks\cms\IHasPermissions) : ?>

                    <a href="#sx-permissions-for-controller" class="btn btn-default btn-primary sx-fancybox">
                        <i class="glyphicon glyphicon-exclamation-sign" data-sx-widget="tooltip-b" data-original-title="<?=\Yii::t('skeeks/cms','Setting up access to this section')?>" style="color: white;"></i>

                    </a>

                    <div style="display: none;">
                        <div id="sx-permissions-for-controller" style="min-height: 300px;">

                            <?
                            $adminPermission = \Yii::$app->authManager->getPermission(\skeeks\cms\rbac\CmsManager::PERMISSION_ADMIN_ACCESS);
                            $items = [];
                            foreach (\Yii::$app->authManager->getRoles() as $role)
                            {
                                if (\Yii::$app->authManager->hasChild($role, $adminPermission))
                                {
                                    $items[] = $role;
                                }
                            }
                            ?>
                            <? if (\Yii::$app->controller->permissionNames) : ?>
                                <? foreach (\Yii::$app->controller->permissionNames as $parmissionName => $permissionLabel) : ?>
                                    <?= \skeeks\cms\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
                                        'permissionName'        => $parmissionName,
                                        'permissionDescription' => $permissionLabel,
                                        'label'                 => $permissionLabel,
                                        'items'                 => \yii\helpers\ArrayHelper::map($items, 'name', 'description'),
                                    ]); ?>
                                <? endforeach; ?>

                                <? if (\Yii::$app->controller->allActions) : ?>
                                    <h2>Действия</h2>
                                    <hr />
                                    <? foreach (\Yii::$app->controller->allActions as $actionObj) : ?>
                                        <div class="row">
                                            <div class="col-md-3">
                                                <label><?= $actionObj->name; ?></label>
                                            </div>
                                            <div class="col-md-9">
                                                <? if ($actionObj->permissionNames) : ?>
                                                    <? foreach ($actionObj->permissionNames as $parmissionName => $permissionLabel) : ?>
                                                        <?= \skeeks\cms\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
                                                            'permissionName'        => $parmissionName,
                                                            'permissionDescription' => $permissionLabel,
                                                            'label'                 => $permissionLabel,
                                                            'items'                 => \yii\helpers\ArrayHelper::map($items, 'name', 'description'),
                                                        ]); ?>
                                                    <? endforeach; ?>
                                                <? endif; ?>
                                            </div>
                                        </div>




                                        <?/*= \skeeks\cms\rbac\widgets\adminPermissionForRoles\AdminPermissionForRolesWidget::widget([
                                            'permissionName'        => $parmissionName,
                                            'permissionDescription' => $permissionLabel,
                                            'label'                 => $permissionLabel,
                                            'items'                 => \yii\helpers\ArrayHelper::map($items, 'name', 'description'),
                                        ]); */?><!--
                                        -->
                                    <? endforeach; ?>
                                <? endif; ?>
                            <? endif; ?>

                            <?=\Yii::t('skeeks/cms','Specify which groups of users will have access.')?>
                        </div>
                    </div>

                <? endif; ?>

            </div>
        </div>
    </div>
</div>
