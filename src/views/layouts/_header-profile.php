<?php
/**
 * @var yii\web\View $this
 */

use skeeks\cms\backend\helpers\BackendIcon;
use skeeks\cms\backend\widgets\BackendShellProfileWidget;
use skeeks\cms\helpers\Image;
use yii\helpers\Url;

$user = \Yii::$app->user->identity;
$avatarSrc = $user && $user->avatarSrc ? $user->avatarSrc : Image::getCapSrc();
$displayName = $user ? $user->shortDisplayName : '';

ob_start();
?>
<li>
    <a class="dropdown-item sx-shell-header__menu-item" href="<?= Url::to(['/cms/admin-profile/update']); ?>">
        <?= BackendIcon::render('user', ['size' => 18]); ?>
        <span><?= \Yii::t('skeeks/cms', 'Profile') ?></span>
    </a>
</li>
<li>
    <a class="dropdown-item sx-shell-header__menu-item" href="<?= Url::to(['/cms/admin-profile/password']); ?>">
        <?= BackendIcon::render('settings', ['size' => 18]); ?>
        <span><?= \Yii::t('skeeks/cms', 'Security'); ?></span>
    </a>
</li>
<li>
    <a
        class="dropdown-item sx-shell-header__menu-item"
        href="<?= \skeeks\cms\helpers\UrlHelper::construct('/admin/admin-auth/lock')->setCurrentRef(); ?>"
        data-method="post"
    >
        <?= BackendIcon::render('lock', ['size' => 18]); ?>
        <span><?= \Yii::t('skeeks/cms', 'To block'); ?></span>
    </a>
</li>
<li>
    <a
        class="dropdown-item sx-shell-header__menu-item"
        href="<?= \skeeks\cms\helpers\UrlHelper::construct('/cms/auth/logout')->setCurrentRef(); ?>"
        data-method="post"
    >
        <?= BackendIcon::render('logout', ['size' => 18]); ?>
        <span>Выход</span>
    </a>
</li>
<?php
$menu = ob_get_clean();

echo BackendShellProfileWidget::widget([
    'avatarSrc' => $avatarSrc,
    'avatarAlt' => $displayName,
    'label'     => $displayName,
    'menu'      => $menu,
]);
