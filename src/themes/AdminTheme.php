<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

namespace skeeks\cms\admin\themes;

use skeeks\cms\admin\assets\BackendAdminAppAsset;
use skeeks\cms\admin\assets\BackendAdminHeaderAsset;
use skeeks\cms\admin\assets\BackendAdminMenuAsset;
use skeeks\cms\admin\form\fields\AdminSelectField;
use skeeks\cms\backend\themes\BackendTheme;
use skeeks\yii2\form\fields\SelectField;
use yii\helpers\ArrayHelper;

/**
 * Standard administration theme built directly on the shared backend shell.
 *
 * Legacy layout themes remain opt-in project compatibility layers and are not
 * dependencies of the standard administration package.
 */
class AdminTheme extends BackendTheme
{
    public $appAssetClass = BackendAdminAppAsset::class;

    public $headerAssetClass = BackendAdminHeaderAsset::class;

    public $leftMenuAssetClass = BackendAdminMenuAsset::class;

    public $pathMap = [
        '@app/views' => [
            '@skeeks/cms/admin/views',
            '@skeeks/cms/backend/views',
        ],
    ];

    public $logoTitle = 'SkeekS CMS';

    public function getHeaderClasses()
    {
        return 'sx-shell-header__surface--admin';
    }

    public function getSlideNavClasses()
    {
        return 'sx-shell-sidebar--default';
    }

    public static function initBeforeRender()
    {
        parent::initBeforeRender();

        \Yii::$container->setDefinitions(ArrayHelper::merge(
            \Yii::$container->definitions,
            [
                SelectField::class => [
                    'class' => AdminSelectField::class,
                ],
            ]
        ));
    }
}
