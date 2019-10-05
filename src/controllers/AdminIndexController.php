<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */

namespace skeeks\cms\admin\controllers;

use skeeks\cms\admin\AdminController;
use skeeks\cms\backend\BackendController;
use skeeks\cms\helpers\RequestResponse;
use skeeks\cms\helpers\UrlHelper;
use skeeks\cms\models\CmsDashboard;
use skeeks\cms\models\CmsDashboardWidget;
use skeeks\cms\rbac\CmsManager;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * @author Semenov Alexander <semenov@skeeks.com>
 */
class AdminIndexController extends BackendController
{
    public function init()
    {
        $this->name = \Yii::t('skeeks/cms', "Desktop");
        $this->permissionName = CmsManager::PERMISSION_ADMIN_ACCESS;

        parent::init();
    }

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
            'indexverbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'dashboard-save' => ['post', 'get'],
                ],
            ],
        ]);
    }

    /**
     * @return string
     */
    public function actionIndex()
    {
        $dashboard = null;
        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = CmsDashboard::findOne($pk);
        }

        if (!$dashboard) {
            $dashboard = CmsDashboard::find()->orderBy(['priority' => SORT_ASC])->one();

            if (!$dashboard) {
                $dashboard = new CmsDashboard();
                $dashboard->name = 'Стол по умолчанию';

                if (!$dashboard->save()) {
                    throw new NotFoundHttpException("Рабочий стол не найден");
                }
            }
        }


        return $this->redirect(
            UrlHelper::construct(['/admin/admin-index/dashboard', 'pk' => $dashboard->id])->enableAdmin()->toString()
        );
    }

    public function actionDashboard()
    {
        $dashboard = null;
        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = CmsDashboard::findOne($pk);
        }

        if (!$dashboard) {
            throw new NotFoundHttpException("Рабочий стол не найден");
        }

        $this->layout = '@app/views/layouts/main-empty';

        return $this->render($this->action->id, [
            'dashboard' => $dashboard
        ]);
    }

    public function actionDashboardValidate()
    {
        $rr = new RequestResponse();
        $dashboard = null;

        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = CmsDashboard::findOne($pk);
        }

        if (!$dashboard) {
            $rr->message = "Рабочий стол не найден";
            $rr->success = false;
        }

        if ($rr->isRequestAjaxPost()) {
            return $rr->ajaxValidateForm($dashboard);
        }

        return $rr;
    }


    public function actionDashboardRemove()
    {
        $rr = new RequestResponse();
        $rr->success = false;
        /**
         * @var $dashboard CmsDashboard
         */
        $dashboard = null;

        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = CmsDashboard::findOne($pk);
        }

        if (!$dashboard) {
            $rr->message = "Рабочий стол не найден";
            $rr->success = false;
        }

        try {
            $dashboard->delete();
            $rr->redirect = UrlHelper::construct(['/admin/index'])->enableAdmin()->toString();
            $rr->success = true;

        } catch (\Exception $e) {
            $rr->message = $e->getMessage();
            $rr->success = false;
        }

        return $rr;
    }

    public function actionDashboardSave()
    {
        $rr = new RequestResponse();
        $rr->success = false;

        /**
         * @var $dashboard CmsDashboard
         */
        $dashboard = null;

        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = CmsDashboard::findOne($pk);
        }

        if (!$dashboard) {
            $rr->message = "Рабочий стол не найден";
            $rr->success = false;
        }

        if ($rr->isRequestAjaxPost()) {
            if ($dashboard->load(\Yii::$app->request->post()) && $dashboard->save()) {
                $rr->success = true;
                $rr->message = 'Сохранено';
            } else {

                $rr->message = 'Не сохранено';
            }
        }

        return $rr;
    }


    public function actionDashboardWidgetCreateValidate()
    {
        $rr = new RequestResponse();
        $dashboardWidget = new CmsDashboardWidget();

        if ($rr->isRequestAjaxPost()) {
            return $rr->ajaxValidateForm($dashboardWidget);
        }

        return $rr;
    }

    public function actionDashboardWidgetCreateSave()
    {
        $rr = new RequestResponse();
        $dashboardWidget = new CmsDashboardWidget();

        if ($rr->isRequestAjaxPost()) {
            if ($dashboardWidget->load(\Yii::$app->request->post()) && $dashboardWidget->save()) {
                $rr->success = true;
                $rr->message = 'Сохранено';
            } else {

                $rr->message = 'Не сохранено';
            }
        }

        return $rr;
    }


    public function actionDashboardCreateValidate()
    {
        $rr = new RequestResponse();
        $dashboard = new CmsDashboard();

        if ($rr->isRequestAjaxPost()) {
            return $rr->ajaxValidateForm($dashboard);
        }

        return $rr;
    }


    public function actionDashboardCreateSave()
    {
        $rr = new RequestResponse();
        $dashboard = new CmsDashboard();

        if ($rr->isRequestAjaxPost()) {
            if ($dashboard->load(\Yii::$app->request->post()) && $dashboard->save()) {
                $rr->success = true;
                $rr->message = 'Сохранено';
                $rr->redirect = UrlHelper::construct([
                    '/admin/index/dashboard',
                    'pk' => $dashboard->id
                ])->enableAdmin()->toString();
            } else {

                $rr->message = 'Не сохранено';
            }
        }

        return $rr;
    }


    public function actionWidgetPrioritySave()
    {
        $rr = new RequestResponse();
        $rr->success = false;

        /**
         * @var $dashboard CmsDashboard
         */
        $dashboard = null;

        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboard = CmsDashboard::findOne($pk);
        }

        if (!$dashboard) {
            $rr->message = "Рабочий стол не найден";
            $rr->success = false;
        }

        $widgets = $dashboard->cmsDashboardWidgets;
        $widgets = ArrayHelper::map($dashboard->cmsDashboardWidgets, 'id', function ($model) {
            return $model;
        });

        if ($rr->isRequestAjaxPost()) {
            if ($data = \Yii::$app->request->post()) {
                foreach ($data as $columnId => $widgetIds) {
                    //Обновляем приоритеты виджетов в этой колонке
                    if ($widgetIds) {
                        $priority = 100;
                        foreach ($widgetIds as $widgetId) {
                            if (isset($widgets[$widgetId])) {
                                /**
                                 * @var $widget CmsDashboardWidget
                                 */
                                $widget = $widgets[$widgetId];
                                $widget->cms_dashboard_column = $columnId;
                                $widget->priority = $priority;
                                $widget->save();

                                $priority = $priority + 100;

                                unset($widgets[$widgetId]);
                            }
                        }
                    }
                }

                //еще остались виджеты, суем их в конец
                if ($widgets) {
                    foreach ($widgets as $widget) {
                        $widget->cms_dashboard_column = $columnId;
                        $widget->priority = $priority;
                        $widget->save();

                        $priority = $priority + 100;
                    }
                }
            }
        }

        $rr->success = true;

        return $rr;
    }


    public function actionEditDashboardWidget()
    {
        $rr = new RequestResponse();
        $rr->success = false;

        /**
         * @var $dashboardWidget CmsDashboardWidget
         */
        $dashboardWidget = null;

        if ($pk = \Yii::$app->request->get('pk')) {
            $dashboardWidget = CmsDashboardWidget::findOne($pk);
        }

        //print_r($dashboardWidget->toArray());die;

        if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax) {
            return $rr->ajaxValidateForm($dashboardWidget->widget);
        }

        if (\Yii::$app->request->isPjax && \Yii::$app->request->post()) {
            if (!$dashboardWidget) {
                $rr->message = "Виджет не найден";
                $rr->success = false;
            }

            if ($dashboardWidget->widget->load(\Yii::$app->request->post())) {
                $data = \Yii::$app->request->post($dashboardWidget->widget->formName());
                $dashboardWidget->component_settings = $data;
                if ($dashboardWidget->save()) {
                    \Yii::$app->session->setFlash('success', 'Saved');
                } else {
                    \Yii::$app->session->setFlash('success', 'Errors');
                }
            }

        }

        if (!$dashboardWidget) {
            throw new NotFoundHttpException('Widget not found');
        }

        return $this->render($this->action->id, [
            'model' => $dashboardWidget
        ]);
    }


    public function actionWidgetRemove()
    {
        $rr = new RequestResponse();
        $rr->success = false;

        /**
         * @var $dashboardWidget CmsDashboardWidget
         */
        $dashboardWidget = null;

        if ($pk = \Yii::$app->request->post('id')) {
            $dashboardWidget = CmsDashboardWidget::findOne($pk);
        }

        if (!$dashboardWidget) {
            $rr->message = "Виджет не найден";
            $rr->success = false;
        }

        if ($dashboardWidget->delete()) {
            $rr->success = true;
        }

        return $rr;
    }
}