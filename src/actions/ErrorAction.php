<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 12.03.2017
 */

namespace skeeks\cms\admin\actions;


use skeeks\cms\helpers\RequestResponse;
use skeeks\cms\rbac\CmsManager;
use Yii;
use yii\base\Exception;
use yii\base\UserException;
use yii\helpers\Html;

/**
 * Class ErrorAction
 * @package skeeks\cms\actions
 */
class ErrorAction extends \yii\web\ErrorAction
{
    /**
     * Runs the action
     *
     * @return string result content
     */
    public function run()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            return '';
        }

        if ($exception instanceof \HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }

        if ($exception instanceof Exception) {
            $name = $exception->getName();
        } else {
            $name = $this->defaultName ?: Yii::t('yii', 'Error');
        }

        if ($code) {
            $name .= " (#$code)";
        }

        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = $this->defaultMessage ?: Yii::t('yii', 'An internal server error occurred.');
        }


        if (Yii::$app->getRequest()->getIsAjax()) {
            $rr = new RequestResponse();

            $rr->success = false;
            $rr->message = "$name: $message";

            return (array)$rr;
        } else {
            if (\Yii::$app->user->can(CmsManager::PERMISSION_ADMIN_ACCESS)) {
                $this->controller->layout = \Yii::$app->cms->moduleAdmin->layout;
                return $this->controller->render('@app/views/error/error', [
                    'message' => nl2br(Html::encode($message))
                ]);
            } else {
                $this->controller->layout = '@app/views/layouts/unauthorized';

                return $this->controller->render('@app/views/error/unauthorized-403', [
                    'message' => nl2br(Html::encode($message))
                ]);
            }
        }
    }
}