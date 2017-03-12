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
 * Class JqueryScrollbarAsset
 * @package skeeks\cms\admin\assets
 */
class JqueryScrollbarAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/cms/admin/assets/src/plugins/jquery.scrollbar/';

    public $css = [
        'jquery.scrollbar.css',
    ];
    public $js = [
        'jquery.scrollbar.min.js',
    ];
    public $depends = [];
}
