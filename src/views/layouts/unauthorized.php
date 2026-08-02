<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

use skeeks\cms\admin\assets\BackendAdminUnauthorizedAsset;
use skeeks\cms\backend\widgets\BackendThemeModeSwitcher;
use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $content string */

BackendAdminUnauthorizedAsset::register($this);

$theme = $this->theme;
$themeMode = $theme->normalizedThemeMode;
$themeModeStorageKey = (string) $theme->themeModeStorageKey;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html
    lang="<?= Yii::$app->language ?>"
    prefix="og: http://ogp.me/ns#"
    data-sx-theme="<?= Html::encode($themeMode === 'dark' ? 'dark' : 'light') ?>"
    data-sx-theme-mode="<?= Html::encode($themeMode) ?>"
    data-sx-theme-storage-key="<?= Html::encode($themeModeStorageKey) ?>"
>
<head>
    <?= $this->render('@skeeks/cms/backend/views/layouts/_theme-mode-bootstrap', [
        'theme' => $theme,
    ]) ?>
    <meta charset="<?= Yii::$app->charset ?>"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body class="sx-auth-layout">
<?php $this->beginBody() ?>
<div class="sx-preloader" aria-hidden="true">
    <div class="sx-loader-image"></div>
</div>
<?= BackendThemeModeSwitcher::widget([
    'containerClass' => 'sx-auth-theme-switcher',
    'toggleClass' => 'sx-auth-theme-switcher__toggle',
]) ?>
<main class="sx-auth-layout__main">
    <div class="sx-auth-layout__content">
        <?= $content ?>
    </div>
    <footer class="sx-auth-layout__footer">
        <a
            href="https://cms.skeeks.com"
            target="_blank"
            rel="noopener"
            data-sx-widget="tooltip"
            title="<?= \Yii::t('skeeks/cms', 'Go to site {cms}', ['cms' => 'SkeekS CMS']) ?>"
        >SkeekS CMS</a>
        <span aria-hidden="true">&middot;</span>
        <a
            href="https://skeeks.com"
            target="_blank"
            rel="noopener"
            data-sx-widget="tooltip"
            title="<?= \Yii::t('skeeks/cms', 'Go to site of the developer') ?>"
        >SkeekS.com</a>
    </footer>
</main>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
