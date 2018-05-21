<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link https://skeeks.com/
 * @copyright (c) 2010 SkeekS
 * @date 12.03.2017
 */

namespace skeeks\cms\admin\assets;

/**
 * Class ActionFilesAsset
 * @package skeeks\cms\admin\assets
 */
class ActionFilesAsset extends AdminAsset
{
    public $css = [
    ];
    public $js =
        [
            'actions/files/files.js',
        ];
    public $depends = [
        '\skeeks\sx\assets\Custom',
        '\skeeks\widget\simpleajaxuploader\Asset',
    ];
}
