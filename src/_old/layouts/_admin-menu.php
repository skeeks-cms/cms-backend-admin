<?php
/**
 * @author Semenov Alexander <semenov@skeeks.com>
 * @link http://skeeks.com/
 * @copyright 2010 SkeekS (СкикС)
 * @date 27.09.2015
 */
?>
<div class="sidebar sx-sidebar sx-bg-glass sx-bg-glass-hover">
    <a href="#" onclick="sx.App.Menu.toggleTrigger(); return false;" class="btn btn-default btn-xs sx-main-menu-toggle sx-main-menu-toggle-opened" data-sx-widget="tooltip-l" data-original-title="<?=\Yii::t('skeeks/cms','Close menu')?>">
        <i class="glyphicon glyphicon-menu-left"></i>
    </a>
    <a href="#" onclick="sx.App.Menu.toggleTrigger(); return false;" class="btn btn-default btn-xs sx-main-menu-toggle sx-main-menu-toggle-closed" data-sx-widget="tooltip-r" data-original-title="<?=\Yii::t('skeeks/cms','Open menu')?>">
        <i class="glyphicon glyphicon-menu-right"></i>
    </a>
    <div class="inner-wrapper scrollbar-macosx">
        <div class="sidebar-collapse sx-sidebar-collapse">

<? if ($items = \skeeks\cms\backend\BackendComponent::getCurrent()->menu->items) : ?>
    <? foreach ($items as $adminMenuItem) : ?>
        <? if ($adminMenuItem->isVisible && $adminMenuItem->items) : ?>

            <div class="sidebar-menu <?= $adminMenuItem->isActive ? ' sx-opened' : '' ?>" id="<?= $adminMenuItem->id; ?>">
                <div class="sx-head" title="<?= $adminMenuItem->name; ?>">
                    <? if ($imgUrl = $adminMenuItem->image) : ?>
                        <span class="sx-icon">
                            <img src="<?= $imgUrl; ?>" />
                        </span>
                    <? else : ?>
                        <span class="sx-icon">
                            <img src="<?= \skeeks\cms\assets\CmsAsset::getAssetUrl('images/icons/posteditem.png'); ?>" />
                        </span>
                    <? endif; ?>
                    <?= $adminMenuItem->name; ?>
                </div>

                <?= $this->render('_admin-menu-sub', [
                    'subAdminMenuItems' => $adminMenuItem->items
                ]); ?>

            </div>
        <? endif; ?>
    <? endforeach; ?>
<? endif; ?>


        </div>
    </div>
</div>
