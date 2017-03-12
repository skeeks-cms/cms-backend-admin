<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 09.06.2015
 */
namespace skeeks\cms\admin\assets;
/**
 * Class AdminFormAsset
 * @package skeeks\cms\admin\assets
 */
class AdminFormAsset extends AdminAsset
{
    public $css =
    [
        'css/form.css',
    ];

    public $js = [
        'js/classes/Form.js',
    ];

    public $depends =
    [
        'skeeks\cms\admin\assets\AdminAsset',
    ];
}

