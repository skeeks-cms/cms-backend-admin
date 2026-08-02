<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\cms\admin\assets;

use skeeks\cms\backend\assets\BackendUiAsset;

/**
 * Semantic administration dashboard panel.
 */
class AdminPanelAsset extends \skeeks\cms\base\AssetBundle
{
    public $sourcePath = '@skeeks/cms/admin/assets/src';

    public $css = [
        'css/admin-panel.css',
    ];

    public $depends = [
        BackendUiAsset::class,
    ];
}
