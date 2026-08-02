<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\cms\admin\assets;

use skeeks\cms\backend\assets\BackendShellHeaderAsset;

/**
 * Standard administration header entry point.
 */
class BackendAdminHeaderAsset extends \skeeks\cms\base\AssetBundle
{
    public $depends = [
        BackendAdminAppAsset::class,
        BackendShellHeaderAsset::class,
    ];
}
