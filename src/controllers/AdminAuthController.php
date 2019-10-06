<?php
/**
 * AuthController
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010-2014 SkeekS (Sx)
 * @date 05.11.2014
 * @since 1.0.0
 */

namespace skeeks\cms\admin\controllers;


use skeeks\cms\actions\LogoutAction;
use skeeks\cms\backend\BackendController;
use skeeks\cms\helpers\RequestResponse;
use skeeks\cms\helpers\UrlHelper;
use skeeks\cms\models\forms\BlockedUserForm;
use skeeks\cms\models\forms\LoginFormUsernameOrEmail;
use skeeks\cms\models\forms\PasswordResetRequestFormEmailOrLogin;
use skeeks\cms\models\User;
use skeeks\cms\modules\admin\controllers\helpers\ActionManager;
use skeeks\cms\modules\admin\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * Class AuthController
 * @package skeeks\cms\admin\controllers
 */
class AdminAuthController extends BackendController
{
    public function init()
    {
        $this->permissionNames = [];
    }

    /**
     * @var boolean whether to enable CSRF validation for the actions in this controller.
     * CSRF validation is enabled only when both this property and [[Request::enableCsrfValidation]] are true.
     */
    //public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => \skeeks\cms\admin\AdminAccessControl::class,
                'only'  => [
                    'logout',
                    'lock'
                    //, 'login', 'auth', 'reset-password'
                ],
                'rules' => [
                    /*[
                        'actions' => ['login', 'auth', 'reset-password'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],*/
                    [
                        'actions' => ['logout', 'lock'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],

            'verbs' => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                    'lock'   => ['post'],
                ],
            ],
        ];
    }

    public $defaultAction = 'auth';

    /**
     * @inheritdoc
     */
    public function actions()
    {
        //var_dump(\Yii::$app->request->getCookies()->getValue(\Yii::$app->request->csrfParam));
        // var_dump(\Yii::$app->request->getBodyParam(\Yii::$app->request->csrfParam));
        // die;
        return [
            'logout' => [
                'class' => LogoutAction::className(),
            ],
        ];
    }

    public function actionLock()
    {
        $this->view->title = \Yii::t('skeeks/cms', 'Lock Mode');
        \Yii::$app->user->identity->lockAdmin();

        if ($ref = UrlHelper::getCurrent()->getRef()) {
            return $this->redirect($ref);
        } else {
            return $this->redirect(Yii::$app->getUser()->getReturnUrl());
        }
    }

    public function actionResetPassword()
    {
        $this->view->title = \Yii::t('skeeks/cms', 'Password recovery');
        $this->layout = '@app/views/layouts/unauthorized.php';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $token = \Yii::$app->request->get('token');

        if (!$token) {
            return $this->goHome();
        }

        $user = User::findByPasswordResetToken($token);

        if ($user) {
            $password = \Yii::$app->getSecurity()->generateRandomString(10);

            $user->setPassword($password);
            $user->generatePasswordResetToken();

            if ($user->save(false)) {

                \Yii::$app->mailer->view->theme->pathMap = ArrayHelper::merge(\Yii::$app->mailer->view->theme->pathMap,
                    [
                        '@app/mail' =>
                            [
                                '@skeeks/cms/mail-templates',
                            ],
                    ]);

                \Yii::$app->mailer->compose('@app/mail/new-password', ['user' => $user, 'password' => $password])
                    ->setFrom([\Yii::$app->cms->adminEmail => \Yii::$app->cms->appName])
                    ->setTo($user->email)
                    ->setSubject(\Yii::t('skeeks/cms', 'New password').' '.\Yii::$app->cms->appName)
                    ->send();

                $message = \Yii::t('skeeks/cms', 'New password sent to your e-mail');
            }
        } else {
            $message = \Yii::t('skeeks/cms', 'Link outdated, try to request a password recovery again.');
        }


        return $this->render('reset-password', [
            'message' => $message,
        ]);
    }

    public function actionBlocked()
    {
        $this->view->title = \Yii::t('skeeks/cms', 'Lock Mode');

        $this->layout = '@app/views/layouts/unauthorized';

        $goUrl = "";

        if ($ref = UrlHelper::getCurrent()->getRef()) {
            $goUrl = $ref;
        }

        if (!$goUrl) {
            $goUrl = \Yii::$app->getHomeUrl();
        }

        if (\Yii::$app->user->isGuest) {
            return $goUrl ? $this->redirect($goUrl) : $this->goHome();
        }

        $model = new BlockedUserForm();

        $rr = new RequestResponse();
        if ($rr->isRequestOnValidateAjaxForm()) {
            return $rr->ajaxValidateForm($model);
        }

        if ($rr->isRequestAjaxPost()) {
            if ($model->load(\Yii::$app->request->post()) && $model->login()) {
                $rr->success = true;
                $rr->message = "";
                $rr->redirect = $goUrl;
            } else {
                $rr->success = false;
                $rr->message = \Yii::t('skeeks/cms', "Failed log in");
            }

            return $rr;
        }

        return $this->render('blocked',
            [
                'model' => $model,
            ]);
    }

    public function actionAuth()
    {
        $this->view->title = \Yii::t('skeeks/cms', 'Authorization');
        $this->layout = '@app/views/layouts/unauthorized';

        $goUrl = "";
        $loginModel = new LoginFormUsernameOrEmail();

        if ($ref = UrlHelper::getCurrent()->getRef()) {
            $goUrl = $ref;
        }

        $rr = new RequestResponse();

        if (!\Yii::$app->user->isGuest) {
            return $goUrl ? $this->redirect($goUrl) : $this->goHome();
        }


            if ($rr->isRequestOnValidateAjaxForm()) {
                return $rr->ajaxValidateForm($loginModel);
            }

            if ($rr->isRequestAjaxPost()) {
                if ($loginModel->load(\Yii::$app->request->post()) && $loginModel->login()) {
                    if (!$goUrl) {
                        $goUrl = \Yii::$app->getUser()->getReturnUrl($defaultUrl);
                    }

                    $rr->redirect = $goUrl;

                    $rr->success = true;
                    $rr->message = "";
                    $rr->message = "";
                    return (array)$rr;
                } else {
                    $rr->success = false;
                    $rr->message = \Yii::t('skeeks/cms', "Unsuccessful attempt authorization");
                    return (array)$rr;
                }
            }




        return $this->render('auth', [
            'loginModel'         => $loginModel,
            'goUrl'              => $goUrl,
        ]);
    }


    public function actionForget()
    {
        $this->view->title = \Yii::t('skeeks/cms', 'Authorization');
        $this->layout = '@app/views/layouts/unauthorized';

        $goUrl = "";
        $passwordResetModel = new PasswordResetRequestFormEmailOrLogin();

        if ($ref = UrlHelper::getCurrent()->getRef()) {
            $goUrl = $ref;
        }

        $rr = new RequestResponse();

        if ($rr->isRequestOnValidateAjaxForm()) {
            return $rr->ajaxValidateForm($passwordResetModel);
        }

        if ($rr->isRequestAjaxPost()) {
            if ($passwordResetModel->load(\Yii::$app->request->post()) && $passwordResetModel->sendEmail()) {
                $rr->success = true;
                $rr->message = \Yii::t('skeeks/cms', "Check your email address");
                return (array)$rr;
            } else {
                $rr->success = false;
                $rr->message = \Yii::t('skeeks/cms', "Failed send email");
                return (array)$rr;
            }
        }

        return $this->render('forget', [
            'model' => $passwordResetModel,
            'goUrl'              => $goUrl,
        ]);
    }

}