<?php

use skeeks\cms\backend\widgets\BackendShellFooterWidget;

ob_start();
?>
<div class="row align-items-center">
    <div class="col-md-4 sx-shell-footer__section">
        <?php if (
            \Yii::$app->user->can('rbac/admin-permission')
            && \Yii::$app->controller instanceof \skeeks\cms\IHasPermissions
        ) : ?>
            <a
                class="sx-shell-footer__permission"
                href="#sx-permisson-modal"
                data-toggle="modal"
                aria-label="<?= \Yii::t('skeeks/cms', 'Permissions') ?>"
            >
                <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
            </a>
        <?php endif; ?>
    </div>

    <div class="col-md-4 sx-shell-footer__section text-center my-auto">
        <ul class="list-inline sx-shell-footer__socials text-center mb-0 my-auto">
            <li class="list-inline-item sx-shell-footer__social-item">
                <a
                    href="https://t.me/skeeks_com"
                    class="sx-shell-footer__link"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Telegram"
                >
                    <i class="fab fa-telegram" aria-hidden="true"></i>
                </a>
            </li>
            <li class="list-inline-item sx-shell-footer__social-item">
                <a
                    href="https://github.com/skeeks-cms/cms"
                    class="sx-shell-footer__link"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="GitHub"
                >
                    <i class="fab fa-github" aria-hidden="true"></i>
                </a>
            </li>
            <li class="list-inline-item sx-shell-footer__social-item">
                <a
                    href="https://vk.com/skeeks_com"
                    class="sx-shell-footer__link"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="VK"
                >
                    <i class="fab fa-vk" aria-hidden="true"></i>
                </a>
            </li>
        </ul>
    </div>

    <div class="col-md-4 text-md-right">
        <ul class="list-inline text-center text-md-right mb-0 sx-shell-footer__copyright">
            <li class="list-inline-item">
                <a
                    class="sx-shell-footer__link sx-shell-footer__copyright-link"
                    target="_blank"
                    rel="noopener noreferrer"
                    href="<?= \Yii::$app->cms->homePage ?>"
                >
                    <img
                        src="<?= \Yii::$app->cms->logo() ?>"
                        class="sx-shell-footer__logo"
                        alt=""
                    >
                    &copy; <?= \Yii::$app->formatter->asDate(time(), 'php:Y') ?>
                    <?= \Yii::$app->cms->cmsName ?>
                </a>
            </li>
        </ul>
    </div>
</div>
<?php
$footerContent = ob_get_clean();

echo BackendShellFooterWidget::widget([
    'content' => $footerContent,
    'options' => [
        'class'              => 'sx-shell-footer--sticky',
        'data-sx-slot-owner' => 'cms-backend-admin',
    ],
]);
