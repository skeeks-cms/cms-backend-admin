<?php

$autoloadCandidates = [
    '/app/vendor/autoload.php',
    dirname(__DIR__).'/vendor/autoload.php',
    dirname(__DIR__, 3).'/autoload.php',
];

foreach ($autoloadCandidates as $autoload) {
    if (is_file($autoload)) {
        require $autoload;
        break;
    }
}

$yiiCandidates = [
    '/app/vendor/yiisoft/yii2/Yii.php',
    dirname(__DIR__).'/vendor/yiisoft/yii2/Yii.php',
    dirname(__DIR__, 3).'/yiisoft/yii2/Yii.php',
];
foreach ($yiiCandidates as $yiiBootstrap) {
    if (is_file($yiiBootstrap)) {
        require_once $yiiBootstrap;
        break;
    }
}

use skeeks\cms\admin\assets\AdminDashboardAsset;
use skeeks\cms\admin\assets\BackendAdminAppAsset;
use skeeks\cms\admin\assets\AdminPanelAsset;
use skeeks\cms\backend\assets\BackendBlockAsset;
use skeeks\cms\backend\assets\BackendUiAsset;

Yii::setAlias('@skeeks/cms/admin', dirname(__DIR__).'/src');

function dashboardExpect($condition, $message)
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$dashboardAsset = (new ReflectionClass(AdminDashboardAsset::class))->newInstanceWithoutConstructor();
$appAsset = (new ReflectionClass(BackendAdminAppAsset::class))->newInstanceWithoutConstructor();
dashboardExpect(in_array(BackendUiAsset::class, (array)$dashboardAsset->depends, true), 'Dashboard semantic UI dependency is missing.');
dashboardExpect(!in_array(AdminPanelAsset::class, (array)$dashboardAsset->depends, true), 'Dashboard still loads deprecated admin panel compatibility.');
dashboardExpect($dashboardAsset->css === ['css/dashboard.css'], 'Dashboard asset must own only dashboard.css.');
dashboardExpect($dashboardAsset->js === ['js/dashboard.js'], 'Dashboard asset must own dashboard.js.');
dashboardExpect(!in_array(BackendBlockAsset::class, (array)$appAsset->depends, true), 'Active admin shell still loads deprecated block compatibility.');

$view = file_get_contents(dirname(__DIR__).'/src/views/admin-index/dashboard.php');
$css = file_get_contents(dirname(__DIR__).'/src/assets/src/css/dashboard.css');
$js = file_get_contents(dirname(__DIR__).'/src/assets/src/js/dashboard.js');
$theme = file_get_contents(dirname(__DIR__).'/src/themes/AdminTheme.php');

dashboardExpect(strpos($view, 'AdminDashboardAsset::register($this)') !== false, 'Dashboard asset is not registered by its page.');
dashboardExpect(strpos($view, 'sx-dashboard-grid') !== false, 'Dashboard grid markup is missing.');
dashboardExpect(strpos($view, '<table id="sx-dashboard-table">') === false, 'Legacy dashboard table layout remains.');
dashboardExpect(strpos($view, "if (\$canEditDashboard) {") !== false, 'Edit actions are not permission-scoped.');
dashboardExpect(strpos($view, 'BackendSurfaceWidget::begin') !== false, 'Dashboard widgets do not use the canonical surface widget.');
dashboardExpect(strpos($view, 'AdminPanelWidget') === false, 'Dashboard still uses the deprecated admin panel widget.');
dashboardExpect(strpos($view, 'sx-panel') === false, 'Dashboard still emits deprecated panel markup or hooks.');
dashboardExpect(strpos($view, 'data-sx-dashboard-drag-handle') !== false, 'Dashboard semantic drag handle is missing.');
dashboardExpect(strpos($view, "BackendIcon::render('expand'") !== false, 'Dashboard fullscreen action does not use the semantic icon contract.');
dashboardExpect(strpos($view, 'BackendSortableAdapterAsset::register($this)') !== false, 'Editable dashboard sortable adapter asset is missing.');
dashboardExpect(strpos($view, 'sx.backend.sortable.create(') !== false, 'Editable dashboard does not use the shared sortable adapter.');
dashboardExpect(strpos($view, 'itemSelector: "> .sx-dashboard-widget"') !== false, 'Dashboard sortable item contract is missing.');
dashboardExpect(strpos($view, "'sortableGroup'             => 'cms-dashboard-' . \$dashboard->id") !== false && strpos($view, "group: this.get('sortableGroup')") !== false, 'Dashboard columns are not connected within their dashboard.');
dashboardExpect(strpos($view, 'onUpdate: function(event)') !== false, 'Dashboard layout is not saved after adapter updates.');
dashboardExpect(strpos($view, '\\yii\\jui\\Sortable::widget()') === false && strpos($view, '.sortable(') === false, 'Dashboard still uses jQuery UI Sortable directly.');
dashboardExpect(strpos($css, 'sx-panel') === false, 'Dashboard CSS still depends on deprecated panel selectors or tokens.');
dashboardExpect(strpos($css, '@media (max-width: 991.98px)') !== false, 'Dashboard mobile layout is missing.');
dashboardExpect(strpos($js, 'data-sx-dashboard-action="fullscreen"') !== false, 'Dashboard fullscreen behavior hook is missing.');
dashboardExpect(strpos($js, "event.key !== 'Escape'") !== false, 'Dashboard fullscreen behavior has no keyboard escape path.');
dashboardExpect(strpos($theme, 'public $appAssetClass = BackendAdminAppAsset::class;') !== false, 'AdminTheme does not use BackendAdminAppAsset.');

echo "Admin dashboard asset contract: OK\n";
