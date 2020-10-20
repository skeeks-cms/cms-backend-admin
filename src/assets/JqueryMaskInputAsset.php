<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 12.03.2017
 */

namespace skeeks\cms\admin\assets;

use skeeks\cms\base\AssetBundle;

/**
 * Class JqueryMaskInputAsset
 * @package skeeks\cms\admin\assets
 */
class JqueryMaskInputAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/cms/admin/assets/src/plugins/jquery.maskedinput';

    public $css = [];

    public $js = [
        'dist/jquery.maskedinput.min.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
    ];
}
