<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 12.03.2017
 */
namespace skeeks\cms\admin\assets;
/**
 * Class AdminCanvasBg
 * @package skeeks\cms\admin\assets
 */
class AdminCanvasBg extends AdminAsset
{
    public $css =
    [];

    public $js = [
        'plugins/canvas-bg/canvasbg.js',
    ];

    public $depends =
    [
        'skeeks\cms\admin\assets\AdminAsset',
    ];
}

