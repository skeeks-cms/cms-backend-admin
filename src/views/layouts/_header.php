<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 * @author Semenov Alexander <semenov@skeeks.com>
 */
/* @var $this yii\web\View */
/**
 * @var $theme \skeeks\cms\themes\unify\admin\UnifyThemeAdmin;
 */
$theme = $this->theme;
?>


<?
$langOptions = \yii\helpers\Json::encode([
    'backend' => \skeeks\cms\helpers\UrlHelper::construct(['/cms/admin-ajax/set-lang'])->enableAdmin()->toString(),
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
                'enableBlocker'                      : true,
                'blockerSelector'                    : 'body',
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


<!-- Header -->
<header id="js-header" class="u-header u-header--sticky-top">
    <div class="<?= $theme->headerClasses; ?>">
        <nav class="navbar no-gutters g-pa-0">
            <div class="col-auto d-flex flex-nowrap u-header-logo-toggler g-py-12">
                <!-- Logo -->
                <a href="<?= $theme->logoHref; ?>" class="navbar-brand d-flex align-self-center g-hidden-xs-down py-0">
                    <? if ($theme->logoSrc) : ?>
                        <img class="default-logo" src="<?= $theme->logoSrc; ?>" alt="<?= $theme->logoTitle; ?>">
                    <? endif; ?>
                    <?= $theme->logoTitle; ?>
                </a>
                <!-- End Logo -->
                <!-- Sidebar Toggler -->
                <a class="js-side-nav u-header__nav-toggler d-flex align-self-center ml-auto" href="#!" data-hssm-class="u-side-nav--mini u-sidebar-navigation-v1--mini" data-hssm-body-class="u-side-nav-mini"
                   data-hssm-is-close-all-except-this="true" data-hssm-target="#sideNav">
                    <i class="hs-admin-align-left"></i>
                </a>
                <!-- End Sidebar Toggler -->
            </div>


            <div class="col-auto d-flex g-py-12 g-pl-40--lg ml-auto">
                <? if (\skeeks\cms\models\CmsSite::find()->active()->count() > 1) : ?>
                
                    <div class="col-auto d-flex g-pt-5 g-pt-0--sm g-pl-10 g-pl-20--sm my-auto">
                        <div class="g-pos-rel g-px-10--lg sx-header-user-profile">
                            <a id="profileMenuInvoker" class="d-block" href="#!" aria-controls="sx-site-menu" aria-haspopup="true" aria-expanded="false" data-dropdown-event="click" data-dropdown-target="#sx-site-menu"
                               data-dropdown-type="css-animation" data-dropdown-duration="300"
                               data-dropdown-animation-in="fadeIn" data-dropdown-animation-out="fadeOut">
                            <span class="g-pos-rel">
                             <img class="g-width-20 g-width-20 g-height-20 g-height-20 rounded-circle g-mr-5--sm sx-avatar"
                                  src="<?= \Yii::$app->skeeks->site->image ? \Yii::$app->skeeks->site->image->src : \skeeks\cms\helpers\Image::getCapSrc(); ?>"
                             >
                            </span>
                                <span class="g-pos-rel g-top-2">
                                <span class="g-hidden-sm-down"><?= \Yii::$app->skeeks->site->name; ?></span>
                                <i class="hs-admin-angle-down g-pos-rel g-top-2 g-ml-5"></i>
                            </span>
                            </a>
                            <ul id="sx-site-menu" class="js-custom-scroll g-absolute-centered--x g-width-340 g-mt-17 rounded g-pb-15 g-pt-10" style="max-width: 340px;" aria-labelledby="profileMenuInvoker">
                                <? if ($sites = \skeeks\cms\models\CmsSite::find()->active()->orderBy(['priority' => SORT_ASC])->all()) : ?>
                                    <?
                                    /**
                                     * @var $site \skeeks\cms\models\CmsSite
                                     */
                                    ?>
                                    <? foreach ($sites as $site) : ?>
                                        <li class="g-mt-5">
                                            <a class="media g-py-5 g-px-20" href="<?= $site->url . \yii\helpers\Url::to(['/admin/admin-index']); ?>">
                                            <span class="d-flex align-self-center g-mr-12">

                                                <? if ($site->image) : ?>
                                                    <img class="pull-right" style="max-width: 25px; max-height: 25px;" src="<?= $site->image->src; ?>"/>
                                                <? else: ?>
                                                    <img class="pull-right" style="max-width: 25px; max-height: 25px;" src="<?= \skeeks\cms\helpers\Image::getCapSrc(); ?>"/>
                                                <? endif; ?>
                                            </span>
                                                <span class="media-body align-self-center">
                                                    <?= $site->name; ?>
                                                    <div style="font-size: 10px; color: gray;"><?= $site->url; ?></div>
                                            </span>
                                            </a>
                                        </li>
                                    <? endforeach; ?>
                                <? endif; ?>
                            </ul>
                        </div>
                    </div>
                <? endif; ?>


                <div class="g-pos-rel sx-btn-backend-header">
                    <a id="messagesInvoker" class="d-block text-uppercase u-header-icon-v1 g-pos-rel g-width-40 g-height-40 rounded-circle g-font-size-20"
                       href="<?= \yii\helpers\Url::home(); ?>"
                       target="_blank"
                       title="<?= \Yii::t('skeeks/cms', 'To main page of site') ?>"
                    >
                        <!--<span class="u-badge-v1 g-top-7 g-right-7 g-width-18 g-height-18 g-bg-primary g-font-size-10 g-color-white rounded-circle p-0">7</span>-->
                        <i class="fas fa-external-link-alt g-absolute-centered"></i>
                    </a>
                </div>

                <? if (\Yii::$app->user->can('cms/admin-clear')) : ?>

                    <?
                    $clearCacheOptions = \yii\helpers\Json::encode([
                        'backend' => \skeeks\cms\helpers\UrlHelper::construct(['/cms/admin-clear/index'])->enableAdmin()->toString(),
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
                'enableBlocker'                      : true,
                'blockerSelector'                    : 'body',
            });

            this.ajaxQuery.execute();
        }
    });

    sx.ClearCache = new sx.classes.ClearCache({$clearCacheOptions});

})(sx, sx.$, sx._);
JS
                    );
                    ?>
                    <div class="g-pos-rel sx-btn-backend-header">
                        <a id="messagesInvoker" class="d-block text-uppercase u-header-icon-v1 g-pos-rel g-width-40 g-height-40 rounded-circle g-font-size-20"
                           href="#" onclick="sx.ClearCache.execute(); return false;"
                           title="<?= \Yii::t('skeeks/cms', 'Clear cache and temporary files') ?>"
                        >
                            <!--<span class="u-badge-v1 g-top-7 g-right-7 g-width-18 g-height-18 g-bg-primary g-font-size-10 g-color-white rounded-circle p-0">7</span>-->
                            <i class="fas fa-sync g-absolute-centered"></i>
                        </a>
                    </div>

                    <!--<li class="sx-left-border dropdown visible-md visible-lg visible-sm visible-xs">
                    <a href="#" onclick="sx.ClearCache.execute(); return false;" style="width: auto;" data-sx-widget="tooltip-b" data-original-title="<? /*=\Yii::t('skeeks/cms','Clear cache and temporary files')*/ ?>"><i class="glyphicon glyphicon-refresh"></i></a>
                </li>-->
                <? endif; ?>

                <? if (\Yii::$app->user->can('cms/admin-settings')) : ?>

                    <div class="g-pos-rel sx-btn-backend-header">
                        <a id="messagesInvoker" class="d-block text-uppercase u-header-icon-v1 g-pos-rel g-width-40 g-height-40 rounded-circle g-font-size-20"
                           href="<?= \yii\helpers\Url::to(['/cms/admin-settings']); ?>"
                           title="<?= \Yii::t('skeeks/cms', 'Project settings') ?>"
                        >
                            <!--<span class="u-badge-v1 g-top-7 g-right-7 g-width-18 g-height-18 g-bg-primary g-font-size-10 g-color-white rounded-circle p-0">7</span>-->
                            <i class="hs-admin-settings g-absolute-centered"></i>
                        </a>
                    </div>

                <? endif; ?>


                <!-- Top User -->
                <div class="col-auto d-flex g-pt-5 g-pt-0--sm g-pl-10 g-pl-20--sm my-auto">
                    <div class="g-pos-rel g-px-10--lg sx-header-user-profile">
                        <a id="profileMenuInvoker" class="d-block" href="#!" aria-controls="sx-lang-menu" aria-haspopup="true" aria-expanded="false" data-dropdown-event="click" data-dropdown-target="#sx-lang-menu"
                           data-dropdown-type="css-animation" data-dropdown-duration="300"
                           data-dropdown-animation-in="fadeIn" data-dropdown-animation-out="fadeOut">
                            <span class="g-pos-rel">
                            <!--<span class="u-badge-v2--xs u-badge--top-right g-hidden-sm-up g-bg-secondary g-mr-5"></span>-->
                                <!--<span class="g-width-30 g-width-40--md g-height-30 g-height-40--md rounded-circle g-mr-10--sm sx-avatar">
                                <? /*= \Yii::$app->admin->cmsLanguage->code; */ ?>
                            </span>-->
                             <img class="g-width-20 g-width-20 g-height-20 g-height-20 rounded-circle g-mr-5--sm sx-avatar"
                                  src="<?= \Yii::$app->admin->cmsLanguage->image ? \Yii::$app->admin->cmsLanguage->image->src : \skeeks\cms\helpers\Image::getCapSrc(); ?>"
                             >
                            </span>
                            <span class="g-pos-rel g-top-2">
                                <span class="g-hidden-sm-down"><?= \Yii::$app->admin->cmsLanguage->name; ?></span>
                                <i class="hs-admin-angle-down g-pos-rel g-top-2 g-ml-5"></i>
                            </span>
                        </a>

                        <!-- Top User Menu -->
                        <ul id="sx-lang-menu" class="js-custom-scroll g-absolute-centered--x g-width-340 g-max-width-200 g-mt-17 rounded g-pb-15 g-pt-10" aria-labelledby="profileMenuInvoker">

                            <? if ($langs = \skeeks\cms\models\CmsLang::find()->active()->all()) : ?>
                                <? foreach ($langs as $lang) : ?>

                                    <li class="g-mt-5">
                                        <a class="media g-py-5 g-px-20" href="#" onclick="sx.ChangeLang.setLang('<?= $lang->code; ?>'); return false;">
                                            <span class="d-flex align-self-center g-mr-12">

                                                <? if ($lang->image) : ?>
                                                    <img class="pull-right" height="20" style="" src="<?= $lang->image->src; ?>"/>
                                                <? else: ?>
                                                    <img class="pull-right" height="20" style="" src="<?= \skeeks\cms\helpers\Image::getCapSrc(); ?>"/>
                                                <? endif; ?>

                                            </span>
                                            <span class="media-body align-self-center">
                                            [<?= $lang->code; ?>] <?= $lang->name; ?>
                                            </span>
                                        </a>
                                    </li>
                                <? endforeach; ?>
                            <? endif; ?>


                        </ul>
                        <!-- End Top User Menu -->
                    </div>
                </div>
                <!-- End Top User -->


                <!-- Top User -->
                <div class="col-auto d-flex g-pt-5 g-pt-0--sm g-pl-10 g-pl-20--sm">
                    <div class="g-pos-rel g-px-10--lg sx-header-user-profile">
                        <a id="profileMenuInvoker" class="d-block" href="#!" aria-controls="profileMenu" aria-haspopup="true" aria-expanded="false" data-dropdown-event="click" data-dropdown-target="#profileMenu"
                           data-dropdown-type="css-animation" data-dropdown-duration="300"
                           data-dropdown-animation-in="fadeIn" data-dropdown-animation-out="fadeOut">
                <span class="g-pos-rel">
        <!--<span class="u-badge-v2--xs u-badge--top-right g-hidden-sm-up g-bg-secondary g-mr-5"></span>-->
                <img class="g-width-30 g-width-40--md g-height-30 g-height-40--md rounded-circle g-mr-10--sm sx-avatar"
                     src="<?= \Yii::$app->user->identity->avatarSrc ? \Yii::$app->user->identity->avatarSrc : \skeeks\cms\helpers\Image::getCapSrc(); ?>" alt="Image description">
                </span>
                            <span class="g-pos-rel g-top-2">
        <span class="g-hidden-sm-down"><?= \Yii::$app->user->identity->shortDisplayName; ?></span>
                <i class="hs-admin-angle-down g-pos-rel g-top-2 g-ml-10"></i>
                </span>
                        </a>

                        <!-- Top User Menu -->
                        <ul id="profileMenu" class="g-pos-abs g-left-0 g-width-100x--lg g-nowrap g-font-size-14 g-py-20 g-mt-17 rounded" aria-labelledby="profileMenuInvoker">

                            <li class="g-mb-10">
                                <a class="media g-py-5 g-px-20" href="<?= \yii\helpers\Url::to(['/cms/admin-profile/update']); ?>">
                                                <span class="d-flex align-self-center g-mr-12">
                                      <i class="hs-admin-user"></i>
                                    </span>
                                    <span class="media-body align-self-center"><?= \Yii::t('skeeks/cms', 'Profile') ?></span>
                                </a>
                            </li>

                            <li class="g-mb-10">
                                <a class="media g-py-5 g-px-20" href="<?= \skeeks\cms\helpers\UrlHelper::construct('admin/admin-auth/lock')->setCurrentRef(); ?>" data-method="post">
                                        <span class="d-flex align-self-center g-mr-12">
                                      <i class="fas fa-lock"></i>
                                    </span>
                                    <span class="media-body align-self-center"><?= \Yii::t('skeeks/cms', 'To block'); ?></span>
                                </a>
                            </li>

                            <li class="mb-0">
                                <a class="media g-py-5 g-px-20" href="<?= \skeeks\cms\helpers\UrlHelper::construct('cms/auth/logout')->setCurrentRef(); ?>" data-method="post">
                    <span class="d-flex align-self-center g-mr-12">
          <i class="hs-admin-shift-right"></i>
        </span>
                                    <span class="media-body align-self-center">Выход</span>
                                </a>
                            </li>
                        </ul>
                        <!-- End Top User Menu -->
                    </div>
                </div>
                <!-- End Top User -->
            </div>
            <!-- End Messages/Notifications/Top Search Bar/Top User -->
        </nav>

    </div>
</header>
<!-- End Header -->