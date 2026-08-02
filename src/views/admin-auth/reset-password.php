<?php
/**
 * @link https://cms.skeeks.com/
 * @copyright Copyright (c) 2010 SkeekS
 * @license https://cms.skeeks.com/license/
 */

use yii\helpers\Html;

/* @var $this \yii\web\View */
/* @var $message string */

$authUrl = \skeeks\cms\helpers\UrlHelper::construct('/admin/admin-index')
    ->enableAbsolute()
    ->enableAdmin();

$this->registerJs(
    'window.setTimeout(function () { window.location.replace('
    . \yii\helpers\Json::htmlEncode((string) $authUrl)
    . '); }, 5000);'
);
?>
<section class="sx-auth-page">
    <div class="sx-auth-card">
        <h1 class="sx-auth-card__title"><?= \Yii::t('skeeks/cms', 'Password recovery') ?></h1>
        <div class="sx-auth-card__message"><?= Html::encode($message) ?></div>
    </div>
</section>
