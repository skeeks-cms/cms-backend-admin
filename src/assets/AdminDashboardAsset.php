<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\cms\admin\assets;

use skeeks\cms\backend\assets\BackendUiAsset;

/**
 * Dashboard-only layout. Widget-specific assets remain owned by each widget.
 */
class AdminDashboardAsset extends \skeeks\cms\base\AssetBundle
{
    public $sourcePath = '@skeeks/cms/admin/assets/src';

    public $css = [
        'css/dashboard.css',
    ];

    public $js = [
        'js/dashboard.js',
    ];

    public $depends = [
        BackendUiAsset::class,
    ];
}
