<?php
/**
 * @var yii\web\View $this
 * @var \skeeks\cms\models\CmsLang[] $langs
 * @var array[] $quickCreateItems
 */

use skeeks\cms\backend\helpers\BackendIcon;
use skeeks\cms\helpers\UrlHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;

$this->registerJs(<<<JS
(function(sx, $)
{
    $(document).on('click', '[data-sx-quick-create-url]', function(event) {
        event.preventDefault();

        var url = $(this).attr('data-sx-quick-create-url');
        if (!url) {
            return false;
        }

        if (sx.classes && sx.classes.backend && sx.classes.backend.widgets && sx.classes.backend.widgets.Action) {
            new sx.classes.backend.widgets.Action({
                url: url,
                isOpenNewWindow: true
            }).go();
        } else {
            window.location.href = url;
        }

        return false;
    });
})(sx, sx.$);
JS
);
?>
<?= \skeeks\cms\backend\widgets\BackendThemeModeSwitcher::widget([
    'containerClass' => 'sx-shell-header__theme',
]); ?>

<div class="sx-btn-backend-header dropdown sx-header-quick-create">
    <a class="sx-shell-header__action sx-shell-header__action--icon" href="#" data-toggle="dropdown" title="Быстро добавить" aria-haspopup="true" aria-expanded="false">
        <?= BackendIcon::render('plus', ['size' => 20]); ?>
    </a>
    <div class="dropdown-menu dropdown-menu-right sx-shell-header__menu">
        <?php foreach ($quickCreateItems as $quickCreateItem) : ?>
            <a
                class="dropdown-item sx-shell-header__menu-item"
                href="#"
                data-sx-quick-create-url="<?= Html::encode($quickCreateItem['url']); ?>"
            >
                <?= BackendIcon::render($quickCreateItem['icon'], ['size' => 18]); ?>
                <span><?= Html::encode($quickCreateItem['label']); ?></span>
            </a>
        <?php endforeach; ?>
    </div>
</div>

<div class="sx-btn-backend-header">
    <a class="sx-shell-header__action sx-shell-header__action--icon" href="#" data-sx-quick-access-toggle data-sx-quick-access-tab="users" title="Сотрудники">
        <?= BackendIcon::render('users', ['size' => 20]); ?>
    </a>
</div>
<div class="sx-btn-backend-header">
    <a class="sx-shell-header__action sx-shell-header__action--icon" href="#" data-sx-quick-access-toggle data-sx-quick-access-tab="favorites" title="Избранное">
        <?= BackendIcon::render('star', ['size' => 20]); ?>
    </a>
</div>

<?= \skeeks\cms\widgets\admin\CmsWebNotifyWidget::widget(); ?>

<?php if (\Yii::$app->skeeks->site->cmsSiteMainDomain
    || (!\Yii::$app->skeeks->site->cmsSiteMainDomain && \Yii::$app->skeeks->site->is_default)) : ?>
    <div class="sx-btn-backend-header">
        <a
            class="sx-shell-header__action sx-shell-header__action--icon"
            href="<?= \Yii::$app->skeeks->site->url; ?>"
            target="_blank"
            title="<?= \Yii::t('skeeks/cms', 'To main page of site') ?>"
        >
            <?= BackendIcon::render('external-link', ['size' => 20]); ?>
        </a>
    </div>
<?php endif; ?>

<?php if (\Yii::$app->user->can(\skeeks\cms\rbac\CmsManager::PERMISSION_ROLE_ADMIN_ACCESS)) : ?>
    <?php
    $clearCacheOptions = Json::encode([
        'backend' => UrlHelper::construct(['/cms/admin-cache/invalidate'])->enableAdmin()->toString(),
    ]);

    $this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.ClearCache = sx.classes.Component.extend({
        execute: function(code)
        {
            this.ajaxQuery = sx.ajax.preparePostQuery(this.get('backend'), {
                'code' : code
            });

            var Handler = new sx.classes.AjaxHandlerStandartRespose(this.ajaxQuery, {
                'enableBlocker' : true,
                'blockerSelector' : 'body',
            });

            this.ajaxQuery.execute();
        }
    });

    sx.ClearCache = new sx.classes.ClearCache({$clearCacheOptions});
})(sx, sx.$, sx._);
JS
    );
    ?>
    <div class="sx-btn-backend-header">
        <a
            class="sx-shell-header__action sx-shell-header__action--icon"
            href="#"
            onclick="sx.ClearCache.execute(); return false;"
            title="<?= \Yii::t('skeeks/cms', 'Clear cache and temporary files') ?>"
        >
            <?= BackendIcon::render('refresh', ['size' => 20]); ?>
        </a>
    </div>

    <div class="sx-btn-backend-header">
        <a
            class="sx-shell-header__action sx-shell-header__action--icon"
            href="<?= Url::to(['/cms/admin-settings']); ?>"
            title="<?= \Yii::t('skeeks/cms', 'Project settings') ?>"
        >
            <?= BackendIcon::render('settings', ['size' => 20]); ?>
        </a>
    </div>
<?php endif; ?>

<?php if (count($langs) > 1) : ?>
    <?php
    $langOptions = Json::encode([
        'backend' => UrlHelper::construct(['/cms/admin-ajax/set-lang'])->enableAdmin()->toString(),
    ]);

    $this->registerJs(<<<JS
(function(sx, $, _)
{
    sx.classes.ChangeLang = sx.classes.Component.extend({
        setLang: function(code)
        {
            this.ajaxQuery = sx.ajax.preparePostQuery(this.get('backend'), {
                'code' : code
            });

            var Handler = new sx.classes.AjaxHandlerStandartRespose(this.ajaxQuery, {
                'enableBlocker' : true,
                'blockerSelector' : 'body',
            });

            Handler.bind('success', function()
            {
                window.location.reload();
            });

            this.ajaxQuery.execute();
        }
    });

    sx.ChangeLang = new sx.classes.ChangeLang({$langOptions});
})(sx, sx.$, sx._);
JS
    );
    ?>
    <div class="sx-lang-col">
        <div class="dropdown">
            <a class="sx-shell-header__action dropdown-toggle" href="#" data-toggle="dropdown">
                <span class="sx-shell-header__label">
                    <span class="sx-shell-hidden-sm-down"><?= \Yii::$app->admin->cmsLanguage->name; ?></span>
                </span>
            </a>
            <ul id="sx-lang-menu" class="dropdown-menu">
                <?php foreach ($langs as $lang) : ?>
                    <li>
                        <a
                            class="media"
                            href="#"
                            onclick="sx.ChangeLang.setLang('<?= $lang->code; ?>'); return false;"
                        >
                            <span class="media-body align-self-center">
                                [<?= $lang->code; ?>]&nbsp;<?= $lang->name; ?>
                            </span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
<?php endif; ?>
