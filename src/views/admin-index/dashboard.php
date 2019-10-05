<?php
/* @var $this yii\web\View */
/* @var $dashboard skeeks\cms\models\CmsDashboard */

$this->title = $dashboard->name . " / " . \Yii::t('skeeks/cms','Dashboard');


$this->registerCss(<<<CSS
.sx-dashboard-head
{
    padding: 10px 0;
    margin-bottom: 10px;
    border-left: 1px solid rgba(255, 255, 255, 0.46);
}

.sx-dashboard table tr td.sx-columns
{
    vertical-align: top;
}

.sx-dashboard table tr td.sx-first
{
    padding-left: 0;
}

#sx-dashboard-table {
    width: 100%;
}

.sx-dashboard-body
{
    margin-top: 10px;
}

CSS
);

$sortableString = [];
?>
<div class="col-md-12 sx-dashboard" id="sx-dashboard">

    <? if (\Yii::$app->user->can(\skeeks\cms\rbac\CmsManager::PERMISSION_ADMIN_DASHBOARDS_EDIT)) : ?>
        <? echo $this->render('_head', [
            'dashboard' => $dashboard
        ]); ?>
    <? endif; ?>


    <div class="row sx-dashboard-body">
        <div class="col-lg-12 col-md-12">
            <? if (!$dashboard->cmsDashboardWidgets) : ?>

                <?=
                    yii\bootstrap\Alert::widget([
                        'options' => [
                          'class' => 'alert-info',
                      ],
                      'body' => \yii\helpers\Html::tag("h1", \Yii::t('skeeks/cms','Welcome! You are in the site management system.')),
                    ]);
                ?>

            <? else : ?>


                <table id="sx-dashboard-table">
                    <tr>
                        <? for($i = 1; $i <= $dashboard->columns; $i++) : ?>
                            <?
                            $sortableString[] = "#sx-column-" . $i;
                            ?>
                            <td style="width: <? echo round(100/$dashboard->columns); ?>%;" id="sx-column-<?= $i; ?>" class="sx-columns <?= $i == 1 ? "sx-first": ""?>" data-column="<?= $i; ?>">
                                <? $widgets = $dashboard->getCmsDashboardWidgets()->andWhere(['cms_dashboard_column' => $i])->orderBy(['priority' => SORT_ASC])->all(); ?>
                                <? if ($widgets) : ?>

                                    <?
                                    /**
                                     * @var $widgets \skeeks\cms\models\CmsDashboardWidget[]
                                     */
                                    foreach($widgets as $cmsDashboardWidget) : ?>

                                        <? if (\Yii::$app->user->can(\skeeks\cms\rbac\CmsManager::PERMISSION_ADMIN_DASHBOARDS_EDIT)) : ?>
                                        <?
                                            $cmsWidgetData = $cmsDashboardWidget->toArray(['id']);

                                            $requestData = [
                                                'pk' => $cmsDashboardWidget->id
                                            ];

                                            $cmsWidgetData = \yii\helpers\ArrayHelper::merge($cmsWidgetData, [
                                                'editConfigUrl' => \skeeks\cms\backend\helpers\BackendUrlHelper::createByParams(['admin/admin-index/edit-dashboard-widget'])
                                                    ->merge((array) $requestData)
                                                    ->enableEmptyLayout()
                                                    ->url
                                            ]);

                                            $cmsWidgetData = \yii\helpers\Json::encode($cmsWidgetData);

                                            $openClose = \Yii::t('skeeks/cms', 'Expand/Collapse');

                                        $actions = <<<HTML
<a href="#sx-permissions-for-controller" onclick='sx.Dashboard.editConfigWidget({$cmsWidgetData}); return false;'
class="u-link-v5 g-color-gray-light-v3 g-color-primary--hover g-ml-10"
>
    <i class="fa fa-cog" data-sx-widget="tooltip-b" data-original-title="Настроить"></i>
</a>

<a href="#"
class="sx-btn-trigger-full u-link-v5 g-color-gray-light-v3 g-color-primary--hover g-ml-10"
>
    <i class="fa fa-expand" data-sx-widget="tooltip-b" data-original-title="{$openClose}"></i>
</a>

<a href="#sx-permissions-for-controller" onclick='sx.Dashboard.removeWidget({$cmsWidgetData}); return false;'
class="u-link-v5 g-color-gray-light-v3 g-color-primary--hover g-ml-10"
>
    <i class="fa fa-times" data-sx-widget="tooltip-b" data-original-title="Удалить"></i>
</a>
HTML;
                                        ?>



                                        <? \skeeks\cms\admin\widgets\AdminPanelWidget::begin([
                                            'name'      => $cmsDashboardWidget->name,
                                            'actions'   => $actions,

                                            'options' =>
                                            [
                                                'class' => 'sx-dashboard-widget',
                                                'data'      => $cmsDashboardWidget->toArray(['id']),
                                            ],
                                        ]); ?>
                                            <? if ($cmsDashboardWidget->widget) : ?>
                                                <?
                                                    try
                                                    {
                                                        echo $cmsDashboardWidget->widget->run();
                                                    } catch (\Exception $e)
                                                    {
                                                        echo $e->getMessage();
                                                    }
                                                ?>
                                            <? else : ?>
                                                Виджет удален
                                            <? endif; ?>
                                        <? \skeeks\cms\admin\widgets\AdminPanelWidget::end(); ?>

                                        <? endif; ?>
                                    <? endforeach; ?>

                                <? endif; ?>
                            </td>
                            <? if ($dashboard->columns > 1 && $i != $dashboard->columns) : ?>
                                <td width="20">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            <? endif; ?>
                        <? endfor; ?>
                    </tr>
                </table>

            <? endif; ?>

        </div>
    </div>
</div>

<? if (\Yii::$app->user->can(\skeeks\cms\rbac\CmsManager::PERMISSION_ADMIN_DASHBOARDS_EDIT)) : ?>

    <?

    $this->registerCss(<<<CSS
.sx-panel .panel-heading
{
    cursor: move;
}
CSS
);
    \yii\jui\Sortable::widget();

    $sortableString = implode(', ', $sortableString);

    $jsonData = \yii\helpers\Json::encode([
        'model'                     => $dashboard,
        'sortableSelector'          => $sortableString,
        'backendPrioritySave'       => \skeeks\cms\helpers\UrlHelper::construct(['/admin/admin-index/widget-priority-save', 'pk' => $dashboard->id])->enableAdmin()->toString(),
        'backendWidgetRemove'       => \skeeks\cms\helpers\UrlHelper::construct(['/admin/admin-index/widget-remove'])->enableAdmin()->toString(),
    ]);

    $this->registerJs(<<<JS

    (function(sx, $, _)
    {
        sx.classes.Dashboard = sx.classes.Component.extend({

            _init: function()
            {
                var self = this;

                this.bind('change', function(e, data)
                {
                    self.save();
                });
            },

            _onDomReady: function()
            {
                this._initSortable();


            },

            /**
            *
            * @returns {*|HTMLElement}
            */
            getJWrapper: function()
            {
                return $('#sx-dashboard');
            },

            /**
            *
            * @returns {{}|*}
            */
            getData: function()
            {
                data = {};

                $('table tr td.sx-columns', this.getJWrapper()).each(function()
                {
                    var ids = [];
                    $(".sx-dashboard-widget", $(this)).each(function()
                    {
                        ids.push($(this).data('id'));
                    });

                    data[ $(this).data('column') ] = ids;
                });

                return data;
            },

            save: function()
            {
                var self = this;
                var data = self.getData();

                var ajax = sx.ajax.preparePostQuery(this.get('backendPrioritySave'), data);

                new sx.classes.AjaxHandlerNoLoader(ajax);

                new sx.classes.AjaxHandlerStandartRespose(ajax, {
                    'enableBlocker' : true,
                    'blockerSelector' : this.getJWrapper()
                });

                ajax.onError(function(e, data)
                {
                    sx.notify.info("Подождите сейчас страница будет перезагружена");
                    _.delay(function()
                    {
                        //window.location.reload();
                    }, 2000);
                })
                .onSuccess(function(e, data)
                {
                    //blocker.unblock();
                })
                .execute();
            },


            editConfigWidget: function(data)
            {
                new sx.classes.DashboardWidget(this, data).editConfig();
            },

            removeWidget: function(data)
            {
                new sx.classes.DashboardWidget(this, data).remove();
            },

            _initSortable: function()
            {
                var self = this;

                $(self.get('sortableSelector')).sortable(
                {
                    connectWith: ".sx-columns",
                    cursor: "move",
                    handle: ".panel-heading",
                    forceHelperSize: true,
                    forcePlaceholderSize: true,
                    //delay: 150,
                    opacity: 0.5,
                    placeholder: "ui-state-highlight",
                    stop: function( event, ui )
                    {
                        self.trigger('change', {
                            'event' : event,
                            'ui' : ui,
                        });
                    }

                }).disableSelection();
            }
        });

        sx.Dashboard = new sx.classes.Dashboard({$jsonData});


        sx.classes.DashboardWidget = sx.classes.Component.extend({

            construct: function (Dashboard, opts)
            {
                var self = this;
                opts = opts || {};
                this.Dashboard = Dashboard;
                //this.parent.construct(opts);
                this.applyParentMethod(sx.classes.Component, 'construct', [opts]); // TODO: make a workaround for magic parent calling
            },

            _init: function()
            {
                var self = this;
            },

            /**
            *
            * @returns {*|HTMLElement}
            */
            getJWrapper: function()
            {
                return $('.sx-dashboard-widget[data-id=' + this.get('id') + ']');
            },

            remove: function()
            {
                var self = this;
                var jWrapper = this.getJWrapper();

                var ajax = sx.ajax.preparePostQuery(this.Dashboard.get('backendWidgetRemove'), {
                    'id' : this.get('id')
                });

                new sx.classes.AjaxHandlerNoLoader(ajax);

                var Handler = new sx.classes.AjaxHandlerStandartRespose(ajax, {
                    'enableBlocker' : true,
                    'blockerSelector' : jWrapper
                });

                Handler.bind('success', function()
                {
                    jWrapper.fadeOut('fast', function()
                    {
                        $(this).remove();
                    });
                });

                ajax.onError(function(e, data)
                {
                    sx.notify.info("Подождите сейчас страница будет перезагружена");
                    _.delay(function()
                    {
                        //window.location.reload();
                    }, 2000);
                })
                .onSuccess(function(e, data)
                {})
                .execute();
            },

            editConfig: function()
            {
                this.Window = new sx.classes.Window(this.get('editConfigUrl'), 'sx-edit-widget-' + this.get('id'));
                this.Window.open();

                this.Window.bind('close', function()
                {
                    window.location.reload();
                });
            }
        });


    })(sx, sx.$, sx._);


JS
    );

    ?>
<? endif; ?>
