<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\cms\admin\assets;

use skeeks\cms\backend\assets\BackendLegacyIconAsset;
use skeeks\cms\backend\assets\BackendUiAsset;

/**
 * Assets for the standard backend guest/authentication layout.
 */
class BackendAdminUnauthorizedAsset extends \skeeks\cms\base\AssetBundle
{
    public $sourcePath = '@skeeks/cms/admin/assets/src';

    public $css = [
        'css/unauthorized.css',
    ];

    public $js = [
        'js/unauthorized.js',
    ];

    public $depends = [
        BackendUiAsset::class,
        BackendLegacyIconAsset::class,
    ];
}
