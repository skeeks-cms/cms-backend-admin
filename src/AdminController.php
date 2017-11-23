<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 10.03.2017
 */

namespace skeeks\cms\admin;

use skeeks\cms\backend\BackendController;

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