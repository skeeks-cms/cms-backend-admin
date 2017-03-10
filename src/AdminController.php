<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 10.03.2017
 */
namespace skeeks\cms\admin;

use skeeks\cms\backend\BackendController;
use skeeks\cms\modules\admin\filters\AdminAccessControl;
use skeeks\cms\modules\admin\filters\AdminLastActivityAccessControl;
use skeeks\cms\rbac\CmsManager;
use yii\helpers\ArrayHelper;

/**
 * Class AdminController
 * @package skeeks\cms\admin
 */
abstract class AdminController extends BackendController
{
    /**
     * @return array
     */
    public function getPermissionNames()
    {
        return [
            CmsManager::PERMISSION_ADMIN_ACCESS,
            $this->permissionName
        ];
    }

    /**
     * Проверка доступа к админке
     * @return array
     */
    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(),
        [
            //Проверка основной привелигии доступа к админ панели
            'access' =>
            [
                'class'         => AdminAccessControl::className(),
            ],

            //Обновление активности пользователя взаимдействие с админкой
            'adminLastActivityAccess' =>
            [
                'class'         => AdminLastActivityAccessControl::className(),
                'rules' =>
                [
                    [
                        'allow'         => true,
                        'matchCallback' => function($rule, $action)
                        {
                            if (\Yii::$app->user->identity->lastAdminActivityAgo > \Yii::$app->admin->blockedTime)
                            {
                                return false;
                            }

                            if (\Yii::$app->user->identity)
                            {
                                \Yii::$app->user->identity->updateLastAdminActivity();
                            }

                            return true;
                        }
                    ]
                ],
            ],
        ]);
    }


    public function init()
    {
        \Yii::$app->admin;
        parent::init();
    }

    /**
     * TODO::Is deprecated
     *
     * The name of the privilege of access to this controller
     * @return string
     */
    public function getPermissionName()
    {
        return $this->getUniqueId();
    }

}