<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 10.03.2017
 */
namespace skeeks\cms\admin;

use skeeks\cms\backend\BackendController;
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
        $result = ArrayHelper::merge(parent::behaviors(),
        [
            //Проверка основной привелигии доступа к админ панели
            'access' =>
            [
                'class'         => \skeeks\cms\admin\AdminAccessControl::class,
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

        return $result;
    }

}