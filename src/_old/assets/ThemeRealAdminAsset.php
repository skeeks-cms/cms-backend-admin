<?php
/**
 * @see http://bootstrapmaster.com/live/real/index.html#table.html
 *
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 12.03.2017
 */

namespace skeeks\cms\admin\assets;

use skeeks\cms\base\AssetBundle;

/**
 * Class ThemeRealAdminAsset
 * @package skeeks\cms\admin\assets
 */
class ThemeRealAdminAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/cms/admin/assets/src/themes/real-admin';

    public $css = [
        //'themes/real-admin/css/jquery.mmenu.css',
        'css/simple-line-icons.css',
        'css/font-awesome.min.css',
        'css/add-ons.min.css',
        //'themes/real-admin/css/style.min.css',
        'css/style-normal.css',
    ];
    public $js = [
        //'themes/real-admin/js/jquery.mmenu.min.js',
    ];
    public $depends = [
    ];
}
