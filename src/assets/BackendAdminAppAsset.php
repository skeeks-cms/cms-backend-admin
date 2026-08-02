<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\cms\admin\assets;

use skeeks\cms\backend\assets\BackendAppAsset;
use skeeks\cms\backend\assets\BackendLegacyIconAsset;

/**
 * Standard administration shell without a layout-theme dependency.
 */
class BackendAdminAppAsset extends \skeeks\cms\base\AssetBundle
{
    public $depends = [
        BackendAppAsset::class,
        BackendLegacyIconAsset::class,
    ];
}
