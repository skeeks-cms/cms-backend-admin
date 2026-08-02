<?php
/**
 * @var yii\web\View $this
 */
?>
<div class="col-auto d-flex sx-user-profile-col">
    <div class="sx-header-user-profile dropdown">
        <a class="d-block dropdown-toggle" href="#" data-toggle="dropdown">
            <span class="sx-shell-header__avatar">
                <img
                    class="rounded-circle sx-avatar"
                    src="<?= \Yii::$app->user->identity && \Yii::$app->user->identity->avatarSrc
                        ? \Yii::$app->user->identity->avatarSrc
                        : \skeeks\cms\helpers\Image::getCapSrc(); ?>"
                    alt="Image description"
                >
            </span>
            <span class="sx-shell-header__label">
                <span class="sx-shell-hidden-sm-down"><?= \Yii::$app->user->identity->shortDisplayName; ?></span>
            </span>
        </a>

        <ul class="dropdown-menu dropdown-menu-right sx-shell-header__menu">
            <li>
                <a class="dropdown-item sx-shell-header__menu-item" href="<?= \yii\helpers\Url::to(['/cms/admin-profile/update']); ?>">
                    <?= \skeeks\cms\backend\helpers\BackendIcon::render('user', ['size' => 18]); ?>
                    <span><?= \Yii::t('skeeks/cms', 'Profile') ?></span>
                </a>
            </li>
            <li>
                <a class="dropdown-item sx-shell-header__menu-item" href="<?= \yii\helpers\Url::to(['/cms/admin-profile/password']); ?>">
                    <?= \skeeks\cms\backend\helpers\BackendIcon::render('settings', ['size' => 18]); ?>
                    <span><?= \Yii::t('skeeks/cms', 'Security'); ?></span>
                </a>
            </li>
            <li>
                <a
                    class="dropdown-item sx-shell-header__menu-item"
                    href="<?= \skeeks\cms\helpers\UrlHelper::construct('/admin/admin-auth/lock')->setCurrentRef(); ?>"
                    data-method="post"
                >
                    <?= \skeeks\cms\backend\helpers\BackendIcon::render('lock', ['size' => 18]); ?>
                    <span><?= \Yii::t('skeeks/cms', 'To block'); ?></span>
                </a>
            </li>
            <li>
                <a
                    class="dropdown-item sx-shell-header__menu-item"
                    href="<?= \skeeks\cms\helpers\UrlHelper::construct('/cms/auth/logout')->setCurrentRef(); ?>"
                    data-method="post"
                >
                    <?= \skeeks\cms\backend\helpers\BackendIcon::render('logout', ['size' => 18]); ?>
                    <span>Выход</span>
                </a>
            </li>
        </ul>
    </div>
</div>
