<?php
/**
 * @var yii\web\View $this
 * @var \skeeks\cms\backend\themes\BackendTheme $theme
 */
?>
<?php if (\Yii::$app->mobileDetect->isMobile) : ?>
    <a
        href="#sideNav"
        class="sx-shell-header__mobile-button"
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
    <?php
    $brandClasses = ['sx-shell-header__brand-link', 'sx-shell-hidden-xs-down'];
    if ($theme->logoSrcLight) {
        $brandClasses[] = 'sx-shell-header__brand--has-light-logo';
    }
    if ($theme->logoSrcDark) {
        $brandClasses[] = 'sx-shell-header__brand--has-dark-logo';
    }
    $fallbackLogoSrc = $theme->logoSrc ?: ($theme->logoSrcLight ?: $theme->logoSrcDark);
    ?>
    <a href="<?= $theme->logoHref; ?>" class="<?= implode(' ', $brandClasses); ?>">
        <?php if ($fallbackLogoSrc) : ?>
            <img class="sx-shell-header__brand-logo sx-shell-header__brand-logo--fallback" src="<?= $fallbackLogoSrc; ?>" alt="<?= $theme->logoTitle; ?>">
        <?php endif; ?>
        <?php if ($theme->logoSrcLight) : ?>
            <img class="sx-shell-header__brand-logo sx-shell-header__brand-logo--light" src="<?= $theme->logoSrcLight; ?>" alt="<?= $theme->logoTitle; ?>">
        <?php endif; ?>
        <?php if ($theme->logoSrcDark) : ?>
            <img class="sx-shell-header__brand-logo sx-shell-header__brand-logo--dark" src="<?= $theme->logoSrcDark; ?>" alt="<?= $theme->logoTitle; ?>">
        <?php endif; ?>
        <?= $theme->logoTitle; ?>
    </a>
<?php endif; ?>
