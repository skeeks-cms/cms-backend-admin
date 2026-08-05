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

Yii::setAlias('@skeeks/cms/admin', dirname(__DIR__).'/src');

function dashboardExpect($condition, $message)
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$dashboardAsset = (new ReflectionClass(AdminDashboardAsset::class))->newInstanceWithoutConstructor();
$appAsset = (new ReflectionClass(BackendAdminAppAsset::class))->newInstanceWithoutConstructor();
dashboardExpect(in_array(AdminPanelAsset::class, (array)$dashboardAsset->depends, true), 'Dashboard panel dependency is missing.');
dashboardExpect($dashboardAsset->css === ['css/dashboard.css'], 'Dashboard asset must own only dashboard.css.');
dashboardExpect(in_array(BackendBlockAsset::class, (array)$appAsset->depends, true), 'Active admin shell does not load deprecated block compatibility.');

$view = file_get_contents(dirname(__DIR__).'/src/views/admin-index/dashboard.php');
$css = file_get_contents(dirname(__DIR__).'/src/assets/src/css/dashboard.css');
$theme = file_get_contents(dirname(__DIR__).'/src/themes/AdminTheme.php');

dashboardExpect(strpos($view, 'AdminDashboardAsset::register($this)') !== false, 'Dashboard asset is not registered by its page.');
dashboardExpect(strpos($view, 'sx-dashboard-grid') !== false, 'Dashboard grid markup is missing.');
dashboardExpect(strpos($view, '<table id="sx-dashboard-table">') === false, 'Legacy dashboard table layout remains.');
dashboardExpect(strpos($view, "if (\$canEditDashboard) {") !== false, 'Edit actions are not permission-scoped.');
dashboardExpect(strpos($view, '\\yii\\jui\\Sortable::widget()') !== false, 'Editable dashboard sortable adapter is missing.');
dashboardExpect(strpos($css, '@media (max-width: 991.98px)') !== false, 'Dashboard mobile layout is missing.');
dashboardExpect(strpos($theme, 'public $appAssetClass = BackendAdminAppAsset::class;') !== false, 'AdminTheme does not use BackendAdminAppAsset.');

echo "Admin dashboard asset contract: OK\n";
