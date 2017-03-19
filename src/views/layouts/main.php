<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use skeeks\cms\helpers\UrlHelper;

/* @var $this \yii\web\View */
/* @var $content string */

\skeeks\cms\admin\assets\AdminAsset::register($this);
\Yii::$app->backendAdmin->initJs($this);
\skeeks\cms\modules\admin\widgets\UserLastActivityWidget::widget();
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <link rel="icon" href="https://skeeks.com/favicon.ico"  type="image/x-icon" />
        <?php $this->head() ?>
    </head>
    <body class="<?= \Yii::$app->user->isGuest ? "sidebar-hidden" : ""?> <?= \Yii::$app->admin->isEmptyLayout() ? "empty" : ""?>">
<?php $this->beginBody() ?>
    <?= $this->render('_header'); ?>
    <? if (!\Yii::$app->user->isGuest): ?>
        <?= $this->render('_admin-menu'); ?>
    <? endif; ?>
        <div class="main">

            <?= $this->render('_main-head'); ?>

            <div class="col-lg-12 sx-main-body">
                <? $openClose = \Yii::t('skeeks/cms', 'Expand/Collapse')?>
                <? \skeeks\cms\admin\widgets\AdminPanelWidget::begin([
                    'name'      => \Yii::$app->controller instanceof \skeeks\cms\IHasInfo ? \Yii::$app->controller->name : "",
                    'actions'   => <<<HTML
                        <a href="#" class="sx-btn-trigger-full">
                            <i class="glyphicon glyphicon-fullscreen" data-sx-widget="tooltip-b" data-original-title="{$openClose}" style="color: white;"></i>
                        </a>
HTML
,

                    'options' =>
                    [
                        'class' => 'sx-main-content-widget sx-panel-content',
                    ],
                ]); ?>
                   <div class="panel-content-before">
                        <? if (!UrlHelper::constructCurrent()->getSystem(\skeeks\cms\modules\admin\Module::SYSTEM_QUERY_NO_ACTIONS_MODEL)) : ?>
                            <? if (\Yii::$app->controller && \Yii::$app->controller instanceof \skeeks\cms\backend\IHasInfoActions
                                && \Yii::$app->controller->actions && count(\Yii::$app->controller->actions) > 1) : ?>
                                <?
                                    echo \skeeks\cms\backend\widgets\ControllerActionsWidget::currentWidget();
                                ?>
                            <? endif; ?>
                        <? endif; ?>
                    </div>

                    <div class="panel-content-before panel-content-before-second">
                        <? if (\Yii::$app->controller && \Yii::$app->controller instanceof \skeeks\cms\backend\controllers\IBackendModelController
                            && \Yii::$app->controller->modelActions && count(\Yii::$app->controller->modelActions)) : ?>

                            <div class="col-md-1 sx-model-title" title="<?= \Yii::$app->controller->modelShowName; ?>"">id <?= \Yii::$app->controller->modelPkValue ?>:</div>
                            <?
                                echo \skeeks\cms\backend\widgets\ControllerActionsWidget::widget([
                                        'actions' => \Yii::$app->controller->modelActions,
                                        'activeId' => \Yii::$app->controller->action->id
                                ]);
                            ?>
                        <? endif; ?>
                    </div>
                    <div class="panel-content">
                        <?= \skeeks\cms\modules\admin\widgets\Alert::widget(); ?>
                        <?= $content ?>
                    </div>
                <? \skeeks\cms\admin\widgets\AdminPanelWidget::end(); ?>
            </div>

        </div>
        <?php echo $this->render('_footer'); ?>
        <?php $this->endBody() ?>
    </body>
</html>
<?php $this->endPage() ?>
