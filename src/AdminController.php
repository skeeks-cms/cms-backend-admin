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
 * @deprecated
 */
abstract class AdminController extends BackendController
{
    /**
     * @return array
     */
    /*public function getPermissionNames()
    {
        return [
            CmsManager::PERMISSION_ADMIN_ACCESS => \Yii::t('skeeks/cms', 'Access to the administration system'),
            $this->permissionName => $this->name
        ];
    }*/
}