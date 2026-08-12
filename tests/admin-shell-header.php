<?php

function adminHeaderExpect($condition, $message)
{
    if (!$condition) {
        throw new RuntimeException($message);
    }
}

$header = file_get_contents(dirname(__DIR__).'/src/views/layouts/_header.php');
$brand = file_get_contents(dirname(__DIR__).'/src/views/layouts/_header-brand.php');
$actions = file_get_contents(dirname(__DIR__).'/src/views/layouts/_header-actions.php');
$profile = file_get_contents(dirname(__DIR__).'/src/views/layouts/_header-profile.php');
$unauthorizedCss = file_get_contents(dirname(__DIR__).'/src/assets/src/css/unauthorized.css');

adminHeaderExpect(strpos($header, "'class' => 'navbar no-gutters'") === false, 'Admin header still adds Bootstrap navbar geometry.');
adminHeaderExpect(strpos($brand, "'sx-shell-header__brand-link'") !== false, 'Admin brand does not use the shared header contract.');
adminHeaderExpect(strpos($actions, "'containerClass' => 'sx-shell-header__theme'") !== false, 'Admin theme switcher does not use the shared header slot.');
adminHeaderExpect(substr_count($actions, 'sx-shell-header__action--icon') >= 6, 'Admin icon actions do not use shared hit targets.');
adminHeaderExpect(strpos($actions, 'sx-icon-centered') === false, 'Semantic header actions still use legacy absolute icon centering.');
adminHeaderExpect(strpos($profile, 'BackendShellProfileWidget::widget') !== false, 'Admin profile does not use the shared profile widget.');
adminHeaderExpect(strpos($profile, '$user && $user->image') !== false, 'Admin profile does not distinguish a real avatar from the placeholder image.');
adminHeaderExpect(strpos($profile, 'sx-header-user-profile') === false, 'Legacy admin profile markup remains.');
adminHeaderExpect(strpos($unauthorizedCss, '.sx-auth-card .btn-primary') === false, 'Admin auth screen still overrides shared primary buttons.');
adminHeaderExpect(strpos($unauthorizedCss, '.sx-auth-card .btn-danger') === false, 'Admin auth screen still overrides shared danger buttons.');

echo "Admin shell header contract: OK\n";
