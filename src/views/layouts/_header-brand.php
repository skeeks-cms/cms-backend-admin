<?php
/**
 * @var yii\web\View $this
 * @var \skeeks\cms\backend\themes\BackendTheme $theme
 */
?>
<?php if (\Yii::$app->mobileDetect->isMobile) : ?>
    <a
        href="#sideNav"
        class="navbar-toggler btn sx-shell-header__mobile-button"
        data-sx-shell-nav-toggle
        aria-controls="sideNav"
        aria-expanded="false"
        aria-label="Меню"
        title="Меню"
    >
        <span class="hamburger">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </span>
    </a>
<?php else : ?>
    <a href="<?= $theme->logoHref; ?>" class="navbar-brand d-flex align-self-center sx-shell-hidden-xs-down">
        <?php if ($theme->logoSrc) : ?>
            <img class="default-logo" src="<?= $theme->logoSrc; ?>" alt="<?= $theme->logoTitle; ?>">
        <?php endif; ?>
        <?= $theme->logoTitle; ?>
    </a>
<?php endif; ?>
