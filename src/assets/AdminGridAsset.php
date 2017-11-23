<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 12.03.2017
 */

namespace skeeks\cms\admin\assets;

/**
 * Class AdminGridAsset
 * @package skeeks\cms\admin\assets
 */
class AdminGridAsset extends AdminAsset
{
    public $css =
        [
            'css/grid.css',
            'css/table.css',
        ];

    public $js = [];

    public $depends =
        [
            //'skeeks\cms\admin\assets\AdminAsset',
        ];
}

