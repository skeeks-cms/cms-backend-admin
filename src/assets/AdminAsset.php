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
 * Class AdminAsset
 * @package skeeks\cms\admin\assets
 */
class AdminAsset extends AssetBundle
{
    public $sourcePath = '@skeeks/cms/admin/assets/src';

    public $css = [
        'https://use.fontawesome.com/releases/v5.0.7/css/all.css',

        'css/panel.css',
        'css/sidebar.css',
        'css/app.css',

        'css/grid.css',
        'css/table.css'
    ];
    public $js = [
        'js/classes/Blocker.js',
        'js/classes/OldNav.js',
        'js/classes/Menu.js',
        'js/classes/Iframe.js',
        'js/classes/Window.js',
        'js/classes/modal/Dialog.js',
        'js/classes/Fullscreen.js',
        'js/classes/UserLastActivity.js',
        'js/classes/modal/Promt.js',
        'js/classes/modal/Confirm.js',
        //'js/App.js',
        'js/Admin.js',
    ];
    public $depends = [

        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',

        'skeeks\sx\assets\Custom',
        'skeeks\sx\assets\ComponentAjaxLoader',
        'skeeks\cms\admin\assets\JqueryScrollbarAsset',
        'skeeks\cms\admin\assets\ThemeRealAdminAsset',
        'skeeks\cms\assets\FancyboxAssets',
    ];

    /**
     * Registers this asset bundle with a view.
     * @param View $view the view to be registered with
     * @return static the registered asset bundle instance
     */
    public function registerAssetFiles($view)
    {
        if (\Yii::$app->request->isPjax) {
            return parent::registerAssetFiles($view);
        }

        parent::registerAssetFiles($view);
    }
}

