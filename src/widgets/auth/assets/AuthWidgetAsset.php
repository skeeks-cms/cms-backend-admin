<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\cms\admin\widgets\auth\assets;

use skeeks\cms\admin\assets\JqueryMaskInputAsset;
use skeeks\cms\backend\assets\BackendUiAsset;
use yii\web\AssetBundle;

/**
 * Behavior and scoped presentation for the administration auth widget.
 */
class AuthWidgetAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/cms/admin/widgets/auth/assets/src';

    public $css = [
        'auth.css',
    ];

    public $js = [
        'auth.js',
    ];

    public $depends = [
        BackendUiAsset::class,
        JqueryMaskInputAsset::class,
    ];
}
