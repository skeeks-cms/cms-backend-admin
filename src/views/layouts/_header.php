<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 *
 * @var yii\web\View $this
 * @var \skeeks\cms\backend\themes\BackendTheme $theme
 */

use skeeks\cms\admin\assets\BackendAdminHeaderAsset;
use skeeks\cms\backend\helpers\BackendUrlHelper;
use skeeks\cms\backend\widgets\BackendShellHeaderWidget;
use skeeks\cms\models\CmsLang;

$theme = $this->theme;
$headerAssetClass = $theme->headerAssetClass ?: BackendAdminHeaderAsset::class;
$headerAssetClass::register($this);

$langs = CmsLang::find()->active()->all();
$quickCreateItems = [
    ['label' => 'Задачу', 'icon' => 'tasks', 'url' => BackendUrlHelper::createByParams(['/cms/admin-cms-task/create'])->enableEmptyLayout()->enableNoActions()->url],
    ['label' => 'Компанию', 'icon' => 'building', 'url' => BackendUrlHelper::createByParams(['/cms/admin-cms-company/create'])->enableEmptyLayout()->enableNoActions()->url],
    ['label' => 'Клиента', 'icon' => 'user', 'url' => BackendUrlHelper::createByParams(['/cms/admin-user/create'])->enableEmptyLayout()->enableNoActions()->url],
    ['label' => 'Сделку', 'icon' => 'handshake', 'url' => BackendUrlHelper::createByParams(['/cms/admin-cms-deal/create'])->enableEmptyLayout()->enableNoActions()->url],
    ['label' => 'Счет', 'icon' => 'invoice', 'url' => BackendUrlHelper::createByParams(['/cms/admin-cms-bill/create'])->enableEmptyLayout()->enableNoActions()->url],
    ['label' => 'Платеж', 'icon' => 'credit-card', 'url' => BackendUrlHelper::createByParams(['/shop/admin-payment/create'])->enableEmptyLayout()->enableNoActions()->url],
];

echo BackendShellHeaderWidget::widget([
    'brand' => $this->render('_header-brand', [
        'theme' => $theme,
    ]),
    'context' => $this->render('_header-context'),
    'actions' => $this->render('_header-actions', [
        'langs'            => $langs,
        'quickCreateItems' => $quickCreateItems,
    ]),
    'profile' => $this->render('_header-profile'),
    'surfaceOptions' => [
        'class' => $theme->headerClasses,
    ],
    'navOptions' => [
        'class' => 'navbar no-gutters',
    ],
    'brandOptions' => [
        'class' => \Yii::$app->mobileDetect->isMobile
            ? 'sx-shell-header__mobile-toggle'
            : 'col-auto d-flex flex-nowrap sx-header-logo-toggler',
    ],
    'contextOptions' => [
        'class' => 'col-auto d-flex sx-breadcrumbs-wrapper',
    ],
    'actionsOptions' => [
        'class' => 'col-auto d-flex ml-auto sx-right-col',
    ],
]);
