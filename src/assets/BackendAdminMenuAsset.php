<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\cms\admin\assets;

use skeeks\cms\backend\assets\BackendShellMenuAsset;

/**
 * Standard administration sidebar/menu entry point.
 */
class BackendAdminMenuAsset extends \skeeks\cms\base\AssetBundle
{
    public $depends = [
        BackendAdminAppAsset::class,
        BackendShellMenuAsset::class,
    ];
}
