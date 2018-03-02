<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 31.05.2015
 */

namespace skeeks\cms\admin;

use skeeks\cms\helpers\RequestResponse;
use skeeks\cms\helpers\UrlHelper;
use yii\web\ForbiddenHttpException;
use yii\web\User;

/**
 * Class AdminAccessControl
 * @package skeeks\cms\admin
 */
class AdminAccessControl extends \yii\filters\AccessControl
{
    /**
     * Denies the access of the user.
     * The default implementation will redirect the user to the login page if he is a guest;
     * if the user is already logged, a 403 HTTP exception will be thrown.
     * @param User $user the current user
     * @throws ForbiddenHttpException if the user is already logged in.
     */
    protected function denyAccess($user)
    {
        $rr = new RequestResponse();

        if ($user->getIsGuest()) {
            $authUrl = UrlHelper::construct(["/admin/auth"])->setCurrentRef()->enableAdmin()->createUrl();

            if (\Yii::$app->request->isAjax && !\Yii::$app->request->isPjax) {
                $rr->redirect = $authUrl;
                return (array)$rr;
            } else {
                \Yii::$app->getResponse()->redirect($authUrl);
            }

        } else {
            throw new ForbiddenHttpException(\Yii::t('yii',
                \Yii::t('skeeks/cms', 'You are not allowed to perform this action.')));
        }
    }
}
