<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 02.07.2015
 */
namespace skeeks\cms\admin\assets;

/**
 * Class AdminUnauthorizedAsset
 * @package skeeks\cms\admin\assets
 */
class AdminUnauthorizedAsset extends AdminAsset
{
    public $css = [
        'css/unauthorized.css',
    ];

    public $js = [
        'js/Unauthorized.js',
    ];
    public $depends = [
        '\skeeks\cms\admin\assets\AdminAsset',
        '\skeeks\cms\admin\assets\AdminCanvasBg',
    ];
}

